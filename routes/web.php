<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

Route::get('registro/conteoregistros/{id}/{idcup}', [App\Http\Controllers\RegistroController::class, 'conteo']);

Route::put('registro/{id}', [App\Http\Controllers\RegistroController::class, 'eliminar']);


// RUTAS DE MANTENIMIENTO DE USUARIOS 
Route::get('registro/{id}', [App\Http\Controllers\CupoController::class, 'vistaregistro']);

Route::post('registro/usuarios', [App\Http\Controllers\HomeController::class, 'usuarios']);

Route::post('registro/datosusuarios', [App\Http\Controllers\HomeController::class, 'mostrarusuarios']);

Route::post('registro/editarusuarios/{id}', [App\Http\Controllers\HomeController::class, 'editarusuario']);

Route::post('registro/actualizarusuario', [App\Http\Controllers\HomeController::class, 'actualizarusuario']);

Route::post('registro/eliminarUsuario/{id}', [App\Http\Controllers\HomeController::class, 'eliminarusuario']);

Route::post('registro/paises', [App\Http\Controllers\HomeController::class, 'paises']);


//RUTAS DE REPORTE DE HORAS DE AGENTE

Route::get('vistareporte', [App\Http\Controllers\ReporteController::class, 'show']);

Route::get('registro/acceso/{id}', [App\Http\Controllers\ReporteController::class, 'acceso']);

Route::post('registro/accesoagentes', [App\Http\Controllers\ReporteController::class, 'accesoagentes']);


//Route::post('registro/reporte/{id}', [App\Http\Controllers\ReporteController::class, 'mostrarReporte']);

//Route::post('registro/idusuario', [App\Http\Controllers\ReporteController::class, 'idusuarios']);

Route::post('registro/reportehoras', [App\Http\Controllers\ReporteController::class, 'mostrarReporte']);


Route::post('registro/total', [App\Http\Controllers\ReporteController::class, 'total']);

//muestra total de horas de cada agente
Route::post('registro/horasusuario/{funo}/{fdos}/{id}', [App\Http\Controllers\ReporteController::class, 'totalusuario']);

// GENERA EXCEL

Route::get('registro/excel/{fech1}/{fech2}', function ($fecha1,$fecha2) {

return (new RegistroExports($fecha1,$fecha2))->download('invoices.xlsx');

});

// VISTA DE HORARIOS

Route::get('vistahorarios', function () {
    return view('horariosvista');
});

//RUTA DE CUPOS DE HORARIO
Route::get('agente/horarios', [App\Http\Controllers\CupoController::class, 'cuposhorario']);

Route::post('horario/cupo', [App\Http\Controllers\CupoController::class, 'store']);

Route::get('horario/mostrar/{id}', [App\Http\Controllers\CupoController::class, 'vistahorarios']);



});








/*
Route::get('/route1', function() { Artisan::call('optimize'); });

Route::get('/route2', function() { Artisan::call('route:clear'); });

Route::get('/route3', function() { Artisan::call('view:clear'); });
*/
