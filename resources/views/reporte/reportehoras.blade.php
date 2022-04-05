@extends('layouts.app')
@section('content')
<script src="{{ asset('js/reporteHoras.js') }}" defer></script>

<div class="container">
    <div class="card">
        <div class="card-body text-aline" style="justify-content: center">
            <form class="form-inline" id="formFechas">
                <div class="form-group mb-2">
                <label class="mr-sm-2" for="inlineFormCustomSelect">Fecha inicio</label>
                    <input type="date"  class="form-control" 
                        value="" id="fechainicio" name= "fechainicio">
                </div>

                <div class="form-group mx-sm-3 mb-2">
                <label class="mr-sm-2" for="inlineFormCustomSelect">Fecha final</label>
                    <input type="date" class="form-control" id="fechafinal" name="fechafinal" placeholder="">
                </div>
                <button type="button" class="btn  btn-success mb-2" id="btnReporte" Onchange="reportehoras()" >Reporte Agentes</button>
            </form>
        </div>
    </div>
</div>


<idv class="col-md-12 table-responsive">
        <table id="registro_horas" class="table table-striped table-bordered dt-responsive nowrap datatable text-center table-sm"
            class="display" cellspacing="0" cellpadding="3" width="100%"  style="background-color: ">
            <thead>
                <tr>
                    <th class="col-md-2">Nombre</th>
                    <th class="col-md-2">Fecha inicio</th>
                    <th class="col-md-2">Fecha final</th>
                    <th class="col-md-2">Total Horas</th>
                    <th class="col-md-2">Total Citas</th>
                </tr>
            </thead>
            <tbody id="insertadatoshoras" scope="row">
             </tbody>
        </table>
</div>  
@endsection