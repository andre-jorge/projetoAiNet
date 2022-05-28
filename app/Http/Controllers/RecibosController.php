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
   // public function index()
   //    {
   //       $recibos = Recibo::paginate(8);
   //       return view('recibos.index', compact('recibos'));
   //    }
}

