<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use App\Models\Veris;

class SeguridadesController extends Controller
{
    /*Login*/
    public function login(){
        $info = Session::get('userData');
        return view('login.login');
    }

    public function autenticar(Request $request){
        $data = $request->all();
        $user = $data['user'];
        $password = $data['password'];

        $method = '/seguridad/v1/usuarios/verificacion_cuenta';
        $param = '?usuario='.strtoupper($user);

        $response = Ism::call([
            'endpoint' => Veris::BASE_URL.$method.$param,
            //'token'    => Ism::getToken(),
            //'data'     => ['' => $var],
            'method'   => 'GET'
        ]);

        if($response->code == 200){
            $method = '/seguridad/v1/autenticacion/login';

            /*$response = Ism::call([
                'endpoint'  => Veris::BASE_URL.$method,
                'basic'     => base64_encode(strtoupper($user) .":". $password),
                'method'    => 'POST'
            ]);*/

            $res =  Http::withOptions([
                        'verify' => false, // Desactivar verificación de certificados
                    ])->withHeaders([
                        'Application' => Ism::APPLICATION,
                        'Authorization' => 'Basic '.base64_encode(strtoupper($user) .":". $password),
                    ])->post(Veris::BASE_URL.$method);
            $response = json_decode($res->body());

            //dd($response);
            /*$method = '/seguridad/v1/usuarios/'.$response->data->secuenciaUsuario;
            $response = Ism::call([
                'endpoint' => Veris::BASE_URL.$method.$param,
                'token'    => $response->data->idToken,
                'method'   => 'GET'
            ]);
            dd($response);*/
            if($response->code == 200){
                switch($response->data->estadoUsuario) {
                    case 'CONFIRMED':
                        Session::put('userData', $response->data);
                        Session::put('accessToken', $response->data->idToken);
                        
                        $method = '/seguridad/v1/usuarios/'.$response->data->secuenciaUsuario.'/modulos_opciones_acceso';
                        $param = '?codigoSucursal='.Ism::CODIGOSUCURSAL;

                        $response = Ism::call([
                            'endpoint' => Veris::BASE_URL.$method.$param,
                            'token'    => $response->data->idToken,
                            'method'   => 'GET'
                        ]);
                        // echo Veris::BASE_URL.$method.$param;
                        // dump($response);
                        // dd(0);

                        Session::put('menu', $response->data);
                        return redirect('/cotizador/consulta-cotizaciones');
                    break;
                    case 'FORCE_CHANGE_PASSWORD':
                        $message = "Usuario nuevo que ingresa una clave temporal";
                    break;
                    case 'CHANGE_PASSWORD':
                        $message = "Usuario debe cambiar su clave porque ha pasado 'x' tiempo desde el último cambio";
                    break;
                    case 'RESET_REQUIRED':
                        $message = "Usuario importado debe seguir el flujo de recuperar contraseña";
                    break;
                }
            }else{
                $message = $response->message;
            }
        }else{
            $message = $response->message;
        }
        if(isset($message)){
            session()->flash('mensaje', $message);
            session()->flash('user', strtoupper($user));
            return redirect('/login');
        }
    }

    public function registrarCuenta(){
        return view('login.registrar_cuenta');
    }

    /*Formulario de Olvide clave*/
    public function olvideClave(){
        return view('login.olvide_clave');
    }

    /*Envio de petición para reestablecer clave*/
    public function recuperarClave(Request $request){
        /*$data = $request->all();
        $user = $data['user'];

        $method = '/seguridad/v1/usuarios/solicitud_recuperacion_clave';

        $response = Ism::call([
            'endpoint' => Veris::BASE_URL.$method,
            //'token'    => Ism::getToken(),
            'data'     => ['usuario' => strtoupper($user)],
            'method'   => 'POST'
        ]);

        session()->flash('mensaje', $response->message);
        return view('login.olvide_clave');*/
        return view('login.reestablecer_clave');
    }

    /*Reestablecer clave*/
    public function reestablecerClave(){
        return view('login.reestablecer_clave');
    }

    public function formularioActualizarClave($codigo, $usuario){
        return view('login.actualizar_clave')
            ->with('codigo',$codigo)
            ->with('usuario',$usuario);
    }

    public function actualizarClave(Request $request){
        $data = $request->all();
        $method = '/seguridad/v1/usuarios/recuperacion_clave';
        $response = Ism::call([
            'endpoint' => Veris::BASE_URL.$method,
            //'token'    => Ism::getToken(),
            'data'     => ['usuario' => $data['usuario'], 'codigoRecuperacion' => $data['codigo'], 'claveNueva' => $data['nuevaClave']],
            'method'   => 'POST'
        ]);

        if($response->code != 200){
            session()->flash('mensaje', $response->message);
            return Redirect::route('actualizar_clave.form', ['codigo' => $data['codigo'], 'usuario' => $data['usuario']]);
        }

        session()->flash('mensaje', "Contraseña actualizada exitosamente.");
        return redirect()->route('login');
    }

    /*Refresh Token*/
    public function refreshToken(){
        $info = Session::get('userData');
        $method = '/seguridad/v1/autenticacion/refresh_token';
        $response = Ism::call([
            'endpoint'  => Veris::BASE_URL.$method,
            'data'      => ["refreshToken" => $info->refreshToken],
            'method'    => 'POST'
        ]);

        Session::put('accessToken', $response->data->idToken);

        $msg = [
            "code" => $response->code,
            "message" => $response->code
        ];

        if($response->code == 200){
            $msg["idToken"] = $response->data->idToken;
        }

        return response()->json($msg);
    }

    /*Logout*/
    public function logout(){
        //dd(0);
        // Session::forget('user');
        Session::flush();
        return redirect()->route('login');
    }
}
