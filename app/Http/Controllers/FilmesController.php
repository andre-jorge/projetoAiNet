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
use Illuminate\Support\Str;


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
                        ->distinct('filme_id')
                        ->paginate(10);

                       

                        //dd($filmesAtuais);
         if($request->genero && $request->genero != 'ALL' && $request->genero != null ){
            $filmesGenero = Filme::where('genero_code', $request->genero)->pluck('id');
            //dd($filmesGenero);
            $filmesAtuais = Sessao::where('sessoes.data','>', $currentTime)
                        ->whereIn('filme_id',$filmesGenero)
                        ->with('filmes')
                        ->distinct('filme_id')
                        ->paginate(8);        
                  }
                  //dd($filmesAtuais);
         if($request->string && $request->string != null){
            $filmeString = Filme::where('sumario', 'like', '%' . $request->string . '%')
                                 ->orWhere('titulo', 'like', '%' . $request->string . '%')
                                 ->pluck('id');
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
   public function update(Request $request,Filme $filme)
   {
      if(is_null($request->cartaz_url)){
         $request->cartaz_url = $filme->cartaz_url;
      }else{
         $random = Str::random(10);
         $nameFile = $filme->id . '_'. $random . '.' . $request->cartaz_url->extension(); 
         $request->cartaz_url->move(public_path('storage/cartazes'), $nameFile);
         $request->cartaz_url =$nameFile;
      }
      //dd($request->cartaz_url);
      $validatedData = $request->validate([
         'titulo' => 'required|max:50',
         'genero_code' => 'required|max:20',
         'ano' => 'required|numeric|between:1950,2100',
         'cartaz_url' => 'nullable',
         'sumario' => 'required|max:255',
         'trailer_url' => 'required|max:200'
      ]);
         //dd($validatedData);
         DB::table('filmes')
               ->where('id', $request->id)
               ->update(['titulo' => $validatedData['titulo'],
               'genero_code' => $validatedData['genero_code'],
               'ano' => $validatedData['ano'],
               'cartaz_url' => $request->cartaz_url,
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
      $lastId = Filme::latest('id')->first()->id+1;
      $random = Str::random(10);
      $nameFile = $lastId . '_'. $random . '.' . $request->cartaz_url->extension(); 
      $request->cartaz_url->move(public_path('storage/cartazes'), $nameFile);
      
      $validatedData = $request->validate([
         'titulo' => 'required|max:50',
         'genero_code' => 'required|max:20',
         'ano' => 'required|numeric|between:1950,2100',
         'cartaz_url' => 'nullable',
         'sumario' => 'required|max:255',
         'trailer_url' => 'required|max:200'
      ]);
      //dd($validatedData);
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

      if (is_null(Sessao::where('filme_id', $filme->id)->first())) {
      $filmeApagar = Filme::find($filme->id);
      $filmeApagar->delete();
      return redirect()->route('filmes.admin')
            ->with('alert-msg', 'Filme foi eliminado com sucesso!')
            ->with('alert-type', 'success');
   }else{
      return redirect()->back()
      ->with('alert-msg', 'Filme com sessões impossivel apagar!')
      ->with('alert-type', 'danger');        
   } 
   
   }
}

