<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExperienciaController extends Controller
{
    // Return view experiencia
    public function tuExperiencia() {
        return view('experiencia.index');
    }
}
