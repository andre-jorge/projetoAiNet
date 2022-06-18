<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmesController;
use App\Http\Controllers\SessoesController;
use App\Http\Controllers\SalasController;
use App\Http\Controllers\GenerosController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RecibosController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\EmailController;
use App\Services\Payment;
use App\Http\Controllers\EstatisticasController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/home', function () {
//     return view('home');
// });


// Route::get('/', function () {
//      return view('page.index');
// });

Route::get('/', [FilmesController::class, 'index'])
        ->name('filme.index');

Route::get('sessoesFilme/{filme}', [SessoesController::class, 'index'])
        ->name('sessoes.index');//sessoes

Route::get('sessoes/lugares/{sessao}', [SessoesController::class, 'lugares'])
        ->name('sessoes.lugares');//lugares sessoes

Route::post('email/notification/1', [EmailController::class, 'send_email_with_notification1'])
        ->name('email.send_with_notification1');

Route::post('email/mailable', [EmailController::class, 'send_email_with_mailable'])
        ->name('email.send_with_mailable');

//-----------------------------------------------------------------------------------------
//--------------------------FUNCIONARIOS---------------------------------------------------        
//----------------------------------------------------------------------------------------- 
//--------------------FUNCIONARIOS VALIDA SESSOES------------------------------------------
Route::get('funcionario/sessoes', [SessoesController::class, 'funcionarioSessoes'])
->middleware('auth')->name('sessoes.funcionario.index')
->middleware('can:viewFuncionario,App\Models\User'); //sessoes

Route::get('funcionario/sessoes/{sessao}', [SessoesController::class, 'funcionarioValidarSessoes'])
->middleware('auth')->name('sessoes.funcionario.validarSessao')
->middleware('can:viewFuncionario,App\Models\User')
; 
Route::get('funcionario/sessoes/validaBilhete/{bilhete}', [SessoesController::class, 'validaBilhete'])
->middleware('auth')->name('sessoes.funcionario.validaBilhete')
->middleware('can:viewFuncionario,App\Models\User')
; 
Route::get('funcionario/sessoes/bilheteId/{sessao}', [SessoesController::class, 'validaBilhetePorId'])
->middleware('auth')->name('sessoes.funcionario.validaBilhetePorId')
->middleware('can:viewFuncionario,App\Models\User')
; 
//----------END------------FUNCIONARIOS VALIDA SESSOES----------------END-----------------


Route::get('funcionario/sessoes/{id?}', [SessoesController::class, 'edit'])
->middleware('auth')->name('sessoes.edit')
->middleware('can:viewFuncionario,App\Models\User');//sessoes

Route::put('funcionario/sessoes/{id?}', [SessoesController::class, 'update'])
->middleware('auth')->name('sessoes.update')
->middleware('can:viewFuncionario,App\Models\User');


//---------------------------Sessoes ADMIN-------------------------------------
Route::get('adminsessoes/{filme}', [SessoesController::class, 'admin_index'])
->middleware('auth')->name('sessoes.admin.index');

Route::get('adminsessoes', [SessoesController::class, 'admin_create'])
->middleware('auth')->name('sessoes.admin.create');

Route::post('adminsessoes', [SessoesController::class, 'admin_store'])
->middleware('auth')->name('sessoes.admin.store'); 

Route::get('admin/adminsessoes/editar/{sessao}', [SessoesController::class, 'admin_edit'])
->middleware('auth')->name('sessoes.admin.edit'); 

Route::put('admin/adminsessoes/editar/{sessao}', [SessoesController::class, 'admin_update'])
->middleware('auth')->name('sessoes.admin.update');

Route::delete('admin/adminsessoes/{sessao}', [SessoesController::class, 'admin_destroy'])
->middleware('auth')->name('sessoes.admin.destroy');



//---------------------Salas-------------------------------------------------
Route::get('admin/recuperar/salas/{salas}', [SalasController::class, 'sala_recuperar'])
        ->name('salas.index.recuperar');


Route::get('admin/salas', [SalasController::class, 'index'])
->middleware('auth')->name('salas.index')
->middleware('can:viewAdmin,App\Models\User')
; //salas

