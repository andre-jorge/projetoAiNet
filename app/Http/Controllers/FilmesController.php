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

    
   public function index(Request $request)
      {
         
        


         // PROCURA POR NOME ou Sumario
          $todosFilmes = Filme::where([
             [function($query) use ($request){
               if (($term = $request->term)){
                  $query->orWhere('titulo', 'LIKE', '%' . $term . '%')->get();
                   $query->orWhere('sumario', 'LIKE', '%' . $term . '%')->get();
                }
             }]
          ])
          ->paginate(8);
         $listaGeneros = Genero::all();
         $filmes = $todosFilmes;
         return view(
             'filmes.index',
             compact('filmes', 'listaGeneros')
         );


        //ORIGINAL
         //$todosFilmes = DB::table('filmes')
          //          ->paginate(8);
         //dd($todosFilmes);
         //return view('filmes.index')->with('filmes', $todosFilmes);
         
      }

  public function create()
      {
        $listaGeneros = Genero::pluck('code', 'nome');
        return view('filmes.create')->with('Generos', $listaGeneros);


   public function edit(Request $request,$id)
      {
         $filme = Filme::where('id', $id)->first();
         $listaGeneros = Genero::pluck('code', 'nome');
         return view('filmes.edit')->withFilme($filme)
                                   ->with('Generos', $listaGeneros);
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
      //dd($validatedData);
      $newFilme = Filme::create($validatedData);
      //DB::table('filmes')->insert($validatedData);
      return redirect()->route('filmes.admin')
            ->with('alert-msg', 'Filme inserido com Sucesso')
            ->with('alert-type', 'success');
    }
}

