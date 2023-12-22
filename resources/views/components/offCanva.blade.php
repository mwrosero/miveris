<!--off canva filtro-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="filtroTratamientos" aria-labelledby="filtroTratamientosLabel">
    <div class="offcanvas-header py-2">
        <h5 class="offcanvas-title" id="filtroTratamientosLabel">Filtros</h5>
        <button type="button" class="btn d-lg-none d-block" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-arrow-left"></i> <b class="fw-normal">Atras</b></button>
    </div>
    <div class="offcanvas-body py-2" style="background: rgba(249, 250, 251, 1);">
        <div>
            <h6 class="fw-light">Selecciona el paciente</h6>
            <div class="list-group gap-2 mb-3 listaPacientesFiltro">
                <!-- Puedes agregar lista de pacientes dinámicamente aquí desde JavaScript -->
                
                
            </div>
            <div class="col-md-12 mb-3">
                <label for="fechaDesde" class="fw-light h6">{{ __('Elige el rango de fechas') }} *</label>
                <input type="text" class="form-control bg-neutral" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required />
            </div>
            <div class="col-md-12 mb-5">
                <input type="text" class="form-control bg-neutral" placeholder="Hasta la fecha" name="fechaHasta" id="fechaHasta" required />
            </div>
            <div class="col-md-12 mb-3">
                <button class="btn btn-primary-veris w-100 mt-5 mb-3 mx-0 py-3" type="button" id="aplicarFiltros" data-context="contextoAplicarFiltros">Aplicar filtros</button>
                <button class="btn text-primary w-100 mb-3 mx-0" type="button" id="btnLimpiarFiltros" data-context="contextoLimpiarFiltros"><i class="bi bi-trash me-2"></i>Limpiar filtros</button>

            </div>
        </div>
    </div>
</div>