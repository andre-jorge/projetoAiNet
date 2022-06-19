<?php

namespace App\Http\Controllers;
use App\Models\Salas;
use App\Models\Lugares;
use App\Models\Sessao;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
//problema com timestamp estava sempre a colocar
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SalasController extends Controller
{
  public static function CriaLugares($arg1,$arg2,$arg3)
  {
    $alphabet = range('A', 'Z');
    for ($i = 0; $i < $arg1; $i++) {
      for ($j = 1; $j <= $arg2; $j++) {
        $data = array(
          'sala_id' => $arg3,
          'fila' => $alphabet[$i], 
          'posicao' => $j);
          $newLugar = Lugares::create($data);
      }}
  }

    public function index(Request $request)
    {
      //dd($request);
      $todassalas = Salas::withTrashed()->paginate(10);
      if ($request->nome and $request->estado and $request->estado != 'Todas') {
        if ($request->estado == 'Ativas') {
          $todassalas = Salas::where('nome', 'like', '%' . $request->nome . '%')->paginate(10);
        }
        if ($request->estado == 'Inativas'){
          $todassalas = Salas::withTrashed()->where('nome', 'like', '%' . $request->nome . '%')->where('deleted_at','!=','null')->paginate(10);
        }
      }else{
      if ($request->nome) {
        $todassalas = Salas::withTrashed()->where('nome', 'like', '%' . $request->nome . '%')->paginate(10);
      }
      if ($request->estado and $request->estado != 'Todas') {
        if ($request->estado == 'Ativas') {
          $todassalas = Salas::paginate(10);
        }else {
          $todassalas = Salas::withTrashed()->where('deleted_at','!=','null')->paginate(10);
        }
      }
    }
      return view('salas.index')->with('todassalas', $todassalas);
    }

    public function create()
    {
      $todassalas = Salas::pluck('id', 'nome');
      return view('salas.create')->with('salas', $todassalas);
    }

    public function store(Request $request)
   {
      $ultimaSala = Salas::orderBy('id', 'desc')->first();
      //dd($request);
      $validatedData = $request->validate([
         'nome' => 'required|max:50',
         'custom' => 'required|numeric'
      ]);
        $newSala = Salas::create($validatedData);
        $newSala->custom = $request->lugares*$request->filas;
        //dd($newSala->custom);
        $newSala->save();
        
        SalasController::CriaLugares($request->filas,$request->lugares,$ultimaSala->id+1);
                    
        //DB::table('filmes')->insert($validatedData);
        return redirect()->route('salas.index')
              ->with('alert-msg', 'Sala criada com Sucesso')
              ->with('alert-type', 'success');
    }

    public function edit(Request $request,Salas $salas)
      {
         $sala = Salas::where('id', $salas->id)->first();
         $listaSalas = Salas::pluck('id', 'nome');
         return view('salas.edit')->withSala($sala)
                                   ->with('Sala', $listaSalas);
      }

      public function update(Request $request, Salas $salas)
    {
      $validatedData = $request->validate([
        'nome' => 'required|max:50',
      ]);
        //dd($validatedData);
        Salas::where('id', $salas->id)
              ->update(['nome' => $validatedData['nome']]);//seleciona apenas o valor nome no array que é a ediçao
        return redirect()->route('salas.index')
            ->with('alert-msg', 'Sala foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    // public function destroy(Request $request, Salas $salas
    // {
    //   $salaApagar = SALAS::find($salas->id);
    //   $salaApagar->delete();
    //   //$deleted = DB::table('salas')->select('*')->where('id', $id)->delete();
    //     return redirect()->route('salas.index')
    //         ->with('alert-msg', 'Sala e Lugares apagados com sucesso!')
    //         ->with('alert-type', 'success');
    // }

    public function sala_recuperar(Request $request)
    {
      //dd($request);
      $currentTime = Carbon::now();
      $currentTime = $currentTime->toDateString();
      $apagar = Salas::withTrashed()->find($request->id);
      $ocupacaoSalas = Sessao::where('data','>', $currentTime)
                             ->where('sala_id', $apagar->id)->first();
                             
      if (!isset($ocupacaoSalas)) {
        if (is_null($apagar->deleted_at)) {
          $lugares = Lugares::where('sala_id',$apagar->id)->get();
          //dd($lugares);
          foreach ($lugares as $lugar) {
            $lugar->delete();
          }
          $apagar->delete();
          return redirect()->back()
                ->with('alert-msg', 'Sala '.$apagar->name.' eliminada com sucesso!')
                ->with('alert-type', 'success');
        }
        if ($apagar->deleted_at != null){
          $lugares = Lugares::withTrashed()->where('sala_id',$apagar->id)->get();
          foreach ($lugares as $lugar) {
            $lugar->restore();
          }
          $apagar->restore();
            return redirect()->back()
                  ->with('alert-msg', 'Sala '.$apagar->name.' recuperada com sucesso!')
                  ->with('alert-type', 'success');
                }
      }else{
        return redirect()->back()
                  ->with('alert-msg', 'Sala '.$apagar->name.' com sessoes a decorrer!')
                  ->with('alert-type', 'danger');
      }
      
      //recuperar/eleminar
      
    }

}



