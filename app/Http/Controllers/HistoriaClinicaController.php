<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoriaClinicaController extends Controller
{
    //Return view historia clinica
    public function historiaClinica() {
        return view('historia_clinica.index');
    }

    //Return view lista de doctores historia clinica
    public function listaDoctoresHistoriaClinica( $params ) {
        return view('historia_clinica.lista_doctores' )->with( 'params', $params );
    }

    // Return view formulario solicitar historia clinica
    public function solicitarHistoriaClinica() {
        return view('historia_clinica.solicitar');
    }
}
