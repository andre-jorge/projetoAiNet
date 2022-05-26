<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Filme;
use App\Models\Genero;
use App\Models\Bilhetes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery\Generator\Parameter;
use PHPUnit\Framework\MockObject\Rule\Parameters;

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
        

    public function edit(Request $request, $id){
        $todasSessoes=DB::table('bilhetes')
                        ->select('bilhetes.id as bil', 'bilhetes.*', 'sessoes.*', 'lugares.*', 'salas.*')
                        ->leftJoin('sessoes', 'sessoes.id', '=', 'bilhetes.sessao_id')
                        ->leftJoin('lugares', 'lugares.id', '=', 'bilhetes.lugar_id')
                        ->leftJoin('salas', 'salas.id', '=', 'lugares.sala_id')
                        ->where('bilhetes.sessao_id', $id)
                        ->where('bilhetes.estado', '=','não usado')
                        ->get();
                        //dd($todasSessoes);
        return view('sessoes.edit', compact('todasSessoes'));
    }

    public function sessoes(){
        $todasSessoesFilmesHoje=DB::table('sessoes')
                                    ->leftJoin('filmes', 'sessoes.filme_id', '=', 'filmes.id')
                                    ->where('sessoes.data', '=','2020-01-01')
                                    ->get();
                                    //dd($todasSessoesFilmesHoje);                         
        return view('sessoes.sessoes', compact('todasSessoesFilmesHoje'));
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

    public function admin_index(Filme $filme)
    {
        $uri = $filme;
        //dd($filme->sessoes);
        $sessoesFilme=DB::table('sessoes')
                        ->where('filme_id', $filme->id)
                        ->get();
        //dd($sessoesFilme)
        //CONTINUAR AQUIIIIIIIIIIIIIIIIIIIIIIIIIIIIII

    return view('sessoes.admin.index', compact('sessoesFilme'));
    }

//-----------------------------------------------------------------------------------
//------------------------------ADMIN------------------------------------------------
//-----------------------------------------------------------------------------------

    public function admin_create()
      {
        $todassessoes = Sessao::pluck('data', 'horario_inicio');
        return view('sessoes.admin.create')->with('sessoes', $todassessoes);
      }

    public function admin_store(Request $request)
   {
      $todassessoes= Sessao::all();
      $validatedData = $request->validate([
        'filme_id' => 'required|max:500',
        'sala_id' => 'required|max:2',
        'data' => 'required|date',
        'horario_inicio' => 'required|date_format:H:i:s']);
        $newSessao = Sessao::create($validatedData);
        return redirect()->route('sessoes.admin.index')
              ->with('alert-msg', 'Sessao criada com sucesso')
              ->with('alert-type', 'success');
    }

    public function admin_edit(Request $request,$id)
      {
         $sessao = Sessao::where('id', $id)->first();
         //$listaSessoes = Sessao::all();
         //dd($sessao);
         return view('sessoes.admin.edit')->with('sessao', $sessao);
      }

    public function admin_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'filme_id' => 'required|max:500',
            'sala_id' => 'required|max:2',
            'data' => 'required|date',
            'horario_inicio' => 'required|date_format:H:i:s']);
            DB::table('sessoes')
                ->where('id', $id)
                ->update(['filme_id' => $validatedData['filme_id'],
                'sala_id' => $validatedData['sala_id'],
                'data' => $validatedData['data'],
                'horario_inicio' => $validatedData['horario_inicio']]);
        return redirect()->route('sessoes.admin.index')
            ->with('alert-msg', 'Sessao foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function admin_destroy(Request $request, $id)
    {
      $sessaoApagar = Sessao::find($id);
      $sessaoApagar->delete();
      //$deleted = DB::table('salas')->select('*')->where('id', $id)->delete();
        return redirect()->route('sessoes.admin.index')
            ->with('alert-msg', 'Sessao foi apagada com sucesso!')
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