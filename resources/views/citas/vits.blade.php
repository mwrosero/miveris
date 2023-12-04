async function obtenerTratamientos(estado, pacienteSeleccionado, fechaDesde, fechaHasta) {
    console.log('obtenerTratamientosImagenProcedimientos');
    const args = {
        method: "GET",
        showLoader: false,
        endpoint: construirEndpoint(estado, fechaDesde, fechaHasta)
    };
    console.log(args["endpoint"]);

    const data = await call(args);
    if (data.code == 200) {
        manejarRespuesta(estado, data);
    }
}

function construirEndpoint(estado, fechaDesde, fechaHasta) {
    const baseEndpoint = `${api_url}/digitales/v1/tratamientos/detallesPorServicio`;
    const numeroPaciente = {{ Session::get('userData')->numeroPaciente }};
    const parametrosComunes = `idPaciente=${numeroPaciente}&canalOrigen=${_canalOrigen}&estadoTratamiento=${estado}&page=1&perPage=100&esDetalleRealizado=N&esResumen=N&tipoServicio=LABORATORIO&plataforma=${_plataforma}&version=${_version}&aplicaNuevoControl=false`;

    if (isNaN(fechaDesde) || isNaN(fechaHasta)) {
        return `${baseEndpoint}?${parametrosComunes}`;
    } else {
        return `${baseEndpoint}?${parametrosComunes}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}`;
    }
}

function manejarRespuesta(estado, data) {
    if (estado == 'PENDIENTE') {
        procesarTratamientosPendientes(data);
    } else if (estado == 'REALIZADO') {
        procesarTratamientosRealizados(data);
    }
}

function procesarTratamientosPendientes(data) {
    const mensajeNoTienesProcedimientos = $('#mensajeNoTienesProcedimientos');
    const html = $('#contenedorTratamientosPendientes');
    html.empty();

    if(data.data.items.length == 0){
        mensajeNoTienesProcedimientos.removeClass('d-none');
    }else{
        let elementos = data.data.items.map(laboratorio => crearElementoTratamiento(laboratorio)).join('');
        html.append(elementos);
    }
}

function procesarTratamientosRealizados(data) {
    const mensajeNoTienesProcedimientosRealizados = $('#mensajeNoTienesProcedimientosRealizados');
    const html = $('#contenedorTratamientosRealizados');
    html.empty();

    if(data.data.items.length == 0){
        mensajeNoTienesProcedimientosRealizados.removeClass('d-none');
    }else{
        let elementos = data.data.items.map(laboratorio => crearElementoTratamiento(laboratorio)).join('');
        html.append(elementos);
    }
}

function crearElementoTratamiento(laboratorio) {
    let detallesTratamiento = laboratorio.detallesTratamiento.map(detalles => crearDetalleTratamiento(detalles)).join('');

    return `<div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body py-2 px-3">
                        <p class="fs--3 text-primary-veris mb-0">Tratamiento</p>
                        <h5 class="text-primary-veris fw-bold mb-0">${capitalizarElemento(laboratorio.nombreEspecialidad)}</h5>
                        <p class="fs--2 fw-bold mb-0">${capitalizarElemento(laboratorio.nombrePaciente)}</p>
                        <p class="fw-normal fs--2 mb-0">Dr(a) ${capitalizarElemento(laboratorio.nombreMedico)}</p>
                        <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="text-primary fw-normal">${laboratorio.fechaTratamiento}</b></p>
                        <p class="fw-normal fs--2 mb-0">${capitalizarElemento(laboratorio.nombreConvenio)}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <div class="col-12 col-md-10 col-lg-8">
                        <div class="row g-3" id="cardTratamientoLaboratorio">
                            <div class="col-12 col-md-6">
                                ${detallesTratamiento}
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
}

function crearDetalleTratamiento(detalles) {
    return `<div class="card">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-primary-veris fw-bold mb-0">${capitalizarElemento(detalles.nombreServicio)}</h6>
                        <span class="fs--2 text-warning-veris fw-bold">${determinarEstado(detalles.esPagada)}</span>
                    </div>
                    <p class="fw-normal fs--2 mb-0">Orden válida hasta: <b class="fw-normal text-primary-veris">${detalles.fechaCaducidad}</b></p>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="avatar me-2">
                            <img src="{{ asset('assets/img/svg/microscopio.svg') }}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                        </div>
                        <div>
                            ${determinarbotonesRecetaMedica(detalles)}  
                        </div>
                    </div>
                </div>
            </div>`;
}

