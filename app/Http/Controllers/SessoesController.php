<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Filme;
use App\Models\Genero;
use App\Models\Bilhetes;
use App\Models\Lugares;
use App\Models\Salas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery\Generator\Parameter;
use PHPUnit\Framework\MockObject\Rule\Parameters;
use Carbon\Carbon;

class SessoesController extends Controller
{
    //FUNÇAO PARA CONTAR BILHETES E DIZER LOTAÇÃO
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

    public function lugares(Sessao $sessao)
    {
        
        $lugaresOcupados=DB::table('lugares')
                         ->select('lugares.id')
                         ->leftJoin('bilhetes', 'bilhetes.lugar_id', '=', 'lugares.id')
                         ->where('sessao_id', $sessao->id)
                         ->get();

        $lugares=$sessao->Salas->Lugares->whereNotIn('id', $lugares2=$sessao->Bilhetes->pluck('lugar_id'));
        //dd($lugares);
        $lugaresOcupados=$sessao->Salas->Lugares->whereIn('id', $lugares2=$sessao->Bilhetes->pluck('lugar_id'));
        //$fila = $lugaresOcupados->pluck('fila');
        //$posicao = $lugaresOcupados->pluck('posicao');
        $totalLugaresDisponiveis = $lugaresOcupados->count();
        //dd($totalLugaresDisponiveis);
        // dd($lugaresOcupados);
        for ($i = 0; $i < $totalLugaresDisponiveis; $i++) {
                $data = array(
                'fila' => $lugaresOcupados->pluck('fila'), 
                'posicao' => $lugaresOcupados->pluck('posicao'));
                //$newLugar = Lugares::create($data);
        }
        //dd($data);
        for ($i=0; $i < $totalLugaresDisponiveis; $i++) { 
            echo $data['fila'][$i];
            echo $data['posicao'][$i];
            $array1[$i] = array($data['fila'][$i] => $data['posicao'][$i]);
        }
        //dd($array1[0]);
        return view('sessoes.lugares')
                    ->with('lugaresOcupados', $array1)
                    ->with('sessao', $sessao)
                    ->with('lugares', $lugares);
    }

    //INDEX JÁ OK
    public function index(Request $request, Filme $filme)
    {
        $currentTime = Carbon::now();
        $currentTime = $currentTime->toDateString();
        $sessoesFilme = Sessao::where('filme_id', $filme->id)
                                    ->where('data','>', $currentTime)
                                    ->paginate(5);
                                    //dd($sessoesFilme);
        return view('sessoes.index')
                    ->with('filme', $filme)
                    ->with('sessoesFilme', $sessoesFilme);
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

    //SESSOES JÁ OK
    public function sessoes(){
        $todasSessoesFilmesHoje = Sessao::where('data','=', '2020-01-01')->get();
        
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

//-----------------------------------------------------------------------------------
//------------------------------ADMIN------------------------------------------------
//-----------------------------------------------------------------------------------
    

    //INDEX JA OK -----------------------------------------------------
    public function admin_index(Filme $filme)
    {
        $sessoesFilme=Sessao::where('filme_id',$filme->id)->get();
        return view('sessoes.admin.index', compact('sessoesFilme'));
    }

    //CRIAR JA OK ----------------------------------------------------
    public function admin_create()
      {
        $sessoes = Sessao::paginate(8);
        $listaFilmes = Filme::pluck('id', 'Titulo');
        $listaSalas = Salas::pluck('id', 'nome');
         return view('sessoes.admin.create', compact('sessoes','listaSalas', 'listaFilmes'));
      }


    //CRIAR PENSO OK ----------------------------------------------------  
    public function admin_store(Request $request)
    {
        //dd($request);
        //$todassessoes= Sessao::all();
        $validatedData = $request->validate([
            'filme_id' => 'required|max:500',
            'sala_id' => 'required|max:2',
            'data' => 'required|date',
            'horario_inicio' => 'required|date_format:H:i:s']);
            $newSessao = Sessao::create($validatedData);
            return redirect()->route('filme.index')
                ->with('alert-msg', 'Sessao criada com sucesso')
                ->with('alert-type', 'success');
    }


    //UPDATE---------------------------------------------
    //ADMIN EDIT OK
    public function admin_edit(Sessao $sessao)
      {
         $editarSessao = Sessao::where('id', $sessao->id)->first();
         $listaSalas = Salas::pluck('id', 'nome');
         return view('sessoes.admin.edit')
                    ->with('listaSalas', $listaSalas)
                    ->with('sessao', $editarSessao);
      }

    public function admin_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sala_id' => 'required|max:2',
            'data' => 'required|date',
            'horario_inicio' => 'required|date_format:H:i:s']);
            //dd($validatedData);
            DB::table('sessoes')
                ->where('id', $id)
                ->update(['sala_id' => $validatedData['sala_id'],
                'data' => $validatedData['data'],
                'horario_inicio' => $validatedData['horario_inicio']]);
        return redirect()->route('filme.index')
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