Route::get('admin/salas/criar', [SalasController::class, 'create'])
->middleware('auth')->name('salas.create')
->middleware('can:viewAdmin,App\Models\User')
;  //criar filme

Route::post('admin/salas', [SalasController::class, 'store'])
->middleware('auth')->name('salas.store')
->middleware('can:viewAdmin,App\Models\User')
;  // guardar filmes

Route::get('admin/salas/{salas}', [SalasController::class, 'edit'])
->middleware('auth')->name('salas.edit')
->middleware('can:viewAdmin,App\Models\User')
;  // editar sala

Route::put('admin/salas/{salas}', [SalasController::class, 'update'])
->middleware('auth')->name('salas.update')
->middleware('can:viewAdmin,App\Models\User')
; 

//-----------------------------------------------------------------------------

//---------------------Configuracoes-------------------------------------------------
Route::get('admin/configs', [ConfiguracoesController::class, 'index'])
->middleware('auth')->name('configuracao.index')
->middleware('can:viewAdmin,App\Models\User'); //bilhetes preços

Route::get('admin/configs/{id?}', [ConfiguracoesController::class, 'edit'])
->middleware('auth')->name('configuracao.edit')
->middleware('can:viewAdmin,App\Models\User'); // editar preços

Route::put('admin/configs/{id?}', [ConfiguracoesController::class, 'update'])
->middleware('auth')->name('configuracao.update')
->middleware('can:viewAdmin,App\Models\User');
//-----------------------------------------------------------------------------



//---------------------GENEROS----------------------------------------------------
Route::get('generos', [GeneroController::class, 'index'])
->middleware('auth')->name('generos.index');//generos!!



//---------------------FILMES----------------------------------------------------
Route::get('admin/filmes', [FilmesController::class, 'admin_index'])
->middleware('auth')->name('filmes.admin')
->middleware('can:viewAdmin,App\Models\User'); // admin filmes
        
Route::get('admin/filmes/criar', [FilmesController::class, 'create'])
->middleware('auth')->name('filmes.create')
->middleware('can:viewAdmin,App\Models\User'); //criar filme
        
Route::get('admin/filmes/{id?}', [FilmesController::class, 'edit'])
->middleware('auth')->name('filmes.edit')
->middleware('can:viewAdmin,App\Models\User'); // editar filme

Route::post('admin/filmes', [FilmesController::class, 'store'])
->middleware('auth') ->name('filmes.store')
->middleware('can:viewAdmin,App\Models\User'); // guardar filmes

Route::put('admin/filmes/{filme}', [FilmesController::class, 'update'])
->middleware('auth')->name('filmes.update')
->middleware('can:viewAdmin,App\Models\User');

Route::delete('admin/filmes/{filme}', [FilmesController::class, 'destroy'])
->middleware('auth')->name('filmes.destroy')
->middleware('can:viewAdmin,App\Models\User');

//-----------------------------------------------------------------------------

