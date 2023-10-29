<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeguridadesController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [SeguridadesController::class, 'login'])->name('login')->withoutMiddleware(['loggedUser']);
    Route::post('/autenticar', [SeguridadesController::class, 'autenticar'])->name('autenticar')->withoutMiddleware(['loggedUser']);
    
    Route::get('/registrar-cuenta', [SeguridadesController::class, 'registrarCuenta'])->name('registrar_cuenta')->withoutMiddleware(['loggedUser']);
    
    Route::get('/olvide-clave', [SeguridadesController::class, 'olvideClave'])->name('olvide_clave')->withoutMiddleware(['loggedUser']);

    Route::get('/activar-cuenta', [SeguridadesController::class, 'activarCuentaView'])->name('activar_cuenta_view')->withoutMiddleware(['loggedUser']);

    Route::post('/activar-cuenta', [SeguridadesController::class, 'activarCuenta'])->name('activar_cuenta')->withoutMiddleware(['loggedUser']);

    // Route::get('/recuperar-clave', [SeguridadesController::class, 'recuperarClave'])->name('recuperar_clave')->withoutMiddleware(['loggedUser']);

    Route::get('/reestablecer-clave/{codigoUsuario}', [SeguridadesController::class, 'reestablecerClave'])->name('reestablecer_clave')->withoutMiddleware(['loggedUser']);
    
    Route::post('/actualizar-clave', [SeguridadesController::class, 'actualizarClave'])->name('actualizar_clave.update')->withoutMiddleware(['loggedUser']);

});

Route::group(['middleware' => ['loggedUser']], function () {
    Route::get('/', [DashboardController::class, 'home'])->name('home')->withoutMiddleware(['guest']);
    Route::get('/logout', [SeguridadesController::class, 'logout'])->name('logout')->withoutMiddleware(['guest']);

});