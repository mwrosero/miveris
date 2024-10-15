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
        // return view('test');
        // session()->flash('error', "Ningun error");
        // session()->flash('url', "https://akold.com");
        // return redirect()->route('payment-error');


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

    public function paymentServices(Request $request){
        $urlParams = $request->all();
        dd($urlParams['codigoPreTransaccion']);
    }

    public function payment(Request $request){
        $urlParams = $request->all();
        if ($request->has('codigoPreTransaccion') || $request->has('idSolicitud')) {
            $esServicioCaja = false;
            $accessToken = $this->getTokenExternalFacturacion();
            // dd($accessToken);
            if($request->has('codigoPreTransaccion')){
                $esServicioCaja = true;
                $method = '/facturacion/v1/pagos_electronicos/obtener_info_previa_factura/pre_transaccion';
                $codigoEmpresa = 1;
                if($request->has('codigoEmpresa')){
                    $codigoEmpresa = $urlParams['codigoEmpresa'];
                }
                $params = '?codigoEmpresa='.$codigoEmpresa.'&idPreTransaccion='.$_REQUEST['codigoPreTransaccion'];
            }else{
                $method = '/facturacion/v1/pagos_electronicos/obtener_info_previa_factura/farmacia_domicilio';
                $codigoEmpresa = 1;
                if($request->has('codigoEmpresa')){
                    $codigoEmpresa = $urlParams['codigoEmpresa'];
                }
                $params = '?codigoEmpresa='.$codigoEmpresa.'&codigoSolicitudServDomicilio='.$_REQUEST['idSolicitud'];
            }
            $response = Veris::call([
                'endpoint' => Veris::BASE_URL.$method.$params,
                'token'    => $accessToken,
                'method'   => 'GET'
            ]);
            // echo Veris::BASE_URL.$method.$params;
            // dd($response);

            if($response->code != 200 || !isset($response->data) || $response->data->estaPagada){
                $message = ( $response->code != 200 || !isset($response->data) ) ? (isset($response->data)) ? $response->message : "No existe información relacionada que pagar" : "El Servicio ya se encuentra pagado";
                return view('external.pasarela.error')
                        ->with('showButtonRePay', false)
                        ->with('error',$message);
            }else{
                if(strlen($response->data->numeroIdentificacionFactura) == 10){
                    $tipoIdentificacionFac = 2;
                }else{
                    $tipoIdentificacionFac = 1;
                }
                $method = '/'.Veris::BASE_WAR.'/v1/seguridad/cuenta?tipoIdentificacion='.$tipoIdentificacionFac.'&numeroIdentificacion='.$response->data->numeroIdentificacionFactura;

                $list_paciente = Veris::call([
                    'endpoint' => Veris::BASE_URL.$method,
                    'method'   => 'GET'
                ]);
                return view('external.pasarela.pago_servicios_y_farmacia')
                            ->with('info',$response->data)
                            ->with('esServicioCaja',$esServicioCaja)
                            ->with('accessToken',$accessToken)
                            ->with('paciente',$list_paciente->data)
                            ->with('codigoEmpresa',$codigoEmpresa);
            }

        }else{

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
    }

    public function pagoExternoKushki($params){
        return view('external.pasarela.pago_kushki_externo')
            ->with('params',$params);
    }

    public function procesarExternoKushki(Request $request, $params) {
        //Realizar cobro y validar para donde redireccionar
        $data = $request->all();
        // dd($data);
        $dataCita = json_decode(utf8_encode(base64_decode(urldecode($data['dataCita']))));
        // $tokenCita = $data['tokenCita'];
        if($dataCita == null){
            $returnUrl = "numeroIdentificacion=".$data['numeroIdentificacionCita']."&tipoIdentificacion=".$data['tipoIdentificacionCita']."&codArticulo=".$data['codigoReserva']."&tipoArticulo=CITA";
            $showButtonRePay = false;
            $codigoPreTransaccion = $data['idPreTransaccion'];
            $razonSocial = "";
            if($data['tipoIdentificacionFact'] == 1){
                $razonSocial = $data['primerNombreFact'];
            }
            $executionId = "";
            if(isset($data['executionId'])){
                $executionId = $data['executionId'];
            }
            $method = '/'.Veris::BASE_WAR.'/v1/facturacion/crear_transaccion_virtual?idPreTransaccion='.$codigoPreTransaccion;
            $responseTV = Veris::call([
                'endpoint' => Veris::BASE_URL.$method,
                'data' => [
                    "codigoUsuario" => $data['numeroIdentificacionFact'],
                    "codigoTipoIdentificacion" => $data['tipoIdentificacionFact'],
                    "numeroIdentificacion" => $data['numeroIdentificacionFact'],
                    "nombreFactura" => $razonSocial,
                    "primerNombre" => $data['primerNombreFact'],
                    "primerApellido" => $data['primerApellidoFact'],
                    "segundoApellido" => $data['segundoApellidoFact'],
                    "direccionFactura" => $data['direccionFact'],
                    "telefonoFactura" => $data['telefonoFact'],
                    "emailFactura" => $data['mailFact'],
                    "modeloDispositivo" => null,
                    "versionSO" => null,
                    "plataformaOrigen" => "WEB",
                    "tipoBoton" => "KUSHKI",
                    "executionId" => $executionId,
                    "canalOrigenDigital" => Veris::CANAL_ORIGEN
                ],
                'method'   => 'POST'
            ]);

            if($responseTV->code == 200){
                $codigoTransaccion = $responseTV->data->codigoTransaccion;
                $method = '/'.Veris::BASE_WAR.'/v1/facturacion/registrar_pago_kushki?idPreTransaccion='.$codigoPreTransaccion;
                $response = Veris::call([
                    'endpoint' => Veris::BASE_URL.$method,
                    'data' => [
                        "tipoIdentificacion" => $data['tipoIdentificacionFact'],
                        "numeroIdentificacion" => $data['tipoIdentificacionFact'],
                        "codigoTransaccion" => $responseTV->data->codigoTransaccion,
                        "cardToken" => $data['kushkiToken'],
                        "suscripcionToken" => null,
                        "nombreTarjetahabiente" => $data['primerNombreFact']." ".$data['primerApellidoFact'],
                        "emailTarjetahabiente" => $data['mailFact'],
                        "codigoSuscripcionTarjeta" => null,
                        "codigoSeguridad" => null,
                        "canalOrigenDigital" => Veris::CANAL_ORIGEN
                    ],
                    'method'   => 'POST'
                ]);
            }else{
                return redirect()->route('payment-error')
                    ->with('error',$responseTV->message);
            }
            
        }else{
            $codigoTransaccion = $dataCita->transaccionVirtual->codigoTransaccion;
            $showButtonRePay = true;
            $returnUrl = $dataCita->returnUrl;
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
        }

        // dd($response);

        if($response->code == 200){
            return redirect('/external/payment/comprobante?'.base64_encode($codigoTransaccion));
        }else{
            // session()->flash('alert', $response->message);
            // return redirect('/external/payment/error')
            return redirect()->route('payment-error')
                    ->with('error',$response->message)
                    ->with('showButtonRePay', true)
                    ->with('urlRetornoPago', $returnUrl);
            // return view('external.pasarela.error')
            //         ->with('showButtonRePay', $showButtonRePay)
            //         ->with('urlRetornoPago', $returnUrl);
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
                // session()->flash('alert', $list->message);
                // return redirect('/external/payment/error/'.$params);
                return view('external.pasarela.error')
                    ->with('showButtonRePay', false)
                    ->with('error', $list->message);
            }
        }
    }

    public function loginQr(){
        if (Session::has('userDataExternal')) {
            return redirect('/external/farmacia/qr/gestion');
        }
        return view('external.qr_farmacia.login_qr_farmacia');
    }

    public function showErrorPayment(Request $request){
        return view('external.pasarela.error');
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

            // dump($data);
            // dd($response);

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

    public function autenticarQr(Request $request){
        $urlParams = $request->all();
        $accessToken = $this->getTokenExternalEpi();

        $method = '/loginUser';
        $response = Veris::call([
            'endpoint' => Veris::URL_EPI.$method,
            'token'    => $accessToken,
            'method'   => 'POST',
            'data'     => ["user"=>strtoupper($_POST['numeroIdentificacion']),"pass"=>$_POST['password']]
        ]);
        // dd($response);
        
        if($response->codigo == 0){
            $isDespacho = false;
            foreach ($response->lsUsuarioXRol as $key => $value) {
                if($value->codigoRol == "DESPACHO_FARMACIA"){
                    $isDespacho = true;
                }
            }
            if($isDespacho){
                Session::put('userDataExternal', $response->usuario);
                return redirect('/external/farmacia/qr/gestion');
            }else{
                session()->flash('alert', "Rol de usuario no permitido");
                return redirect('/external/farmacia/qr');
            }
        }else{
            session()->flash('alert', "Usuario incorrecto");
            return redirect('/external/farmacia/qr');
        }
    }
    
    public function gestionQr(){
        // dd(Session::get('userDataExternal'));
        return view('external.qr_farmacia.index');
    }

    public function logoutQr(){
        Session::flush();
        return redirect()->route('login-qr');
    }

    public function mostrarResultadoLaboratorio($idPaciente){
        $accessToken = $this->getTokenExternalFacturacion(Veris::CONTIENE_DESARROLLO);
        $method = '/apoyosdx/v1/consultas/portal/ordenes_entrega_resultados?fechaInicio&fechaFin&idPaciente='.base64_decode($idPaciente);
        $result = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'token'    => $accessToken,
            'method'   => 'GET',
            'tokenDesarrollo' => Veris::CONTIENE_DESARROLLO
        ]);
        
        return view('external.laboratorio.resultados')
                    ->with('idPaciente', base64_decode($idPaciente))
                    ->with('data', $result->data)
                    ->with('accessToken',$accessToken);
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

    public function getTokenExternalEpi(){
        $token = session('accessTokenEpi', null);

        if( $token !== null ){
            //return $token;
        }

        $method = '/login';
        $response = Veris::call([
            'endpoint' => Veris::URL_EPI.$method,
            'basic' => Veris::BASICAUTHEPI,
            'method'   => 'POST'
        ]);
        // dd($response->accesToken);
        // session(['accessTokenEpi' => $response->accesToken]);
        return $response->accesToken;
    }

    public function getTokenExternalFacturacion($esDesarrollo = false){
        $token = session('accessTokenFacturacion', null);

        if( $token !== null ){
            //return $token;
        }

        if($esDesarrollo){
            $nameWar = Veris::FACTURACION_WAR_DESA;
            $basic = Veris::BASICAUTHFACTURACIONDESARROLLO;
        }else{
            $nameWar = Veris::FACTURACION_WAR;
            $basic = VERIS::BASICAUTHFACTURACION;
        }

        $method = '/'.$nameWar.'/v1/autenticacion/login';
        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'basic' => $basic,
            'method'   => 'POST',
            'tokenDesarrollo' => $esDesarrollo
        ]);
        // dump(Veris::BASE_URL.$method);
        // dd($response);
        session(['accessTokenFacturacion' => $response->data->idToken]);
        return $response->data->idToken;
    }

    public function bot(){
        return view('external.bot.index');
    }

    public function botAi(Request $request){
        $data = $request->all();
        // dd($data['message']);
        $curl = curl_init();
        $payload = [  "sessionId" => "12345678901234577" , "message" => $data['message'] ];

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://34.202.115.111:4393/api/chatbot/message',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $payload,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));


        $response = curl_exec($curl);

    }
}
