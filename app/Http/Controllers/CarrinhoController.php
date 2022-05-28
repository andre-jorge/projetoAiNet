<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use Illuminate\Http\Request;

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
        $carrinho = $request->session()->get('carrinho', []);
        $qtd = ($carrinho[$sessao->id]['qtd'] ?? 0) + 1;
        $carrinho[$sessao->id] = [
            'id' => $sessao->id,
            'qtd' => $qtd,
            'data' => $sessao->data,
            'horario_inicio' => $sessao->horario_inicio,
            'sala_id' => $sessao->sala_id,
        ];
        $request->session()->put('carrinho', $carrinho);
        return back()
            ->with('alert-msg', 'Foi adicionada uma nova sessão ao carrinho!')
            ->with('alert-type', 'success');
    }

    public function update_sessao(Request $request, Sessao $sessao)
    {
        $carrinho = $request->session()->get('carrinho', []);
        $qtd = $carrinho[$sessao->id]['qtd'] ?? 0;
        $qtd += $request->quantidade;
        if ($request->quantidade < 0) {
            $msg = 'Foram removidas ';
        } elseif ($request->quantidade > 0) {
            $msg = 'Foram adicionadas ';
        }
        if ($qtd <= 0) {
            unset($carrinho[$disciplina->id]);
            $msg = 'Foram removidas todas as sessões';
        } else {
            $carrinho[$sessao->id] = [
                'id' => $sessao->id,
                'qtd' => $qtd,
                'data' => $sessao->data,
                'horario_inicio' => $sessao->horario_inicio,
                'sala_id' => $sessao->sala_id,
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

    public function store(Request $request)
    {
        dd(
            'Place code to store the shopping cart / transform the cart into a sale',
            $request->session()->get('carrinho')
        );
    }

    public function destroy(Request $request)
    {
        $request->session()->forget('carrinho');
        return back()
            ->with('alert-msg', 'Carrinho foi limpo!')
            ->with('alert-type', 'danger');
    }
}
