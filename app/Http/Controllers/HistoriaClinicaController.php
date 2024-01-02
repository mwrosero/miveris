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
    public function listaDoctoresHistoriaClinica( $codigoEspecialidad , $tipoIdentificacion, $numeroIdentificacion, $esOnline) {
        return view('historia_clinica.lista_doctores', ['codigoEspecialidad' => $codigoEspecialidad, 'tipoIdentificacion' => $tipoIdentificacion, 'numeroIdentificacion' => $numeroIdentificacion, 'esOnline' => $esOnline]);
    }

    // Return view formulario solicitar historia clinica
    public function solicitarHistoriaClinica() {
        return view('historia_clinica.solicitar');
    }
}
