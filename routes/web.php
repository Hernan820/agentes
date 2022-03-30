<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('usuarios', [App\Http\Controllers\HomeController::class, 'vistausuarios']);

Route::post('agente/cupo', [App\Http\Controllers\CupoController::class, 'create']);

Route::get('agente/mostrar', [App\Http\Controllers\CupoController::class, 'show']);

Route::get('registro/{id}', [App\Http\Controllers\CupoController::class, 'vistaregistro']);

Route::get('registro/registroagente', [App\Http\Controllers\RegistroController::class, 'store']);


});


