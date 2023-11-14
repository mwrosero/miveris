<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TratamientosController extends Controller
{
    // Return view Mis tratamientos
    public function misTratamientos() {
        return view('tratamientos.index');
    }

    // Return view lista de tratamientos
    public function tratamientos() {
        return view('tratamientos.lista_tratamientos');
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
