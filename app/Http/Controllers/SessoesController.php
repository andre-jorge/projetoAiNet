<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Filme;
use App\Models\Genero;
use App\Models\Bilhetes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessoesController extends Controller
{
    public static function ContaBilhetes($arg1,$arg2,$args3){
        $sessoesFilmeBilhetes=DB::table('sessoes')
                        ->leftJoin('salas', 'salas.id', '=', 'sessoes.sala_id')
                        ->leftJoin('bilhetes', 'bilhetes.sessao_id', '=', 'sessoes.id')
                        ->where('sessoes.filme_id', $arg1)
                        ->where('sessoes.data', $arg2)
                        ->where('sessoes.horario_inicio', $args3)
                        ->count();
        return $sessoesFilmeBilhetes;
    }

    public function index(Request $request, $id)
    {
        $listaSessoes = Sessao::all();
        //dd($listaSessoes);
        //$idfilme = $request->query('filmeid', $listaSessoes[0]->id);
        $filme2 = Filme::where('id', $id)->first();
        $FilmeDetalhes = DB::table('filmes')
                        ->select('*')
                        ->leftJoin('generos', 'generos.code', '=', 'filmes.genero_code')
                        ->where('filmes.id', $id)
                        ->first();
                        //dd($filme2);
        //$sessoesFilme = Sessao::where('filme_id', $id)->get();
        //dd($sessoesFilme);
        $sessoesFilme=DB::table('sessoes')
                        ->leftJoin('salas', 'salas.id', '=', 'sessoes.sala_id')
                        ->where('sessoes.filme_id', $id)
                        ->get();

        //Carinho
        $cart = session()->get('cart');
        if ($cart == null)
            $cart = [];

    return view('sessoes.index', compact('sessoesFilme', 'FilmeDetalhes', 'id', 'cart'));
    }


    public function addToCart(Request $request)
        {
            session()->put('cart', $request->post('cart'));

            return response()->json([
                'status' => 'added'
            ]);
        }
        

    public function edit(Request $request){
        $todasSessoes=DB::table('bilhetes')
                        ->select('bilhetes.id as bil', 'bilhetes.*', 'sessoes.*', 'lugares.*', 'salas.*')
                        ->leftJoin('sessoes', 'sessoes.id', '=', 'bilhetes.sessao_id')
                        ->leftJoin('lugares', 'lugares.id', '=', 'bilhetes.lugar_id')
                        ->leftJoin('salas', 'salas.id', '=', 'lugares.sala_id')
                        ->where('sessoes.data', '=','2020-01-01')
                        ->where('sessoes.horario_inicio', '=','19:00:00')
                        ->where('sessoes.filme_id', '=','327')
                        ->where('bilhetes.estado', '=','não usado')
                        ->get();
                        //dd($todasSessoes);
        return view('sessoes.edit', compact('todasSessoes'));
    }
    

    public function update(Request $request, $id)
    {
        $testes= "nao usado";
        //dd($testes);
        Bilhetes::where('id',$id)->update(['estado'=>'usado']);
        return redirect()->route('sessoes.edit')
                ->with('alert-msg', 'Bilhete validado com sucesso!')
                ->with('alert-type', 'success');
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