<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessoesController extends Controller
{
    public function index(Request $request, $id)
    {
        $listaSessoes = Sessao::all();
        //dd($listaSessoes);
        //$idfilme = $request->query('filmeid', $listaSessoes[0]->id);
        $filme = Filme::where('id', $id)->first();
        //$sessoesFilme = Sessao::where('filme_id', $id)->get();
        //dd($sessoesFilme);
        $sessoesFilme=DB::table('sessoes')
                        ->leftJoin('salas', 'salas.id', '=', 'sessoes.sala_id')
                        ->where('sessoes.filme_id', $id)
                        ->get();
        //    //       //->where('data', '<', '2020-01-03');//getdate())

    return view('sessoes.index', compact('sessoesFilme', 'filme', 'id'));
    }

   
}


// //      public function index()
//    //   {
//    //      $todasSessoes = DB::table('sessoes')->get();
//    //       //->where('data', '<', '2020-01-03');//getdate())

//    //       //dd($todasSessoes);
//    //       //$todosFilmes = Filme::all();
//    //       return view('sessoes.index')->with('sessoes', $todasSessoes);
//    //   }

//    public function index(Request $request)
//    {
//        // $listaFilmes = Filme::all();
//        // $id = $request->query('sess', $listaFilmes[0]->id);
//        // dd($id);
//        // $filmes = Filme::findOrFail($id);
//        // $Filmesessao = DB::table('filmes')
//        // ->where('id', $filmes->id)
//        // ->pluck('id');
//        // $filmes = Filmes::whereIn('id', $Filmesessao)->get();
//        // $sessao = $filmes->sessao;
//        // return view(
//        //     'sessoes.index',
//        //     compact('sessao', 'listaFilmes', 'filmes')
//        // );

//        $Sessoes = Sessao::all();
//        $id = $request->query('fil', $Sessoes[0]->id);
//        //dd($id);
//        $idfilme = Filme::findOrFail($id);
//        //dd($idfilme);
//        //$DetalhesFilme = Filme::whereIn('filme_id', $id)->get();
           
//        $FilmeSessoes = DB::table('sessoes')
//        ->get();
//        //dd($FilmeSessoes);

//        return view(
//        'sessoes.index',
//        compact('FilmeSessoes', 'Sessoes'));

//    }