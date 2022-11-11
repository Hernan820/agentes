@extends('layouts.app')
@section('content')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.css">

<script src="{{ asset('js/horarios.js') }}" defer></script>


                            <!-- ***************************************************

<div class="container-fluid">

<div class="table-responsive">
        <div class="col-md-12 table-responsive">

        <table id="tblclientesrate" class="table table-striped table-bordered dt-responsive nowrap  datatable table-sm">
            <thead class="">
                <tr>
                   <th class="col-md-1" style="">USUARIOS</th>
                    <th class="col-md-1" style="">LUNES</th>
                    <th class="col-md-1" style="">MARTES</th>
                    <th class="col-md-1" style="">MIERCOLES</th>
                    <th class="col-md-1" style="">JUEVES</th>
                    <th class="col-md-1" style="">VIERNES</th>
                    <th class="col-md-1" style="">SABADO</th>
                    <th class="col-md-1" style="">DOMINGO</th>
                    <th class="col-md-1" style="">OPCIONES</th>
                </tr>
            </thead>
            <tbody id="" scope="row">
            </tbody>
        </table>
    </div>
</div>
</div>
 -->

 <div class="container">
    <div class="col-12 text-center">
        <div class="f-3">
            <h1>

            <strong>
            CALENDARIO DE HORARIOS
            </strong>
            </h1>

        </div>
    </div>
 </div>


 <div class="container  col-md-9">
    <div class="cards">
        <div id="horarios"></div>

    </div>
</div>


<!-- Modal cupos -->
<div class="modal fade" id="modal_cupo_horario" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog " id="modalcup" role="document">
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
                    <div class="row">
                        <div class="col">
                            <div class="form-group " id="controlfecha">
                                <label for="start">Fecha inicio</label>
                                <div id="control" style="display:flex;justify-content: space-around;">
                                    <input type="date" class="form-control" min="" name="start" id="start"
                                        aria-describedby="helpId" placeholder="">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="nombre">Fecha final</label>
                                <input type="date" class="form-control" required="" name="end" id="end"
                                    aria-describedby="helpId" placeholder="" autocomplete="off">
                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="guardarcupohorario">Crear</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


@endsection
