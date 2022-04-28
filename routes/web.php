<?php

use Illuminate\Support\Facades\Route;

use App\Exports\RegistroExports;
date_default_timezone_set("America/New_York");

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

Route::post('agente/mostrarcupos', [App\Http\Controllers\CupoController::class, 'show']);

Route::post('agente/eliminar/{id}', [App\Http\Controllers\CupoController::class, 'destroy']);

//VISTA DE MANTENIMIENTO DE REGISTRO DE HORAS

Route::get('usuarios', [App\Http\Controllers\HomeController::class, 'vistausuarios']);

Route::post('registro/registrohoras', [App\Http\Controllers\RegistroController::class, 'store']);

Route::get('registro/datos/{id}', [App\Http\Controllers\RegistroController::class, 'todosregistros']);

Route::get('registro/datosusuario/{id}/{id_u}', [App\Http\Controllers\RegistroController::class, 'show']);

Route::post('registro/editaregistro/{id}', [App\Http\Controllers\RegistroController::class, 'edit']);

Route::post('registro/actualizar', [App\Http\Controllers\RegistroController::class, 'update']);

// RUTAS DE MANTENIMIENTO DE USUARIOS 
Route::get('registro/{id}', [App\Http\Controllers\CupoController::class, 'vistaregistro']);

Route::post('registro/usuarios', [App\Http\Controllers\HomeController::class, 'usuarios']);

Route::post('registro/datosusuarios', [App\Http\Controllers\HomeController::class, 'mostrarusuarios']);

Route::post('registro/editarusuarios/{id}', [App\Http\Controllers\HomeController::class, 'editarusuario']);

Route::post('registro/actualizarusuario', [App\Http\Controllers\HomeController::class, 'actualizarusuario']);

Route::post('registro/eliminarUsuario/{id}', [App\Http\Controllers\HomeController::class, 'eliminarusuario']);

//RUTAS DE REPORTE DE HORAS DE AGENTE

Route::get('vistareporte', [App\Http\Controllers\ReporteController::class, 'show']);

Route::post('registro/reporte/{id}', [App\Http\Controllers\ReporteController::class, 'mostrarReporte']);

Route::post('registro/idusuario', [App\Http\Controllers\ReporteController::class, 'idusuarios']);


Route::post('registro/total', [App\Http\Controllers\ReporteController::class, 'total']);

// GENERA EXCEL

Route::get('/excel', function () {


return (new RegistroExports("2022-04-03","2022-04-15"))->download('invoices.xlsx');

});

});

/*

Route::get('/route1', function() { Artisan::call('optimize'); });

Route::get('/route2', function() { Artisan::call('route:clear'); });

Route::get('/route3', function() { Artisan::call('view:clear'); });


*/
