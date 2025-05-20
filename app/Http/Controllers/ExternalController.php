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

    public function nuevoAgendamientoCitas(){
        // return view('test');
        // session()->flash('error', "Ningun error");
        // session()->flash('url', "https://akold.com");
        // return redirect()->route('payment-error');


        return view('external.agendamiento_2025.agendamiento_cita')
            ->with('accesToken',$this->getTokenExternalDigitales());
    }

    public function registroNuevoAgendamientoCitas($params){
        return view('external.agendamiento_2025.registrar_cuenta')->with('params',$params);
    }
    
    public function datosCitaNuevoAgendamientoCitas($params){
        return view('external.agendamiento_2025.seleccionar_datos_cita')->with('params',$params);
    }

    public function fechaNuevoAgendamientoCitas($params){
        return view('external.agendamiento_2025.seleccionar_fecha')->with('params',$params);
    }

    public function VuaNuevoAgendamientoCitas($params){
        return view('external.agendamiento_2025.citas_vua')->with('params',$params);
    }

    public function detalleCitaNuevoAgendamientoCitas($params){
        return view('external.agendamiento_2025.detalle_cita')->with('params',$params);
    }

    public function CitaAgendadaNuevoAgendamientoCitas($params){
        return view('external.agendamiento_2025.cita_agendada')->with('params',$params);
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

    public function detallePaquetePorId(Request $request){
        $urlParams = $request->all();
        $idPaquete = $urlParams['id'];
        return view('external.paquetes_promocionales.detalle_paquete_id')
            ->with('accesToken',$this->getTokenExternalFacturacion())
            ->with('idPaquete', $idPaquete);
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
            //Verificar si Nuvei esta activo
            $method = '/'.Veris::BASE_WAR.'/v1/generales/parametros';
            $params = '?nemonico=DIG_HABILITA_NUVEI';
            $responseNuvei = Veris::call([
                'endpoint' => Veris::BASE_URL.$method.$params,
                'method'   => 'GET'
            ]);
            // dd($responseNuvei);
            $permiteNuvei = $responseNuvei->data->valorTexto;
            // dd($permiteNuvei);
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
                // dd($response->data);
                return view('external.pasarela.pago_servicios_y_farmacia')
                            ->with('info',$response->data)
                            ->with('esServicioCaja',$esServicioCaja)
                            ->with('permiteNuvei',$permiteNuvei)
                            // ->with('permiteNuvei',"N")
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
            // dd($list_paciente);
            $idPaciente = ($list_paciente->data !== null) ? $list_paciente->data->numeroPaciente : null;
            if($list_paciente->data === null){
                $list_paciente->data = new \stdClass();
                $list_paciente->data->idPaciente = null;
                $list_paciente->data->telefonoMovil = "";
            }
            $data = array(
                "idPaciente" => $idPaciente,
                "codigoConvenio" =>  null,
                "secuenciaAfiliado" =>  null,
                // "idPaciente" => null,
                "codigoConvenio" => null,
                "codigoSolicitud" => null
            );

            switch ($urlParams['tipoArticulo']) {
                case 'CITA':
                case 'CITA_ODO':
                    $data["idPaciente"] = $idPaciente;
                    $data["tipoSolicitud"] = null;
                    $data["tipoServicio"] = $urlParams['tipoArticulo'];
                    $data["listaCitas"] = [array(
                            "codigoReserva" => $urlParams['codArticulo']
                        )];
                break;
                case 'DOM':
                    $data["idPaciente"] = $idPaciente;
                    $data["tipoSolicitud"] = "LAB";
                    $data["tipoServicio"] = "DOMICILIO";
                    $data["codigoSolicitud"] = $urlParams['codArticulo'];
                    $data["listaCitas"] = [];
                    $data["listaOrdenes"] = [];
                break;
                case 'ORDEN':
                    $data["idPaciente"] = $idPaciente;
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
                    $data["idPaciente"] = $idPaciente;
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
            //CANAL_ORIGEN_EXTERNAL
            $method = '/'.Veris::BASE_WAR.'/v1/facturacion/crear_pretransaccion?canalOrigen='.Veris::CANAL_ORIGEN_EXTERNAL;

            // Pago para Digiturno
            if(isset($urlParams['esLinkDigiturno'])){
                $data['esLinkDigiturno'] = true;
                $data['macAddress'] = $urlParams['macAddress'];
            }else{
                $data['esLinkDigiturno'] = false;
            }

            // dd($data);

            $response_pretrx = Veris::call([
                'endpoint' => Veris::BASE_URL.$method,
                'method'   => 'POST',
                'data'     => $data
            ]);
            // echo Veris::BASE_URL.$method;
            // dump($data);
            // dump($response_pretrx);
            
            if($response_pretrx->code == 200){
                return view('external.pasarela.datos_facturacion')
                        ->with('paciente',$list_paciente)
                        ->with('urlRetornoPago', http_build_query($urlParams))
                        ->with('origenInvocacion', (isset($urlParams['origenInvocacion'])) ? $urlParams['origenInvocacion'] : Veris::CANAL_ORIGEN_EXTERNAL)
                        ->with('esLinkDigiturno', $data['esLinkDigiturno'])
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
        $accessToken = $this->getTokenExternalFacturacion();
        return view('external.pasarela.pago_kushki_externo')
            ->with('accessToken',$accessToken)
            ->with('params',$params);
    }

    public function procesarExternoKushki(Request $request, $params) {
        //Realizar cobro y validar para donde redireccionar
        $data = $request->all();
        $dataCita = json_decode(utf8_encode(base64_decode(urldecode($data['dataCita']))));

        // dd($dataCita->datosIngresadosFactura);
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
                    "canalOrigenDigital" => Veris::CANAL_ORIGEN_EXTERNAL,
                    "origenInvocacion" => ( isset($urlParams['origenInvocacion']) ) ? $urlParams['origenInvocacion'] : Veris::CANAL_ORIGEN_EXTERNAL
                ],
                'method'   => 'POST'
            ]);
            // dd($responseTV);

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
                        "canalOrigenDigital" => Veris::CANAL_ORIGEN_EXTERNAL
                    ],
                    'method'   => 'POST'
                ]);
            }else{
                /*return redirect()->route('payment-error')
                    ->with('error',$response->message)
                    ->with('showButtonRePay', true)
                    ->with('urlRetornoPago', $returnUrl);*/
                return redirect()->route('payment-error', [
                    'error' => $responseTV->message,
                    'showButtonRePay' => true,
                    'urlRetornoPago' => $returnUrl,
                ]);
            }
        }else if(isset($dataCita->datosIngresadosFactura) && !empty($dataCita->datosIngresadosFactura)){
            $returnUrl = (isset($dataCita->returnUrl)) ? $dataCita->returnUrl : "numeroIdentificacion=".$data['numeroIdentificacionCita']."&tipoIdentificacion=".$data['tipoIdentificacionCita']."&codArticulo=".$data['codigoReserva']."&tipoArticulo=CITA";
            $showButtonRePay = true;
            // dd($dataCita);
            $codigoTransaccion = $dataCita->transaccionVirtual->codigoTransaccion;
            $method = '/'.Veris::BASE_WAR.'/v1/facturacion/registrar_pago_kushki?idPreTransaccion='.$dataCita->preTransaccion->codigoPreTransaccion;
            $response = Veris::call([
                'endpoint' => Veris::BASE_URL.$method,
                'data' => [
                    "tipoIdentificacion" => $dataCita->datosIngresadosFactura->codigoTipoIdentificacion,
                    "numeroIdentificacion" => $dataCita->datosIngresadosFactura->numeroIdentificacion,
                    "codigoTransaccion" => $codigoTransaccion,
                    "cardToken" => $data['kushkiToken'],
                    "suscripcionToken" => null,
                    "nombreTarjetahabiente" => $dataCita->datosIngresadosFactura->primerNombre." ".$dataCita->datosIngresadosFactura->primerApellido,
                    "emailTarjetahabiente" => $dataCita->datosIngresadosFactura->emailFactura,
                    "codigoSuscripcionTarjeta" => null,
                    "codigoSeguridad" => null,
                    "canalOrigenDigital" => Veris::CANAL_ORIGEN_EXTERNAL
                ],
                'method'   => 'POST'
            ]);
            // return redirect()->route('payment-error', [
            //     'error' => $responseTV->message,
            //     'showButtonRePay' => true,
            //     'urlRetornoPago' => $returnUrl,
            // ]);
        }else{
            // dd($dataCita);
            if(isset($dataCita->infoTransaccion)){
                $codigoTransaccion = $dataCita->infoTransaccion->codigoEpago;
                $showButtonRePay = true;
                // $codigoTransaccion = $dataCita->infoTransaccion->codigoPreTransaccion;
                $accessToken = $this->getTokenExternalFacturacion();
                if(isset($dataCita->infoTransaccion->codigoPreTransaccion)){
                    $returnUrl = "codigoPreTransaccion=".$dataCita->infoTransaccion->codigoPreTransaccion;
                    $nemonicoFlujoCobro = Veris::NEMONICO_FLUJO_PAGO;
                    $esServicioCaja = true;
                    $method = '/facturacion/v1/pagos_electronicos/obtener_info_previa_factura/pre_transaccion';
                    $codigoEmpresa = 1;
                    if(isset($dataCita->infoTransaccion->codigoEmpresa)){
                        $codigoEmpresa = $urlParams['codigoEmpresa'];
                    }
                    $params = '?codigoEmpresa='.$codigoEmpresa.'&idPreTransaccion='.$dataCita->infoTransaccion->codigoPreTransaccion;
                }else{
                    $returnUrl = "idSolicitud=".$dataCita->infoTransaccion->codigoSolicitudServDomicilio;
                    $nemonicoFlujoCobro = Veris::NEMONICO_FARMACIA;
                    $method = '/facturacion/v1/pagos_electronicos/obtener_info_previa_factura/farmacia_domicilio';
                    $codigoEmpresa = 1;
                    if($request->has('codigoEmpresa')){
                        $codigoEmpresa = $urlParams['codigoEmpresa'];
                    }

                    $params = '?codigoEmpresa='.$codigoEmpresa.'&codigoSolicitudServDomicilio='.$dataCita->infoTransaccion->codigoSolicitudServDomicilio;
                }
                // dd($returnUrl);
                $response = Veris::call([
                    'endpoint' => Veris::BASE_URL.$method.$params,
                    'token'    => $accessToken,
                    'method'   => 'GET'
                ]);

                // dd($dataCita);
                if(isset($data['kushkiToken'])){
                    if(isset($data["kushkiDeferred"])){
                        $meses1 = $data["kushkiDeferred"];
                    }else{
                        $meses1 = 0;
                    }

                    $meses = intval($meses1);
                    $subtotalIva =  0;
                    $iva = 0;
                    $subtotalIva0 = $dataCita->infoTransaccion->valor;
                    $ice = 0;

                    $monto = array("subtotalIva"=>$subtotalIva,"subtotalIva0"=>$subtotalIva0,"ice"=>$ice,"iva"=>$iva,"currency"=>"USD");
                    $idPreTransaccionMeta = (isset($dataCita->infoTransaccion->codigoPreTransaccion)) ? $dataCita->infoTransaccion->codigoPreTransaccion : $dataCita->infoTransaccion->codigoSolicitudServDomicilio;
                    $metadata = array("codigoPreTransaccion"=>$idPreTransaccionMeta,"codigoEpago"=>$dataCita->infoTransaccion->codigoEpago);

                    if($meses > 0){
                        $deferred = array("graceMonths"=>"00","creditType"=>$data['kushkiDeferredType'],"months"=>$meses);
                        $dataKushki = array("token"=>$data['kushkiToken'], "amount"=>$monto, "deferred"=>$deferred, "metadata"=>$metadata, "fullResponse"=> true);
                    }else{
                        $dataKushki = array("token"=>$data['kushkiToken'], "amount"=>$monto, "metadata"=>$metadata, "fullResponse"=> true);
                    }

                    $data_string = json_encode($dataKushki);
                    // dd($dataKushki);
                    $method = '/card/v1/charges';
                    $listK = Veris::call([
                        'endpoint' => Veris::URL_KUSHKI.$method,
                        'tokenKushki' => Veris::KUSHKI_PRIVATE_MERCHANT_ID,
                        'method'   => 'POST',
                        'data'     => $dataKushki
                    ]);

                    // $listK['data']
                    // dump($listK);
                    if($listK['status_code'] == 200 || $listK['status_code'] == 201){
                        if(isset($listK['data']['details']['recap'])){
                            $recap = $listK['data']['details']['recap'];
                        }else{
                            $recap = 0;
                        }
                        if(isset($listK['data']['details']['processorName'])){
                            $processorName = $listK['data']['details']['processorName'];
                        }else{
                            $processorName = "-";
                        }
                        if(isset($listK['data']['details']['acquirerBank'])){
                            $issuingBank = $listK['data']['details']['acquirerBank'];
                        }else{
                            $issuingBank = "-";
                        }
                        if(isset($listK['data']['details']['maskedCardNumber'])){
                            $maskedCardNumber = $listK['data']['details']['maskedCardNumber'];
                        }else{
                            $maskedCardNumber = "-";
                        }
                        if(isset($listK['data']['details']['cardType'])){
                            $cardType = $listK['data']['details']['cardType'];
                        }else{
                            $cardType = "-";
                        }

                        $dataK = array(
                            "codigoEmpresa"=> (int)$codigoEmpresa, 
                            "codigoEpago"=> (int)$dataCita->infoTransaccion->codigoEpago, 
                            "nemonicoFlujoCobro"=> $nemonicoFlujoCobro,
                            "datoskushki"=> array(
                                "ticketNumber"=> $listK['data']['ticketNumber'] ?? "", 
                                "approvalCode"=> (int)$listK['data']['details']['approvalCode'] ?? "",
                                "recap"=> (int)$recap, 
                                "paymentBrand"=> $listK['data']['details']['paymentBrand'] ?? "", 
                                "maskedCreditCard"=> $maskedCardNumber,
                                "processorName"=> $processorName, 
                                "issuingBank"=> $issuingBank, 
                                "cardType"=> $cardType
                            )
                        );

                        if(isset($dataCita->infoTransaccion->codigoPreTransaccion)){
                            $dataK["metadataIdFlujoCobro"] = array(
                                "codigoIngresoVap" => null,
                                "idPreTransaccion" => $dataCita->infoTransaccion->codigoPreTransaccion,
                                "codigoSolicitudServDomicilio" => null
                            );
                        }else{
                            $dataK["metadataIdFlujoCobro"] = array(
                                "codigoIngresoVap" => null,
                                "idPreTransaccion" => null,
                                "codigoSolicitudServDomicilio" => $dataCita->infoTransaccion->idSolicitud
                            );
                        }

                        // dump($dataK);
                        $accessToken = $this->getTokenExternalFacturacion();
                        $method = '/facturacion/v1/pagos_electronicos/kushki/registrar_cobro/';
                        $response = Veris::call([
                            'endpoint' => Veris::BASE_URL.$method,
                            'token'    => $accessToken,
                            'method'   => 'POST',
                            'data'     => $dataK
                        ]);
                        // dd($list);
                    }else{
                        // dd($listK['data']['message']);
                        // Mejora
                        // dd('Pago no realizado, mostrar error');
                        return redirect()->route('payment-error', [
                            'error' => $listK['data']['message'],
                            'showButtonRePay' => true,
                            'urlRetornoPago' => $returnUrl,
                        ]);
                    }
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
                        "canalOrigenDigital" => Veris::CANAL_ORIGEN_EXTERNAL
                    ],
                    'method'   => 'POST'
                ]);
            }
        }

        if($response->code == 200){
            return redirect('/external/payment/comprobante?'.base64_encode($codigoTransaccion));
        }else{
            return redirect()->route('payment-error', [
                'error' => $response->message,
                'showButtonRePay' => true,
                'urlRetornoPago' => $returnUrl,
            ]);
        }
    }

    public function procesarExternoNuvei(Request $request, $params) {
        //Realizar cobro y validar para donde redireccionar
        $urlParams = $request->all();
        // dd($urlParams);
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
        // $queryString = $request->getQueryString();
        //dd($request->input('urlRetornoPago'));
        return view('external.pasarela.error')
            ->with('error',$request->input('error'))
            ->with('showButtonRePay',$request->input('showButtonRePay'))
            ->with('urlRetornoPago',$request->input('urlRetornoPago'));
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
        // dd($list);
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
        //return view('external.mantenimiento.index');
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

        $method = '/'.Veris::BASE_WAR.'/v1/seguridad/login?canalOrigen='.Veris::CANAL_ORIGEN_EXTERNAL;
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

    public function devoluciones(Request $request){
        $data = $request->all();
        $accessToken = $this->getTokenExternalFacturacion(Veris::CONTIENE_DESARROLLO);
        $canalOrigen = (isset($data['origenInvocacion'])) ? $data['origenInvocacion'] : 'IVR';
        return view('external.financiero.devoluciones')
                ->with('canalOrigen',$canalOrigen)
                ->with('accessToken',$accessToken);
        // return view('external.mantenimiento.index');
    }

    public function trackDevoluciones($numeroFactura, $tipoIdentificacion,$numeroIdentificacion){
        $accessToken = $this->getTokenExternalFacturacion(Veris::CONTIENE_DESARROLLO);
        return view('external.financiero.tracking_devoluciones')
                ->with('numeroFactura',$numeroFactura)
                ->with('tipoIdentificacion',$tipoIdentificacion)
                ->with('numeroIdentificacion',$numeroIdentificacion)
                ->with('accessToken',$accessToken);
    }

    public function soportesPhantomX(Request $request){
        // return view('external.mantenimiento.index');
        $data = $request->all();
        $accessToken = $this->getTokenExternalFacturacion();
        return view('external.qr_ordenes.ordenes_paperless')
                ->with('idPreTransaccion',$data['idPreTransaccion'])
                ->with('codigoEmpresa',$data['codigoEmpresa'])
                ->with('accessToken',$accessToken);
    }

    public function loginFarmaciaPickingView(){
        return view('external.farmacia.login');
    }

    public function loginFarmaciaPickingAction(Request $request){
        $data = $request->all();
        $user = strtoupper($data['numeroIdentificacion']);
        $password = $data['password'];


        $method = '/'.Veris::FACTURACION_WAR.'/v1/autenticacion/login';
        $res =  Http::withOptions([
                    'verify' => false, // Desactivar verificación de certificados
                ])->withHeaders([
                    'Application' => Veris::APPLICATION_FARMACIA,
                    'Authorization' => 'Basic '.base64_encode(strtoupper($user) .":". $password),
                ])->post(Veris::BASE_URL.$method);
        
        $response = json_decode($res->body());

        if($response->code == 200){
            switch($response->data->estadoUsuario) {
                case 'CONFIRMED':

                    $method = '/'.Veris::FACTURACION_WAR.'/v1/usuarios/'.$response->data->secuenciaUsuario.'?tipoSucursal=TODOS';
                    $dataRoles = Veris::call([
                        'endpoint' => Veris::BASE_URL.$method,
                        'method'   => 'GET',
                        'application' => Veris::APPLICATION_FARMACIA,
                        'token'    => $response->data->idToken,
                        'data'     => $data
                    ]);
                    $roles = collect($dataRoles->data->roles); // $tuArray es el array que muestras

                    $existe = $roles->contains(function ($item) {
                        return $item->codigoRol == 1121 && trim($item->nombreRol) == 'GUIA DE DESPACHO USUARIO2';
                    });
                    // dump($existe);

                    if ($existe){
                        Session::put('userData', $response->data);
                        Session::put('accessToken', $response->data->idToken);
                        // dd($response->data->secuenciaUsuario);
                        Session::put('roles', $dataRoles->data);
                        return redirect('/external/farmacia/gestion');
                    }else{
                        $message = "Usuario no dispone del ROL requerido.";
                    }
                break;
                case 'FORCE_CHANGE_PASSWORD':
                    $message = "Usuario nuevo que ingresa una clave temporal";
                break;
                case 'CHANGE_PASSWORD':
                    $message = "Usuario debe cambiar su clave porque ha pasado 'x' tiempo desde el último cambio";
                break;
                case 'RESET_REQUIRED':
                    $message = "7702057701963";
                break;
            }
        }else{
            $message = $response->message;
        }

        if(isset($message)){
            session()->flash('mensaje', $message);
            session()->flash('user', strtoupper($user));
            return redirect('/external/farmacia/login');
        }
    }

    public function gestionFarmaciaPickingView(){
        $accessToken = $this->getTokenExternalFacturacion();
        return view('external.farmacia.gestion')
                ->with('accessToken',$accessToken);
    }

    public function gestionFarmaciaPickingLogout(){
        Session::flush();
        return redirect()->route('login-farmacia-picking-view');
    }

    public function refreshToken(){
        $info = Session::get('userData');
        // dd($info->refreshToken);
        
        $method = '/'.Veris::FACTURACION_WAR.'/v1/autenticacion/refresh_token';
        $response = Veris::call([
            'endpoint'  => Veris::BASE_URL.$method,
            'data'      => ["refreshToken" => $info->refreshToken],
            'method'    => 'POST',
            'application' => Veris::APPLICATION_FARMACIA
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

    public function botAi(Request $request){
        $data = $request->all();
        // dd($data['message']);
        $curl = curl_init();
        $payload = [  "sessionId" => $data['sessionId'], "canal" => "WEB", "message" => $data['message'] ];

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://sempitecno.com:6040/api/chatbot/message',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($payload),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));


        $response = curl_exec($curl);
            
        $jsonData = json_decode($response, true); // Para un array asociativo, usa 'true'. Para un objeto, omite 'true'.

        // Devolver la respuesta JSON
        return response()->json($jsonData)
        ->header('Access-Control-Allow-Origin', '*') // Permitir solicitudes desde cualquier origen
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS') // Métodos permitidos
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization'); // Encabezados permitidos
    }
}
