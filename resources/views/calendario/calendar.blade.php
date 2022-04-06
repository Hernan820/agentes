@extends('layouts.app')
@section('content')
<script src="{{ asset('js/calendario.js') }}" defer></script>

@if(@Auth::user()->hasRole('administrador'))
   <style>
    .fc-custom2-button{
        display:show !important;
    }
    </style>
@else
<style>
    .fc-custom2-button{
        display:none !important;
    }
    </style>
@endif

<div class="container  col-md-9">
    <div class="cards">
        <div id="calendario"></div>

    </div>
</div>

<!-- Modal cupos -->
<div class="modal fade" id="modal_cupo" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                <form action="" id="formcupo">

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
                <button type="button" class="btn btn-success" id="guardarcupo">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection