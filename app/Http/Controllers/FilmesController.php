<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Filme;


class FilmesController extends Controller
{
    // public function admin_index()
    // {
    //     $todosCursos = Curso::all();
    //     return view('cursos.admin')->with('cursos', $todosCursos);
    // }

    public function index()
    {
        $todosFilmes = Filme::paginate(8);
        //$todosFilmes = Filme::all();
        return view('filmes.index')->with('filmes', $todosFilmes);
    }
}
