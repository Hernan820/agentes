@extends('layouts.app')
@section('content')
<script src="{{ asset('js/usuarios.js') }}" defer></script>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registro de Usuarios</div>

                <div class="card-body">
                    <form method="POST" id="formregistrousuarios" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombres') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="off" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('Correo Electronico') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="emailnuevo"
                                    autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cars" class="col-md-4 col-form-label text-md-right">Roles:</label>

                            <div class="col-md-6">
                                <select name="rol" id="rol" class="form-control @error('email') is-invalid @enderror">
                                    <option value="" selected>Roles</option>
                                    <option value="administrador">Administrator</option>
                                    <option value="agente">Agente&nbsp;</option>>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" name="password_confirm" type="password"
                                    class="form-control password_confimar" name="password_confirmation" required
                                    autocomplete="new-password">
                            </div>
                        </div>
                        <input type="hidden" id="estado_user" name="estado_user" value="1">
                        <input type="hidden" id="id_user" name="id_user" value="">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4" id="botones">
                                <button type="button" id="guardarusuario" class="btn btn-primary">
                                    Registrar
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <div class="col-md-12 table-responsive">
            <table id="usuarios" class="table table-striped table-bordered dt-responsive nowrap datatable">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="insertarUsusarios" scope="row">
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection