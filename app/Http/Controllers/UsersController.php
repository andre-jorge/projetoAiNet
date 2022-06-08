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


class UsersController extends Controller
{
   public function index(Request $request)
      {
         $id = auth()->user()->id;
         $cliente = User::where('id', $id)->first();
                     return view('users.index')->with('clientes', $cliente);
      }
   
   public function index_admin()
      {
         $dadosClientes = DB::table('users')
                     ->select('*')
                     ->leftjoin('clientes','clientes.id','=','users.id')
                     ->paginate(20);  
                     //dd($dadosClientes);
                     return view('users.admin')->with('Clientes', $dadosClientes);   
      }

   public function funcionarios(Request $request)
      {
         $user = auth()->user();
         $id = auth()->user()->id;
         $dadosFuncionarios = User::where('tipo','=','F')
                     ->paginate(5, ['*'], 'funcionario');  
                     //dd($dadosFuncionarios);
         $dadosAdmin = User::where('tipo','=','A')
                     ->where('id','<>',$id)
                     ->paginate(5, ['*'], 'administrador');
                     return view('users.funcionarios.index')
                                 ->with('Admins', $dadosAdmin)
                                 ->with('Funcionarios', $dadosFuncionarios);   
      }

   public function recibos(Request $request)
      {
         $user = auth()->user();
         $id = auth()->user()->id;
         $recibos = Recibo::where('cliente_id',$id)->paginate(8);
         //dd($recibos);
         return view('users.recibos', compact('recibos'));
      }

   
   
   

   //----------------------------------------------------------------
   //-----------------------FUNCIONARIO------------------------------
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
      $nameFile = $lastId . '_'. $random . '.' . $request->foto_url->extension(); 
      $request->foto_url->move(public_path('storage/fotos'), $nameFile);
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
        $newUser->foto_url = $nameFile;
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
          return redirect()->route('users.funcionarios.index')
              ->with('alert-msg', 'Utilizador '.$user->name. ' Inativado')
              ->with('alert-type', 'success');
            }

            if($user->bloqueado == 1){
               User::where('id', $user->id)
                     ->update(['bloqueado' => '0',
                   ]);
               return redirect()->route('users.funcionarios.index')
                   ->with('alert-msg', 'Utilizador '.$user->name.' Ativado')
                   ->with('alert-type', 'success');
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
      return redirect()->route('users.funcionarios.index')
            ->with('alert-msg', 'Utilizador '.$user->name.' eliminado com sucesso!')
            ->with('alert-type', 'success');
    }
}

