@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="{{ asset('js/registrohoras.js?v=abcdefg123413') }}" defer></script>

<script src="https://unpkg.com/imask"></script>

<style>
.todo {
    display: flex;
    gap: 12px;
}

.todo input {
    width: 80%;
}

table {

    table-layout: fixed;
}

table td {
    word-wrap: break-word;
    max-width: 400px;
}

#registro_horas td {
    white-space: inherit;
}

table.display {
    table-layout: fixed;
}
</style>
<style>
.switch {
    position: relative;
    display: inline-block;
    width: 34px;
    height: 19px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .2s;
    border-radius: 19px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: .2s;
    border-radius: 50%;
}

.switch input:checked + .slider {
    background-color: #28a745;
}

.switch input:checked + .slider:before {
    transform: translateX(15px);
}

.registro-agente .registro-header {
    align-items: center;
    gap: 1rem;
}

.registro-agente .registro-header h2 {
    margin: 0;
    font-size: clamp(1.15rem, 2.5vw, 1.75rem);
}

.registro-agente #registro_horas_wrapper {
    width: 100%;
}

#modal_registro .modal-dialog {
    width: calc(100vw - 3rem);
    max-width: 1100px;
    margin-right: auto;
    margin-left: auto;
}

#modal_registro .modal-content {
    max-height: calc(100vh - 2rem);
}

#modal_registro .modal-body {
    overflow-y: auto;
}

#modal_registro .registro-seccion {
    margin-bottom: 1.5rem;
}

#modal_registro .registro-seccion-titulo {
    margin-bottom: .25rem;
    color: #263b5e;
    font-size: 1.1rem;
    font-weight: 600;
}

#modal_registro .registro-ayuda {
    margin-bottom: .75rem;
    color: #6c757d;
}

#modal_registro #tabla {
    width: 100%;
    table-layout: fixed;
    margin-bottom: 0;
}

#modal_registro #tabla th:nth-child(1),
#modal_registro #tabla td:nth-child(1),
#modal_registro #tabla th:nth-child(2),
#modal_registro #tabla td:nth-child(2) {
    width: 42%;
}

#modal_registro #tabla th:nth-child(3),
#modal_registro #tabla td:nth-child(3) {
    width: 16%;
}

#modal_registro #tabla th,
#modal_registro #tabla td {
    vertical-align: middle;
}

#modal_registro #tabla tbody tr {
    border-top: 1px solid #dee2e6;
}

#modal_registro #tabla tbody td {
    padding-top: .75rem;
    padding-bottom: .75rem;
}

#modal_registro .registro-hora-grupo {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    width: 100%;
    max-width: 400px;
    gap: .5rem;
}

#modal_registro .registro-hora-grupo .form-control {
    width: 100%;
    height: 44px;
    min-width: 0;
    box-sizing: border-box;
    padding-right: .5rem;
    padding-left: .5rem;
}

#modal_registro .registro-campo {
    max-width: 620px;
}

#modal_registro .registro-campo label {
    font-weight: 600;
}

#modal_registro .registro-campo .form-control {
    width: 100%;
}

#modal_registro .registro-resumen {
    margin-bottom: 1.25rem;
    padding: 1rem;
    background: #f5f7fa;
    border: 1px solid #e1e6ed;
    border-radius: .375rem;
}

#modal_registro .registro-resumen .registro-campo:last-child {
    margin-bottom: 0;
}

#modal_registro .registro-diaoff {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .65rem .85rem;
    color: #111;
    background: #33ecff;
    border-radius: .25rem;
}

#modal_registro .registro-diaoff .form-check-input {
    position: static;
    margin: 0;
}

