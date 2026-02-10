@extends('layouts.app')

@section('content')
<div>
    <h1>Editar mi Perfil</h1>
    
    <a href="{{ route('trabajador.dashboard') }}">Volver al inicio</a>

    <h2>Actualizar Información Personal</h2>

    <form action="{{ route('trabajador.actualizarPerfil') }}" method="POST">
        @csrf

        <label>Nombres:</label>
        <input type="text" name="nombres" value="{{ $profesionista->nombres }}" required>
        <br>

        <label>Apellido Paterno:</label>
        <input type="text" name="apellido_p" value="{{ $profesionista->apellido_p }}" required>
        <br>

        <label>Apellido Materno:</label>
        <input type="text" name="apellido_m" value="{{ $profesionista->apellido_m }}">
        <br>

        <label>Género:</label>
        <select name="genero" required>
            <option value="M" {{ $profesionista->genero == 'M' ? 'selected' : '' }}>Masculino</option>
            <option value="F" {{ $profesionista->genero == 'F' ? 'selected' : '' }}>Femenino</option>
        </select>
        <br>

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="{{ $profesionista->telefono }}" required>
        <br>

        <label>Nivel de Estudios:</label>
        <input type="text" name="nivel_estudios" value="{{ $profesionista->nivel_estudios }}" required>
        <br>

        <label>Especialidad:</label>
        <input type="text" name="especializado" value="{{ $profesionista->especializado }}" required>
        <br>

        <label>Código Postal:</label>
        <input type="number" name="cp" value="{{ $profesionista->cp }}" required>
        <br>

        <label>Domicilio:</label>
        <input type="text" name="domicilio" value="{{ $profesionista->domicilio }}" required>
        <br>

        <label>Nueva Contraseña (dejar en blanco para no cambiar):</label>
        <input type="password" name="contrasena">
        <br>

        <button type="submit">Actualizar Perfil</button>
    </form>
</div>
@endsection