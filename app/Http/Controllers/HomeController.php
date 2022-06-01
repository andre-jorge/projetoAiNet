<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Sessao;
use App\Models\Genero;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentTime = Carbon::now();
         $currentTime = $currentTime->toDateString();
         $filmesAtuais = Sessao::where('sessoes.data','>', $currentTime)
                        ->with('filmes')
                        ->distinct('filme_id')
                        ->paginate(8);
                        //dd($filmesAtuais);

         // $filmesAtuais = DB::table('filmes')
         //             ->leftjoin('sessoes','sessoes.filme_id','=','filmes.id')
         //             ->where('sessoes.data','>', $currentTime)
         //             ->orderby('sessoes.data','asc')
         //             ->distinct('filmes.id')
         //             ->paginate(8);  
         // if($request->genero){
         //    $filmesAtuais = DB::table('filmes')
         //             ->leftjoin('sessoes','sessoes.filme_id','=','filmes.id')
         //             ->where('sessoes.data','>', $currentTime)
         //             ->where('filmes.genero_code',$request->genero)
         //             ->orderby('sessoes.data','asc')
         //             ->distinct()
         //             ->paginate(8); 

         // }
         

         // PROCURA POR NOME ou Sumario
         //  $todosFilmes = Filme::where([
         //     [function($query) use ($request){
         //       if (($genero = $request->genero)){
         //          $query->Where('genero_code', $genero)->get();
         //          //$query->orWhere('sumario', 'LIKE', '%' . $sumario . '%')->get();
         //        }
         //     }]
         //  ])
         //  ->paginate(8);
         //dd($filmesAtuais);
         $listaGeneros = Genero::all();
         //$filmes = $todosFilmes;
         
         return view(
             'filmes.index',
             compact('filmesAtuais', 'listaGeneros'));

        return view('filmes.index')
               ->with('alert-msg', 'Login com sucesso')
               ->with('alert-type', 'success');
        //return view('home');
    }
}