@media (max-width: 767.98px) {
    .registro-agente .registro-header {
        flex-direction: column;
        align-items: stretch !important;
    }

    .registro-agente .registro-header h2 {
        line-height: 1.35;
    }

    .registro-agente .registro-header #registro {
        width: 100%;
    }

    .registro-agente .table-responsive {
        margin-right: -.5rem;
        margin-left: -.5rem;
        width: calc(100% + 1rem);
    }

    #modal_registro .modal-dialog {
        width: auto;
        margin: .5rem;
    }

    #modal_registro .modal-content {
        max-height: calc(100vh - 1rem);
    }

    #modal_registro .modal-body {
        padding: 1rem .75rem;
    }

    #modal_registro .registro-seccion-titulo {
        font-size: 1rem;
    }

    #modal_registro #tabla,
    #modal_registro #tabla tbody,
    #modal_registro #tabla tr,
    #modal_registro #tabla td {
        display: block;
        width: 100%;
    }

    #modal_registro #tabla td:nth-child(1),
    #modal_registro #tabla td:nth-child(2),
    #modal_registro #tabla td:nth-child(3) {
        width: 100%;
    }

    #modal_registro #tabla thead {
        display: none;
    }

    #modal_registro #tabla tr.fila-fija {
        margin-bottom: .75rem;
        padding: .75rem;
        border: 1px solid #dee2e6;
        border-radius: .375rem;
    }

    #modal_registro #tabla td {
        padding: .5rem 0;
        border: 0;
    }

    #modal_registro #tabla td::before {
        display: block;
        margin-bottom: .35rem;
        font-weight: 600;
        content: attr(data-label);
    }

    #modal_registro .registro-hora-grupo {
        gap: .35rem;
    }

    #modal_registro .registro-hora-grupo .form-control {
        padding-right: .35rem;
        padding-left: .35rem;
        font-size: 16px;
    }

    #modal_registro #btnagregar {
        width: 100%;
        min-height: 44px;
    }

    #modal_registro .registro-campo {
        max-width: none;
    }

    #modal_registro .modal-footer {
        display: flex;
        flex-direction: column;
        gap: .5rem;
    }

    #modal_registro .modal-footer .btn {
        width: 100%;
        min-height: 44px;
        margin: 0;
    }
}

@media (max-width: 575.98px) {
    #modal_registro .modal-dialog {
        min-height: calc(100% - 1rem);
    }

    #modal_registro .modal-content {
        min-height: calc(100vh - 1rem);
    }
}
</style>


@if(@Auth::user()->hasRole('administrador'))
<input type="hidden" name="rol" id="rol" value="administrador" />
@elseif (@Auth::user()->hasRole('agente'))
<input type="hidden" name="rol" id="rol" value="agente" />
@endif


<input type="hidden" value="{{$cupo->id}}" id="id_cupo" name="id_cupo">
<input type="hidden" value="{{$cupo->vista}}" id="vista" name="vista">
<input type="hidden" value="{{$cupo->start}}" id="fechas" name="fechas">
<input type="hidden" name="usuario_log" id="usuario_log" value="{{ auth()->user()->id }}" />

<!-- Input de guardan horario asigando a usuario -->

<input type="hidden" value="" id="hiniciales" name="hiniciales">
<input type="hidden" value="" id="hfinales" name="hfinales">

<div class="col-md-12 registro-agente" style="background-color: ">
    <div class="jumbotron col-md-12 col d-flex justify-content-between border border-secondary rounded shadow-sm my-3 py-2 registro-header">
        <h2><strong> Lista de control de Horas&nbsp; &nbsp; &nbsp; Fecha:
                &nbsp;{{ \Carbon\Carbon::parse($cupo->start)->isoformat('dddd D \d\e MMMM \d\e\l Y')}}</strong> </h2>

        @if(Auth::user() && Auth::user()->hasRole('administrador'))
            <input class="btn btn-primary float-right" id="registro" type="submit" value="Crear registro">
        @else
            @php

                $fechaCupo = \Carbon\Carbon::parse($cupo->start)->startOfDay();
                $fechaActual = \Carbon\Carbon::today();
                $fechaManana = $fechaActual->copy()->addDay();

                $esDiaActual = $fechaCupo->isSameDay($fechaActual);

                $esDiaEspecialManana = $fechaCupo->isSameDay($fechaManana)
                    && (
                        $fechaCupo->day === 15 ||
                        $fechaCupo->isLastOfMonth()
                    );

                $registroHabilitado = $esDiaActual
                    || $esDiaEspecialManana
                    || $cupo->permitir_registro;

            @endphp

                <div class="d-flex flex-column align-items-center">

                    <input class="btn btn-primary float-right inpCrearRegistro"
                        id="registro"
                        type="submit"
                        value="Crear registro"
                        {{ $registroHabilitado ? '' : 'disabled' }}
                        title="{{ $registroHabilitado ? 'Crear registro' : 'Solo habilitado para la fecha de hoy' }}">

                    @if(!$esDiaActual && $esDiaEspecialManana)

                        <small class="text-info mt-1 text-center font-weight-bold inpCrearRegistro"
                            style="max-width: 220px;">
                            <b>
                                Habilitado desde un día antes.
                            </b>
                        </small>

                    @elseif(!$esDiaActual && $cupo->permitir_registro)

                        <small class="text-success mt-1 text-center font-weight-bold inpCrearRegistro"
                            style="max-width: 220px;">
                            <b>
                                Habilitado por el administrador.
                            </b>
                        </small>

                    @elseif(!$registroHabilitado)

                        <small class="text-danger mt-1 text-center font-weight-bold inpCrearRegistro"
                            style="max-width: 180px;">
                            <b>
                                No habilitado
                            </b>
                        </small>

                    @endif
                </div>
        @endif
    </div>

