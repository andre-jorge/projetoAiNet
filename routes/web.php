<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmesController;
use App\Http\Controllers\SessoesController;
use App\Http\Controllers\PageController;

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
        ->name('sessoes.index');
        
Route::get('admin/filmes', [FilmesController::class, 'admin_index'])
        ->name('filmes.admin');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