Auth::routes(['verify' => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    

//------------------------------------------------------------------------------

//------------------USERS----------------------

Route::get('user', [usersController::class, 'index'])
        ->middleware('auth')->name('users.index')
        ->middleware('can:viewCliente,App\Models\User')
        ;// admin filmes

Route::get('admin/clientes', [usersController::class, 'index_admin'])
        ->middleware('auth')->name('users.admin')
        ->middleware('can:viewAdmin,App\Models\User')
        ;

Route::get('user/recibos', [usersController::class, 'recibos'])
        ->middleware('auth')->name('users.recibos')
        ->middleware('can:viewCliente,App\Models\User')
        ;
//dados clientes update
 Route::put('user/edit', [usersController::class, 'cliente_update'])
         ->middleware('auth')->name('users.edit')
         ->middleware('can:viewCliente,App\Models\User')
         ;

//------------------------FUNCSS-------------------------------------
Route::get('admin/recuperar/funcionarios/{user}', [usersController::class, 'funcionario_recuperar'])
        ->middleware('auth')->name('users.funcionarios.recuperar')
        ->middleware('can:viewAdmin,App\Models\User')
        ;


Route::get('admin/funcionarios', [usersController::class, 'funcionarios'])
        ->middleware('auth')->name('users.funcionarios.index')
        ->middleware('can:viewAdmin,App\Models\User');

Route::get('admin/funcionarios/criar', [usersController::class, 'funcionario_create'])
        ->middleware('auth')->name('users.funcionarios.create')
        ->middleware('can:viewAdmin,App\Models\User')
        ; 
        
Route::post('admin/funcionarios', [usersController::class, 'funcionario_store'])
        ->middleware('auth')->name('users.funcionarios.store')
        ->middleware('can:viewAdmin,App\Models\User')
        ;  

Route::get('admin/funcionarios/{user}/inativar', [usersController::class, 'funcionario_inativar'])
        ->middleware('auth')->name('users.funcionarios.inativar')
        ->middleware('can:viewAdmin,App\Models\User')
        ; 

Route::get('admin/funcionarios/{user}', [usersController::class, 'funcionario_edit'])
        ->middleware('auth')->name('users.funcionarios.edit')
        ->middleware('can:viewAdmin,App\Models\User')
        ;  
        
Route::put('admin/funcionarios/{user}', [usersController::class, 'funcionario_update'])
        ->middleware('auth')->name('users.funcionarios.update')
        ->middleware('can:viewAdmin,App\Models\User')
        ; 
        
Route::delete('admin/funcionarios/{user}', [usersController::class, 'funcionario_destroy'])
        ->middleware('auth')->name('users.funcionarios.destroy')
        ->middleware('can:viewAdmin,App\Models\User')
        ;
        
        
//---------------------------------------------------------
//Route::put('user/{id?}', [usersController::class, 'update'])
//       ->name('user.update');
//------------------PDF----------------------

Route::get('recibos/bilhete/{recibo}', [PdfController::class, 'geraPdfBilhete'])
        ->middleware('auth')->name('pdf.bilhete')
        ->middleware('can:viewAdminCliente,App\Models\User');

Route::get('recibos', [PdfController::class, 'indexRecibo'])
        ->middleware('auth')->name('pdf.indexRecibo')
        ->middleware('can:viewAdmin,App\Models\User');

Route::get('recibos/{recibo}', [PdfController::class, 'geraPdfRecibo'])
        ->middleware('auth')->name('pdf.recibo')
        ->middleware('can:viewAdminCliente,App\Models\User');





//------------------Recibos----------------------

// Route::get('recibos', [RecibosController::class, 'index'])
// ->name('recibos.index');



//------------------Carrinho----------------------
Route::get('carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
Route::post('carrinho/sessaoValidada', [CarrinhoController::class, 'carrinhoValidado'])->name('carrinho.carrinhoValidado');
Route::post('carrinho/sessao/{sessao}', [CarrinhoController::class, 'store_sessao'])->name('carrinho.store_sessao');
Route::put('carrinho/sessao/{sessao}', [CarrinhoController::class, 'update_sessao'])->name('carrinho.update_sessao');
Route::delete('carrinho/sessao/{sessao}', [CarrinhoController::class, 'destroy_sessao'])->name('carrinho.destroy_sessao');
Route::post('carrinho', [CarrinhoController::class, 'store'])->name('carrinho.store');
Route::delete('carrinho', [CarrinhoController::class, 'destroy'])->name('carrinho.destroy');


//Estatisticas
Route::get('admin/estatisticas/totais/diarios', [EstatisticasController::class, 'estatisticas_totais_diario'])
        ->middleware('auth')->name('estatisticas.totais.diarios')
        ->middleware('can:viewAdmin,App\Models\User')
        ;
Route::get('admin/estatisticas/totais/mensal', [EstatisticasController::class, 'estatisticas_total_mensal'])
        ->middleware('auth')->name('estatisticas.totais.mensal')
        ->middleware('can:viewAdmin,App\Models\User')
        ;
Route::get('admin/estatisticas/totais/anual', [EstatisticasController::class, 'estatisticas_total_anual'])
        ->middleware('auth')->name('estatisticas.totais.anual')
        ->middleware('can:viewAdmin,App\Models\User')
        ;

Route::get('export', [EstatisticasController::class, 'export']);







Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
