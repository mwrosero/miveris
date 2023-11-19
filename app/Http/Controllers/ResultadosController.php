<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultadosController extends Controller
{
    // Return view resultados [Laboratorio - Imagenes]
    public function resultados() {
        return view('resultados.index');
    }

    // Return view resultados [Lista Laboratorio]
    public function resultadosLaboratorio() {
        return view('resultados.laboratorio');
    }

    // Return view resultados [Lista Imagenes y Procedimientos]
    public function resultadosImagenesProcedimientos() {
        return view('resultados.imagenes_procedimientos');
    }
}
