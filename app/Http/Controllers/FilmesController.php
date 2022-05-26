<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Sessao;
use App\Models\Genero;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class FilmesController extends Controller
{
   public function admin_index()
      {
         $filme = Filme::findOrFail(1);
         //dd($filme->generos->nome);
         $filmes = DB::table('filmes')
                     ->select('*')
                     ->paginate(8);
         return view('filmes.admin', compact('filmes'));
      }

   public function index(Request $request)
      {
         //dd(123);
         $filmes = DB::table('filmes')
                     ->select('*')
                     ->leftjoin('generos','generos.code','=','filmes.genero_code')
                     ->paginate(8);  
                     //dd($filmes);
         // PROCURA POR NOME ou Sumario
         
          $todosFilmes = Filme::where([
             [function($query) use ($request){
               if (($genero = $request->genero)){
                  $query->Where('genero_code', $genero)->get();
                  //$query->orWhere('sumario', 'LIKE', '%' . $sumario . '%')->get();
                }
             }]
          ])
          ->paginate(8);
          
         $listaGeneros = Genero::all();
         $filmes = $todosFilmes;
         
         return view(
             'filmes.index',
             compact('filmes', 'listaGeneros'));


        //ORIGINAL
         //$todosFilmes = DB::table('filmes')
          //          ->paginate(8);
         //dd($todosFilmes);
         //return view('filmes.index')->with('filmes', $todosFilmes);
         
      }

  public function create()
      {
         $filmes = DB::table('filmes')
                     ->select('*')
                     ->leftjoin('generos','generos.code','=','filmes.genero_code')
                     ->paginate(8); 
                     $listaGeneros = Genero::pluck('code', 'nome');
         return view(
         'filmes.create',
         compact('filmes', 'listaGeneros'));
   }


   public function edit(Request $request,$id)
      {
         $filme = Filme::where('id', $id)->first();
         $listaGeneros = Genero::pluck('code', 'nome');
         return view('filmes.edit')->withFilme($filme)
                                   ->with('Generos', $listaGeneros);
      }

   public function update(Request $request, $id)
   {
      $validatedData = $request->validate([
         'titulo' => 'required|max:50',
         'genero_code' => 'required|max:20',
         'ano' => 'required|numeric|between:1950,2100',
         'cartaz_url' => 'required|max:200',
         'sumario' => 'required|max:255',
         'trailer_url' => 'required|max:200'
      ]);
         //dd($validatedData);
         DB::table('filmes')
               ->where('id', $id)
               ->update(['titulo' => $validatedData['titulo'],
               'genero_code' => $validatedData['genero_code'],
               'ano' => $validatedData['ano'],
               'cartaz_url' => $validatedData['cartaz_url'],
               'sumario' => $validatedData['sumario'],
               'trailer_url' => $validatedData['trailer_url']]);
         //seleciona apenas o valor nome no array que é a ediçao
         return redirect()->route('filmes.admin')
            ->with('alert-msg', 'Filme alterado com sucesso!')
            ->with('alert-type', 'success');
   }




   public function store(Request $request)
   {
      $validatedData = $request->validate([
         'titulo' => 'required|max:50',
         'genero_code' => 'required|max:20',
         'ano' => 'required|numeric|between:1950,2100',
         'cartaz_url' => 'required|max:200',
         'sumario' => 'required|max:255',
         'trailer_url' => 'required|max:200'
      ]);
      //dd($validatedData);
      $newFilme = Filme::create($validatedData);
      //DB::table('filmes')->insert($validatedData);
      return redirect()->route('filmes.admin')
            ->with('alert-msg', 'Filme inserido com sucesso')
            ->with('alert-type', 'success');
    }

    public function destroy(Request $request, $id)
    {
      $filmeApagar = Filme::find($id);
      $filmeApagar->delete();
      //$deleted = DB::table('salas')->select('*')->where('id', $id)->delete();
        return redirect()->route('filmes.admin')
            ->with('alert-msg', 'Filme foi eliminado com sucesso!')
            ->with('alert-type', 'success');
    }
}

