<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Filme;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class FilmesController extends Controller
{
    // public function admin_index()
    // {
    //     $todosCursos = Curso::all();
    //     return view('cursos.admin')->with('cursos', $todosCursos);
    // }

    // public function index(Request $request)
    // {
    //     $listaFilmes = DB::table('filmes')
    //     ->leftjoin('sessoes', 'filmes.id', '=', 'sessoes.filme_id')
    //     ->where('sessoes.data', '<', '2020-01-03')//getdate())
    //     ->orderBy('data','asc')
    //     ->paginate(8);
    //     $id = $request->query('film', $listaFilmes[0]->id);
    //     $filme = Filme::findOrFail($id);
    //     return view('filmes.index', compact('listaFilmes', 'filme'));
    // }


     public function index()
     {
        $todosFilmes = DB::table('filmes')
         ->leftjoin('sessoes', 'filmes.id', '=', 'sessoes.filme_id')
         ->where('sessoes.data', '<', '2020-01-03')//getdate())
         ->orderBy('data','asc')
         ->paginate(8);

         //dd($todosFilmes);
         //$todosFilmes = Filme::all();
         return view('filmes.index')->with('filmes', $todosFilmes);
     }
}
