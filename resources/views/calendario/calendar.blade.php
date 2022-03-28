@extends('layouts.app')
@section('content')
<script src="{{ asset('js/calendario.js') }}" defer></script>



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
                    Crear Cupo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formcupo">

                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col">
                            <div class="form-group " id="controlfecha">
                                <label for="start">Fecha</label>
                                <div id="control" style="display:flex;justify-content: space-around;">
                                    <input type="date" class="form-control" min="" name="start" id="start"
                                        aria-describedby="helpId" placeholder="">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="nombre">Nombre de cupo </label>
                                <input type="text" class="form-control" required="" name="nombre" id="nombre"
                                    aria-describedby="helpId" placeholder="nombre" autocomplete="off">
                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="guardarcupo">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection