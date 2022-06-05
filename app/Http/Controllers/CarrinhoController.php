<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Sessao;
use App\Models\Lugares;
use App\Models\Recibo;
use App\Models\Bilhetes;
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

        $idCarrinho = $request->session()->increment('count');
        //dd( $idCarrinho);
        $carrinho = $request->session()->get('carrinho', []);

        $qtd = $idCarrinho;
        $fila = ($carrinho[$idCarrinho]['fila']?? 0);
        $lugar = ($carrinho[$idCarrinho]['lugar']?? 0);
        $precoBilhete = Configuracao::find(1);
        $total = $qtd*($precoBilhete->preco_bilhete_sem_iva);
        //dd($precoBilhete->percentagem_iva);
        $fila=Lugares::where('id',$idlugar)->pluck('fila');
        $posicao=Lugares::where('id',$idlugar)->pluck('posicao');
        
        //dd($lugar=$sessao->Filmes);

        //dd($lugar);
        $total = $precoBilhete->preco_bilhete_sem_iva*$qtd;
        $carrinho[$idCarrinho] = [
            'id' => $sessao->id,
            'filme' => $sessao->Filmes->titulo,
            'qtd' => $qtd,
            'data' => $sessao->data,
            'horario_inicio' => $sessao->horario_inicio,
            'sala_id' => $sessao->Salas->nome,
            'preco' => $precoBilhete->preco_bilhete_sem_iva,
            'iva' => $precoBilhete->percentagem_iva,
            'idLugar' => $idlugar,
            'fila' => $fila[0],
            'lugar' => $posicao[0],
            'total' => $total,
        ];
        //dd($carrinho);
        $request->session()->put('carrinho', $carrinho);
        //$request->session()->increment('count', $incrementBy = 1);//incrementa 1 no [] do carrinho
        return back()
            ->with('alert-msg', 'Foi adicionada uma nova sessão ao carrinho!')
            ->with('alert-type', 'success');
    }

    // public function update_sessao(Request $request, Sessao $sessao)
    // {
        
    //     $carrinho = $request->session()->get('carrinho', []);
    //     $qtd = $carrinho[$sessao->id]['qtd'] ?? 0;
    //     $total = $carrinho[$sessao->id]['total'] ?? 0;
    //     $qtd += $request->quantidade;
    //     $precoBilhete = Configuracao::find(1);
    //     //dd($precoTotalSessao);
    //     $total = $precoBilhete->preco_bilhete_sem_iva*$qtd;
    //     if ($request->quantidade < 0) {
    //         $msg = 'Foram removidas ';
    //     } elseif ($request->quantidade > 0) {
    //         $msg = 'Foram adicionadas ';
    //     }
    //     if ($qtd <= 0) {
    //         unset($carrinho[$sessao->id]);
    //         $msg = 'Foram removidas todas as sessões';
    //     } else {
    //         $carrinho[$sessao->id] = [
    //             'id' => $sessao->id,
    //             'filme' => $sessao->Filmes->titulo,
    //             'qtd' => $qtd,
    //             'data' => $sessao->data,
    //             'horario_inicio' => $sessao->horario_inicio,
    //             'sala_id' => $sessao->Salas->nome,
    //             'preco' => $precoBilhete->preco_bilhete_sem_iva,
    //             'iva' => $precoBilhete->percentagem_iva,
    //             'total' => $total,

    //         ];
    //     }
    //     $request->session()->put('carrinho', $carrinho);
    //     return back()
    //         ->with('alert-msg', $msg)
    //         ->with('alert-type', 'success');
    // }

    public function destroy_sessao(Request $request, Sessao $sessao)
    {
        $idCarrinho = $request->session()->decrement('count');
        $carrinho = $request->session()->get('carrinho', []);
        if (array_key_exists($request->eleminar, $carrinho)) {
            unset($carrinho[$request->eleminar]);
            $request->session()->put('carrinho', $carrinho);
            return back()
                ->with('alert-msg', 'Foram removida a Sessão')
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
        $userInfo = auth()->user();
        //dd($user->id);
        //dd($request);
        //dd($currentTime);
        //dd($user->id);
        // a funcar
        $metodoPagamento = $request->paymentMethod;
        //dd($metodoPagamento);
        $nomeCartao = $request->ccname;
        $numeroCartao = $request->ccnumber;
        $expirationCartao = $request->ccexpiration;
        $cvvCartao = $request->cccvv;
        $nif = $request->nif;
        $precoBilhete = Configuracao::where('id', 1)->pluck('preco_bilhete_sem_iva');
        $ivaBilhete = Configuracao::where('id', 1)->pluck('percentagem_iva'); 
        $carro = $request->session()->get('carrinho');  
        $quantidadeCarrinho = count($carro); 
        $precoTotalBilhetesSemIva = ($precoBilhete[0]*$quantidadeCarrinho);     
        $data = $request->session()->all(); // ver tudo da sessao   


        //---------------------Emitir Recibo--------------------
        $newRecibo = ([
            'cliente_id' => $userInfo->id,
            'data' => $currentTime,
            'preco_total_sem_iva' => $precoTotalBilhetesSemIva,
            'iva' => $ivaBilhete[0],
            'preco_total_com_iva' => round($precoTotalBilhetesSemIva*($ivaBilhete[0]/100 + 1),2),
            'nif' => $nif,
            'nome_cliente' => $userInfo->name,
            'tipo_pagamento' => $metodoPagamento,
            'ref_pagamento' => $request->ccnumber,
        ]);
        $Recibo = Recibo::create($newRecibo);
        //------------------------------------------------------
        //------------------------------------------------------
        //---------------------Emitir Bilhetes--------------------
        $ultimoRecibo = Recibo::orderBy('id','desc')->first();
        $ultimoIdRecibo = $ultimoRecibo->id;
        for ($i=1; $i <= $quantidadeCarrinho ; $i++) { 
            $newBilhete = ([
                'recibo_id' => $ultimoIdRecibo,
                'cliente_id' => $userInfo->id,
                'sessao_id' => $carro[$i]['id'],
                'lugar_id' => $carro[$i]['idLugar'],
                'preco_sem_iva' => $precoBilhete[0],
                'estado' => 'não usado',
            ]);
            $Bilhete = Bilhetes::create($newBilhete);
        }
        //-----------------------------------------------------

        $request->session()->forget('count');
        $request->session()->forget('carrinho');
        return redirect()->route('carrinho.index')
                         ->with('alert-msg', 'Compra efetuado com Sucesso')
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
    }

    public function destroy(Request $request)
    {
        $request->session()->forget('count');
        $request->session()->forget('carrinho');
        return back()
            ->with('alert-msg', 'Carrinho foi limpo!')
            ->with('alert-type', 'danger');
    }
}
