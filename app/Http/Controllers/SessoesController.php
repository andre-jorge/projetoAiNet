<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use Illuminate\Http\Request;

class SessoesController extends Controller
{
     public function index()
     {
         $todasSessoes = Sessao::all();
         return view('sessoes.index')->with('sessoes', $todasSessoes);
     }
}
