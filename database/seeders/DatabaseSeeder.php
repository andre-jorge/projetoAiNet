<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public static $seedType = "full";

    public static function readCSVFile($filename, $startFromRow = 1): array
    {
        $line_of_text = [];
        $file_handle = fopen($filename, 'r');
        try {
            while (!feof($file_handle)) {
                $line = fgetcsv($file_handle, 0, ';');
                if (empty($line)) {
                    continue;
                }
                if ((count($line) == 1) && (trim($line[0]) == '')) {
                    continue;
                }
                $line_of_text[] = $line;
            }
        } finally {
            fclose($file_handle);
        }

        return array_slice($line_of_text, $startFromRow-1);
    }


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function runComplete()
    {
        DB::statement("SET foreign_key_checks=0");

        DB::table('configuracao')->delete();
        DB::table('generos')->delete();
        DB::table('users')->delete();
        DB::table('clientes')->delete();
        DB::table('filmes')->delete();
        DB::table('salas')->delete();
        DB::table('lugares')->delete();
        DB::table('sessoes')->delete();
        DB::table('recibos')->delete();
        DB::table('bilhetes')->delete();

        DB::statement('ALTER TABLE configuracao AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE filmes AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE salas AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE lugares AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE sessoes AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE recibos AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE bilhetes AUTO_INCREMENT = 0');

        DB::statement("SET foreign_key_checks=1");

        $this->call(ConfiguracaoSeeder::class);
        $this->call(GenerosSeeder::class);
        $this->call(FilmesSeeder::class);
        $this->call(SalasSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(SessoesSeeder::class);
    }

    public function runIncremental()
    {
        $this->call(SessoesSeeder::class);
    }

    public function run()
    {
        $this->command->info("-----------------------------------------------");
        $this->command->info("START of database seeder");
        $this->command->info("-----------------------------------------------");
        if (DB::table('generos')->count() == 0) {
            DatabaseSeeder::$seedType = 'completo';
        } else {
            DatabaseSeeder::$seedType = $this->command->choice('Que tipo de seeder pretende aplicar? ("completo" para recriar toda a BD; "incremental" para adicionar apenas sessões e bilhetes para datas posteriores ao ultimo "seeder")', ['completo', 'incremental'], 1);
            if (DatabaseSeeder::$seedType == 'completo') {
                $this->command->info("-----------------------------------------------");
                $this->command->info("seed 'completo' - todos os dados serão apagados e reconstruidos de novo");
                $this->command->info("-----------------------------------------------");
            } else {
                $this->command->info("-----------------------------------------------");
                $this->command->info("seed 'incremental' - Só serão acrescentadas sessões, bilhetes e recibos para os dias mais recentes");
                $this->command->info("-----------------------------------------------");
            }
        }
        if (DatabaseSeeder::$seedType == 'completo') {
            $this->runComplete();
        } else {
            $this->runIncremental();
        }

        $this->command->info("-----------------------------------------------");
        $this->command->info("END of database seeder");
        $this->command->info("-----------------------------------------------");
    }


}
