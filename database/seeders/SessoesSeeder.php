<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Carbon\Carbon;


class SessoesSeeder extends Seeder
{
    private $numberOfYears = 2;
    private $numberOfAvgSessionPerMovie = 24;
    private $deltaSessionPerMovieDown = 20;
    private $deltaSessionPerMovieUp = 50;
    private $numberOfDaysAfterToday = 10;
    private $lugares = [];
    private $avgTaxaOcupacao = 20;
    private $horariosSessoes = [  // Domingo, Segunda, etc... 12 sesõoes por semana
        [14, 18, 22],
        [19],
        [19],
        [19],
        [21],
        [21],
        [13, 16, 19, 22],
    ];
    private $clientes = [];
    private $movies = [];
    private $quantidades = [1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 6, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10];
    private $faker = null;

    public function run()
    {
        $this->faker = \Faker\Factory::create('pt_PT');
        $this->command->info("Sessões e bilhetes");

        $today = Carbon::today();

        // CHANGE - INCREMENTAL
        $this->start_date = $today->copy();
        $this->start_date->subYears($this->numberOfYears);
        $d = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date->year . "-1-1 00:00:00");
        $largestOldSessionId = -1;
        if (DatabaseSeeder::$seedType == 'incremental') {
            if (Storage::exists('seed_info.log')) {
                $data =  Storage::get('seed_info.log');
                $data = Carbon::createFromFormat('Y-m-d H:i:s',  $data);
            } else {
                $data = DB::table('sessoes')->max('data');
                $data = Carbon::createFromFormat('Y-m-d H:i:s',  $data . ' 0:00:00');
            }
            $data->subDays($this->numberOfDaysAfterToday);
            $d = $data->copy();
            $this->command->info("Vai reconstruir sessões, bilhetes e recibos a partir da data: " . $d->format('Y-m-d'));
            $this->prepareIncremental($data);
            SalasSeeder::fillSalasInfo();
            $this->fillLugares();
            $largestOldSessionId = DB::table('sessoes')->max('id');
        }

        $this->end_date = $today->copy();
        $this->end_date->addDays($this->numberOfDaysAfterToday);
        $i = 0;

        $this->criarPastaRecibos();
        $this->fillClientes();
        $this->fillLugares();
        $this->rebuildListOfMovies();

        // Generate All Sessions:
        $salas_IDs = array_keys(SalasSeeder::$salas);
        $sessoesToSave = [];
        $moviesSalas = null;

        while ($d->lessThanOrEqualTo($this->end_date)) {
            $moviesSalas = $this->distribui_movies_salas($moviesSalas);
            $sessoes = $this->horariosSessoes[$d->dayOfWeek];
            foreach ($sessoes as $sessao) {
                foreach($salas_IDs as $salaId) {
                    $sessoesToSave[] = $this->createSessaoArray($moviesSalas[$salaId][0], $salaId, $d, $sessao);
                    $moviesSalas[$salaId][1]--;
                }
            }
            if ($i % 100 == 0) { /// 100 em 100 dias grava as sessões
                $this->command->info("Está a inserir sessões até à data " . $d->toDateString());
                DB::table('sessoes')->insert($sessoesToSave);
                $sessoesToSave = [];
            }
            $i++;
            $d->addDays(1);
        }
        // Guarda as sessões restantes
        if (count($sessoesToSave)>1) {
            $this->command->info("Está a inserir sessões até à data " . $d->toDateString());
            DB::table('sessoes')->insert($sessoesToSave);
            $sessoesToSave = [];
        }
        // Apaga as sessões da sala soft_deleted depois de uma determinada data:
        $dataRef = $this->end_date->copy();
        $dataRef->subDays(200);
        $this->command->info("Vai apagar sessões da sala 5 (softdeleted) depois da data " . $dataRef->toDateString());
        DB::table('sessoes')
            ->where('sala_id', 5)
            ->where('data', '>', $dataRef)
            ->delete();

        $sessoes = DB::table('sessoes')->where('id', '>', $largestOldSessionId)->get();
        $totalSessoes = $sessoes->count();

