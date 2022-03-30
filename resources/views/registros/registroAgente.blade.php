@extends('layouts.app')
@section('content')
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
</style>





<div class="col-md-12">
    <div class="jumbotron col-md-12 col d-flex justify-content-between ">
        <h2><strong> Lista de control de Horas&nbsp; &nbsp; &nbsp; Fecha:
                &nbsp;{{ \Carbon\Carbon::parse($cupo->start)->isoformat('dddd D \d\e MMMM \d\e\l Y')}}</strong> </h2>
        <input class="btn btn-success float-right " id="registro" type="submit" value="Crear registro">
    </div>



    <idv class="col-md-12 table-responsive">
        <table id="registro_horas" class="table table-striped table-bordered dt-responsive nowrap datatable">
            <thead>
                <tr>
                    <th class="col-md-2">Nombre</th>
                    <th class="col-md-2">Total Horas</th>
                    <th class="col-md-2">Total Citas</th>
                    <th class="col-md-3">Comentario</th>
                    <th class="col-md-3"></th>
                </tr>
            </thead>
        </table>
</div>
</div>


<!-- Modal registro de horas -->

<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modalcup" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Registro de horas de usuario
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="registroHora">

                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="hora">Hora de inicio y Hora de fin </label>

                        <div class="todo" style="display: flex;justify-content: space-around;">

                            <div class="grupouno" style="display: flex;justify-content: space-around;">
                                <select name="horaini" id="horaini" class="form-control col-md-3">
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
                                    id="minutosini" aria-describedby="helpId" value="00" placeholder="00" autocomplete="off"
                                    style="width: inherit;">


                                <select name="horario1" id="horario1" class="form-control col-md-3">
                                <option value="" selected  selected disabled ="true">seleccione</option>
                                    <option value="AM" >AM</option>
                                    <option value="PM">PM</option>
                                </select>


                            </div>
                            <strong>a</strong>
                            <div class="grupouno" style="display: flex;justify-content: space-around;">

                                <div class="grupouno" style="display: flex;justify-content: space-around;">
                                    <select name="horafin" id="horafin" class="form-control col-md-3">
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
                                        style="width: inherit;" value="00">


                                    <select name="horario2" id="horario2" class="form-control col-md-3" onchange="conteo_horas()">
                                    <option value=""   selected disabled ="true">seleccione</option>
                                        <option value="AM" selected>AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>

                                <input class="btn btn-success float-right" id="intervalo" type="button"
                                    value="Agregar Intervalo">
                            </div>


                        </div>
                    </div>

                    <div class="collapse" id="CollapseExample1">
                        <div class="form-group">
                            <label for="hora">intervalo</label>
                            <div class="todo" style="display: flex;justify-content: space-around;">

                                <div class="grupouno" style="display: flex;justify-content: space-around;">
                                    <select name="intervalo_horaini" id="intervalo_horaini"
                                        class="form-control col-md-3">
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
                                        autocomplete="off" style="width: inherit;" value="00">


                                    <select name="horario_intervalo1" id="horario_intervalo1"
                                        class="form-control col-md-3">
                                        <option value=""   selected disabled ="true">seleccione</option>
                                        <option value="AM" selected>AM</option>
                                        <option value="PM">PM</option>
                                    </select>


                                </div>
                                <strong>a</strong>
                                <div class="grupouno" style="display: flex;justify-content: space-around;">

                                    <div class="grupouno" style="display: flex;justify-content: space-around;">
                                        <select name="intervalo_horafin" id="intervalo_horafin"
                                            class="form-control col-md-3">
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
                                            placeholder="00" autocomplete="off" style="width: inherit;" value="00">


                                        <select name="horario_intervalo2" id="horario_intervalo2"
                                            class="form-control col-md-3"  onchange="conteo_horas()">
                                            <option value=""   selected disabled ="true">seleccione</option>
                                            <option value="AM" selected>AM</option>
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
                        <input type="text" class="form-control col-md-9 " required="" name="total_horas" id="total_horas"
                            aria-describedby="helpId" placeholder="" autocomplete="off" disabled ="true">
                    </div>

                    <div class="form-group">
                        <label for="total_citas">Agregue el total de citas </label>
                        <input type="text" class="form-control col-md-9 " required="" name="total_citas" id="total_citas"
                            aria-describedby="helpId" placeholder="" autocomplete="off" enabled>
                    </div>


                    <div class="form-group">
                        <label for="comentarios">Comentarios </label>
                        <input type="text" class="form-control col-md-9" required="" name="comentarios" id="comentarios"
                            aria-describedby="helpId" placeholder="" autocomplete="off">
                    </div>

                    <input type="hidden" value="" id="horainicio" name="horainicio"></input>
                    <input type="hidden" value="" id="horafinal" name="horafinal"></input>
                    <input type="hidden" value="" id="intervaloinicio" name="intervaloinicio"></input>
                    <input type="hidden" value="" id="intervalofinal" name="intervalofinal"></input>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="guardar_registro">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection