<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitasController extends Controller
{
    // Return view index [citas]
    public function citas() {
        return view('citas.index');
    }

    public function agendamiento(){
        return view('citas.agendamiento');
    }

    // Return view elegir paciente
    public function listaPacientes($params) {
        return view('citas.paciente')->with('params',$params);
    }

    // Return view elegir espcialidad
    public function listaEspecialidades($params) {
        return view('citas.especialidades')->with('params',$params);
    }

    // Return view elegir central medica
    public function listaCentralMedica($params) {
        return view('citas.central_medica')->with('params',$params);
    }

    // Return view elegir fecha y doctor
    public function fechaDoctor($params) {
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

    // Return view Laboratorio
    public function laboratorio() {
        return view('citas.laboratorio');
    }

    // Return view laboratorio a domicilio
    public function laboratorioDomicilio($codigoTratamiento) {
        return view('citas.laboratorio_domicilio', ['codigoTratamiento' => $codigoTratamiento]);
    }

    // Return view citas / laboratorio
    public function citasLaboratorio() {
        return view('citas.citas_laboratorio');
    }

    // Return view imagenes / procedimientos
    public function imagenesProcedimientos() {
        return view('citas.imagenes_procedimientos');
    }

    // Return view terapia fisica
    public function terapiaFisica() {
        return view('citas.terapia_fisica');
    }

    // Return view Receta médica
    public function recetaMedica() {
        return view('citas.receta_medica');
    }

    // Return view Ordenes externas
    public function ordenesExternas() {
        return view('citas.ordenes_externas');
    }

    // Return view formulario registrar orden externa
    public function registrarOrdenesExternas($params) {
        return view('citas.registrar_orden_externa'
        ,['params' => $params]);
    }

    // Return view formulario registrar orden externa ubicacion
    public function registrarOrdenesExternasUbicacion($params) {
        return view('citas.laboratorio_domicilioExterna')->with('params',$params);
    }


    // Return view Mis citas
    public function misCitas() {
        return view('citas.mis_citas');
    }
}
