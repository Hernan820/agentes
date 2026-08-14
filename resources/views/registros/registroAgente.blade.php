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

<div class="col-md-12" style="background-color: ">
    <div class="jumbotron col-md-12 col d-flex justify-content-between border border-secondary rounded shadow-sm my-3 py-2">
        <h2><strong> Lista de control de Horas&nbsp; &nbsp; &nbsp; Fecha:
                &nbsp;{{ \Carbon\Carbon::parse($cupo->start)->isoformat('dddd D \d\e MMMM \d\e\l Y')}}</strong> </h2>

        @if(Auth::user() && Auth::user()->hasRole('administrador'))
            <input class="btn btn-success float-right" id="registro" type="submit" value="Crear registro">
        @else
            @php
                $fechaCupo = \Carbon\Carbon::parse($cupo->start)->startOfDay();
                $fechaActual = \Carbon\Carbon::today();
                $esDiaActual = $fechaCupo->isSameDay($fechaActual);
            @endphp

            <div class="d-flex flex-column align-items-center">
                <input class="btn btn-success float-right {{ $esDiaActual ? '' : 'disabled' }} inpCrearRegistro"
                       id="registro"
                       type="submit"
                       value="Crear registro"
                       {{ $esDiaActual ? '' : 'disabled' }}
                       title="Solo habilitado para el día actual">

                @if(!$esDiaActual)
                    <small class="text-danger mt-1 text-center fw-bold inpCrearRegistro" style="max-width: 180px;">
                        <b>
                            Solo habilitado para la fecha de hoy.
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

<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modalcup" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Registro de horas de usuario
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="registroHorario">

                    {!! csrf_field() !!}


                    <div class="form-group">
                        <table class="table table-striped  table-responsive-lg table-sm" id="tabla">
                            <thead>
                                <tr>
                                    <th class="col-md-4">Hora inicial</th>
                                    <th class="col-md-4">Hora final</th>
                                    <th class="col-md-3"></th>
                                </tr>
                            </thead>
                            <tbody id="fila1">
                                <tr class="fila-fija" id="fila1">
                                    <td width="">
                                        <div style="display: flex;justify-content: space-around;">
                                            <select name="horaini[]" id="horaini"
                                                class="form-control col-md-3 horas entrada">
                                                <option value="" disabled selected></option>
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

                                            <input type="number" class="form-control col-md-3 horas minutitos entrada"
                                                required="" name="minutosini[]" id="minutosini"
                                                aria-describedby="helpId" value="" placeholder="00" autocomplete="off"
                                                min="0" max="59" style="width:100%">

                                            <select name="horarioini[]" id="horario1"
                                                class="form-control col-md-3 horas entrada">
                                                <option value="" selected selected disabled="true"></option>
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>

                                        </div>
                                    </td>


                                    <td width="">
                                        <div style="display: flex;justify-content: space-around;">


                                            <select name="horaini2[]" id="horaini2"
                                                class="form-control col-md-3 horas entrada">
                                                <option value="" disabled selected></option>
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

                                            <input type="number" class="form-control col-md-3 horas entrada" required=""
                                                name="minutosini2[]" id="minutosini2" aria-describedby="helpId" value=""
                                                placeholder="00" autocomplete="off" style="width:100%" min="0" max="59">


                                            <select name="horarioini2[]" id="horario2"
                                                class="form-control col-md-3 horas entrada">
                                                <option value="" selected selected disabled="true"></option>
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>

                                        </div>



                                    </td>
                                    </td>
                                    <td width="" id="agregar" class="">
                                        <input type="button" id="btnagregar" class="btn btn-success masmenos entrada"
                                            value="agregar intervalo">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="form-group">
                        <label for="total_horas">Total de horas </label>
                        <input type="text" class="form-control col-md-9 " required="" name="total_horas"
                            id="total_horas" aria-describedby="helpId" placeholder="" autocomplete="off"
                            disabled="true">
                    </div>

                    <div class="form-group">
                        <label for="total_citas">Agregue el total de citas </label>
                        <input type="number" class="form-control col-md-9 entrada" required="" name="total_citas"
                            id="total_citas" aria-describedby="helpId" value="" placeholder="" autocomplete="off"
                            min="0">
                    </div>

                    <div class="form-group">
                        <label for="comentarios">Comentarios </label>
                        <input type="text" class="form-control col-md-9 entrada" required="" name="comentarios"
                            id="comentarios" aria-describedby="helpId" placeholder="" autocomplete="off">
                    </div>

                    
                    <div class="form-group" id="motivoscoincidencia">
                        <label for="comentarios">Motivo</label>
                        <input type="text" class="form-control col-md-9 entrada" required="" name="motivoshorario"
                            id="motivoshorario" aria-describedby="helpId" placeholder="" autocomplete="off">
                    </div>

                    <div class="form-check col-md-3" style="padding-left:7.25rem !important; color:black !important;background: #33ECFF !important;">
                        <input class="form-check-input" type="checkbox" value="1" id="diaoff">
                        <label class="form-check-label" for="diaoff">
                            DIA OFF
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
                <button type="button" class="btn btn-success" id="guardar_registro">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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