<?php

namespace App\Http\Controllers;
use App\Models\Configuracao;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
      public function index()
    {
      $configs = Configuracao::all();
      //dd($configs);
      return view('configuracao.index')->with('configs', $configs);
    }

    public function edit(Request $request,$id)
      {
         $configs = Configuracao::where('id', $id)->first();
         return view('configuracao.edit')->with('configs', $configs);
      }

      public function update(Request $request, $id)
    {
      $validatedData = $request->validate([
        'preco_bilhete_sem_iva' => 'required|max:50',
        'percentagem_iva' => 'required|numeric|min:1|max:99.99'
      ]);
        //dd($validatedData);
        Configuracao::where('id', $id)
              ->update(['preco_bilhete_sem_iva' => $validatedData['preco_bilhete_sem_iva'],'percentagem_iva' => $validatedData['percentagem_iva']]);//seleciona apenas o valor nome no array que é a ediçao
        return redirect()->route('configuracao.index')
            ->with('alert-msg', 'Preço do bilhete foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }
}



