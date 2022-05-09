<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class FilmesSeeder extends Seeder
{
    public static $arrayMovies = [];
    private $cartazesPublicPath = 'public/cartazes';

    public function run()
    {
        $this->command->info("Filmes");
        $this->command->info("Ler base de dados de filmes");
        static::$arrayMovies = DatabaseSeeder::readCSVFile(database_path("seeders/bd_filmes/filmesDB.csv"), 3);
        $faker = \Faker\Factory::create('pt_PT');
        $this->limparFicheirosCartazes();
        $movies = [];
        foreach(static::$arrayMovies as $movie) {
            $newMovie = $this->newMovie($faker, $movie);
            if ($newMovie) {
                $movies[] = $newMovie;
            }
        }
        $this->command->info("Gravar todos os filmes em bloco na base de dados");
        DB::table('filmes')->insert($movies);
        // A partir daqui, vamos copiar as imagens dos cartazes
        $this->command->info("Copiar imagens das estampas");
        $movies = DB::table('filmes')->get();
        foreach ($movies as $movie) {
            if ($movie->cartaz_url) {
                $this->saveCartaz($movie->id, $movie->cartaz_url);
            }
        }
    }

    private function newMovie($faker, $movieRow)
    {
        $idx = $movieRow[0];
        $genero = $movieRow[1];
        $titulo = $movieRow[2];
        $ano = $movieRow[3];
        $cartaz = $movieRow[4];
        $sumario = $movieRow[5];
        $trailer = $movieRow[6];
        if (trim($genero) == '') {
            return null;
        }
        $titulo = trim($titulo) == '' ? 'Movie ' . $genero . ' ' . ($idx-1) : trim($titulo);
        $ano = trim($ano) == '' ? '2020' : trim($ano);
        $cartaz = trim($cartaz) == '' ? null : trim($cartaz);
        $sumario = trim($sumario) == '' ? $faker->realText(100): trim($sumario);
        $trailer = trim($trailer) == '' ? null : trim($trailer);
        $createdAt = $faker->dateTimeBetween('-3 years', '-3 months');
        $updatedAt = $faker->dateTimeBetween($createdAt, '-1 months');
        return [
            'titulo' => $titulo,
            'genero_code' => $genero,
            'ano' => $ano,
            'cartaz_url' => $cartaz,
            'sumario' => $sumario,
            'trailer_url' => $trailer,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    private function saveCartaz($id, $file)
    {
        $fileName = database_path('seeders/cartazes') . '/' . $file;
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $targetDir = storage_path('app/' . $this->cartazesPublicPath);
        $newfilename = $id . "_" . uniqid() . '.' . $ext;
        File::copy($fileName, $targetDir . '/' . $newfilename);
        DB::table('filmes')->where('id', $id)->update(['cartaz_url' => $newfilename]);
        $this->command->info("Atualizada imagem do cartaz $id. Nome do ficheiro copiado = $newfilename");
    }

    private function limparFicheirosCartazes()
    {
        Storage::deleteDirectory($this->cartazesPublicPath);
        Storage::makeDirectory($this->cartazesPublicPath);
    }

    private function getNomeFromFilename($filename)
    {
        $strNome = str_replace(".png", "", $filename);
        $strNome = str_replace("_", " ", $strNome);
        $strNome = str_replace("-", " ", $strNome);
        return ucfirst($strNome);
    }
}
