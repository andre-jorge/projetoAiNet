<?php

namespace App\Http\Controllers;
use App\Models\Salas;
use App\Models\Lugares;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
//problema com timestamp estava sempre a colocar

use Illuminate\Http\Request;

class SalasController extends Controller
{
  public static function CriaLugares($arg1,$arg2,$arg3){

    $alphabet = range('A', 'Z');
    for ($i = 0; $i < $arg1; $i++) {
      for ($j = 1; $j <= $arg2; $j++) {
        $data = array(
          'sala_id' => $arg3,
          'fila' => $alphabet[$i], 
          'posicao' => $j);
          $newLugar = Lugares::create($data);
      }

  }
  }

    public function index()
    {
      $todassalas = Salas::all();
      //dd($todassalas);
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
      $ultimaSalaId = $ultimaSala->id+1;
      //dd($request);
      $validatedData = $request->validate([
         'nome' => 'required|max:50',
         'custom' => 'required|numeric'
      ]);
        $newSala = Salas::create($validatedData);
        $newSala->custom = $request->lugares*$request->filas;
        //dd($newSala->custom);
        $newSala->save();
        
        SalasController::CriaLugares($request->filas,$request->lugares,$ultimaSalaId);
                    
        //DB::table('filmes')->insert($validatedData);
        return redirect()->route('salas.index')
              ->with('alert-msg', 'Sala criada com Sucesso')
              ->with('alert-type', 'success');
    }

    public function edit(Request $request,$id)
      {
         $sala = Salas::where('id', $id)->first();
         $listaSalas = Salas::pluck('id', 'nome');
         return view('salas.edit')->withSala($sala)
                                   ->with('Sala', $listaSalas);
      }

      public function update(Request $request, $id)
    {
      $validatedData = $request->validate([
        'nome' => 'required|max:50',
        'custom' => 'required|numeric|between:40,120'
      ]);
        //dd($validatedData);
        Salas::where('id', $id)
              ->update(['nome' => $validatedData['nome'],'custom' => $validatedData['custom']]);//seleciona apenas o valor nome no array que é a ediçao
        return redirect()->route('salas.index')
            ->with('alert-msg', 'Sala foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(Request $request, $id)
    {
      $comments = Lugares::where('sala_id', $id)->get();
      if(count($comments)>1)
      {
          $comment_id= [];
          foreach ($comments as $i)
          {
              $comment_id[] = $i->id;
          }
          for($i=0;$i<count($comments);$i++)
          {
              Lugares::find($comment_id[$i])->delete();
          }
          }
          elseif (count($comments)==1)
          {
              $comments->delete();
          }
      $salaApagar = SALAS::find($id);
      $salaApagar->delete();
      //$deleted = DB::table('salas')->select('*')->where('id', $id)->delete();
        return redirect()->route('salas.index')
            ->with('alert-msg', 'Sala e Lugares apagados com sucesso!')
            ->with('alert-type', 'success');
    }
}



