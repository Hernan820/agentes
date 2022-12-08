@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="{{ asset('js/horarios.js') }}" defer></script>

<style>
.horarioporusuario {
    max-width: 80% !important;
}

.editahorariousuario{
/*max-width: 50% !important;*/
}

.p-3 {
    padding: 1.9rem !important;
}
</style>
<script type="text/javascript">
var rango = jQuery.noConflict();

rango(function() {
    rango('#rango_fechas').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    rango('#rango_fechas').on('apply.daterangepicker', function(ev, picker) {
        var ini = moment(picker.startDate.format('YYYY-MM-DD'));
        var fin = moment(picker.endDate.format('YYYY-MM-DD'));
        if (ini != undefined && fin != undefined) {

            var fechas = [];
            while (ini.isSameOrBefore(fin)) {
                fechas.push(ini.format('M/D/YYYY'));
                ini.add(1, 'days');
            }
            if (fechas.length != 7) {
                Swal.fire("¡Debe agregar 7 dias que conforma una semana!");
                rango(this).val('');
                return;
            }
        }

        rango('#rango_fechas').val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate
            .format('MM/DD/YYYY'));
    });

    rango('#rango_fechas').on('cancel.daterangepicker', function(ev, picker) {
        rango(this).val('');
    });

});
</script>

<div class="container rounded border border-primary">
    <div class="col-12">
        <label for="week" class="text-dark">Seleccione una semana</label><br>

        <input type="week" class="form-control col-2" name="semana" id="semana" value="" />

    </div>
    <div class="col-12 text-center">

        <div class="f-3">

            <h1>
                <strong>
                    CALENDARIO DE HORARIOS
                </strong>
                <button type="button" class="btn btn-primary float-right " id="horariodeusuario">
                    crear horario
                </button>
            </h1>

        </div>
    </div>
</div>
<br><br>

<div class="container rounded ">
    <div class="row">
        <div class="col">
            <h3 id="titulohorario" class="mb-3" style="background:#d5a6bd"   ></h3>
        </div>
        <table id="tablehorariosusario" class="table table-striped">
            <thead>
                <tr id="dias" class="mb-0 p-0" style="color:black">

                </tr>
            </thead>
            <tbody id="filausuario">

            </tbody>
        </table>
    </div>
</div>



