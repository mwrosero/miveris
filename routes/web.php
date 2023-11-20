<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeguridadesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\TratamientosController;
use App\Http\Controllers\ResultadosController;
use App\Http\Controllers\DomicilioController;
use App\Http\Controllers\FamiliaAmigosController;
use App\Http\Controllers\DoctoresFavoritosController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\ExperienciaController;
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
    #Inicio
    Route::get('/', [DashboardController::class, 'home'])->name('home')->withoutMiddleware(['guest']);
    Route::get('/logout', [SeguridadesController::class, 'logout'])->name('logout')->withoutMiddleware(['guest']);
    Route::get('/mis-datos', [DashboardController::class, 'misDatos'])->name('misDatos')->withoutMiddleware(['guest']);
    Route::get('/politica-privacidad-datos', [DashboardController::class, 'politicaPrivacidadDatos'])->name('politicaPrivacidadDatos')->withoutMiddleware(['guest']);
    Route::get('/promociones', [DashboardController::class, 'listaPromociones'])->name('home.promociones')->withoutMiddleware(['guest']);
    Route::get('/detalle', [DashboardController::class, 'promocionDetalle'])->name('home.promocionDetalle')->withoutMiddleware(['guest']);

    #Citas
    Route::get('/citas', [CitasController::class, 'citas'])->name('citas')->withoutMiddleware(['guest']);
    Route::get('/citas-elegir-paciente',[CitasController::class, 'listaPacientes'])->name('citas.listaPacientes')->withoutMiddleware(['guest']);
    Route::get('/citas-elegir-especialidad',[CitasController::class, 'listaEspecialidades'])->name('citas.listaEspecialidades')->withoutMiddleware(['guest']);
    Route::get('/citas-elegir-central-medica',[CitasController::class, 'listaCentralMedica'])->name('citas.listaCentralMedica')->withoutMiddleware(['guest']);
    Route::get('/citas-elegir-fecha-doctor',[CitasController::class, 'fechaDoctor'])->name('citas.fechaDoctor')->withoutMiddleware(['guest']);
    Route::get('/citas-revisa-tus-datos',[CitasController::class, 'detalleCita'])->name('citas.detalleCita')->withoutMiddleware(['guest']);
    Route::get('/citas-datos-facturacion',[CitasController::class, 'datosFacturacion'])->name('citas.datosFacturacion')->withoutMiddleware(['guest']);
    Route::get('/citas-informacion-pago',[CitasController::class, 'citaInformacionPago'])->name('citas.citaInformacionPago')->withoutMiddleware(['guest']);
    Route::get('/citas-agendada',[CitasController::class, 'citaAgendada'])->name('citas.agendada')->withoutMiddleware(['guest']);
    #Laboratorio
    Route::get('/laboratorio',[CitasController::class, 'laboratorio'])->name('citas.laboratorio')->withoutMiddleware(['guest']);
    Route::get('/laboratorio-domicilio', [CitasController::class, 'laboratorioDomicilio'])->name('citas.laboratorioDomicilio')->withoutMiddleware((['guest']));
    Route::get('/citas-laboratorio', [CitasController::class, 'citasLaboratorio'])->name('citas.citasLaboratorio')->withoutMiddleware((['guest']));
    #Imagenes y procedimientos
    Route::get('/imagenes-procedimientos',[CitasController::class, 'imagenesProcedimientos'])->name('citas.imagenesProcedimientos')->withoutMiddleware(['guest']);
    #Terapia fisica
    Route::get('/terapia-fisica',[CitasController::class, 'terapiaFisica'])->name('citas.terapiaFisica')->withoutMiddleware(['guest']);
    #Receta medica
    Route::get('/receta-medica',[CitasController::class, 'recetaMedica'])->name('citas.recetaMedica')->withoutMiddleware(['guest']);

    #Tratamientos
    Route::get('/mis-tratamientos', [TratamientosController::class, 'misTratamientos'])->name('tratamientos')->withoutMiddleware(['guest']);
    Route::get('/tratamientos', [TratamientosController::class, 'tratamientos'])->name('tratamientos.lista')->withoutMiddleware(['guest']);
    Route::get('/tu-tratamiento', [TratamientosController::class, 'detalleTratamiento'])->name('tratamientos.detalle')->withoutMiddleware(['guest']);
    Route::get('/farmacia-domicilio', [TratamientosController::class, 'farmaciaDomicilio'])->name('tratamientos.farmaciaDomicilio')->withoutMiddleware((['guest']));
    #Resultados
    Route::get('/resultados', [ResultadosController::class, 'resultados'])->name('resultados')->withoutMiddleware(['guest']);
    Route::get('/resultados-laboratorio', [ResultadosController::class, 'resultadosLaboratorio'])->name('resultados.laboratorio')->withoutMiddleware(['guest']);
    Route::get('/resultados-imagenes-procedimientos', [ResultadosController::class, 'resultadosImagenesProcedimientos'])->name('resultados.ImagenesProcedimientos')->withoutMiddleware(['guest']);

    #Domicilio
    Route::get('/servicio-domicilio', [DomicilioController::class, 'domilicio'])->name('domicilio')->withoutMiddleware(['guest']);

    #Familia y amigos
    Route::get('/familia-amigos', [FamiliaAmigosController::class, 'familiaAmigos'])->name('familia')->withoutMiddleware(['guest']);
    Route::get('/familia-amigos-lista', [FamiliaAmigosController::class, 'listaFamiliaAmigos'])->name('familia.lista')->withoutMiddleware(['guest']);
    Route::get('/datos-familiar', [FamiliaAmigosController::class, 'datosFamiliar'])->name('familia.datosFamiliar')->withoutMiddleware(['guest']);

    #Doctores favoritos
    Route::get('/doctores-favoritos', [DoctoresFavoritosController::class, 'doctoresFavoritos'])->name('doctoresFavoritos')->withoutMiddleware(['guest']);
    Route::get('/buscar-doctor', [DoctoresFavoritosController::class, 'buscarDoctor'])->name('doctoresFavoritos.buscarDoctor')->withoutMiddleware(['guest']);

    #Solicitar historia clínica
    Route::get('/historia-clinica', [HistoriaClinicaController::class, 'historiaClinica'])->name('historiaClinica')->withoutMiddleware(['guest']);
    Route::get('/lista-doctores', [HistoriaClinicaController::class, 'listaDoctoresHistoriaClinica'])->name('historiaClinica.listaDoctores')->withoutMiddleware(['guest']);
    Route::get('/solicitar-historia-clinica', [HistoriaClinicaController::class, 'solicitarHistoriaClinica'])->name('historiaClinica.solicitar')->withoutMiddleware(['guest']);

    #Experiencia
    Route::get('/cuentanos-tu-experiencia', [ExperienciaController::class, 'tuExperiencia'])->name('experiencia')->withoutMiddleware(['guest']);
});