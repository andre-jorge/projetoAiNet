<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recibo;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersController extends Controller
{
   public function index(Request $request) // Dados Clientes
      {
         $id = auth()->user()->id;
         $cliente = User::where('id', $id)->first();
                     return view('users.index')->with('clientes', $cliente);
      }
   
   public function index_admin(Request $request)//Pagina clientes
      {
         if(($request->string && $request->string != null ) && ($request->nif && $request->nif != null ) ){
            $dadosClientes = User::withTrashed()
                           ->where('tipo','=','C')
                           ->Where('name', 'like', '%' . $request->string . '%')
                           ->orWhere('email', 'like', '%' . $request->string . '%')
                           ->orWhere('nif', 'like', '%' . $request->nif . '%')
                           ->paginate(6, ['*'], 'ativos'); 
                           //dd($dadosFuncionarios);
                           return view('users.admin')
                                 ->with('dadosClientes', $dadosClientes);  
                        }
                        //dd($request->string); 
         //Se tiver String nome e email                  
         if($request->string && $request->string != null ){
            $dadosClientes = User::withTrashed()
                           ->where('tipo','=','C')
                           ->Where('name', 'like', '%' . $request->string . '%')
                           ->orWhere('email', 'like', '%' . $request->string . '%')
                           ->paginate(6, ['*'], 'ativos'); 
                           return view('users.admin')
                                 ->with('dadosClientes', $dadosClientes); 
                        }
         //Se tiver NIF               
         if($request->nif && $request->nif != null ){
            $numeroClienteNif = Cliente::where('nif', 'like', '%' . $request->nif . '%')->pluck('id');
            $dadosClientes = User::withTrashed()
                           ->where('tipo','=','C')
                           ->Where('id',$numeroClienteNif)
                           ->paginate(6, ['*'], 'ativos'); 
                           return view('users.admin')
                                 ->with('dadosClientes', $dadosClientes); 
                        }
         $dadosClientes = User::withTrashed()
                              ->where('tipo','=','C')
                              ->paginate(6, ['*'], 'ativos'); 
                     //dd($dadosClientes);
                     return view('users.admin')
                                 ->with('dadosClientes', $dadosClientes);   
      }

   public function recibos(Request $request)
      {
         $user = auth()->user();
         $id = auth()->user()->id;
         $recibos = Recibo::where('cliente_id',$id)->orderBy('id', 'desc')->paginate(8);
         //dd($recibos);
         return view('users.recibos', compact('recibos'));
      }

   
   
   

   //----------------------------------------------------------------
   //-----------------------FUNCIONARIO E ADMIN----------------------

   public function funcionarios(Request $request) // Mostra Lista Funcionarios
      {
         $user = auth()->user();
         $id = auth()->user()->id;
         $tipoUtilizador = 'Todos';
         //                         
         //Se tiver String e Tipo                 
         if(($request->string && $request->string != null) && ($request->tipo && $request->tipo != 'Todos' ) ){
            $dadosFuncionarios = User::withTrashed()
                           ->where('id','<>',$id)
                           ->where('tipo','<>','C')
                           ->Where('tipo', $request->tipo)
                           ->Where('name', 'like', '%' . $request->string . '%')
                           ->orWhere('email', 'like', '%' . $request->string . '%')
                           ->paginate(10, ['*'], 'funcionario');  
                           //dd($dadosFuncionarios);
                           $tipoUtilizador = $request->tipo;
                           return view('users.funcionarios.index')
                                 ->with('tipoUtilizador', $tipoUtilizador)
                                 ->with('Funcionarios', $dadosFuncionarios);
                                 
                        }
                        
                        //dd($request->string); 
         //Se tiver String                  
         if($request->string && $request->string != null ){
            $dadosFuncionarios = User::withTrashed()
                           ->where('id','<>',$id)
                           ->where('tipo','<>','C')
                           ->Where('name', 'like', '%' . $request->string . '%')
                           ->Where('tipo', $request->tipo)
                           ->orWhere('email', 'like', '%' . $request->string . '%')
                           ->paginate(10, ['*'], 'funcionario');  
                           //dd($dadosFuncionarios);
                           return view('users.funcionarios.index')
                                 ->with('tipoUtilizador', $tipoUtilizador)
                                 ->with('Funcionarios', $dadosFuncionarios);
                        }
         //dd($request->string && $request->string != null );
         //Se tiver Tipo               
         if ($request->tipo && $request->tipo != 'Todos' ) {
            $dadosFuncionarios = User::withTrashed()
                           ->where('id','<>',$id)
                           ->where('tipo', $request->tipo)
                           ->paginate(10, ['*'], 'funcionario');  
                           $tipoUtilizador = $request->tipo;
                           return view('users.funcionarios.index')
                                 ->with('tipoUtilizador', $tipoUtilizador)
                                 ->with('Funcionarios', $dadosFuncionarios);
                           //dd($dadosFuncionarios);
                           
         }
         //dd($tipoUtilizador); 
         $dadosFuncionarios = User::withTrashed()
                                    ->where('id','<>',$id)
                                    ->where('tipo','<>','C')
                                    ->paginate(10, ['*'], 'funcionario');
         return view('users.funcionarios.index')
                     ->with('tipoUtilizador', $tipoUtilizador)
                     ->with('Funcionarios', $dadosFuncionarios);   
      }

   public function funcionario_create()
      {
         $dadosFuncionarios = User::where('tipo','=','F')->get();
         //dd($dadosFuncionarios);
         return view('users.funcionarios.create')->with('funcionario', $dadosFuncionarios);
      }

   public function funcionario_store(Request $request, User $user)
   {
      $hashedPassword = Hash::make($request->password);
      $lastId = User::latest('id')->first()->id+1;
      $random = Str::random(10);
      dd($user);
      //valida nome
      if ($request->name == null) {
         return back()
                ->with('alert-msg', 'Campo Nome Obrigatorio')
                ->with('alert-type', 'danger');
      }
      // valida email
      if ($request->email == null) {
         return back()
                ->with('alert-msg', 'Email já existente')
                ->with('alert-type', 'danger');
      }
      //valida foto
      if ($request->foto_url == null){
         return back()
                ->with('alert-msg', 'Foto em Falta')
                ->with('alert-type', 'danger');
      }else{
         $nameFile = $lastId . '_'. $random . '.' . $request->foto_url->extension(); 
         $request->foto_url->move(public_path('storage/fotos'), $nameFile);
      }
      //valida password
      if ($request->password == null) {
         return back()
                ->with('alert-msg', 'Password Obrigatorio')
                ->with('alert-type', 'danger');
      }
      
      $validatedData = $request->validate([
         'name' => 'required|max:50',
         'email' => 'required',
         'foto_url' => 'nullable',
         'bloqueado' => 'max:1',
         'tipo' => 'max:1',
         'password' => 'required',
       ]);
        $newUser = User::create($validatedData);
        $newUser->password = $hashedPassword;
        $newUser->bloqueado = 0;
        $newUser->tipo = $request->tipo;
      if ($request->foto_url <> null) {
        $newUser->foto_url = $nameFile;
      }
        $newUser->save();
                    
        //DB::table('filmes')->insert($validatedData);
        return redirect()->route('users.funcionarios.index')
              ->with('alert-msg', 'User inserido com Sucesso')
              ->with('alert-type', 'success');
    }

    public function funcionario_edit(Request $request, User $user)
      {
         //dd($user->id);
         $funcionario = User::where('id', $user->id)->first();
         //$listaFuncs = User::pluck('id');
         return view('users.funcionarios.edit')->with('funcionario', $funcionario)
                                   ;
      }
   
   public function funcionario_inativar(Request $request, User $user)
      {
         if($user->bloqueado == 0){
          User::where('id', $user->id)
                ->update(['bloqueado' => '1',
              ]);
              if ($user->tipo == 'C') {
                  return redirect()->back()
                  ->with('alert-msg', 'Cliente '.$user->name. ' Bolqueado')
                  ->with('alert-type', 'success');
            }else{
               return redirect()->back()
                  ->with('alert-msg', 'Utilizador '.$user->name. ' Bolqueado')
                  ->with('alert-type', 'success');
            }
         }

         if($user->bloqueado == 1){
            User::where('id', $user->id)
                  ->update(['bloqueado' => '0',
                  ]);
               if ($user->tipo == 'C') {
                     return redirect()->back()
                     ->with('alert-msg', 'Cliente '.$user->name. ' Desbolqueado')
                     ->with('alert-type', 'success');
               }else{
                  return redirect()->back()
                     ->with('alert-msg', 'Utilizador '.$user->name. ' Desbolqueado')
                     ->with('alert-type', 'success');
               }
      }
   }

   public function funcionario_update(Request $request, User $user)
    {
       //dd($request->foto_url);
      if(is_null($request->foto_url)){
         $nameFile = $user->foto_url;
      }else{
         $random = Str::random(10);
         $nameFile = $user->id . '_'. $random . '.' . $request->foto_url->extension(); 
         $request->foto_url->move(public_path('storage/fotos'), $nameFile);
         $request->foto_url =$nameFile;
      }
      //dd($request);
      $validatedData = $request->validate([
        'name' => 'required|max:50',
        'email' => 'required',
        'foto_url' => 'nullable',
        'tipo' => 'nullable',
      ]);
        //dd($nameFile);

        User::where('id', $user->id)
              ->update(['name' => $validatedData['name'],
              'email' => $validatedData['email'],
              'foto_url' => $nameFile,
              'tipo' => $request->tipo,
            ]);
        return redirect()->route('users.funcionarios.index')
            ->with('alert-msg', 'Utilizador '.$validatedData['name'].' atualizado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function funcionario_destroy(Request $request, User $user)
    {
      $userApagar = User::find($user->id);
      $userApagar->delete();
      if ($user->tipo == 'C') {
         $clienteApagar = Cliente::find($user->id);
         $clienteApagar->delete();
         return redirect()->route('users.admin')
            ->with('alert-msg', 'Cliente '.$user->name.' eliminado com sucesso!')
            ->with('alert-type', 'success');
      }
      return redirect()->route('users.funcionarios.index')
            ->with('alert-msg', 'Utilizador '.$user->name.' eliminado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function funcionario_recuperar(Request $request)
    {
      $user = User::withTrashed()->find($request->user);
      //dd($userRecuperar);
      if ($user->tipo == 'C') {//se é cliente
         if (is_null($user->deleted_at)) {// Valida se esta deleted_at (Apaga User e Cliente)
            $clienteApagar = Cliente::withTrashed()->find($user->id);
            $user->delete();
            $clienteApagar->delete();
            return redirect()->back()
            ->with('alert-msg', 'Cliente '.$user->name.' eliminado com sucesso!')
            ->with('alert-type', 'success');
            
      }else{// Caso deleted_at entao recuperar (Recupera User e Cliente)
            $clienteRecuperar = Cliente::withTrashed()->find($user->id);
            $user->restore();
            $clienteRecuperar->restore();
            return redirect()->back()
               ->with('alert-msg', 'Cliente '.$user->name.' recuperado com sucesso!')
               ->with('alert-type', 'success');
      }  
      }
      //se for funcionario ou admin
      if (is_null($user->deleted_at)) {
         $user->delete();
         return redirect()->back()
               ->with('alert-msg', 'Utilizador '.$user->name.' Eliminado com sucesso!')
               ->with('alert-type', 'success');
      }else{
         $user->restore();
         return redirect()->back()
               ->with('alert-msg', 'Utilizador '.$user->name.' recuperado com sucesso!')
               ->with('alert-type', 'success');
      }    
    }

    //Dados clientes update
    public function cliente_update(Request $request)
   {
      $user = auth()->user();
      $random = Str::random(10);
      //dd(strlen($request->nif));
      //valida se houver alterações
      if ($request->name == $user->name and $request->nif == $user->Cliente->nif and $request->tipo_pagamento == $user->Cliente->tipo_pagamento and $request->foto_url == null) {
         return back()
                ->with('alert-msg', 'Sem dados a alterar')
                ->with('alert-type', 'success');
      }
      
     
      //update nome
      if($request->name){
         $validatedData = $request->validate(['name' => 'required|max:50']);
         User::where('id', $user->id)->update(['name' => $validatedData['name']]);
      }
      //update nif
      if($request->nif){
         if (strlen($request->nif) == 9) {
         $validatedData = $request->validate(['nif' => 'required']);
         Cliente::where('id', $user->id)->update(['nif' => $validatedData['nif']]);
      }else{
         return back()
             ->with('alert-msg', 'NIF invalido')
             ->with('alert-type', 'success');
      }   
      }
      //update tipo_pagamento
      if($request->tipo_pagamento){
         if ($request->tipo_pagamento != 'NENHUM') {
            Cliente::where('id', $user->id)->update(['tipo_pagamento' => $request->tipo_pagamento]);
         } 
      }
      //update foto
      if($request->foto_url){
         $nameFile = ($user->id . '_'. $random . '.' . $request->foto_url->extension()); 
         $request->foto_url->move(public_path('storage/fotos'), $nameFile);
         User::where('id', $user->id)
              ->update(['foto_url' => $nameFile]);
      }




        return back()
            ->with('alert-msg', 'Dados atualizados com sucesso!')
            ->with('alert-type', 'success');
    }
}

