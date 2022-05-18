<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Sessao;
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

    public function index()
     {
        $todosFilmes = DB::table('filmes')
                    ->paginate(8);
        //dd($todosFilmes);
        return view('filmes.index')->with('filmes', $todosFilmes);

     }

    public function show(Request $request)
     {
        $Filme = Filme::all();
        $id = $request->query('filmeid', $Filme[0]->id);
        //dd($id);

        $Filmeinfo = DB::table('filmes')
        ->where('id',$id)
        ->get();// buscar sessoes do filme

        //dd($Filmeinfo);
        //$DetalhesFilme = Filme::whereIn('filme_id', $id)->get();
            
        $FilmeSessoes = DB::table('sessoes')
        ->where('filme_id',$id)
        ->get();// buscar sessoes do filme
        //  dd($FilmeSessoes);
         
        return view(
            'filmes.show',
            compact('FilmeSessoes', 'Filmeinfo'));
     }
}