<!-- Modal cupos -->
<div class="modal fade" id="modal_cupo_horario" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-lg horarioporusuario" id="modalcup" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Crear cupos por rango
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formcupohorario">

                    {!! csrf_field() !!}

                    <div class="row text-center d-flex">
                        <div class="col">
                            <div class="form-group">
                                <label for="rango_fechas">Elije un rango de fechas </label>
                                <input type="week" class="form-control col-8" name="semanausuario" id="semanausuario" value="" />

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="total_horas">Usuarios </label>
                                <select name="usuarios" id="usuarios" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col p-1">
                            <div class="form-group p-3">
                                <button type="button" class="btn btn-success" id="crearhorario">Crear horarios</button>
                            </div>
                        </div>
                    </div>


                    <div id="tablahorarios">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="lunes" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">Lunes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="martes" data-toggle="tab" href="#formmartes" role="tab"
                                    aria-controls="profile" aria-selected="false">Martes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="miercoles" data-toggle="tab" href="#formmiercoles" role="tab"
                                    aria-controls="contact" aria-selected="false">Miercoles</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="jueves" data-toggle="tab" href="#formjueves" role="tab"
                                    aria-controls="profile" aria-selected="false">Jueves</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="viernes" data-toggle="tab" href="#fomrviernes" role="tab"
                                    aria-controls="contact" aria-selected="false">Viernes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sabado" data-toggle="tab" href="#formsabado" role="tab"
                                    aria-controls="profile" aria-selected="false">Sabado</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="domingo" data-toggle="tab" href="#formdomingo" role="tab"
                                    aria-controls="contact" aria-selected="false">Domingo</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="lunes">

                                <br>
                                <div class="form-group">
                                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Total de horas</div>
                                        </div>
                                        <input type="text" class="form-control col-4" id="totalhorasdia1" placeholder=""
                                            name="totalhorasdia1">
                                    </div>
                                </div>

                                <div class="col-12 text-center mb-0">
                                    <strong>
                                        <h4 id="titulo1">lunes</h4>
                                    </strong>
                                </div>

                                <div class="form-group" id="">
                                    <form id="formdia1">

                                        <table class="table table-striped  table-responsive-lg table-sm tablehoras"
                                            id="tabladia1">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-4 text-center">Hora inicial</th>
                                                    <th class="col-md-4 text-center">Hora final</th>
                                                    <th class="col-md-3"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="fila1">
                                                <tr class="fila-fija " id="fila1">
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini[]" id="horaini"
                                                                class="form-control col-md-3 horas1 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas1 minutitos entrada"
                                                                required="" name="minutosini[]" id="minutosini"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" min="0" max="59" style="width:100%">

                                                            <select name="horarioini[]" id="horario1"
                                                                class="form-control col-md-3 horas1 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>

                                                        </div>
                                                    </td>
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini2[]" id="horaini2"
                                                                class="form-control col-md-3 horas1 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas1 entrada" required=""
                                                                name="minutosini2[]" id="minutosini2"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" style="width:100%" min="0" max="59">


                                                            <select name="horarioini2[]" id="horario2"
                                                                class="form-control col-md-3 horas1 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    </td>
                                                    <td width="" id="agregar1" class="horas1 botonagrega">
                                                        <input type="button" id="btnagregar1"
                                                            class="btn btn-success masmenos " value="agregar intervalo">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>
                                        <div class="form-check col-md-3" for=""
                                            style="padding-left: 7.25rem  !important; color: black !important;   background: #33ECFF  !important;">
                                            <input class="form-check-input offdia" for="" type="checkbox" value="1"
                                                id="diaoff1">
                                            <label class="form-check-label" for="">
                                                DIA OFF
                                            </label>
                                        </div>

                                        <input type="hidden" value="" id="fechadia1" name="fechadia1"></input>
                                        <input type="hidden" value="" id="horas_iniciales_dia1"
                                            name="horas_iniciales_dia1"></input>
                                        <input type="hidden" value="" id="horas_finales_dia1"
                                            name="horas_finales_dia1"></input>
                                        <input type="hidden" value="" id="total_horasdia1"
                                            name="total_horasdia1"></input>
                                    </form>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="formmartes" role="tabpanel" aria-labelledby="martes">

                                <br>
                                <div class="form-group">
                                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Total de horas</div>
                                        </div>
                                        <input type="text" class="form-control col-4" id="totalhorasdia2" placeholder=""
                                            name="totalhorasdia2">
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <strong>
                                        <h4 id="titulo2">Martes</h4>
                                    </strong>
                                </div>

                                <div class="form-group" id="">
                                    <form id="formdia2">

                                        <table class="table table-striped  table-responsive-lg table-sm tablehoras"
                                            id="tabladia2">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-4 text-center">Hora inicial</th>
                                                    <th class="col-md-4 text-center">Hora final</th>
                                                    <th class="col-md-3"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="fila1">
                                                <tr class="fila-fija " id="fila1">
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini[]" id="horaini"
                                                                class="form-control col-md-3 horas2 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas2 minutitos entrada"
                                                                required="" name="minutosini[]" id="minutosini"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" min="0" max="59" style="width:100%">

                                                            <select name="horarioini[]" id="horario1"
                                                                class="form-control col-md-3 horas2 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>

                                                        </div>
                                                    </td>
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini2[]" id="horaini2"
                                                                class="form-control col-md-3 horas2 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas2 entrada" required=""
                                                                name="minutosini2[]" id="minutosini2"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" style="width:100%" min="0" max="59">


                                                            <select name="horarioini2[]" id="horario2"
                                                                class="form-control col-md-3 horas2 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    </td>
                                                    <td width="" id="agregar2" class="botonagrega">
                                                        <input type="button" id="btnagregar2"
                                                            class="btn btn-success masmenos " value="agregar intervalo">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>
                                        <div class="form-check col-md-3" for=""
                                            style="padding-left: 7.25rem  !important; color: black !important;   background: #33ECFF  !important;">
                                            <input class="form-check-input offdia" for="" type="checkbox" value="1"
                                                id="diaoff2">
                                            <label class="form-check-label" for="">
                                                DIA OFF
                                            </label>
                                        </div>

                                        <input type="hidden" value="" id="fechadia2" name="fechadia2"></input>
                                        <input type="hidden" value="" id="horas_iniciales_dia2"
                                            name="horas_iniciales_dia2"></input>
                                        <input type="hidden" value="" id="horas_finales_dia2"
                                            name="horas_finales_dia2"></input>
                                        <input type="hidden" value="" id="total_horasdia2"
                                            name="total_horasdia2"></input>
                                    </form>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="formmiercoles" role="tabpanel" aria-labelledby="miercoles">

                                <br>
                                <div class="form-group">
                                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Total de horas</div>
                                        </div>
                                        <input type="text" class="form-control col-4" id="totalhorasdia3" placeholder=""
                                            name="totalhorasdia3">
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <strong>
                                        <h4 id="titulo3">Miercoles</h4>
                                    </strong>
                                </div>

                                <div class="form-group" id="">
                                    <form id="formdia3">

                                        <table class="table table-striped  table-responsive-lg table-sm tablehoras"
                                            id="tabladia3">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-4 text-center">Hora inicial</th>
                                                    <th class="col-md-4 text-center">Hora final</th>
                                                    <th class="col-md-3"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="fila1">
                                                <tr class="fila-fija " id="fila1">
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini[]" id="horaini"
                                                                class="form-control col-md-3 horas3 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas3 minutitos entrada"
                                                                required="" name="minutosini[]" id="minutosini"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" min="0" max="59" style="width:100%">

                                                            <select name="horarioini[]" id="horario1"
                                                                class="form-control col-md-3 horas3 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>

                                                        </div>
                                                    </td>
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini2[]" id="horaini2"
                                                                class="form-control col-md-3 horas3 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas3 entrada" required=""
                                                                name="minutosini2[]" id="minutosini2"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" style="width:100%" min="0" max="59">


                                                            <select name="horarioini2[]" id="horario2"
                                                                class="form-control col-md-3 horas3 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    </td>
                                                    <td width="" id="agregar3" class="botonagrega">
                                                        <input type="button" id="btnagregar3"
                                                            class="btn btn-success masmenos " value="agregar intervalo">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>
                                        <div class="form-check col-md-3" for=""
                                            style="padding-left: 7.25rem  !important; color: black !important;   background: #33ECFF  !important;">
                                            <input class="form-check-input offdia" for="" type="checkbox" value="1"
                                                id="diaoff3">
                                            <label class="form-check-label" for="">
                                                DIA OFF
                                            </label>
                                        </div>

                                        <input type="hidden" value="" id="fechadia3" name="fechadia3"></input>
                                        <input type="hidden" value="" id="horas_iniciales_dia3"
                                            name="horas_iniciales_dia3"></input>
                                        <input type="hidden" value="" id="horas_finales_dia3"
                                            name="horas_finales_dia3"></input>
                                        <input type="hidden" value="" id="total_horasdia3"
                                            name="total_horasdia3"></input>
                                    </form>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="formjueves" role="tabpanel" aria-labelledby="jueves">
                                <br>
                                <div class="form-group">
                                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Total de horas</div>
                                        </div>
                                        <input type="text" class="form-control col-4" id="totalhorasdia4" placeholder=""
                                            name="totalhorasdia4">
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <strong>
                                        <h4 id="titulo4">Jueves</h4>
                                    </strong>
                                </div>

                                <div class="form-group" id="">
                                    <form id="formdia4">

                                        <table class="table table-striped  table-responsive-lg table-sm tablehoras"
                                            id="tabladia4">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-4 text-center">Hora inicial</th>
                                                    <th class="col-md-4 text-center">Hora final</th>
                                                    <th class="col-md-3"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="fila1">
                                                <tr class="fila-fija " id="fila1">
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini[]" id="horaini"
                                                                class="form-control col-md-3 horas4 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas4 minutitos entrada"
                                                                required="" name="minutosini[]" id="minutosini"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" min="0" max="59" style="width:100%">

                                                            <select name="horarioini[]" id="horario1"
                                                                class="form-control col-md-3 horas4 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>

                                                        </div>
                                                    </td>
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini2[]" id="horaini2"
                                                                class="form-control col-md-3 horas4 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas4 entrada" required=""
                                                                name="minutosini2[]" id="minutosini2"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" style="width:100%" min="0" max="59">


                                                            <select name="horarioini2[]" id="horario2"
                                                                class="form-control col-md-3 horas4 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    </td>
                                                    <td width="" id="agregar4" class="botonagrega">
                                                        <input type="button" id="btnagregar4"
                                                            class="btn btn-success masmenos " value="agregar intervalo">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>
                                        <div class="form-check col-md-3" for=""
                                            style="padding-left: 7.25rem  !important; color: black !important;   background: #33ECFF  !important;">
                                            <input class="form-check-input offdia" for="" type="checkbox" value="1"
                                                id="diaoff4">
                                            <label class="form-check-label" for="">
                                                DIA OFF
                                            </label>
                                        </div>

                                        <input type="hidden" value="" id="fechadia4" name="fechadia4"></input>
                                        <input type="hidden" value="" id="horas_iniciales_dia4"
                                            name="horas_iniciales_dia4"></input>
                                        <input type="hidden" value="" id="horas_finales_dia4"
                                            name="horas_finales_dia4"></input>
                                        <input type="hidden" value="" id="total_horasdia4"
                                            name="total_horasdia4"></input>
                                    </form>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="fomrviernes" role="tabpanel" aria-labelledby="viernes">
                                <br>
                                <div class="form-group">
                                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Total de horas</div>
                                        </div>
                                        <input type="text" class="form-control col-4" id="totalhorasdia5" placeholder=""
                                            name="totalhorasdia5">
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <strong>
                                        <h4 id="titulo5">Viernes</h4>
                                    </strong>
                                </div>

                                <div class="form-group" id="">
                                    <form id="formdia5">

                                        <table class="table table-striped  table-responsive-lg table-sm tablehoras"
                                            id="tabladia5">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-4 text-center">Hora inicial</th>
                                                    <th class="col-md-4 text-center">Hora final</th>
                                                    <th class="col-md-3"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="fila1">
                                                <tr class="fila-fija " id="fila1">
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini[]" id="horaini"
                                                                class="form-control col-md-3 horas5 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas5 minutitos entrada"
                                                                required="" name="minutosini[]" id="minutosini"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" min="0" max="59" style="width:100%">

                                                            <select name="horarioini[]" id="horario1"
                                                                class="form-control col-md-3 horas5 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>

                                                        </div>
                                                    </td>
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini2[]" id="horaini2"
                                                                class="form-control col-md-3 horas5 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas5 entrada" required=""
                                                                name="minutosini2[]" id="minutosini2"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" style="width:100%" min="0" max="59">


                                                            <select name="horarioini2[]" id="horario2"
                                                                class="form-control col-md-3 horas5 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    </td>
                                                    <td width="" id="agregar5" class="botonagrega">
                                                        <input type="button" id="btnagregar5"
                                                            class="btn btn-success masmenos " value="agregar intervalo">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>
                                        <div class="form-check col-md-3" for=""
                                            style="padding-left: 7.25rem  !important; color: black !important;   background: #33ECFF  !important;">
                                            <input class="form-check-input offdia" for="" type="checkbox" value="1"
                                                id="diaoff5">
                                            <label class="form-check-label" for="">
                                                DIA OFF
                                            </label>
                                        </div>

                                        <input type="hidden" value="" id="fechadia5" name="fechadia5"></input>
                                        <input type="hidden" value="" id="horas_iniciales_dia5"
                                            name="horas_iniciales_dia5"></input>
                                        <input type="hidden" value="" id="horas_finales_dia5"
                                            name="horas_finales_dia5"></input>
                                        <input type="hidden" value="" id="total_horasdia5"
                                            name="total_horasdia5"></input>
                                    </form>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="formsabado" role="tabpanel" aria-labelledby="sabado">
                                <br>
                                <div class="form-group">
                                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Total de horas</div>
                                        </div>
                                        <input type="text" class="form-control col-4" id="totalhorasdia6" placeholder=""
                                            name="totalhorasdia6">
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <strong>
                                        <h4 id="titulo6">Sabado</h4>
                                    </strong>
                                </div>

                                <div class="form-group" id="">
                                    <form id="formdia6">

                                        <table class="table table-striped  table-responsive-lg table-sm tablehoras"
                                            id="tabladia6">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-4 text-center">Hora inicial</th>
                                                    <th class="col-md-4 text-center">Hora final</th>
                                                    <th class="col-md-3"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="fila1">
                                                <tr class="fila-fija " id="fila1">
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini[]" id="horaini"
                                                                class="form-control col-md-3 horas6 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas6 minutitos entrada"
                                                                required="" name="minutosini[]" id="minutosini"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" min="0" max="59" style="width:100%">

                                                            <select name="horarioini[]" id="horario1"
                                                                class="form-control col-md-3 horas6 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>

                                                        </div>
                                                    </td>
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini2[]" id="horaini2"
                                                                class="form-control col-md-3 horas6 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas6 entrada" required=""
                                                                name="minutosini2[]" id="minutosini2"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" style="width:100%" min="0" max="59">


                                                            <select name="horarioini2[]" id="horario2"
                                                                class="form-control col-md-3 horas6 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    </td>
                                                    <td width="" id="agregar6" class="botonagrega">
                                                        <input type="button" id="btnagregar6"
                                                            class="btn btn-success masmenos " value="agregar intervalo">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>
                                        <div class="form-check col-md-3" for=""
                                            style="padding-left: 7.25rem  !important; color: black !important;   background: #33ECFF  !important;">
                                            <input class="form-check-input offdia" for="" type="checkbox" value="1"
                                                id="diaoff6">
                                            <label class="form-check-label" for="">
                                                DIA OFF
                                            </label>
                                        </div>

                                        <input type="hidden" value="" id="fechadia6" name="fechadia6"></input>
                                        <input type="hidden" value="" id="horas_iniciales_dia6"
                                            name="horas_iniciales_dia6"></input>
                                        <input type="hidden" value="" id="horas_finales_dia6"
                                            name="horas_finales_dia6"></input>
                                        <input type="hidden" value="" id="total_horasdia6"
                                            name="total_horasdia6"></input>
                                    </form>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="formdomingo" role="tabpanel" aria-labelledby="domingo">
                                <br>
                                <div class="form-group">
                                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Total de horas</div>
                                        </div>
                                        <input type="text" class="form-control col-4" id="totalhorasdia7" placeholder=""
                                            name="totalhorasdia7">
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <strong>
                                        <h4 id="titulo7">Domingo</h4>
                                    </strong>
                                </div>

                                <div class="form-group" id="">
                                    <form id="formdia7">

                                        <table class="table table-striped  table-responsive-lg table-sm tablehoras"
                                            id="tabladia7">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-4 text-center">Hora inicial</th>
                                                    <th class="col-md-4 text-center">Hora final</th>
                                                    <th class="col-md-3"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="fila1">
                                                <tr class="fila-fija " id="fila1">
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini[]" id="horaini"
                                                                class="form-control col-md-3 horas7 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas7 minutitos entrada"
                                                                required="" name="minutosini[]" id="minutosini"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" min="0" max="59" style="width:100%">

                                                            <select name="horarioini[]" id="horario1"
                                                                class="form-control col-md-3 horas7 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>

                                                        </div>
                                                    </td>
                                                    <td width="">
                                                        <div style="display: flex;justify-content: space-around;">
                                                            <select name="horaini2[]" id="horaini2"
                                                                class="form-control col-md-3 horas7 entrada">
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

                                                            <input type="number"
                                                                class="form-control col-md-3 horas7 entrada" required=""
                                                                name="minutosini2[]" id="minutosini2"
                                                                aria-describedby="helpId" value="" placeholder="00"
                                                                autocomplete="off" style="width:100%" min="0" max="59">


                                                            <select name="horarioini2[]" id="horario2"
                                                                class="form-control col-md-3 horas7 entrada">
                                                                <option value="" selected selected disabled="true">
                                                                </option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    </td>
                                                    <td width="" id="agregar7" class="botonagrega">
                                                        <input type="button" id="btnagregar7"
                                                            class="btn btn-success masmenos " value="agregar intervalo">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>
                                        <div class="form-check col-md-3" for=""
                                            style="padding-left: 7.25rem  !important; color: black !important;   background: #33ECFF  !important;">
                                            <input class="form-check-input offdia" for="" type="checkbox" value="1"
                                                id="diaoff7">
                                            <label class="form-check-label" for="">
                                                DIA OFF
                                            </label>
                                        </div>

                                        <input type="hidden" value="" id="fechadia7" name="fechadia7"></input>
                                        <input type="hidden" value="" id="horas_iniciales_dia7"
                                            name="horas_iniciales_dia7"></input>
                                        <input type="hidden" value="" id="horas_finales_dia7"
                                            name="horas_finales_dia7"></input>
                                        <input type="hidden" value="" id="total_horasdia7"
                                            name="total_horasdia7"></input>
                                    </form>
                                </div>

                            </div>

                        </div>
                        </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="guardarhorariousuario">Agregar horario</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE EDICION DE HORARIOS DE USUARIO -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg editahorariousuario " id="modalcup" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">
                    Crear cupos por rango
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="edithorario">
                    {!! csrf_field() !!}
                    <div class="container mb-3"><h3 id="fechaedicion" class="text-center"></h3></div>
                    <div class="form-group">
                        <table class="table table-striped  table-responsive-lg table-sm tablehoras" id="tablaedicion">
                            <thead>
                                <tr>
                                    <th class="col-md-4 text-center">Hora inicial</th>
                                    <th class="col-md-4 text-center">Hora final</th>
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

                                            <select name="horarioini[]" id="horarioini"
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

                                            <select name="horarioini2[]" id="horarioini2"
                                                class="form-control col-md-3 horas entrada">
                                                <option value="" selected selected disabled="true"></option>
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>
                                        </div>
                                    </td>
                                    </td>
                                    <td width="" id="intervaloedicion" class="botonagrega">
                                        <input type="button" id="btnintervaloedicion" class="btn btn-success masmenos entrada agregaedi"
                                            value="agregar intervalo" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label for="total_de_horas">Total de horas </label>
                        <input type="text" class="form-control col-md-9 " required="" name="total_de_horas"
                            id="total_de_horas" aria-describedby="helpId" placeholder="" autocomplete="off"
                            disabled="true">
                    </div>

                    <div class="form-check col-md-3"
                        style="padding-left: 7.25rem  !important; color: black !important;   background: #33ECFF  !important;">
                        <input class="form-check-input offdia" type="checkbox" value="1" id="diaoffedicion">
                        <label class="form-check-label" for="defaultCheck1">
                            DIA OFF
                        </label>
                    </div>

                    <input type="hidden" class="oculto" value="" id="hiniciales" name="hiniciales"></input>
                    <input type="hidden" class="oculto" value="" id="hfinales" name="hfinales"></input>
                    <input type="hidden" class="oculto" value="" id="TotaDeHoras" name="TotaDeHoras"></input>
                    <input type="hidden" class="oculto" value="" id="id_registro" name="id_registro"></input>
                    
                    <input type="hidden" class="oculto" value="edicion" id="edicion" name="edicion"></input>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="gurdaedcionhorario">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


@endsection