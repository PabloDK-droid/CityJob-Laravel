@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registro CityJob') }}</div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="/register">
                        @csrf

                        <div class="row mb-3">
                            <label for="rol" class="col-md-4 col-form-label text-md-end">Tipo de Usuario</label>
                            <div class="col-md-6">
                                <select id="rol" class="form-select" name="rol" onchange="toggleFormFields()" required>
                                    <option value="">Selecciona...</option>
                                    <option value="cliente">Quiero contratar servicios</option>
                                    <option value="trabajador">Quiero ofrecer mis servicios</option>
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
                            <label for="genero" class="col-md-4 col-form-label text-md-end">Género</label>
                            <div class="col-md-6">
                                <select id="genero" class="form-select" name="genero" required>
                                    <option value="">Selecciona...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telefono" class="col-md-4 col-form-label text-md-end">Teléfono</label>
                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control" name="telefono" required placeholder="10 dígitos">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telefono_fijo" class="col-md-4 col-form-label text-md-end">Teléfono Fijo (opcional)</label>
                            <div class="col-md-6">
                                <input id="telefono_fijo" type="text" class="form-control" name="telefono_fijo" placeholder="10 dígitos">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="correo_electronico" class="col-md-4 col-form-label text-md-end">Correo Electrónico</label>
                            <div class="col-md-6">
                                <input id="correo_electronico" type="email" class="form-control" name="correo_electronico" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cp" class="col-md-4 col-form-label text-md-end">Código Postal</label>
                            <div class="col-md-6">
                                <input id="cp" type="number" class="form-control" name="cp" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="domicilio" class="col-md-4 col-form-label text-md-end">Domicilio</label>
                            <div class="col-md-6">
                                <input id="domicilio" type="text" class="form-control" name="domicilio" required placeholder="Calle, número, colonia">
                            </div>
                        </div>

                        <!-- Campos específicos para CLIENTE -->
                        <div id="campos_cliente" style="display: none;">
                            <div class="row mb-3">
                                <label for="referencias" class="col-md-4 col-form-label text-md-end">Referencias</label>
                                <div class="col-md-6">
                                    <textarea id="referencias" class="form-control" name="referencias" rows="3" placeholder="Referencias de ubicación"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Campos específicos para TRABAJADOR -->
                        <div id="campos_trabajador" style="display: none;">
                            <div class="row mb-3">
                                <label for="nivel_estudios" class="col-md-4 col-form-label text-md-end">Nivel de Estudios</label>
                                <div class="col-md-6">
                                    <input id="nivel_estudios" type="text" class="form-control" name="nivel_estudios" placeholder="Ej: Licenciatura, Técnico, etc.">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="especializado" class="col-md-4 col-form-label text-md-end">Especialidad</label>
                                <div class="col-md-6">
                                    <input id="especializado" type="text" class="form-control" name="especializado" placeholder="Ej: Plomería, Electricidad, etc.">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contrasena" class="col-md-4 col-form-label text-md-end">Contraseña</label>
                            <div class="col-md-6">
                                <input id="contrasena" type="password" class="form-control" name="contrasena" required minlength="6">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contrasena_confirmacion" class="col-md-4 col-form-label text-md-end">Confirmar Contraseña</label>
                            <div class="col-md-6">
                                <input id="contrasena_confirmacion" type="password" class="form-control" name="contrasena_confirmacion" required minlength="6">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrarse
                                </button>
                                <a href="{{ url('/') }}" class="btn btn-secondary">Cancelar</a>
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
    const camposCliente = document.getElementById('campos_cliente');
    const camposTrabajador = document.getElementById('campos_trabajador');
    const nivelEstudios = document.getElementById('nivel_estudios');
    const especializado = document.getElementById('especializado');

    if (rol === 'cliente') {
        camposCliente.style.display = 'block';
        camposTrabajador.style.display = 'none';
        nivelEstudios.removeAttribute('required');
        especializado.removeAttribute('required');
    } else if (rol === 'trabajador') {
        camposCliente.style.display = 'none';
        camposTrabajador.style.display = 'block';
        nivelEstudios.setAttribute('required', 'required');
        especializado.setAttribute('required', 'required');
    } else {
        camposCliente.style.display = 'none';
        camposTrabajador.style.display = 'none';
    }
}
</script>
@endsection