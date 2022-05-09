<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GenerosSeeder extends Seeder
{
    // Generos - usar esta tabela para associar aos seeds dos filmes
    public static $generos = [
        "COMEDY" => "Comédia",
        "SCI-FI" => "Ficção científica",
        "HORROR" => "Terror",
        "ROMANCE" => "Romance",
        "ACTION" => "Acção",
        "THRILLER" => "Suspense",
        "DRAMA" => "Drama",
        "MISTERY" => "Mistério",
        "CRIME" => "Crime",
        "ANIMATION" => "Animação",
        "ADVENTURE" => "Aventura",
        "FAMILY" => "Família",
        "FANTASY" => "Fantasia",
        "COMEDY-ROMANCE" => "Comédia romântica",
        "COMEDY-ACTION" => "Comédia e acção",
        "SUPERHERO" => "Super herois",
        "MUSICAL" => "Musical",
        "BIBLOGRAPHY" => "Bibliografia",
        "HISTORY" => "Histórico",
        "WESTERN" => "Western",
        "WAR" => "Guerra",
        "CULT" => "Filme de culto",
        "SILENT" => "Filme silencioso",
    ];

    public function run()
    {
        $this->command->info("Generos de filmes");
        foreach (GenerosSeeder::$generos as $key => $value) {
            $id = DB::table('generos')->insert([
                'code' => $key,
                'nome' => $value,
                'deleted_at' => null
            ]);
        }
        $faker = \Faker\Factory::create('pt_PT');
        DB::table('generos')
            ->where('code', 'SILENT')
            ->update(['deleted_at' =>  $faker->dateTimeBetween('-3 months', '-1 months')]);
    }
}
