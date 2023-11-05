<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitasController extends Controller
{
    // Return view index [citas]
    public function citas() {
        return view('citas.index');
    }

    // Return view elegir paciente
    public function listaPacientes() {
        return view('citas.paciente');
    }

    // Return view elegir espcialidad
    public function listaEspecialidades() {
        return view('citas.especialidades');
    }

    // Return view elegir central medica
    public function listaCentralMedica() {
        return view('citas.central_medica');
    }

    // Return view elegir fecha y doctor
    public function fechaDoctor() {
        return view('citas.fecha_doctor');
    }
    // Return view detalle de la cita
    public function detalleCita() {
        return view('citas.detalle_cita');
    }

    // Return view datos de facturacion
    public function datosFacturacion() {
        return view('citas.datos_facturacion');
    }

    // Return view informacion de pago
    public function citaInformacionPago() {
        return view('citas.informacion_pago');
    }
    // Return view mensaje cita agendada
    public function citaAgendada() {
        return view('citas.cita_agendada');
    }


}