        $i = 0;
        $comprasToSave = [];
        foreach ($sessoes as $sessao) {
            $this->createAndSaveComprasForSessao($sessao);
            if ($i % 100 == 0) { /// 100 em 100 sessoes mostra uma mensage
                $this->command->info("Criou e gravou recibos e bilhetes para a sessão $i/$totalSessoes");
            }
            if ($i % 1000 == 0) { /// 500 em 500 sessoes atualiza a percentagem ocupação
                $this->avgTaxaOcupacao = $this->avgTaxaOcupacao - rand(1,3) + rand(1,4);
                $this->avgTaxaOcupacao = $this->avgTaxaOcupacao < 5 ? 5 : $this->avgTaxaOcupacao;
                $this->avgTaxaOcupacao = $this->avgTaxaOcupacao > 80 ? 80 : $this->avgTaxaOcupacao;
                $this->command->info("Nova taxa de ocupação média = $this->avgTaxaOcupacao");
            }
            $i++;
        }
        $this->command->info("Criou e gravou recibos e bilhetes para a sessão $i/$totalSessoes");

        $totalBilhetesVendidos = DB::table('bilhetes')->count();
        $this->command->info("Total de bilhetes vendidos = $totalBilhetesVendidos");
        Storage::put('seed_info.log', $this->end_date->format('Y-m-d H:i:s'));
    }

    private function prepareIncremental($data)
    {
        $sessoes_to_delete = DB::table('sessoes')->where('data', '>=', $data)->pluck('id')->toArray();
        DB::table('bilhetes')->whereIntegerInRaw('sessao_id', $sessoes_to_delete)->delete();
        DB::table('sessoes')->whereIntegerInRaw('id', $sessoes_to_delete)->delete();
        DB::delete('delete from recibos where id not in (select recibo_id from bilhetes)');
    }


    private function fillClientes()
    {
        $this->clientes = DB::table('clientes')
            ->select(DB::raw('clientes.id, clientes.nif, clientes.tipo_pagamento, clientes.ref_pagamento, users.name'))
            ->join('users', 'clientes.id', '=', 'users.id')
            ->get()
            ->toArray();
    }

    private function fillLugares()
    {
        $salas_IDs = array_keys(SalasSeeder::$salas);
        foreach ($salas_IDs as $salaId) {
            $this->lugares[$salaId] = DB::table('lugares')->select('id')->where('sala_id', $salaId)->pluck('id')->toArray();
        }
    }

    private function shuffleLugares($sala = null)
    {
        $salas_IDs = array_keys(SalasSeeder::$salas);
        if ($sala == null) {
            foreach ($salas_IDs as $salaId) {
                $this->lugares[$salaId] = Arr::shuffle($this->lugares[$salaId]);
            }
        } else {
            $this->lugares[$sala] = Arr::shuffle($this->lugares[$sala]);
        }
    }

    private function shuffleClientes()
    {
        $this->clientes = Arr::shuffle($this->clientes);
    }

    private function fillMovies()
    {
        $idsMoviesUsed = DB::table('sessoes')->select('filme_id')->distinct()->pluck('filme_id')->toArray();
        if (empty($idsMoviesUsed)) {
            $this->movies = DB::table('filmes')->select('id')->pluck('id')->toArray();
        } else {
            $this->movies = DB::table('filmes')->select('id')->whereNotIn('id', $idsMoviesUsed)->pluck('id')->toArray();
            if (empty($this->movies) || (count($this->movies)< 20) ) {
                $this->movies = DB::table('filmes')->select('id')->pluck('id')->toArray();
            }
        }
    }

    private function shuffleMovies()
    {
        $this->movies = Arr::shuffle($this->movies);
    }

    private function rebuildListOfMovies(){
        $this->command->info("Rebuilding list of movies");
        $this->fillMovies();
        $this->shuffleMovies();
    }

    private function distribui_movies_salas($salasMovies){
        if (count($this->movies) == 0) {
            $this->rebuildListOfMovies();
        }
        if (!is_array($salasMovies)) {
            $salasMovies = [
                1 => [null, 0],
                2 => [null, 0],
                3 => [null, 0],
                4 => [null, 0],
                5 => [null, 0],
                6 => [null, 0],
                7 => [null, 0],
                8 => [null, 0],
            ];
        }
        foreach ($salasMovies as $key => $salaMovie) {
            if ($salaMovie[1] <= 0) { // Sessões desse filme acabaram. Passa a outro filme
                $totalSessoes = $this->numberOfAvgSessionPerMovie - rand(1, $this->deltaSessionPerMovieDown) + rand(1, $this->deltaSessionPerMovieUp);

                $removedMovie = array_shift($this->movies);
                if (count($this->movies) == 0) {
                    $this->rebuildListOfMovies();
                }
                $salasMovies[$key] = [$removedMovie, $totalSessoes];
                //$this->command->info("aleatorio (sala = $key) = movie: " . $salasMovies[$key][0]. " total = " . $salasMovies[$key][1]);
            }
        }
        return $salasMovies;
    }

    private function createSessaoArray($filme, $sala, $data, $hora)
    {
        $inicio = $data->copy()->subDays(8)->addSeconds(rand(39600, 78000));
        $fim = $inicio->copy()->subDays(7)->addSeconds(rand(60, 300000));
        return [
            'filme_id' => $filme,
            'sala_id' => $sala,
            'data' => $data->toDateString(),
            'horario_inicio' => $hora . ":00:00",
            'created_at' => $inicio,
            'updated_at' => $fim,
        ];
    }

    private function createAndSaveComprasForSessao($sessao)
    {
        $this->shuffleLugares($sessao->sala_id);
        $d = Carbon::createFromFormat('Y-m-d', $sessao->data);
        $diaSemana = $d->dayOfWeek;
        if (($diaSemana == 0) || ($diaSemana == 6)) {
            $factor = 1.1;
        } else {
            $factor = 0.3;
        }
        $taxa = ($this->avgTaxaOcupacao + rand(1,20) + rand(1,20)) * $factor;
        $totalLugares = SalasSeeder::$salas[$sessao->sala_id];
        $totalBilhetes = round($totalLugares * $taxa / 100, 0);
        $totalBilhetes = min($totalBilhetes, $totalLugares);
        $totalBilhetes = max($totalBilhetes, 0);

        $arrayCompras = [];
        $idxLugar = 0;
        while ($totalBilhetes > 0) {
            $cliente = $this->faker->randomElement($this->clientes);
            $qtdBilhetes = $this->faker->randomElement($this->quantidades);
            $qtdBilhetes = $qtdBilhetes > $totalBilhetes ? $totalBilhetes : $qtdBilhetes;
            $totalBilhetes -= $qtdBilhetes;
            $compraArray = $this->createCompraArray($sessao, $cliente, $qtdBilhetes,$idxLugar);
            $arrayCompras[] = $compraArray;
        }
        $this->saveCompras($arrayCompras);
    }

    private function createCompraArray($sessao, $cliente, $numBilhetes, &$idxLugar)
    {
        $d = Carbon::createFromFormat('Y-m-d', $sessao->data);
        $d->subDays(rand(1,7))->addSeconds(rand(60, 780000));
        $precoTotal = round($numBilhetes * 8.85,2);
        $iva = round($precoTotal * 0.13, 2);
        $updated = $d->copy()->addSeconds(rand(60, 300000));
        $bilhetes = [];
        for($i=0; $i < $numBilhetes; $i++) {
            if ($idxLugar >= count($this->lugares[$sessao->sala_id])) {
                break;
            }
            $bilhetes[] = [
                'recibo_id' => null,
                'cliente_id' => $cliente->id,
                'sessao_id' => $sessao->id,
                'lugar_id' => $this->lugares[$sessao->sala_id][$idxLugar],
                'preco_sem_iva' => 8.85,
                'estado' => $sessao->data > Carbon::now() ? 'não usado' : (rand(1,6) == 3 ? 'não usado' : 'usado')
            ];
            $idxLugar++;
        }
        if (count($bilhetes) == 0) {
            return [];
        }
        return [
            'cliente_id' => $cliente->id,
            'data' => $d->toDateString(),
            'preco_total_sem_iva' => $precoTotal,
            'iva' => $iva,
            'preco_total_com_iva' => $precoTotal + $iva,
            'nif' => $cliente->nif,
            'nome_cliente' => $cliente->name,
            'tipo_pagamento' => $cliente->tipo_pagamento ?: 'MBWAY',
            'ref_pagamento' => $cliente->ref_pagamento ?: '9' . $this->faker->randomNumber($nbDigits = 8, $strict = true),
            'recibo_pdf_url' => null,
            'created_at' => $d,
            'updated_at' => $updated,
            'bilhetes' => $bilhetes
        ];
    }


    private function criarPastaRecibos()
    {
        Storage::deleteDirectory('pdf_recibos');
        Storage::makeDirectory('pdf_recibos');
    }


    private function saveCompras($comprasToSave)
    {
        foreach ($comprasToSave as $compraToSave) {
            DB::transaction(function () use ($compraToSave) {
                $arrayCompra = Arr::except($compraToSave, ['bilhetes']);
                $idRecibo = DB::table('recibos')->insertGetId($arrayCompra);
                foreach ($compraToSave['bilhetes'] as $key => $value) {
                    $compraToSave['bilhetes'][$key]['recibo_id'] = $idRecibo;
                }
                DB::table('bilhetes')->insert($compraToSave['bilhetes']);
            });
        }
    }

}
