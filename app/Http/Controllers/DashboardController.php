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

    public function promocionDetalle($params) {
        return view('inicio.detalle_promocion')->with('params',$params);
    }
}