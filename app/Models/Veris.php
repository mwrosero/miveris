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
    //PROD
    public const BASE_URL = 'https://api.phantomx.com.ec';
    public const APPLICATION = 'UEhBTlRPTVhfRU1QUkVTQVJJQUw=';
    public const IDORGANIZACION = '365509c8-9596-4506-a5b3-487782d5876e';
    public const CODIGOSUCURSAL = 12;
    public const PERPAGE = 10;

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

        // dump($header);
        
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

}