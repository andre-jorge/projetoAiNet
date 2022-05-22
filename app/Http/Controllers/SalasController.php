<?php

namespace App\Http\Controllers;
use App\Models\Salas;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
//problema com timestamp estava sempre a colocar

use Illuminate\Http\Request;

class SalasController extends Controller
{
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
      $todassalas= Salas::all();
      $validatedData = $request->validate([
         'nome' => 'required|max:50'
      ]);
        $newSala = DB::table('salas')->insert(
          array('nome' => $validatedData)
      );
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
        'nome' => 'required|max:50']);
        //dd($validatedData);
          DB::table('salas')
              ->where('id', $id)
              ->update(['nome' => $validatedData['nome']]);//seleciona apenas o valor nome no array que é a ediçao
        return redirect()->route('salas.index')
            ->with('alert-msg', 'Sala foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(Request $request, $id)
    {
      $salaApagar = SALAS::find($id);
      $salaApagar->delete();
      //$deleted = DB::table('salas')->select('*')->where('id', $id)->delete();
        return redirect()->route('salas.index')
            ->with('alert-msg', 'Sala foi apagada com sucesso!')
            ->with('alert-type', 'success');


        
        // $oldName = $curso->nome;
        // DB::table('salas')
        //       ->where('id', $id)
        //       ->delete();
        //     return redirect()->route('salas.index')
        //         ->with('alert-msg', 'Curso foi apagado com sucesso!')
        //         ->with('alert-type', 'success');
    }
}