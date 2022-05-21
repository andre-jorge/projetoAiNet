<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Sessao;
use App\Models\Genero;
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
   public function admin_index()
      {
         $filmes = Filme::all();
         return view('filmes.admin', compact('filmes'));
      }

    
   public function index()
      {
         $todosFilmes = DB::table('filmes')
                     ->paginate(8);
         //dd($todosFilmes);
         return view('filmes.index')->with('filmes', $todosFilmes);
         
      }
   public function create()
    {
        $listaGeneros = Genero::pluck('code', 'nome');
        return view('filmes.create')->with('Generos', $listaGeneros);
    }

   public function store(Request $request)
   {
      $validatedData = $request->validate([
         'titulo' => 'required|max:50',
         'genero_code' => 'required|max:20',
         'ano' => 'required|numeric|between:1950,2100',
         'cartaz_url' => 'required|max:200',
         'sumario' => 'required|max:255',
         'trailer_url' => 'required|max:200'
      ]);
      $newFilme = Filme::create($validatedData);
      return redirect()->route('filmes.index')
            ->with('alert-msg', 'Filme inserido com Sucesso')
            ->with('alert-type', 'success');
    }
}