<div class="card border border-primary rounded mb-2 shadow-sm  @if(Auth::user() && !Auth::user()->hasRole('administrador'))  d-none @endif  ">
    <div class="card-header bg-white py-2">
        <strong>Controles del cupo</strong>
    </div>
    <div class="card-body py-2">
        @if(Auth::user() && Auth::user()->hasRole('administrador'))
            <div class="d-flex align-items-center">
                <label class="switch mb-0 mr-2">
                    <input type="checkbox"
                           id="registro_habilitado"
                           name="registro_habilitado"
                           {{ $cupo->permitir_registro ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
                <label for="registro_habilitado" class="mb-0">
                    Habilitar registro
                </label>
            </div>
        @endif
    </div>

    <div class="card-footer bg-white py-2">
        <button
            class="btn btn-primary btn-sm"
            onclick="generarReporte()">
            Generar reporte
        </button>
    </div>
</div>

    <div class="col-md-12 table-responsive mt-3">
        <table id="registro_horas" class="table table-striped table-bordered dt-responsive nowrap datatable"
            class="display" cellspacing="0" cellpadding="3" width="100%" style="background-color: ">
            <thead>
                <tr>
                    <th class="col-md-2">#</th>
                    <th class="col-md-2">Nombre</th>
                    <th class="col-md-2">Total Horas</th>
                    <th class="col-md-2">Total Citas</th>
                    <th class="col-md-3">Comentario</th>
                    <th class="col-md-3">Opciones</th>
                </tr>
            </thead>
        </table>
    </div>

</div>


<!-- Modal registro de horas -->

<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="modal_registro_title"
    aria-describedby="modal_registro_help"
    aria-hidden="true">
    <div class="modal-dialog " id="modalcup" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_registro_title">
                    Registrar jornada
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar ventana">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="registroHorario">

                    {!! csrf_field() !!}

                    <section class="registro-seccion" aria-labelledby="registro_intervalos_titulo">
                        <h6 class="registro-seccion-titulo" id="registro_intervalos_titulo">Horario trabajado</h6>
                        <p class="registro-ayuda" id="modal_registro_help">
                            Indica la hora de inicio y fin de cada periodo. Si tomaste un descanso, agrega un intervalo por cada periodo trabajado.
                        </p>

                        <table class="table table-sm" id="tabla">
                            <thead>
                                <tr>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="fila1">
                                <tr class="fila-fija" id="fila1">
                                    <td data-label="Inicio del intervalo">
                                        <div class="registro-hora-grupo">
                                            <select name="horaini[]" id="horaini"
                                                class="form-control horas entrada" aria-label="Hora de inicio">
                                                <option value="" disabled selected>Hora</option>
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>

                                            <input type="number" class="form-control horas minutitos entrada"
                                                required="" name="minutosini[]" id="minutosini"
                                                value="" placeholder="Min." autocomplete="off"
                                                min="0" max="59" aria-label="Minutos de inicio">

                                            <select name="horarioini[]" id="horario1"
                                                class="form-control horas entrada" aria-label="AM o PM de inicio">
                                                <option value="" disabled selected>AM/PM</option>
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>

                                        </div>
                                    </td>


                                    <td data-label="Fin del intervalo">
                                        <div class="registro-hora-grupo">


                                            <select name="horaini2[]" id="horaini2"
                                                class="form-control horas entrada" aria-label="Hora de finalización">
                                                <option value="" disabled selected>Hora</option>
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>

                                            <input type="number" class="form-control horas entrada" required=""
                                                name="minutosini2[]" id="minutosini2" value=""
                                                placeholder="Min." autocomplete="off" min="0" max="59"
                                                aria-label="Minutos de finalización">


                                            <select name="horarioini2[]" id="horario2"
                                                class="form-control horas entrada" aria-label="AM o PM de finalización">
                                                <option value="" disabled selected>AM/PM</option>
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>

                                        </div>



                                    </td>
                                    <td id="agregar" class="" data-label="Acciones">
                                        <input type="button" id="btnagregar" class="btn btn-success masmenos entrada"
                                            value="Agregar intervalo">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </section>


                    <section class="registro-seccion registro-resumen" aria-labelledby="registro_resumen_titulo">
                        <h6 class="registro-seccion-titulo" id="registro_resumen_titulo">Resumen de la jornada</h6>
                        <p class="registro-ayuda">El total de horas se calcula automáticamente a partir de los intervalos.</p>
                        <div class="form-group registro-campo">
                            <label for="total_horas">Total de horas trabajadas</label>
                            <input type="text" class="form-control col-md-9 " required="" name="total_horas"
                                id="total_horas" aria-describedby="total_horas_help" placeholder="" autocomplete="off"
                                disabled="true">
                            <small class="form-text text-muted" id="total_horas_help">Se actualiza al ingresar o modificar los intervalos.</small>
                        </div>

                        <div class="form-group registro-campo">
                            <label for="total_citas">Número total de citas</label>
                            <input type="number" class="form-control col-md-9 entrada" required="" name="total_citas"
                                id="total_citas" aria-describedby="total_citas_help" value="" placeholder="Ej. 8" autocomplete="off"
                                min="0">
                            <small class="form-text text-muted" id="total_citas_help">Escribe cuántas citas atendiste durante la jornada.</small>
                        </div>

                        <div class="form-group registro-campo">
                            <label for="comentarios">Comentario de la jornada</label>
                            <input type="text" class="form-control col-md-9 entrada" required="" name="comentarios"
                                id="comentarios" aria-describedby="comentarios_help" placeholder="Agrega un detalle relevante" autocomplete="off">
                            <small class="form-text text-muted" id="comentarios_help">Si no hay nada que agregar, indica “Sin comentarios”.</small>
                        </div> 

                        <div class="form-group registro-campo" id="motivoscoincidencia">
                            <label for="motivoshorario">Motivo de diferencia con el horario asignado</label>
                            <input type="text" class="form-control col-md-9 entrada" required="" name="motivoshorario"
                                id="motivoshorario" aria-describedby="motivoshorario_help" placeholder="Explica brevemente el motivo" autocomplete="off">
                            <small class="form-text text-muted" id="motivoshorario_help">Describe por qué las horas registradas no coinciden con tu horario.</small>
                        </div>

                    </section>

                    <div class="form-check registro-diaoff">
                        <input class="form-check-input" type="checkbox" value="1" id="diaoff">
                        <label class="form-check-label" for="diaoff">
                            Marcar como día libre (sin horas trabajadas)
                        </label>
                    </div>

                    <input type="hidden" class="oculto" value="" id="horasiniciales" name="horasiniciales">
                    <input type="hidden" class="oculto" value="" id="horasfinales" name="horasfinales">
                    <input type="hidden" class="oculto" value="" id="TotaDeHoras" name="TotaDeHoras">
                    <input type="hidden" class="oculto" value="" id="id_registro" name="id_registro">
                    <input type="hidden" class="" value="{{$cupo->id}}" id="cupo_id" name="cupo_id">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="guardar_registro">Guardar registro</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalReporte" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Reporte de horas
                </h5>

                <button class="close" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <textarea
                    id="txtReporte"
                    class="form-control"
                    rows="18"
                    readonly
                ></textarea>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-success"
                    onclick="copiarReporte()"
                >
                    Copiar reporte
                </button>

                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cerrar
                </button>

            </div>

        </div>
    </div>
</div>

@endsection