@extends('layouts.app')
@section('content')
<script src="{{ asset('js/reporteHoras.js') }}" defer></script>

<div class="container">
    <div class="card">
        <div class="card-body text-aline" style="justify-content: center">
            <form class="form-inline" id="formFechas">
                <div class="form-group mb-2">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Fecha Inicio</label>
                    <input type="date" class="form-control" value="" id="fechainicio" name="fechainicio">
                </div>

                <div class="form-group mx-sm-3 mb-2">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Fecha Final</label>
                    <input type="date" class="form-control" id="fechafinal" name="fechafinal" placeholder="">
                </div>
                <button type="button" class="btn  btn-success mb-2" id="btnReporte">Reporte Agentes</button>
                </br>

                <div class="form-group mx-sm-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="desactivar">
                        <label class="form-check-label" for="flexCheckDefault">
                         Desactivar agentes
                        </label>
                    </div>
                </div>
                <button type="button" class="btn  btn-success mb-2" id="excel" style="margin: auto;">Excel</button>



            </form>
        </div>
    </div>
</div>


<idv class="col-md-12 table-responsive">
    <table id="registro_horas"
        class="table table-striped table-bordered dt-responsive nowrap datatable text-center table-sm" class="display"
        cellspacing="0" cellpadding="3" width="100%" style="background-color: ">
        <thead>
            <tr>
                <th class="col-md-2">Nombre</th>
                <th class="col-md-2">Fecha</th>
                <th class="col-md-2">Hora inicio / Hora fin</th>
                <th class="col-md-2"> Horas</th>
                <th class="col-md-2"> Citas</th>
            </tr>
        </thead>
        <tbody id="insertadatoshoras" scope="row">
        </tbody>
    </table>
    </div>
    @endsection