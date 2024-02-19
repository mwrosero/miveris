<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use App\Models\Veris;

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
        //dd(utf8_encode(base64_decode($params)));
        return view('citas.fecha_doctor')->with('params',$params);
    }
    // Return view detalle de la cita
    public function detalleCita($params) {
        return view('citas.detalle_cita')->with('params',$params);
    }

    // Return view datos de facturacion
    public function datosFacturacion($params) {
        return view('citas.datos_facturacion')->with('params',$params);
    }

    // Return view pago con kushki
    public function pagoKushki($params) {
        return view('citas.pago_kushki')->with('params',$params);
    }

    // Procesar pago con kushki
    public function procesarKushki(Request $request) {
        //Realizar cobro y validar para donde redireccionar
        $data = $request->all();
        $dataCita = json_decode(utf8_encode(base64_decode(urldecode($data['dataCita']))));
        $tokenCita = $data['tokenCita'];

        $codigoPreTransaccion = $dataCita->preTransaccion->codigoPreTransaccion;
        $method = '/digitalestest/v1/facturacion/registrar_pago_kushki?idPreTransaccion='.$codigoPreTransaccion;

        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'data' => [
                "tipoIdentificacion" => $dataCita->facturacion->datosFactura->codigoTipoIdentificacion,
                "numeroIdentificacion" => $dataCita->facturacion->datosFactura->codigoTipoIdentificacion,
                "codigoTransaccion" => $dataCita->transaccionVirtual->codigoTransaccion,
                "cardToken" => $data['kushkiToken'],
                "suscripcionToken" => null,
                "nombreTarjetahabiente" => $dataCita->facturacion->datosFactura->primerNombre." ".$dataCita->facturacion->datosFactura->primerApellido,
                "emailTarjetahabiente" => $dataCita->facturacion->datosFactura->email,
                "codigoSuscripcionTarjeta" => null,
                "codigoSeguridad" => null,
                "canalOrigenDigital" => Veris::CANAL_ORIGEN
            ],
            'method'   => 'POST'
        ]);

        if($response->code == 200){
            return redirect('/cita-agendada/'.$tokenCita);
        }else{
            session()->flash('alert', $response->message);
            return redirect('/citas-pago-kushki/'.$tokenCita);
        }
    }

    // return view seleccionar tarjeta
    public function seleccionarTarjeta($params) {
        // dd($params);
        // $params = str_replace('|', '/', $params);
        return view('citas.seleccionar_tarjeta')->with('params',$params);;
    }
    // Return view informacion de pago
    public function citaInformacionPago($params) {
        // $params = str_replace('|', '/', $params);
        return view('citas.informacion_pago')->with('params',$params);;
    }
    // Return view Autenticacion Registro de tarjeta
    public function authRegistroTarjeta($params) {
        // $params = str_replace('|', '/', $params);
        return view('citas.autenticacion_registro_tarjeta')->with('params',$params);
    }
    // Return view Autenticacion exitosa
    public function authExitosa($params) {
        // $params = str_replace('|', '/', $params);
        return view('citas.autenticacion_exitosa')->with('params',$params);
    }
    // Return view Confirmar pago
    public function confirmarPago($params) {
        // $params = str_replace('|', '/', $params);
        return view('citas.confirmar_pago')->with('params',$params);
    }

    // confirmacion cita
    public function confirmacionCita($params) {
        // $params = str_replace('|', '/', $params);
        return view('citas.laboratorio_confirmacion_cita')->with('params',$params);
    }
    // Return view mensaje cita agendada
    public function citaAgendada($params) {
        // $params = str_replace('|', '/', $params);
        return view('citas.cita_agendada')->with('params',$params);
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
    public function citasLaboratorio($params) {
        return view('citas.citas_laboratorio')->with('params',$params);
    }

    // Return view imagenes / procedimientos
    public function imagenesProcedimientos() {
        return view('citas.imagenes_procedimientos')->with('tipoServicio','IMAGENES,PROCEDIMIENTOS');
    }

    // Return view terapia fisica
    public function terapiaFisica() {
        return view('citas.terapia_fisica')->with('tipoServicio','TERAPIA');
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
