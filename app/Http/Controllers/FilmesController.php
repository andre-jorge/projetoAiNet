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

}
   //  public function show(Request $request)
   //   {
   //      $Filme = Filme::all();
   //      $id = $request->query('filmeid', $Filme[0]->id);
   //      //dd($id);

   //      $Filmeinfo = DB::table('filmes')
   //      ->where('id',$id)
   //      ->get();// buscar sessoes do filme

   //      //dd($Filmeinfo);
   //      //$DetalhesFilme = Filme::whereIn('filme_id', $id)->get();
            
   //      $FilmeSessoes = DB::table('sessoes')
   //      ->where('filme_id',$id)
   //      ->get();// buscar sessoes do filme
   //      // \ dd($FilmeSessoes);
         
   //      return view(
   //          'filmes.show',
   //  

   

