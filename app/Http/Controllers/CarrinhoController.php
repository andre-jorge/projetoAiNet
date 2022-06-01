<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Sessao;
use App\Models\Lugares;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CarrinhoController extends Controller
{
    public function index(Request $request)
    {
        //dd($request);
        return view('carrinho.index')
            ->with('pageTitle', 'Carrinho de compras')
            ->with('carrinho', session('carrinho') ?? []);
    }

    public function store_sessao(Request $request, Sessao $sessao)
    {
        $idlugar = $request->idlugar;
        
        
        
        //dd($fila);
        $carrinho = $request->session()->get('carrinho', []);
        $qtd = ($carrinho[$sessao->id]['qtd'] ?? 0) + 1;
        $fila = ($carrinho[$sessao->id]['fila']?? 0);
        $lugar = ($carrinho[$sessao->id]['lugar']?? 0);
        $total = ($carrinho[$sessao->id]['total'] ?? 0);
        $precoBilhete = Configuracao::find(1);
        //dd($precoBilhete->percentagem_iva);
        $fila=Lugares::where('id',$idlugar)->pluck('fila');
        $posicao=Lugares::where('id',$idlugar)->pluck('posicao');
        
        //dd($lugar=$sessao->Filmes);

        //dd($lugar);
        $total = $precoBilhete->preco_bilhete_sem_iva*$qtd;
        $carrinho[$sessao->id] = [
            'id' => $sessao->id,
            'filme' => $sessao->Filmes->titulo,
            'qtd' => $qtd,
            'data' => $sessao->data,
            'horario_inicio' => $sessao->horario_inicio,
            'sala_id' => $sessao->Salas->nome,
            'preco' => $precoBilhete->preco_bilhete_sem_iva,
            'iva' => $precoBilhete->percentagem_iva,
            'fila' => $fila[0],
            'lugar' => $posicao[0],
            'total' => $total,
        ];
        //dd($carrinho);
        $request->session()->put('carrinho', $carrinho);
        return back()
            ->with('alert-msg', 'Foi adicionada uma nova sessão ao carrinho!')
            ->with('alert-type', 'success');
    }

    public function update_sessao(Request $request, Sessao $sessao)
    {
        
        $carrinho = $request->session()->get('carrinho', []);
        $qtd = $carrinho[$sessao->id]['qtd'] ?? 0;
        $total = $carrinho[$sessao->id]['total'] ?? 0;
        $qtd += $request->quantidade;
        $precoBilhete = Configuracao::find(1);
        //dd($precoTotalSessao);
        $total = $precoBilhete->preco_bilhete_sem_iva*$qtd;
        if ($request->quantidade < 0) {
            $msg = 'Foram removidas ';
        } elseif ($request->quantidade > 0) {
            $msg = 'Foram adicionadas ';
        }
        if ($qtd <= 0) {
            unset($carrinho[$sessao->id]);
            $msg = 'Foram removidas todas as sessões';
        } else {
            $carrinho[$sessao->id] = [
                'id' => $sessao->id,
                'filme' => $sessao->Filmes->titulo,
                'qtd' => $qtd,
                'data' => $sessao->data,
                'horario_inicio' => $sessao->horario_inicio,
                'sala_id' => $sessao->Salas->nome,
                'preco' => $precoBilhete->preco_bilhete_sem_iva,
                'iva' => $precoBilhete->percentagem_iva,
                'total' => $total,

            ];
        }
        $request->session()->put('carrinho', $carrinho);
        return back()
            ->with('alert-msg', $msg)
            ->with('alert-type', 'success');
    }

    public function destroy_sessao(Request $request, Sessao $sessao)
    {
        $carrinho = $request->session()->get('carrinho', []);
        if (array_key_exists($sessao->id, $carrinho)) {
            unset($carrinho[$sessao->id]);
            $request->session()->put('carrinho', $carrinho);
            return back()
                ->with('alert-msg', 'Foram removidas todas as Sessaões')
                ->with('alert-type', 'success');
        }
        return back()
            ->with('alert-msg', 'A disciplina já não tinha inscrições no carrinho!')
            ->with('alert-type', 'warning');
    }

    public function store(Request $request, Sessao $sessao)
    {
        $currentTime = Carbon::now();
        $currentTime = $currentTime->toDateString();
        $user = auth()->user();
        //dd($request);
        //dd($currentTime);
        //dd($user->id);

        $dataForm = $request->session()->get('carrinho');
        //dd($dataForm);


        $carro = $request->session()->get('carrinho');
        dd($request);
        // AQUIIIIII
        //$data = $request->session()->all(); // ver tudo da sessao
        // dd(
        //     'Place code to store the shopping cart / transform the cart into a sale',
        //     $carro->filme // aqui esta a info do carrinho
        //     //$user = auth()->user() // aqui esta a info do user
        // );
        // aqui adiconar as coisa
        // A FAZER: Quando a Compra é bem sucedida
        // Criar um Recibo e Gerar os bilhetes relativos à compra, 
        // Limpar o carrinho de compras
        // $newRecibo = ([
        //     'cliente_id' => $user->id,
        //     'data' => $currentTime,
        //     'preco_total_sem_iva' => 'required',
        //     'iva' => 'required',
        //     'preco_total_com_iva' => 'required',
        //     'nif' => 'required',
        //     'nome_cliente' => 'required',
        //     'tipo_pagamento' => 'required',
        //     'ref_pagamento' => 'required',
        // ]);

        $validatedDataCartao = $request->validate([
            'paymentMethod' => 'required',
            'data' => 'required|max:60',
            'cc-number' => 'required',
            'cc-expiration' => 'required',
            'cc-cvv' => 'required',
         ]);

         $newRecibo = new Recibo();
         $newRecibo->cliente_id = $user->id;
         $newRecibo->data = $currentTime;
         $newRecibo->preco_total_sem_iva = $nameFile;
         $newRecibo->iva = $nameFile;
         $newRecibo->preco_total_com_iva = $nameFile;
         $newRecibo->nif = $nameFile;
         $newRecibo->nome_cliente = $nameFile;
         $newRecibo->tipo_pagamento = $nameFile;
         $newRecibo->ref_pagamento = $nameFile;
         $newRecibo->save();
         return redirect()->route('filmes.admin')
               ->with('alert-msg', 'Filme inserido com sucesso')
               ->with('alert-type', 'success');


    //     $nameFile = $request->titulo . '.' . $request->cartaz_url->extension(); 
    //   $bilhete = [
    //     'cliente_id' => $sessao->id,
    //     'data' => $currentTime,
    //     'preço' => $qtd,
    //     'data' => $sessao->data,
    //     'horario_inicio' => $sessao->horario_inicio,
    //     'sala_id' => $sessao->sala_id,
    // ];
    //   $newFilme = Filme::create($validatedData);
    //   $newFilme->cartaz_url = $nameFile;
    //   $newFilme->save();
    //   return redirect()->route('filmes.admin')
    //         ->with('alert-msg', 'Filme inserido com sucesso')
    //         ->with('alert-type', 'success');
    }

    public function destroy(Request $request)
    {
        $request->session()->forget('carrinho');
        return back()
            ->with('alert-msg', 'Carrinho foi limpo!')
            ->with('alert-type', 'danger');
    }
}
