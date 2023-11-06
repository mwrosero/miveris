<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FamiliaAmigosController extends Controller
{
    // Return view familia amigos
    public function familiaAmigos() {
        return view('familia_amigos.index');
    }

    // Return view lista familiar y amigo agregados
    public function listaFamiliaAmigos() {
        return view('familia_amigos.lista_familia_amigos');
    }

    // Retun view datos familiar
    public function datosFamiliar() {
        return view('familia_amigos.datos_familiar');
    }
}
