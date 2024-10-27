<?php

use App\Http\Controllers\ComparacionController;
use App\Http\Controllers\EgresadosController;
use App\Http\Controllers\InscritosController;
use App\Http\Controllers\PpacController;
use App\Http\Controllers\PpsController;
use App\Http\Controllers\TituladosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/servicios', function () {
    return view('services');
});



//Route::get('/inscritos-carrera-facultad', InscritosController::class . '@carreraFacultad');
Route::get('/inscritos-carrera-facultad', [InscritosController::class, 'carreraFacultad'])->name('inscritos-carrera-facultad');

// Ruta para actualizar los datos de inscritos por carrera
Route::get('/inscritos-carrera', [InscritosController::class, 'carrera'])->name('inscritos-carrera');



Route::get('/inscritos-facultad', InscritosController::class . '@facultad');

Route::get('/inscritos-localidad', [InscritosController::class, 'localidad'])->name('inscritos-localidad');
// Route::get('/inscritos-localidad', InscritosController::class . '@localidad');

Route::get('/inscritos-modalidad', InscritosController::class . '@modalidad');
Route::get('/inscritos-nuevo-carrera', InscritosController::class . '@nuevoCarrera');
//titulados
Route::get('/titulados-periodo', TituladosController::class . '@periodo');
Route::get('/titulados-facultad', TituladosController::class . '@facultad');

//egresados
Route::get('/egresados-periodo', EgresadosController::class . '@periodo');
Route::get('/egresados-facultad', EgresadosController::class . '@facultad');
//comparacion
Route::get('/comparacion-periodo', ComparacionController::class . '@periodo');
Route::get('/comparacion-facultad', ComparacionController::class . '@facultad');
//desercion
Route::get('/desercion-periodo', ComparacionController::class . '@periodo');
Route::get('/desercion-facultad', ComparacionController::class . '@facultad');
//rendimiento
Route::get('/rendimiento-periodo', ComparacionController::class . '@periodo');
Route::get('/rendimiento-facultad', ComparacionController::class . '@facultad');
//pps
Route::get('/pps-periodo', PpsController::class . '@periodo');
Route::get('/pps-facultad', PpsController::class . '@facultad');
//ppac
Route::get('/ppac-periodo', PpacController::class . '@periodo');
Route::get('/ppac-facultad', PpacController::class . '@facultad');
Route::get('/ppac-sin0periodo', PpacController::class . '@sin0periodo');
Route::get('/ppac-sin0facultad', PpacController::class . '@sin0facultad');
