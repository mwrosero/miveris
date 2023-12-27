<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Psy\Readline\Hoa\Console;

class TratamientosController extends Controller
{
    // Return view Mis tratamientos
    public function misTratamientos() {
        return view('tratamientos.index');
    }

    // Return view lista de tratamientos
    public function tratamientos($params) {
        return view('tratamientos.lista_tratamientos')
                ->with('params', $params);
    }
    
    

    // Return view detalle de tratamiento
    public function detalleTratamiento($params) {
        
        return view('tratamientos.detalle')
                ->with('params', $params);
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
