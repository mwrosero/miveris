<?php

namespace App\Models;

use session;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veris extends Model
{
    use HasFactory;
    //DEV
    // public const BASE_URL = 'https://api-phantomx.veris.com.ec';
    // public const BASE_WAR = 'digitalestest';
    // public const FACTURACION_WAR = 'seguridadtest';
    // public const CANAL_ORIGEN = 'MVE_CMV';
    // public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';//UEhBTlRPTVhfRU1QUkVTQVJJQUw=
    // public const IDORGANIZACION = 'adf4e264-cd20-4653-9a44-025b13050992';//365509c8-9596-4506-a5b3-487782d5876e
    // public const KUSHKI_MERCHANT_ID = '10000003012872942409151942277385';
    // public const ENVIRONMENT_NUVEI = "stg";
    // public const TEST_ENVIRONMENT_KUSHKI = true;
    // public const AMPLITUDE = "1cbd8baed97a6c8abf6b8e398b77cf6f";
    // public const BASICAUTHDIGITALES = 'd3NhcHBjZW50cmljbzpDQVM1Nzg5Yjg2TWRyNUMzbnRyMWMw';
    // public const BASICAUTHFACTURACION = 'QkFDS0VORFBIQU5UT006Q2xAdmUxMjM0';
    // public const NEMONICO_FLUJO_PAGO = 'PRE_TRANSACCIONES';
    // public const URL_EPI = 'http://ecstest.veris.com.ec/Verisrest/v1/formularioepi1';
    // public const BASICAUTHEPI = 'd3Nmb3JtdWxhcmlvZXBpMTpDQVM1Nzg5Yjg2TWRyNUYwcm11bGFyMTAzcGkxKg==';

    //PROD
    public const BASE_URL = 'https://api.phantomx.com.ec';
    public const BASE_WAR = 'digitales';
    public const FACTURACION_WAR = 'seguridad';
    public const CANAL_ORIGEN = 'MVE_CMV';
    public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';
    public const IDORGANIZACION = '365509c8-9596-4506-a5b3-487782d5876e';
    public const KUSHKI_MERCHANT_ID = '1012311620855990918315314280226';
    public const ENVIRONMENT_NUVEI = "prod";
    public const TEST_ENVIRONMENT_KUSHKI = false;
    public const AMPLITUDE = "93127ac840f734cdcc8bf469f8bc95d5";
    public const BASICAUTHDIGITALES = 'd3NhcHBjZW50cmljbzpDQVM1Nzg5Yjg2TWRyNUMzbnRyMWMw';
    public const BASICAUTHFACTURACION = 'YmFja2VuZHBoYW50b206QmFja1BAbnRoMG1QQHNzMjAyMQ==';
    public const NEMONICO_FLUJO_PAGO = 'PRE_TRANSACCIONES';
    public const URL_EPI = 'https://phantom-wsexternos.phantomx.com.ec/Verisrest/v1/formularioepi1';
    public const BASICAUTHEPI = 'd3Nmb3JtdWxhcmlvZXBpMTpDQVM1Nzg5Yjg2TWRyNUYwcm11bGFyMTAzcGkxKg==';

    static function call(Array $config)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $config['endpoint']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // METHOD
        if( $config['method'] == 'POST' ){
            curl_setopt($ch, CURLOPT_POST, 1);
        }else if( $config['method'] == 'GET' || $config['method'] == 'PUT' ){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $config['method']);
        }

        $header = [];
        $header[] = 'Application: ' . self::APPLICATION;
        $header[] = 'IdOrganizacion: ' . self::IDORGANIZACION;

        // AUTH
        if( isset($config['token']) && !isset($config['data'])){
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $config['token'] ));
            $header[] = 'Authorization: Bearer ' . $config['token'];
        }

        // POST DATA
        if( isset($config['data']) && ($config['method'] == 'POST' || $config['method'] == 'PUT' ) ){
            $data_serialized = json_encode($config['data']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_serialized);
            
            $header[] = 'Content-Type: application/json';
            $header[] = 'Content-Length: ' . strlen($data_serialized);
            $header[] = 'content-language: es';
            
            if( isset($config['token']) ){
                $header[] = 'Authorization: Bearer ' . $config['token'];
            }
        }

        if( isset($config['basic']) ){
            $header[] = 'Authorization: Basic ' . $config['basic'];
            $header[] = 'Content-Type: application/json';
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // LOGIN
        if( isset($config['username']) && isset($config['password'])){
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $config['username'].":".$config['password']);
        }

        // dd($header);
        
        // API CALL
        try{
            $result = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);
        }
        catch(\Exception $e){
            $result = [ 'error' => 'Falla en la llamada', ];
        }

        // RETURN DATA
        if( gettype($result) === 'string' )
            return json_decode($result);

        return $result;
    }

    /*
    * getToken
    * ----------------------------------------------
    * Peticion al webservice de ISM para obtener el token
    * de acceso para las peticiones CURL. Esto se debe
    * ejecutar una sola vez por sessión.
    * ----------------------------------------------
    */
    static function getToken()
    {
        $token = session('accessToken', null);

        /*if( $token !== null ){
            return $token;
        }*/


        $username = '';
        $password = '';
        $method = '/generaToken';
        //dump(self::BASE_URL.$method);
        $result = self::call([
            'endpoint' => self::BASE_URL.$method,
            'method'   => 'POST',
            'username' => $username,
            'password' => $password
        ]);
        /*dump(self::BASE_URL.$method);
        dd($result);*/
        /*$curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => self::BASE_URL.$method,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic d3N3ZWJhdXJvcmE6bjNVRTYwQHMzUnYxYzEwQFczYkF1UjByYQ=='
          ),
        ));

        $result = curl_exec($curl);*/

        session(['accessToken' => $result->accesToken]);
        return $result->accesToken;
    }

    static function getTokenDigitales()
    {
        $token = session('accessTokenDigitales', null);

        if( $token !== null ){
            return $token;
        }

        $username = '';
        $password = '';
        $method = '/v1/seguridad/login?canalOrigen=MVE_CMV';
        //dump(self::BASE_URL.$method);
        $result = self::call([
            'endpoint' => self::BASE_URL.$method,
            'method'   => 'POST',
            'username' => $username,
            'password' => $password
        ]);
        /*dump(self::BASE_URL.$method);
        dd($result);*/
        /*$curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => self::BASE_URL.$method,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic d3N3ZWJhdXJvcmE6bjNVRTYwQHMzUnYxYzEwQFczYkF1UjByYQ=='
          ),
        ));

        $result = curl_exec($curl);*/

        session(['accessTokenDigitales' => $result->accesToken]);
        return $result->accesToken;
    }

}