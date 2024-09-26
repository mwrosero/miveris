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
use App\Http\Controllers\ExternalController;
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

    Route::get('/reestablecer-clave/{params}', [SeguridadesController::class, 'reestablecerClave'])->name('reestablecer_clave')->withoutMiddleware(['loggedUser']);
    
    Route::post('/actualizar-clave', [SeguridadesController::class, 'actualizarClave'])->name('actualizar_clave.update')->withoutMiddleware(['loggedUser']);

    /*Externo*/
    Route::prefix('external')->group(function () {
        Route::get('/citas', [ExternalController::class, 'agendamientoCitas'])->name('embudo-agendamiento')->withoutMiddleware(['guest']);
        Route::get('/planes-promocionales', [ExternalController::class, 'listadoPaquetes'])->name('listado-paquetes')->withoutMiddleware(['guest']);
        Route::get('/planes-promocionales/detalle/{params}', [ExternalController::class, 'detallePaquete'])->name('detalle-paquete')->withoutMiddleware(['guest']);
        Route::get('/planes-promocionales/asignar/{params}', [ExternalController::class, 'asignarPaquete'])->name('asignar-paquete')->withoutMiddleware(['guest']);
        Route::get('/payment/', [ExternalController::class, 'payment'])->name('pago-citas')->withoutMiddleware(['guest']);
        // Route::get('/payment/services/', [ExternalController::class, 'paymentServices'])->name('pago-servicios')->withoutMiddleware(['guest']);
        Route::get('/payment/kushki/{params}', [ExternalController::class, 'pagoExternoKushki'])->name('pago-kushki-externo')->withoutMiddleware(['guest']);
        Route::post('/payment/kushki/procesar/{params}', [ExternalController::class, 'procesarExternoKushki'])->name('procesar-pago-kushki-externo')->withoutMiddleware(['guest']);
        Route::get('/payment/error', [ExternalController::class, 'showErrorPayment'])->name('payment-error')->withoutMiddleware(['guest']);
        
        Route::post('/payment/nuvei/procesar/{params}', [ExternalController::class, 'procesarExternoNuvei'])->name('procesar-pago-nuvei-externo')->withoutMiddleware(['guest']);

        Route::get('/payment/comprobante', [ExternalController::class, 'comprobantePago'])->name('comprobante-pago')->withoutMiddleware(['guest']);

        Route::get('/farmacia/qr', [ExternalController::class, 'loginQr'])->name('login-qr')->withoutMiddleware(['guest']);
        Route::get('/logout-qr', [ExternalController::class, 'logoutQr'])->name('logout-qr')->withoutMiddleware(['guest']);

        Route::post('/farmacia/qr/autenticar', [ExternalController::class, 'autenticarQr'])->name('autenticar-qr')->withoutMiddleware(['externalVeris']);

        Route::get('/bot', [ExternalController::class, 'bot'])->name('bot')->withoutMiddleware(['guest']);

        Route::get('/laboratorio/resultados/{idPaciente}', [ExternalController::class, 'mostrarResultadoLaboratorio'])->name('resultado-laboratorio')->withoutMiddleware(['guest']);
    });

});

Route::group(['middleware' => ['loggedExternalUser']], function () {
    Route::prefix('external')->group(function () {
        Route::get('/farmacia/qr/gestion', [ExternalController::class, 'gestionQr'])->name('gestion-qr')->withoutMiddleware(['externalVeris']);
    });
});

