<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;


class TratamientosController extends Controller
{
    // Return view Mis tratamientos
    public function misTratamientos() {
        return view('tratamientos.index');
    }

    // Return view lista de tratamientos
    public function tratamientos(Request $request) {

        $data = $request->all();    
        
        return view('tratamientos.lista_tratamientos', ['data' => $data]);
    }

    // Return view detalle de tratamiento
    public function detalleTratamiento() {
        return view('tratamientos.detalle');
    }

    // Return view farmacia a domicilio
    public function farmaciaDomicilio() {
        return view('tratamientos.farmacia_domicilio');
    }

    // Return view laboratorio a domicilio
    public function laboratorioDomicilio() {
        return view('tratamientos.laboratorio_domicilio');
    }

    // Return view citas / laboratorio
    public function citasLaboratorio() {
        return view('tratamientos.citas_laboratorio');
    }
}
