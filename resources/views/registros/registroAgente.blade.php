@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script src="{{ asset('js/registrohoras.js') }}" defer></script>
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
white-space:inherit;
}
table.display {
    table-layout: fixed;          
}
</style>


<input type="hidden" value="{{$cupo->id}}" id="id_cupo" name="id_cupo"></input>
<input type="hidden" name="usuario_log" id="usuario_log" value="{{ auth()->user()->id }}" />



<div class="col-md-12" style="background-color: ">
    <div class="jumbotron col-md-12 col d-flex justify-content-between ">
        <h2><strong> Lista de control de Horas&nbsp; &nbsp; &nbsp; Fecha:
                &nbsp;{{ \Carbon\Carbon::parse($cupo->start)->isoformat('dddd D \d\e MMMM \d\e\l Y')}}</strong> </h2>
        <input class="btn btn-success float-right " id="registro" type="submit" value="Crear registro">
    </div>



    <idv class="col-md-12 table-responsive">
        <table id="registro_horas" class="table table-striped table-bordered dt-responsive nowrap datatable"
            class="display" cellspacing="0" cellpadding="3" width="100%"  style="background-color: ">
            <thead>
                <tr>
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
                        <label for="hora">Hora de inicio y Hora de fin </label>

                        <div class="todo" style="display: flex;justify-content: space-around;">

                            <div class="grupouno" style="display: flex;justify-content: space-around;">
                                <select name="horaini" id="horaini" class="form-control col-md-3" Onchange="conteo_horas()">
                                    <option value="00" selected>00</option>
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
                                <strong>:</strong>
                                <input type="text" class="form-control col-md-2" required="" name="minutosini"
                                    id="minutosini" aria-describedby="helpId" value="00" placeholder="00"
                                    autocomplete="off" style="width: inherit;" Onchange="conteo_horas()">


                                <select name="horario1" id="horario1" class="form-control col-md-3" Onchange="conteo_horas()">
                                    <option value="" selected selected disabled="true"></option>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>


                            </div>
                            <strong>a</strong>
                            <div class="grupouno" style="display: flex;justify-content: space-around;">

                                <div class="grupouno" style="display: flex;justify-content: space-around;">
                                    <select name="horafin" id="horafin" class="form-control col-md-3"
                                    Onchange="conteo_horas()">
                                        <option value="00" selected>00</option>
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
                                    <strong>:</strong>
                                    <input type="text" class="form-control col-md-2" required="" name="minutosfin"
                                        id="minutosfin" aria-describedby="helpId" placeholder="00" autocomplete="off"
                                        style="width: inherit;" value="00" Onchange="conteo_horas()">


                                    <select name="horario2" id="horario2" class="form-control col-md-3"
                                    Onchange="conteo_horas()">
                                        <option value="" selected disabled="true"></option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>

                                <input class="btn btn-success float-right col-md-4" id="intervalo" type="button"
                                    value="Agregar Intervalo">
                            </div>


                        </div>
                    </div>

                    <div class="collapse" id="CollapseExample1" aria-expanded="false">
                        <div class="form-group">
                            <label for="hora">intervalo</label>
                            <div class="todo" style="display: flex;justify-content: space-around;">

                                <div class="grupouno" style="display: flex;justify-content: space-around;">
                                    <select name="intervalo_horaini" id="intervalo_horaini"
                                        class="form-control col-md-3" Onchange="conteo_horas()">
                                        <option value="00" selected>00</option>
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
                                    <strong>:</strong>
                                    <input type="text" class="form-control col-md-2" required="" name="intervalo_minini"
                                        id="intervalo_minini" aria-describedby="helpId" placeholder="00"
                                        autocomplete="off" style="width: inherit;" value="00" Onchange="conteo_horas()">


                                    <select name="horario_intervalo1" id="horario_intervalo1"
                                        class="form-control col-md-3" Onchange="conteo_horas()">
                                        <option value="" selected disabled="true"></option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>


                                </div>
                                <strong>a</strong>
                                <div class="grupouno" style="display: flex;justify-content: space-around;">

                                    <div class="grupouno" style="display: flex;justify-content: space-around;">
                                        <select name="intervalo_horafin" id="intervalo_horafin"
                                            class="form-control col-md-3" Onchange="conteo_horas()">
                                            <option value="00" selected>00</option>
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
                                        <strong>:</strong>
                                        <input type="text" class="form-control col-md-2" required=""
                                            name="intervalo_minfin" id="intervalo_minfin" aria-describedby="helpId"
                                            placeholder="00" autocomplete="off" style="width: inherit;" value="00"
                                            Onchange="conteo_horas()">


                                        <select name="horario_intervalo2" id="horario_intervalo2"
                                            class="form-control col-md-3" Onchange="conteo_horas()">
                                            <option value="" selected disabled="true"></option>
                                            <option value="AM">AM</option>
                                            <option value="PM">PM</option>
                                        </select>
                                    </div>
                                    <div class="container">
                                    </div>
                                    <div class="container">

                                    </div>
                                    <div class="container">
                                    </div>
                                    <div class="container">

                                    </div>
                                    <div class="container">
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_horas">Total de horas </label>
                        <input type="text" class="form-control col-md-9 " required="" name="total_horas"
                            id="total_horas" aria-describedby="helpId" placeholder="" autocomplete="off"
                            disabled="true">
                    </div>

                    <div class="form-group">
                        <label for="total_citas">Agregue el total de citas </label>
                        <input type="text" class="form-control col-md-9 " required="" name="total_citas"
                            id="total_citas" aria-describedby="helpId" placeholder="" autocomplete="off" enabled>
                    </div>


                    <div class="form-group">
                        <label for="comentarios">Comentarios </label>
                        <input type="text" class="form-control col-md-9" required="" name="comentarios" id="comentarios"
                            aria-describedby="helpId" placeholder="" autocomplete="off">
                    </div>

                    <input type="hidden" class="oculto"value="" id="horainicio" name="horainicio"></input>
                    <input type="hidden" class="oculto"value="" id="horafinal" name="horafinal"></input>
                    <input type="hidden" class="oculto"value="" id="intervaloinicio" name="intervaloinicio"></input>
                    <input type="hidden" class="oculto"value="" id="intervalofinal" name="intervalofinal"></input>
                    <input type="hidden" class="oculto"value="" id="total_horas_realizadas" name="total_horas_realizadas"></input>
                    <input type="hidden" class="oculto"value="" id="intervalo_activo" name="intervalo_activo"></input>
                    <input type="hidden" class="oculto"value="" id="id_registro" name="id_registro"></input>
                    <input type="hidden" class=""value="{{$cupo->id}}" id="cupo_id" name="cupo_id"></input>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="guardar_registro">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection