<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfiguracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("Configuracação de parâmetros");
        DB::table('configuracao')->insert([
            "preco_bilhete_sem_iva" => 8.85,
            "percentagem_iva" => 13
        ]);
    }
}
