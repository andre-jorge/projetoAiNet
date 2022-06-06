<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Sessao;
use App\Models\Genero;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;


class FilmesController extends Controller
{
   // ADMIN_INDEX JA OK
   public function admin_index()
      {
         $filmes = Filme::paginate(8);
         return view('filmes.admin', compact('filmes'));
      }

   // INDEX JA OK
   public function index(Request $request)
      {
         //dd($request);
         $currentTime = Carbon::now();
         $currentTime = $currentTime->toDateString();
         $filmesAtuais = Sessao::where('sessoes.data','>', $currentTime)
                        ->with('filmes')
                        ->distinct('filme_id')
                        ->paginate(8);
                        //dd($filmesAtuais);
         if($request->genero){
            $filmesGenero = Filme::where('genero_code', $request->genero)->pluck('id');
            //dd($filmesGenero);
            $filmesAtuais = Sessao::where('sessoes.data','>', $currentTime)
                        ->whereIn('filme_id',$filmesGenero)
                        ->with('filmes')
                        ->distinct('filme_id')
                        ->paginate(8);        
                  }
                  //dd($filmesAtuais);
         if($request->string){
            $filmeString = Filme::where('sumario', 'like', '%' . $request->string . '%')->pluck('id');
            //dd($filmesGenero);
            $filmesAtuais = Sessao::where('sessoes.data','>', $currentTime)
                        ->whereIn('filme_id',$filmeString)
                        ->with('filmes')
                        ->distinct('filme_id')
                        ->paginate(8);        
                  }
                  //dd($filmesAtuais);
         
         $listaGeneros = Genero::all();         
         return view(
             'filmes.index',
             compact('filmesAtuais', 'listaGeneros'));
      }
      

   // create JA OK
   public function create()
         {
            $filmes = Filme::paginate(8); 
            $listaGeneros = Genero::pluck('code', 'nome');
            return view(
            'filmes.create',
            compact('filmes', 'listaGeneros'));
      }

   // edit JA OK
   public function edit(Request $request,$id)
      {
         $filme = Filme::where('id', $id)->first();
         $listaGeneros = Genero::pluck('code', 'nome');
         return view('filmes.edit')->withFilme($filme)
                                   ->with('Generos', $listaGeneros);
      }

   //revalidar esta funcao
   public function update(Filme $filme)
   {
      dd($filme);
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



   //STORE OK------------
   public function store(Request $request)
   {
      $nameFile = $request->titulo . '.' . $request->cartaz_url->extension(); 
      if ( ! $nameFile ) {
         unset( $this->styles[ $key ] );
         $request->file('cartaz_url')->storeAS('storage/cartazes', $nameFile );
      }
      $validatedData = $request->validate([
         'titulo' => 'required|max:50',
         'genero_code' => 'required|max:20',
         'ano' => 'required|numeric|between:1950,2100',
         'cartaz_url' => 'required',
         'sumario' => 'required|max:255',
         'trailer_url' => 'required|max:200'
      ]);
      $newFilme = Filme::create($validatedData);
      $newFilme->cartaz_url = $nameFile;
      $newFilme->save();
      return redirect()->route('filmes.admin')
            ->with('alert-msg', 'Filme inserido com sucesso')
            ->with('alert-type', 'success');
   }


   //DESTROY OK------------
   public function destroy(Filme $filme)
   {
      $filmeApagar = Filme::find($filme->id);
      $filmeApagar->delete();
      return redirect()->route('filmes.admin')
            ->with('alert-msg', 'Filme foi eliminado com sucesso!')
            ->with('alert-type', 'success');
   }
}

