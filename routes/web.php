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

Route::get('sessoes/{filme}', [SessoesController::class, 'index'])
        ->name('sessoes.index');//sessoes

Route::get('funcionario/sessoes', [SessoesController::class, 'sessoes'])
->middleware('auth')->name('sessoes.sessoes');//sessoes

Route::get('funcionario/sessoes/{id?}', [SessoesController::class, 'edit'])
->middleware('auth')->name('sessoes.edit');//sessoes

Route::put('funcionario/sessoes/{id?}', [SessoesController::class, 'update'])
->middleware('auth')->name('sessoes.update');


//---------------------------Sessoes ADMIN-------------------------------------
Route::get('adminsessoes/{filme}', [SessoesController::class, 'admin_index'])
->middleware('auth')->name('sessoes.admin.index');

Route::get('adminsessoes', [SessoesController::class, 'admin_create'])
->middleware('auth')->name('sessoes.admin.create');

Route::post('adminsessoes', [SessoesController::class, 'admin_store'])
->middleware('auth')->name('sessoes.admin.store'); 

Route::get('admin/adminsessoes/editar/{sessao}', [SessoesController::class, 'admin_edit'])
->middleware('auth')->name('sessoes.admin.edit'); 

Route::put('admin/adminsessoes/editar/{id?}', [SessoesController::class, 'admin_update'])
->middleware('auth')->name('sessoes.admin.update');

Route::delete('admin/adminsessoes/{id?}', [SessoesController::class, 'admin_destroy'])
->middleware('auth')->name('sessoes.admin.destroy');



//---------------------Salas-------------------------------------------------
Route::get('admin/salas', [SalasController::class, 'index'])
->middleware('auth')->name('salas.index');//salas

Route::get('admin/salas/criar', [SalasController::class, 'create'])
->middleware('auth')->name('salas.create'); //criar filme

Route::post('admin/salas', [SalasController::class, 'store'])
->middleware('auth')->name('salas.store'); // guardar filmes

Route::get('admin/salas/{id?}', [SalasController::class, 'edit'])
->middleware('auth')->name('salas.edit'); // editar sala

Route::put('admin/salas/{id?}', [SalasController::class, 'update'])
->middleware('auth')->name('salas.update');

Route::delete('admin/salas/{id?}', [SalasController::class, 'destroy'])
->middleware('auth')->name('salas.destroy');
//-----------------------------------------------------------------------------

//---------------------Configuracoes-------------------------------------------------
Route::get('admin/configs', [ConfiguracoesController::class, 'index'])
->middleware('auth')->name('configuracao.index');//bilhetes preços

Route::get('admin/configs/{id?}', [ConfiguracoesController::class, 'edit'])
->middleware('auth')->name('configuracao.edit'); // editar preços

Route::put('admin/configs/{id?}', [ConfiguracoesController::class, 'update'])
->middleware('auth')->name('configuracao.update');
//-----------------------------------------------------------------------------



//---------------------GENEROS----------------------------------------------------
Route::get('generos', [GeneroController::class, 'index'])
->middleware('auth')->name('generos.index');//generos!!



//---------------------FILMES----------------------------------------------------
Route::get('admin/filmes', [FilmesController::class, 'admin_index'])
->middleware('auth')->name('filmes.admin');// admin filmes
        
Route::get('admin/filmes/criar', [FilmesController::class, 'create'])
->middleware('auth')->name('filmes.create'); //criar filme
        
Route::get('admin/filmes/{id?}', [FilmesController::class, 'edit'])
->middleware('auth')->name('filmes.edit'); // editar filme

Route::post('admin/filmes', [FilmesController::class, 'store'])
->middleware('auth') ->name('filmes.store'); // guardar filmes

Route::put('admin/filmes/{id?}', [FilmesController::class, 'update'])
->middleware('auth')->name('filmes.update');

Route::delete('admin/filmes/{filme}', [FilmesController::class, 'destroy'])
->middleware('auth')->name('filmes.destroy');

//-----------------------------------------------------------------------------

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    

//------------------------------------------------------------------------------

//------------------USERS----------------------

Route::get('user', [usersController::class, 'index'])
        ->middleware('auth')->name('users.index');// admin filmes

Route::get('admin/users', [usersController::class, 'index_admin'])
        ->middleware('auth')->name('users.admin');

Route::get('user/recibos', [usersController::class, 'recibos'])
        ->middleware('auth')->name('users.recibos');

//Route::put('user/{id?}', [usersController::class, 'update'])
//       ->name('user.update');
//------------------PDF----------------------

Route::get('recibos/bilhete/{recibo}', [PdfController::class, 'geraPdfBilhete'])
        ->middleware('auth')->name('pdf.bilhete');

Route::get('recibos', [PdfController::class, 'indexRecibo'])
        ->middleware('auth')->name('pdf.indexRecibo');

Route::get('recibos/{recibo}', [PdfController::class, 'geraPdfRecibo'])
        ->middleware('auth')->name('pdf.recibo');





//------------------Recibos----------------------

// Route::get('recibos', [RecibosController::class, 'index'])
// ->name('recibos.index');



//------------------Carrinho----------------------
Route::get('carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
Route::post('carrinho/sessao/{sessao}', [CarrinhoController::class, 'store_sessao'])->name('carrinho.store_sessao');
Route::put('carrinho/sessao/{sessao}', [CarrinhoController::class, 'update_sessao'])->name('carrinho.update_sessao');
Route::delete('carrinho/sessao/{sessao}', [CarrinhoController::class, 'destroy_sessao'])->name('carrinho.destroy_sessao');
Route::post('carrinho', [CarrinhoController::class, 'store'])->name('carrinho.store');
Route::delete('carrinho', [CarrinhoController::class, 'destroy'])->name('carrinho.destroy');









