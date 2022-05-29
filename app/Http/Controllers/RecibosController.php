<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Sessao;
use App\Models\Genero;
use App\Models\Recibo;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class RecibosController extends Controller
{
   // ADMIN_INDEX JA OK
   // public function index(Request $request)
   //    {
   //       $user = auth()->user();
   //       $recibos = Recibo::where('cliente_id',$user)->paginate(8);
   //       dd($recibos);
   //       return view('users.recibos', compact('recibos'));
   //    }
}

