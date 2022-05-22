<?php

namespace App\Http\Controllers;
use App\Models\Salas;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
//problema com timestamp estava sempre a colocar

use Illuminate\Http\Request;

class SalasController extends Controller
{
    public $timestamps = false;
    public function index()
    {
        $todassalas= Salas::all();
        //dd($todassalas);
        return view('salas.index')->with('salas', $todassalas);
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
      dd($validatedData);
      if ($validatedData->id == $todassalas->id) {
        # update
        $update = DB::table('salas')
              ->where('id', $todassalas->id)
              ->update(['nome' => $validatedData]);
        return redirect()->route('salas.index')
              ->with('alert-msg', 'Sala criada com Sucesso')
              ->with('alert-type', 'success');
      }else {
        $newSala = DB::table('salas')->insert(
          array('nome' => $validatedData)
      );
        //DB::table('filmes')->insert($validatedData);
        return redirect()->route('salas.index')
              ->with('alert-msg', 'Sala criada com Sucesso')
              ->with('alert-type', 'success');
      }
    }

    public function edit(Request $request,$id)
      {
         $sala = Salas::where('id', $id)->first();
         $listaSalas = Salas::pluck('id', 'nome');
         return view('salas.edit')->withSala($sala)
                                   ->with('Sala', $listaSalas);
      }
}