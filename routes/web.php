<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmesController;
use App\Http\Controllers\SessoesController;
use App\Http\Controllers\SalasController;
use App\Http\Controllers\GenerosController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UsersController;

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

 Route::get('sessoes/{id?}', [SessoesController::class, 'index'])
         ->name('sessoes.index');//sessoes

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

Route::delete('admin/filmes/{id?}', [FilmesController::class, 'destroy'])
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

//Route::put('user/{id?}', [usersController::class, 'update'])
//       ->name('user.update');


// Route::get('sessoes/{id?}', [SessoesController::class, 'index'])
// ->name('sessoes.index');
// // Route::get('carrinho', [App\Http\Controllers\SessoesController::class, 'addToCart'])
// // ->name('sessoes.index');


Route::get('cart', [CartController::class, 'index'])
        ->name('cart.index');


