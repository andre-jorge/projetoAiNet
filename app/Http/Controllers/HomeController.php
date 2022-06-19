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
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //dd($request);
        $currentTime = Carbon::now();
        $currentTime = $currentTime->toDateString();
        $filmesGenero = null;
        $filmesAtuais = Sessao::where('data','>', $currentTime)
                       ->get()
                       ->unique('filme_id');

        $generoPedido = Genero::where('code','=','Todos')->first();
        //dd($generoPedido);
        if($request->genero && $request->genero != null ){
           $filmesGenero = Filme::where('genero_code',$request->genero)->pluck('id');
           $filmesAtuais = Sessao::where('data','>', $currentTime)
                       ->whereIn('filme_id',$filmesGenero)
                       ->get()
                       ->unique('filme_id'); 
           $generoPedido = Genero::where('code','=',$request->genero)->first();

        }
        if($request->string && $request->string != null){
           $filmeString = Filme::where('titulo', 'like', '%' . $request->string . '%')
                          ->OrWhere('sumario', 'like', '%' . $request->string . '%')
                          ->pluck('id');
           $filmesAtuais = Sessao::where('sessoes.data','>', $currentTime)
                       ->whereIn('filme_id',$filmeString)
                       ->get()
                       ->unique('filme_id');         
                 }
        $listaGeneros = Genero::all();         
        return view(
            'filmes.index',
            compact('generoPedido','filmesGenero','filmesAtuais', 'listaGeneros'));
    }
}
