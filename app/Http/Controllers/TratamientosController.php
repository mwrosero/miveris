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
    public function tratamientos($codigoTratamiento, $porcentaje) {
        return view('tratamientos.lista_tratamientos', ['codigoTratamiento' => $codigoTratamiento, 'porcentaje' => $porcentaje]);
    }

    // Return view detalle de tratamiento
    public function detalleTratamiento() {
        return view('tratamientos.detalle');
    }

    // Return view farmacia a domicilio
    public function farmaciaDomicilio($codigoTratamiento) {
        return view('tratamientos.farmacia_domicilio', ['codigoTratamiento' => $codigoTratamiento]);
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
