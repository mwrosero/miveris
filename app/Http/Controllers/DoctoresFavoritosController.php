<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctoresFavoritosController extends Controller
{
    //Return view lista doctores favoritos agregados
    public function doctoresFavoritos() {
        return view('doctores_favoritos.index');
    }

    //Return view buscar doctor
    public function buscarDoctor() {
        return view('doctores_favoritos.buscar_doctores');
    }
}
