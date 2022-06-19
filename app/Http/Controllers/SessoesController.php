<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Filme;
use App\Models\Genero;
use App\Models\Bilhetes;
use App\Models\Lugares;
use App\Models\Salas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery\Generator\Parameter;
use PHPUnit\Framework\MockObject\Rule\Parameters;
use Carbon\Carbon;

class SessoesController extends Controller
{
    public function index(Request $request, Filme $filme){
        $currentTime = Carbon::now();
        $currentTime = $currentTime->toDateString();
        $sessoesFilme = Sessao::where('filme_id', $filme->id)
                                    ->where('data','>', $currentTime)
                                    ->paginate(5);
                                    //dd($sessoesFilme);
        
        //dd($contaBilhetes);
        return view('sessoes.index')
                    ->with('filme', $filme)
                    ->with('sessoesFilme', $sessoesFilme);
    }





    //FUNÇAO PARA CONTAR BILHETES E DIZER LOTAÇÃO
    public static function ContaBilhetes($arg1){
        $sessoesFilmeBilhetes = Bilhetes::where('sessao_id',$arg1)->count();
        // $sessoesFilmeBilhetes=DB::table('sessoes')
        //                 ->leftJoin('salas', 'salas.id', '=', 'sessoes.sala_id')
        //                 ->leftJoin('bilhetes', 'bilhetes.sessao_id', '=', 'sessoes.id')
        //                 ->where('sessoes.filme_id', $arg1)
        //                 ->where('sessoes.data', $arg2)
        //                 ->where('sessoes.horario_inicio', $args3)
        //                 ->count();
        return $sessoesFilmeBilhetes;
    }

    public function lugares(Request $request, Sessao $sessao)
    {        
        //TAMANHO SALA
        $num_filas=Lugares::where('sala_id', $sessao->sala_id)
                    ->get()
                    ->unique('fila')
                    ->count();
        //dd($fila);

        $num_pos=Lugares::where('sala_id', $sessao->sala_id)
                    ->get()
                    ->unique('posicao')
                    ->count();
        //dd($num_pos);


        $lugaresOcupados=DB::table('lugares')
                         ->select('lugares.id')
                         ->leftJoin('bilhetes', 'bilhetes.lugar_id', '=', 'lugares.id')
                         ->where('sessao_id', $sessao->id)
                         ->get();
        $carrinho = $request->session()->get('carrinho', [] );
        $carrinhoCount = $request->session()->get('count');
        //dd($carrinhoCount);
        $lugares2=$sessao->Bilhetes->pluck('lugar_id');
        
        //funcao para saber se tem uma sessao dessas no carinho
        //nao deixa duplicar bilhetes no carrinho
        //dd(count($carrinho)+1);
        if (count($carrinho)+1 == 1) {
            
            $array1[0] = array(0 => 0);
            $teste = $lugares2;
        }else{
            for ($i=1 ; $i < $carrinhoCount+1 ; $i++) { 
                if (array_key_exists($i, $carrinho)) {
                    if ($carrinho[$i]['id'] == $sessao->id ) {
                        $array1[$carrinho[$i]['idLugar']] = array($carrinho[$i]['idLugar'] => $carrinho[$i]['idLugar']);
                        $teste = $lugares2->push($carrinho[$i]['idLugar']);
                    }
                }
            }
        }
        //dd($teste);
        //dd($lugares2->toArray());
        $lugares=$sessao->Salas->Lugares
                        ->whereNotIn('id', $lugares2);
                        //dd($lugares2);
        $lugaresOcupados=$sessao->Salas->Lugares->whereIn('id', $lugares2=$sessao->Bilhetes->pluck('lugar_id'));
        //$fila = $lugaresOcupados->pluck('fila');
        //$posicao = $lugaresOcupados->pluck('posicao');
        $totalLugaresDisponiveis = $lugaresOcupados->count();
        //dd($totalLugaresDisponiveis);
        //dd($lugaresOcupados);
        for ($i = 0; $i < $totalLugaresDisponiveis; $i++) {
                $data = array(
                'fila' => $lugaresOcupados->pluck('fila'), 
                'posicao' => $lugaresOcupados->pluck('posicao'));
                //$newLugar = Lugares::create($data);
        }
        //dd($data);
        for ($i=0; $i < $totalLugaresDisponiveis; $i++) { 
            //MOSTRA STRINC COM LUGARES OCUPADOS
            // echo $data['fila'][$i];
            // echo $data['posicao'][$i];

            //ARRAY COM LUGARES OCUPADOS
            $array1[$i] = array($data['fila'][$i] => $data['posicao'][$i]);
        }
        //dd($array1);
        return view('sessoes.lugares')
        ->with('carrinho', session('carrinho') ?? [])
                    ->with('lugaresOcupados', $lugaresOcupados)
                    ->with('sessao', $sessao)
                    ->with('lugares', $lugares)
                    ->with('num_filas', $num_filas)
                    ->with('num_pos', $num_pos);
                    
    }



//----------------------------------------------------------------------------------
//-----------------FUNCIONARIOS VALIDAR SESSOES-------------------------------------
//----------------------------------------------------------------------------------
    public function funcionarioSessoes(Request $request)
    {
        //dd($request);
        $currentTime = Carbon::now();
        $currentTime = $currentTime->toDateString();
        $sessoesValidar = Sessao::where('data','>', $currentTime)->get();  
        $sessoesPorFilme = Sessao::where('data','>', $currentTime)
                                    ->where('filme_id', $request)
                                    ->get();
        return view('sessoes.funcionario.index')
                ->with('sessoesValidar', $sessoesValidar);
    }

