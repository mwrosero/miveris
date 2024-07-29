<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use App\Models\Veris;

class ExternalController extends Controller
{
    public function agendamientoCitas(){
        return view('external.embudo_agendamiento.index_agendamiento')
            ->with('accesToken',$this->getTokenExternalDigitales());
    }
    public function listadoPaquetes(){
        return view('external.paquetes_promocionales.listado_paquetes')
            ->with('accesToken',$this->getTokenExternalDigitales());
    }

    public function getTokenExternalDigitales(){
        $token = session('accessTokenDigitales', null);

        if( $token !== null ){
            return $token;
        }

        $method = '/'.Veris::BASE_WAR.'/v1/seguridad/login?canalOrigen='.Veris::CANAL_ORIGEN;
        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'basic' => Veris::BASICAUTHDIGITALES,
            'method'   => 'POST'
        ]);
        // dd($response->data->tokenPush);
        session(['accessTokenDigitales' => $response->data->tokenPush]);
        return $response->data->tokenPush;
    }

}