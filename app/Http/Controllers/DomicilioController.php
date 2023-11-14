<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DomicilioController extends Controller
{
    // Return view domicilio form
    public function domilicio() {
        return view('domicilio.index');
    }
}
