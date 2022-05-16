<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessoesController extends Controller
{

        public function index()
     {
        $todasSessoes = Sessao::all();
         //->where('data', '<', '2020-01-03');//getdate())

         //dd($todasSessoes);
         //$todosFilmes = Filme::all();
         return view('sessoes.index')->with('sessoes', $todasSessoes);
     }
}
