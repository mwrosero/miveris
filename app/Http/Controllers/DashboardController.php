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

    public function misDatos() {
        return view('inicio.mis_datos');
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
}