Route::group(['middleware' => ['loggedUser']], function () {
    #Inicio
    Route::get('/', [DashboardController::class, 'home'])->name('home')->withoutMiddleware(['guest']);
    Route::get('/logout', [SeguridadesController::class, 'logout'])->name('logout')->withoutMiddleware(['guest']);
    Route::get('/mis-datos', [DashboardController::class, 'misDatos'])->name('home.misDatos')->withoutMiddleware(['guest']);
    Route::get('/politica-privacidad-datos', [DashboardController::class, 'politicaPrivacidadDatos'])->name('home.politicaPrivacidadDatos')->withoutMiddleware(['guest']);
    Route::get('/promociones', [DashboardController::class, 'listaPromociones'])->name('promociones.promociones')->withoutMiddleware(['guest']);
    Route::get('/comprar-promociones', [DashboardController::class, 'comprarPromociones'])->name('promociones.comprar-promociones')->withoutMiddleware(['guest']);
    Route::get('/promociones/sugeridas', [DashboardController::class, 'promocionesSugeridas'])->name('promociones.promociones-sugeridas')->withoutMiddleware(['guest']);
    Route::get('/mis-promociones', [DashboardController::class, 'misPromociones'])->name('promociones.mis-promociones')->withoutMiddleware(['guest']);
    Route::get('/promocion/{params}', [DashboardController::class, 'promocion'])->name('promociones.promocion')->withoutMiddleware(['guest']);
    Route::get('/promocion/detalle/{params}', [DashboardController::class, 'promocionDetalle'])->name('promociones.promocionDetalle')->withoutMiddleware(['guest']);
    Route::get('/mi-promocion/detalle/{params}', [DashboardController::class, 'miPromocionDetalle'])->name('promociones.miPromocionDetalle')->withoutMiddleware(['guest']);
    Route::get('/detalle/item/{params}', [DashboardController::class, 'detalleItem'])->name('promociones.detalleItem')->withoutMiddleware(['guest']);

    #Citas
    //Route::get('/agendamiento', [CitasController::class, 'agendamiento'])->name('agendamiento')->withoutMiddleware(['guest']);
    Route::get('/citas', [CitasController::class, 'citas'])->name('citas')->withoutMiddleware(['guest']);
    Route::get('/citas-elegir-paciente/{params}',[CitasController::class, 'listaPacientes'])->name('citas.listaPacientes')->withoutMiddleware(['guest']);
    Route::get('/citas-elegir-especialidad/{params}',[CitasController::class, 'listaEspecialidades'])->name('citas.listaEspecialidades')->withoutMiddleware(['guest']);
    Route::get('/citas-elegir-central-medica/{params}',[CitasController::class, 'listaCentralMedica'])->name('citas.listaCentralMedica')->withoutMiddleware(['guest']);
    Route::get('/citas-elegir-fecha-doctor/{params}',[CitasController::class, 'fechaDoctor'])->name('citas.fechaDoctor')->withoutMiddleware(['guest']);
    Route::get('/citas-revisa-tus-datos/{params}',[CitasController::class, 'detalleCita'])->name('citas.detalleCita')->withoutMiddleware(['guest']);
    Route::get('/citas-datos-facturacion/{params}',[CitasController::class, 'datosFacturacion'])->name('citas.datosFacturacion')->withoutMiddleware(['guest']);
    Route::get('/citas-pago-kushki/{params}', [CitasController::class, 'pagoKushki'])->name('citas.pagoKushki')->withoutMiddleware(['guest']);
    Route::post('/citas-procesar-pago-kushki', [CitasController::class, 'procesarKushki'])->name('citas.procesarKushki')->withoutMiddleware(['guest']);
    Route::get('/citas-seleccionar-tarjeta/{params}', [CitasController::class, 'seleccionarTarjeta'])->name('citas.seleccionarTarjeta')->withoutMiddleware(['guest']);
    Route::get('/citas-informacion-pago/{params}',[CitasController::class, 'citaInformacionPago'])->name('citas.citaInformacionPago')->withoutMiddleware(['guest']);
    Route::get('/citas-autenticacion-registro-tarjeta/{params}',[CitasController::class, 'authRegistroTarjeta'])->name('citas.authRegistroTarjeta')->withoutMiddleware(['guest']);
    Route::get('/citas-autenticacion-exitosa/{params}',[CitasController::class, 'authExitosa'])->name('citas.authExitosa')->withoutMiddleware(['guest']);
    Route::get('/citas-confirmar-pago/{params}',[CitasController::class, 'confirmarPago'])->name('citas.confirmarPago')->withoutMiddleware(['guest']);
    Route::get('/confirmacion-cita/{params}',[CitasController::class, 'confirmacionCita'])->name('citas.confirmacionCita')->withoutMiddleware(['guest']);
    Route::get('/cita-agendada/{params}',[CitasController::class, 'citaAgendada'])->name('citas.agendada')->withoutMiddleware(['guest']);
    #Reserva VUA
    Route::get('/cita-urgencias-ambulatorias/{params}', [CitasController::class, 'reservarVUA'])->name('citas.reservarVUA')->withoutMiddleware(['guest']);
    
    #Laboratorio
    Route::get('/laboratorio',[CitasController::class, 'laboratorio'])->name('citas.laboratorio')->withoutMiddleware(['guest']);
    Route::get('/laboratorio-domicilio/{params}', [CitasController::class, 'laboratorioDomicilio'])->name('citas.laboratorioDomicilio')->withoutMiddleware((['guest']));
    Route::get('/citas-laboratorio/{params}',[CitasController::class, 'citasLaboratorio'])->name('citas.citasLaboratorio')->withoutMiddleware((['guest']));
     
    #Imagenes y procedimientos              
    Route::get('/imagenes-procedimientos',[CitasController::class, 'imagenesProcedimientos'])->name('citas.imagenesProcedimientos')->withoutMiddleware(['guest']);
    #Terapia fisica
    Route::get('/terapia-fisica',[CitasController::class, 'terapiaFisica'])->name('citas.terapiaFisica')->withoutMiddleware(['guest']);
    #Receta medica
    Route::get('/receta-medica',[CitasController::class, 'recetaMedica'])->name('citas.recetaMedica')->withoutMiddleware(['guest']);
    #Ordenes externas
    Route::get('/ordenes-externas',[CitasController::class, 'ordenesExternas'])->name('citas.ordenesExternas')->withoutMiddleware(['guest']);
    Route::get('/registrar-orden-externa/{params}'
    ,[CitasController::class, 'registrarOrdenesExternas'])->name('citas.registrarOrdenesExternas')->withoutMiddleware(['guest']);

    Route::get('/registrar-orden-externa-ubicacion/{params}
    ',[CitasController::class, 'registrarOrdenesExternasUbicacion'])->name('citas.registrarOrdenesExternasUbicacion')->withoutMiddleware(['guest']);

    #Mis citas 
    Route::get('/mis-citas', [CitasController::class, 'misCitas'])->name('citas.misCitas')->withoutMiddleware(['guest']);

    #Tratamientos
    Route::get('/tratamiento/{params}', [TratamientosController::class, 'tratamientos'])
    ->name('tratamientos.lista')
    ->withoutMiddleware(['guest']);

    Route::get('/detalle-sesion/{params}', [TratamientosController::class, 'detalleSesion'])
    ->name('tratamientos.detalle_sesion')
    ->withoutMiddleware(['guest']);
    
    // Route::get('/tratamientos', [TratamientosController::class, 'tratamientos'])->name('tratamientos.lista')->withoutMiddleware(['guest']);
    Route::get('/mis-tratamientos', [TratamientosController::class, 'misTratamientos'])->name('tratamientos')->withoutMiddleware(['guest']);
    


    // Route::get('/tratamientos/detalle/{codigoTratamiento}/{nombreEspecialidad}/{nombreMedico}/{nombrePaciente}/{nombreConvenio}/{fechaTratamiento}', [TratamientosController::class, 'detalleTratamiento'])->name(''tratamientos.lista');
    Route::get('/tu-tratamiento/{params}
    ', [TratamientosController::class, 'detalleTratamiento'])->name('tratamientos.detalle')->withoutMiddleware(['guest']);
    Route::get('/farmacia-domicilio/{codigoTratamiento}', [TratamientosController::class, 'farmaciaDomicilio'])->name('tratamientos.farmaciaDomicilio')->withoutMiddleware((['guest']));
    
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
    Route::get('/lista-doctores/{params}', [HistoriaClinicaController::class, 'listaDoctoresHistoriaClinica'])->name('historiaClinica.listaDoctores')->withoutMiddleware(['guest']);
    Route::get('/solicitar-historia-clinica', [HistoriaClinicaController::class, 'solicitarHistoriaClinica'])->name('historiaClinica.solicitar')->withoutMiddleware(['guest']);

    #Experiencia
    Route::get('/cuentanos-tu-experiencia', [ExperienciaController::class, 'tuExperiencia'])->name('experiencia')->withoutMiddleware(['guest']);

    
});