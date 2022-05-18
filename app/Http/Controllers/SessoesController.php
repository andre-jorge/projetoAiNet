<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessoesController extends Controller
{

   //      public function index()
   //   {
   //      $todasSessoes = DB::table('sessoes')->get();
   //       //->where('data', '<', '2020-01-03');//getdate())

   //       //dd($todasSessoes);
   //       //$todosFilmes = Filme::all();
   //       return view('sessoes.index')->with('sessoes', $todasSessoes);
   //   }

     public function index(Request $request)
    {
        $listaFilmes = Filme::all();
        $id = $request->query('sess', $listaFilmes[0]->id);
        dd($id);
        $filmes = Filme::findOrFail($id);
        $sessao = $filmes->sessao;
        return view(
            'sessoes.index',
            compact('sessao', 'listaFilmes', 'filmes')
        );
    }
}
