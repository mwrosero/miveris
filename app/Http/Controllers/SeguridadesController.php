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
        return view('seguridades.login');
    }

    public function autenticar(Request $request){
        $data = $request->all();
        $numeroIdentificacion = $data['numeroIdentificacion'];
        $password = $data['password'];

        $method = '/digitales/v1/seguridad/login';
        $res =  Http::withOptions([
                    'verify' => false, // Desactivar verificación de certificados
                ])->withHeaders([
                    'Application' => Veris::APPLICATION,
                    'Authorization' => 'Basic '.base64_encode(strtoupper($numeroIdentificacion) .":". $password),
                ])->post(Veris::BASE_URL.$method);
        
        $response = json_decode($res->body());

        if($response->code == 200){
            Session::put('userData', $response->data);
            return redirect('/cotizador/consulta-cotizaciones');
            /*if (!is_null($response->data->codigoActivacion)) {
                // El parámetro tiene un valor
            }else{
                //No tiene valores
            }*/
        }else{
            $message = $response->message;
        }
        if(isset($message)){
            session()->flash('alert', $message);
            session()->flash('numeroIdentificacion', strtoupper($numeroIdentificacion));
            return redirect('/login');
        }
    }

    public function registrarCuenta(){
        return view('seguridades.registrar_cuenta');
    }

    /*Formulario de Olvide clave*/
    public function olvideClave(){
        return view('seguridades.olvide_clave');
    }

    /*Envio de petición para reestablecer clave*/
    public function recuperarClave(Request $request){
        /*$data = $request->all();
        $user = $data['user'];

        $method = '/seguridad/v1/usuarios/solicitud_recuperacion_clave';

        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            //'token'    => Veris::getToken(),
            'data'     => ['usuario' => strtoupper($user)],
            'method'   => 'POST'
        ]);

        session()->flash('mensaje', $response->message);
        return view('seguridades.olvide_clave');*/
        return view('seguridades.reestablecer_clave');
    }

    /*Reestablecer clave*/
    public function reestablecerClave(){
        return view('seguridades.reestablecer_clave');
    }

    public function formularioActualizarClave($codigo, $usuario){
        return view('seguridades.actualizar_clave')
            ->with('codigo',$codigo)
            ->with('usuario',$usuario);
    }

    public function actualizarClave(Request $request){
        $data = $request->all();
        $method = '/seguridad/v1/usuarios/recuperacion_clave';
        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            //'token'    => Veris::getToken(),
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
        $response = Veris::call([
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
