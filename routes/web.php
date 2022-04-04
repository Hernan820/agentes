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
//RUTAS DE CUPO

Route::post('agente/cupo', [App\Http\Controllers\CupoController::class, 'create']);

Route::get('agente/mostrar', [App\Http\Controllers\CupoController::class, 'show']);

//VISTA DE MANTENIMIENTO DE REGISTRO DE HORAS

Route::get('usuarios', [App\Http\Controllers\HomeController::class, 'vistausuarios']);

Route::post('registro/registrohoras', [App\Http\Controllers\RegistroController::class, 'store']);

Route::get('registro/datos/{id}', [App\Http\Controllers\RegistroController::class, 'show']);

Route::post('registro/editaregistro/{id}', [App\Http\Controllers\RegistroController::class, 'edit']);

Route::post('registro/actualizar', [App\Http\Controllers\RegistroController::class, 'update']);

// RUTAS DE MANTENIMIENTO DE USUARIOS 
Route::get('registro/{id}', [App\Http\Controllers\CupoController::class, 'vistaregistro']);

Route::post('registro/usuarios', [App\Http\Controllers\HomeController::class, 'usuarios']);

Route::post('registro/datosusuarios', [App\Http\Controllers\HomeController::class, 'mostrarusuarios']);

Route::post('registro/editarusuarios/{id}', [App\Http\Controllers\HomeController::class, 'editarusuario']);

Route::post('registro/actualizarusuario', [App\Http\Controllers\HomeController::class, 'actualizarusuario']);



});


