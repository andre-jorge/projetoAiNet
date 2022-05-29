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
        ->name('sessoes.sessoes');//sessoes

Route::get('funcionario/sessoes/{id?}', [SessoesController::class, 'edit'])
        ->name('sessoes.edit');//sessoes

Route::put('funcionario/sessoes/{id?}', [SessoesController::class, 'update'])
        ->name('sessoes.update');


//---------------------------Sessoes ADMIN-------------------------------------
Route::get('adminsessoes/{filme}', [SessoesController::class, 'admin_index'])
        ->name('sessoes.admin.index');

Route::get('adminsessoes', [SessoesController::class, 'admin_create'])
        ->name('sessoes.admin.create');

Route::post('adminsessoes', [SessoesController::class, 'admin_store'])
        ->name('sessoes.admin.store'); 

Route::get('admin/adminsessoes/editar/{sessao}', [SessoesController::class, 'admin_edit'])
        ->name('sessoes.admin.edit'); 

Route::put('admin/adminsessoes/editar/{id?}', [SessoesController::class, 'admin_update'])
        ->name('sessoes.admin.update');

Route::delete('admin/adminsessoes/{id?}', [SessoesController::class, 'admin_destroy'])
        ->name('sessoes.admin.destroy');



//---------------------Salas-------------------------------------------------
Route::get('admin/salas', [SalasController::class, 'index'])
        ->name('salas.index');//salas

Route::get('admin/salas/criar', [SalasController::class, 'create'])
        ->name('salas.create'); //criar filme

Route::post('admin/salas', [SalasController::class, 'store'])
        ->name('salas.store'); // guardar filmes

Route::get('admin/salas/{id?}', [SalasController::class, 'edit'])
        ->name('salas.edit'); // editar sala

Route::put('admin/salas/{id?}', [SalasController::class, 'update'])
        ->name('salas.update');

Route::delete('admin/salas/{id?}', [SalasController::class, 'destroy'])
        ->name('salas.destroy');
//-----------------------------------------------------------------------------

//---------------------Configuracoes-------------------------------------------------
Route::get('admin/configs', [ConfiguracoesController::class, 'index'])
        ->name('configuracao.index');//bilhetes preços

Route::get('admin/configs/{id?}', [ConfiguracoesController::class, 'edit'])
        ->name('configuracao.edit'); // editar preços

Route::put('admin/configs/{id?}', [ConfiguracoesController::class, 'update'])
        ->name('configuracao.update');
//-----------------------------------------------------------------------------



//---------------------GENEROS----------------------------------------------------
Route::get('generos', [GeneroController::class, 'index'])
        ->name('generos.index');//generos!!



//---------------------FILMES----------------------------------------------------
Route::get('admin/filmes', [FilmesController::class, 'admin_index'])
        ->name('filmes.admin');// admin filmes
        
Route::get('admin/filmes/criar', [FilmesController::class, 'create'])
        ->name('filmes.create'); //criar filme
        
Route::get('admin/filmes/{id?}', [FilmesController::class, 'edit'])
        ->name('filmes.edit'); // editar filme

Route::post('admin/filmes', [FilmesController::class, 'store'])
        ->name('filmes.store'); // guardar filmes

Route::put('admin/filmes/{id?}', [FilmesController::class, 'update'])
        ->name('filmes.update');

Route::delete('admin/filmes/{filme}', [FilmesController::class, 'destroy'])
        ->name('filmes.destroy');

//-----------------------------------------------------------------------------

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    

//------------------------------------------------------------------------------

//------------------USERS----------------------

Route::get('user/{id?}', [usersController::class, 'index'])
         ->name('users.index');// admin filmes

Route::get('admin/users', [usersController::class, 'index_admin'])
        ->name('users.admin');

Route::get('user/{id?}/recibos', [usersController::class, 'recibos'])
        ->name('users.recibos');

//Route::put('user/{id?}', [usersController::class, 'update'])
//       ->name('user.update');
//------------------PDF----------------------

Route::get('recibos/bilhete/{recibo}', [PdfController::class, 'geraPdfBilhete'])
->name('pdf.bilhete');

Route::get('recibos', [PdfController::class, 'indexRecibo'])
->name('pdf.indexRecibo');

Route::get('recibos/{recibo}', [PdfController::class, 'geraPdfRecibo'])
->name('pdf.recibo');





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









