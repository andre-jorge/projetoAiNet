<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Filme;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class GenerosController extends Controller
{
   
   public function index()
      {
        $generos = Genero::all();
        return view('generos.index')->withGeneros($generos);
      }
}
