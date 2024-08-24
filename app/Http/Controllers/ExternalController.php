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

    public function detallePaquete($params){
        return view('external.paquetes_promocionales.detalle_paquete')
            ->with('accesToken',$this->getTokenExternalDigitales())
            ->with('params',$params);
    }

    public function asignarPaquete($params){
        return view('external.paquetes_promocionales.asignar_paquete')
            ->with('accesToken',$this->getTokenExternalDigitales())
            ->with('params',$params);
    }

    public function payment(Request $request){
        $urlParams = $request->all();
        $method = '/'.Veris::BASE_WAR.'/v1/seguridad/cuenta?tipoIdentificacion='.$urlParams['tipoIdentificacion'].'&numeroIdentificacion='.$urlParams['numeroIdentificacion'];

        $list_paciente = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'method'   => 'GET'
        ]);
        // dd($response->data);
        $idPaciente = $list_paciente->data->numeroPaciente;
        $data = array(
            "idPaciente" => $idPaciente,
            "codigoConvenio" =>  null,
            "secuenciaAfiliado" =>  null,
            "idPaciente" => null,
            "codigoConvenio" => null,
            "codigoSolicitud" => null
        );

        switch ($urlParams['tipoArticulo']) {
            case 'CITA':
            case 'CITA_ODO':
                $data["idPaciente"] = $list_paciente->data->numeroPaciente;
                $data["tipoSolicitud"] = null;
                $data["tipoServicio"] = $urlParams['tipoArticulo'];
                $data["listaCitas"] = [array(
                        "codigoReserva" => $urlParams['codArticulo']
                    )];
            break;
            case 'DOM':
                $data["idPaciente"] = $list_paciente->data->numeroPaciente;
                $data["tipoSolicitud"] = "LAB";
                $data["tipoServicio"] = "DOMICILIO";
                $data["codigoSolicitud"] = $urlParams['codArticulo'];
                $data["listaCitas"] = [];
                $data["listaOrdenes"] = [];
            break;
            case 'ORDEN':
                $data["idPaciente"] = $list_paciente->data->numeroPaciente;
                $data["tipoSolicitud"] = null;
                $data["tipoServicio"] = "ORDEN";
                $data["codigoSolicitud"] = null;
                $data["listaCitas"] = [];
                $codigos = explode("|", $urlParams['codArticulo']);
                $ordenes = [];
                foreach ($codigos as $value) {
                    array_push($ordenes, array(
                        "numeroOrden" => $value,
                        "lineaDetalle" =>null,
                        "codigoEmpresa" =>null
                    ));
                }
                $data["listaOrdenes"] = $ordenes;
            break;
            case 'PAQUETE':
                $data["idPaciente"] = $list_paciente->data->numeroPaciente;
                if(isset($urlParams['canalOrigen']) && $urlParams['canalOrigen'] == "WEBSITE"){
                    $tramaPaquete = array(
                        "codigoPaquete" => $urlParams['codArticulo']
                    );
                }else{
                    $tramaPaquete = array(
                        "codigoOrdenPaquete" => $urlParams['codArticulo']
                    );
                }
                $data["tipoSolicitud"] = null;
                $data["tipoServicio"] = $urlParams['tipoArticulo'];
                $data["paquete"] = $tramaPaquete;
            break;  
            default:
                // code...
                break;
        }
        
        $method = '/'.Veris::BASE_WAR.'/v1/facturacion/crear_pretransaccion?canalOrigen='.Veris::CANAL_ORIGEN;

        $response_pretrx = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'method'   => 'POST',
            'data'     => $data
        ]);
        // echo Veris::BASE_URL.$method;
        // dump($data);
        // dd($response_pretrx);
        if($response_pretrx->code == 200){
            return view('external.pasarela.datos_facturacion')
                    ->with('paciente',$list_paciente)
                    ->with('urlRetornoPago', http_build_query($urlParams))
                    ->with('pretransaccion',$response_pretrx);
        }else{
            // dd(http_build_query($urlParams)); //MEJORAR
            return view('external.pasarela.error')
                    ->with('showButtonRePay', false)
                    ->with('error',$response_pretrx->message);//'El servicio ya se encuentra pagado o no tiene detalles disponibles'
        }
    }

    public function pagoExternoKushki($params){
        return view('external.pasarela.pago_kushki_externo')
            ->with('params',$params);
    }

    public function procesarExternoKushki(Request $request, $params) {
        //Realizar cobro y validar para donde redireccionar
        $data = $request->all();
        $dataCita = json_decode(utf8_encode(base64_decode(urldecode($data['dataCita']))));
        // $tokenCita = $data['tokenCita'];

        $codigoPreTransaccion = $dataCita->preTransaccion->codigoPreTransaccion;
        $method = '/'.Veris::BASE_WAR.'/v1/facturacion/registrar_pago_kushki?idPreTransaccion='.$codigoPreTransaccion;

        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'data' => [
                "tipoIdentificacion" => $dataCita->facturacion->datosFactura->codigoTipoIdentificacion,
                "numeroIdentificacion" => $dataCita->facturacion->datosFactura->codigoTipoIdentificacion,
                "codigoTransaccion" => $dataCita->transaccionVirtual->codigoTransaccion,
                "cardToken" => $data['kushkiToken'],
                "suscripcionToken" => null,
                "nombreTarjetahabiente" => $dataCita->facturacion->datosFactura->primerNombre." ".$dataCita->facturacion->datosFactura->primerApellido,
                "emailTarjetahabiente" => $dataCita->facturacion->datosFactura->email,
                "codigoSuscripcionTarjeta" => null,
                "codigoSeguridad" => null,
                "canalOrigenDigital" => Veris::CANAL_ORIGEN
            ],
            'method'   => 'POST'
        ]);

        //dd($response);

        if($response->code == 200){
            return redirect('/external/payment/comprobante?'.base64_encode($dataCita->transaccionVirtual->codigoTransaccion));
        }else{
            // session()->flash('alert', $response->message);
            return redirect('/external/payment/error/'.$params)
                    ->with('showButtonRePay', true)
                    ->with('urlRetornoPago', $dataCita->returnUrl);
        }
    }

    public function procesarExternoNuvei(Request $request, $params) {
        //Realizar cobro y validar para donde redireccionar
        $urlParams = $request->all();
        $accessToken = $this->getTokenExternalFacturacion();
        $method = '/facturacion/v1/pagos_electronicos/transaccion_epago/'.$urlParams['codigoEPagoNuvei'];
        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'token'    => $accessToken,
            'method'   => 'GET'
        ]);

        // dd($response);
        if($response->data->estaPagado){
            return redirect('/external/payment/comprobante?'.base64_encode($urlParams['codigoEPagoNuvei']));
        }else{
            $data = array(
                "tipoIdentificacion" => $urlParams['tipoIdentificacionNuvei'],
                "numeroIdentificacion" => $urlParams['numeroIdentificacionNuvei'],
                "codigoTransaccion" => $urlParams['codigoEPagoNuvei'],
                "canalOrigenDigital" => $urlParams['canalOrigenNuvei'],
                "datosNuvei" => $datosNuveiArray
            );

            $method = '/'.Veris::BASE_WAR.'/v1/facturacion/registrar_pago_nuvei?idPreTransaccion='.$urlParams['idPreTransaccionNuvei'];
            $list = Veris::call([
                'endpoint' => Veris::BASE_URL.$method,
                'token'    => $accessToken,
                'method'   => 'POST',
                'data'     => $data
            ]);

            if($list->code == 200){
                return redirect('/external/payment/comprobante?'.base64_encode($urlParams['codigoEPagoNuvei']));
            }else{
                session()->flash('alert', $list->message);
                return redirect('/external/payment/error/'.$params);
            }
        }
    }

    public function loginQr(){
        return view('external.qr_farmacia.login_qr_farmacia');
    }

    public function comprobantePago(Request $request){
        $queryString = $request->getQueryString();
        $codigoEPagoNuvei = urldecode($queryString);

        $accessToken = $this->getTokenExternalFacturacion();
        $method = '/facturacion/v1/pagos_electronicos/transaccion_epago/'.base64_decode($codigoEPagoNuvei);
        $list = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'token'    => $accessToken,
            'method'   => 'GET'
        ]);

        //Validar code != 200
        
        if(!$list->data->estaFacturado){
            $generarBoton = true;
            if($list->data->estaPagado){
                $generarBoton = false;
            }

            $data = array("codigoEmpresa"=>1,"codigoEPago"=>base64_decode($codigoEPagoNuvei), "generarFactura"=>true, "generarCobroBotonPago"=>$generarBoton, "datoskushki"=>null);
            $method = '/facturacion/v1/pagos_electronicos/facturar_pago_transaccion_epago/';
            $response = Veris::call([
                'endpoint' => Veris::BASE_URL.$method,
                'token'    => $accessToken,
                'method'   => 'POST',
                'data'     => $data
            ]);

            if($response->code != 200){
                return view('external.pasarela.error')
                    ->with('showButtonRePay', false)
                    ->with('error',$response->message);
            }

            $method = '/facturacion/v1/pagos_electronicos/transaccion_epago/'.base64_decode($codigoEPagoNuvei);
            $list = Veris::call([
                'endpoint' => Veris::BASE_URL.$method,
                'token'    => $accessToken,
                'method'   => 'GET'
            ]);
        }

        return view('external.pasarela.comprobante_pago')
            ->with('data',$list);
    }

    public function getTokenExternalDigitales(){
        $token = session('accessTokenDigitales', null);

        if( $token !== null ){
            //return $token;
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

    public function getTokenExternalFacturacion(){
        $token = session('accessTokenFacturacion', null);

        if( $token !== null ){
            //return $token;
        }

        $method = '/'.Veris::FACTURACION_WAR.'/v1/autenticacion/login';
        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'basic' => Veris::BASICAUTHFACTURACION,
            'method'   => 'POST'
        ]);
        // dd($response);
        session(['accessTokenFacturacion' => $response->data->idToken]);
        return $response->data->idToken;
    }

}