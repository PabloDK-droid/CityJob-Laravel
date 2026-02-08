@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registro CityJob') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="rol" class="col-md-4 col-form-label text-md-end">Tipo de Usuario</label>
                            <div class="col-md-6">
                                <select id="rol" class="form-select" name="rol" onchange="toggleFormFields()" required>
                                    <option value="cliente">Quiero contratar servicios (Cliente)</option>
                                    <option value="trabajador">Quiero ofrecer mis servicios (Profesionista)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nombres" class="col-md-4 col-form-label text-md-end">Nombre(s)</label>
                            <div class="col-md-6">
                                <input id="nombres" type="text" class="form-control" name="nombres" required autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="apellido_p" class="col-md-4 col-form-label text-md-end">Apellido Paterno</label>
                            <div class="col-md-6">
                                <input id="apellido_p" type="text" class="form-control" name="apellido_p" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="apellido_m" class="col-md-4 col-form-label text-md-end">Apellido Materno</label>
                            <div class="col-md-6">
                                <input id="apellido_m" type="text" class="form-control" name="apellido_m">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="correo_electronico" class="col-md-4 col-form-label text-md-end">Correo Electrónico</label>
                            <div class="col-md-6">
                                <input id="correo_electronico" type="email" class="form-control" name="correo_electronico" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telefono" class="col-md-4 col-form-label text-md-end">Teléfono</label>
                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control" name="telefono" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cp" class="col-md-4 col-form-label text-md-end">Código Postal (CP)</label>
                            <div class="col-md-6">
                                <input id="cp" type="number" class="form-control" name="cp" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="domicilio" class="col-md-4 col-form-label text-md-end">Domicilio Completo</label>
                            <div class="col-md-6">
                                <input id="domicilio" type="text" class="form-control" name="domicilio" required>
                            </div>
                        </div>

                        <div id="section-profesionista" style="display: none;">
                            <div class="row mb-3">
                                <label for="nivel_estudios" class="col-md-4 col-form-label text-md-end">Nivel de Estudios</label>
                                <div class="col-md-6">
                                    <input id="nivel_estudios" type="text" class="form-control" name="nivel_estudios">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="especializado" class="col-md-4 col-form-label text-md-end">Especialidad</label>
                                <div class="col-md-6">
                                    <input id="especializado" type="text" class="form-control" name="especializado">
                                </div>
                            </div>
                        </div>

                        <div id="section-cliente">
                            <div class="row mb-3">
                                <label for="referencias" class="col-md-4 col-form-label text-md-end">Referencias de Domicilio</label>
                                <div class="col-md-6">
                                    <input id="referencias" type="text" class="form-control" name="referencias">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contrasena" class="col-md-4 col-form-label text-md-end">Contraseña</label>
                            <div class="col-md-6">
                                <input id="contrasena" type="password" class="form-control" name="contrasena" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contrasena_confirmation" class="col-md-4 col-form-label text-md-end">Confirmar Contraseña</label>
                            <div class="col-md-6">
                                <input id="contrasena_confirmation" type="password" class="form-control" name="contrasena_confirmation" required>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar en CityJob') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFormFields() {
    const rol = document.getElementById('rol').value;
    const profSection = document.getElementById('section-profesionista');
    const clientSection = document.getElementById('section-cliente');

    if (rol === 'trabajador') {
        profSection.style.display = 'block';
        clientSection.style.display = 'none';
    } else {
        profSection.style.display = 'none';
        clientSection.style.display = 'block';
    }
}
</script>
@endsection