    public function funcionarioValidarSessoes(Request $request, Sessao $sessao)
    {
        //dd($sessao);
        $currentTime = Carbon::now();
        $currentTime = $currentTime->toDateString();
        $todosBilhetes = Bilhetes::where('sessao_id',$sessao->id)
                            ->where('estado','=','não usado')
                            ->get();
        $sessao = Sessao::where('id',$sessao->id)->first();
        //dd($sessao);
        return view('sessoes.funcionario.validarSessao')
                ->with('sessao', $sessao)
                ->with('todosBilhetes', $todosBilhetes);
    }

    public function validaBilhete(Request $request, Bilhetes $bilhete)
    {
        //dd($request);
        $currentTime = Carbon::now();
        $currentTime = $currentTime->toDateString();
        Bilhetes::where('id', $bilhete->id)
                ->update(['estado' => 'usado']);
        $sessaoBilhete = Bilhetes::where('id', $bilhete->id)->pluck('sessao_id');
        $sessao = Sessao::where('id',$sessaoBilhete[0])->first();
        $user = User::where('id', $bilhete->cliente_id)->first();
        //dd($user);
        return view('sessoes.funcionario.validado')
                ->with('bilheteId', $bilhete->id)
                ->with('sessao', $sessao)
                ->with('user', $user)
                ->with('successMsg', 'Bilhete '.$bilhete->id.' validado com sucesso!')
                ->with('alert-type', 'danger');
    }

