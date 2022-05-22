<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmesController;
use App\Http\Controllers\SessoesController;
use App\Http\Controllers\SalasController;
use App\Http\Controllers\GenerosController;

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

Route::get('/sessoes/{id?}', [SessoesController::class, 'index'])
        ->name('sessoes.index');//sessoes

//Salas-----------------
Route::get('salas', [SalasController::class, 'index'])
         ->name('salas.index');//salas

Route::get('salas/criar', [SalasController::class, 'create'])
         ->name('salas.index'); //criar filme

Route::post('salas', [SalasController::class, 'store'])
        ->name('salas.store'); // guardar filmes

Route::get('salas/{id?}/edit', [SalasController::class, 'edit'])
        ->name('salas.edit'); // editar sala


//---------------------

Route::get('admin/filmes', [FilmesController::class, 'admin_index'])
        ->name('filmes.admin');// admin filmes

Route::get('generos', [GeneroController::class, 'index'])
        ->name('generos.index');//generos!!
        
Route::get('filmes', [FilmesController::class, 'create'])
        ->name('filmes.index'); //criar filme

Route::get('filmes/{id?}/edit', [FilmesController::class, 'edit'])
        ->name('filmes.edit'); // editar filme

Route::post('filmes', [FilmesController::class, 'store'])
        ->name('filmes.store'); // guardar filmes


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
