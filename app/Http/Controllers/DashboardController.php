<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use App\Models\Veris;


class DashboardController extends Controller
{
    public function home(){
        return view('inicio.inicio');
    }

    public function miCuenta() {
        return view('inicio.mi_cuenta');
    }

    public function misTarjetas(){
        return view('inicio.mis-tarjetas');
    }

    public function misDatos() {
        // return view('inicio.mis_datos');
        // dd(Session::get('userData')); 
        return view('inicio.mis_datos_2025');
    }

    public function misConvenios() {
        // return view('inicio.mis_datos');
        return view('inicio.mis_convenios');
    }

    public function seleccionarConvenio($params) {
        // return view('inicio.mis_datos');
        return view('inicio.seleccionar_convenios')->with('params', $params);
    }

    public function infoConvenio($params) {
        // return view('inicio.mis_datos');
        return view('inicio.info_convenios')->with('params', $params);
    }

    public function convenioAgregado($params) {
        // return view('inicio.mis_datos');
        return view('inicio.convenio_agregado')->with('params', $params);
    }

    public function politicaPrivacidadDatos() {
        return view('inicio.politica_privacidad_datos');
    }

    public function listaPromociones() {
        return view('inicio.promociones');
    }

    public function comprarPromociones() {
        return view('inicio.comprar-promociones');
    }

    public function promocionesSugeridas() {
        return view('inicio.promociones-sugeridas');
    }

    public function misPromociones() {
        return view('inicio.mis-promociones');
    }

    public function promocion() {
        return view('inicio.mis-promociones');
    }

    public function promocionDetalle($params) {
        return view('inicio.detalle_promocion')->with('params',$params);
    }

    public function miPromocionDetalle($params) {
        return view('inicio.detalle_mi_promocion')->with('params',$params);
    }

    public function detalleItem($params) {
        return view('inicio.detalle_item')->with('params',$params);
    }
    public function detalleItemPreparacionPrevia($params) {
        return view('inicio.preparacion_previa')->with('params',$params);
    }
}