    public function validaBilhetePorId(Request $request, Sessao $sessao)
    {
        //dd($request->string);
        $idBilhete = $request->string;
        //buscar apenas o id no fim do link
        $idBilhete = substr($idBilhete,strpos($idBilhete, "bilhete/")+8);
        $sessao = Sessao::where('id',$sessao->id)->first();
        //dd($sessao);
        $bilhete = Bilhetes::where('id',$idBilhete)->first();
        $user = User::where('id', $bilhete->cliente_id)->first();

        if ($bilhete->sessao_id == $sessao->id) {
            if ($bilhete->estado == 'não usado') {
                Bilhetes::where('id', $bilhete->id)
                        ->update(['estado' => 'usado']);
                return view('sessoes.funcionario.validado')
                        ->with('bilheteId', $bilhete->id)
                        ->with('sessao', $sessao->id)
                        ->with('user', $user)
                        ->with('alert-msg', 'Bilhete '.$bilhete->id.' validado com sucesso!')
                        ->with('alert-type', 'success');
            }else{
                //dd($bilhete->estado);
                return back()
                        ->with('bilheteId', $bilhete->id)
                        ->with('sessao', $sessao->id)
                        ->with('user', $user)
                        ->with('alert-msg', 'Bilhete '.$bilhete->id.' já validado!!')
                        ->with('alert-type', 'danger');
            }
        }else{
            $outroFilme = Filme::where('id',$sessao->filme_id)->first();
            return back()
                        ->with('bilheteId', $bilhete->id)
                        ->with('sessao', $sessao->id)
                        ->with('user', $user)
                        ->with('alert-msg', 'Bilhete '.$bilhete->id.' não pertence a este filme!!, mas sim ao filme '.$outroFilme->titulo.'.')
                        ->with('alert-type', 'danger');
        }
    }
//------------END--FUNCIONARIOS VALIDAR SESSOES----------END--------------------
//------------END--FUNCIONARIOS VALIDAR SESSOES----------END--------------------
//------------END--FUNCIONARIOS VALIDAR SESSOES----------END--------------------


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
        $continuar = 0;
         return view('sessoes.admin.create', compact('sessoes','continuar','listaSalas', 'listaFilmes'));
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
            'horario_inicio' => 'required|date_format:H:i']);
            $newSessao = Sessao::create($validatedData);

        if ($request->continuar == 1) {
                $sessoes = Sessao::paginate(8);
                $listaFilmes = Filme::pluck('id', 'Titulo');
                $listaSalas = Salas::pluck('id', 'nome');
                $continuar = 1;
                return view('sessoes.admin.create')
                    ->with('sessoes', $sessoes)
                    ->with('continuar', $continuar)
                    ->with('listaSalas', $listaSalas)
                    ->with('listaFilmes', $listaFilmes)
                    ->with('alert-msg', 'Sessao criada com sucesso')
                    ->with('alert-type', 'success');
            }else{
                $filmes = Filme::paginate(8);
                $listaGeneros = Genero::all();   
                return view('filmes.admin', compact('filmes','listaGeneros'))
                ->with('alert-msg', 'Sessao criada com sucesso')
                ->with('alert-type', 'success');
            }
    }


    //UPDATE---------------------------------------------
    //ADMIN EDIT OK
    public function admin_edit(Sessao $sessao)
      {
        //dd($sessao);
        if (is_null(Bilhetes::where('sessao_id', $sessao->id)->first())) {
         $editarSessao = Sessao::where('id', $sessao->id)->first();
         $listaSalas = Salas::pluck('id', 'nome');
         return view('sessoes.admin.edit')
                    ->with('listaSalas', $listaSalas)
                    ->with('sessao', $editarSessao);
        }
        else{
            return redirect()->back()
            ->with('alert-msg', 'Sessao com Bilhetes já vendidos impossivel alterar!')
            ->with('alert-type', 'danger');        
        } 
      }

    public function admin_update(Request $request, Sessao $sessao)
    {
        //dd($sessao);
        $filme = Filme::where('id', $sessao->filme_id)->first();
        $validatedData = $request->validate([
            'sala_id' => 'required|max:2',
            'data' => 'required|date',
            'horario_inicio' => 'required|date_format:H:i:s']);
            //dd($validatedData);
            DB::table('sessoes')
                ->where('id', $sessao->id)
                ->update(['sala_id' => $validatedData['sala_id'],
                'data' => $validatedData['data'],
                'horario_inicio' => $validatedData['horario_inicio']]);
        return redirect()->route('sessoes.admin.index', $filme)
            ->with('alert-msg', 'Sessao foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function admin_destroy(Request $request, Sessao $sessao)
    {
        //dd($sessao);
        $filme = Filme::where('id',$sessao->filme_id)->get();
        //dd(is_null(Bilhetes::where('sessao_id', $sessao->id)->first()));
        //CASO NAO EXISTA BILHETES ASSOCIADOS A ESTA SESSAO É PERMITIDO ELEMINAR
        if (is_null(Bilhetes::where('sessao_id', $sessao->id)->first())) {
            $sessaoApagar = Sessao::find($sessao->id);
            $sessaoApagar->delete();
            return redirect()->back()
            ->with('alert-msg', 'Sessao foi apagada com sucesso!')
            ->with('alert-type', 'success'); 
        }else{
            return redirect()->back()
            ->with('alert-msg', 'Sessao com Bilhetes já vendidos!')
            ->with('alert-type', 'danger');        
        } 
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