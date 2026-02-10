@extends('layouts.app')

@section('content')
<div>
    <h1>Editar mi Perfil</h1>
    
    <a href="{{ route('cliente.dashboard') }}">Volver al inicio</a>

    <h2>Actualizar Información Personal</h2>

    <form action="{{ route('cliente.actualizarPerfil') }}" method="POST">
        @csrf

        <label>Nombres:</label>
        <input type="text" name="nombres" value="{{ $cliente->nombres }}" required>
        <br>

        <label>Apellido Paterno:</label>
        <input type="text" name="apellido_p" value="{{ $cliente->apellido_p }}" required>
        <br>

        <label>Apellido Materno:</label>
        <input type="text" name="apellido_m" value="{{ $cliente->apellido_m }}">
        <br>

        <label>Género:</label>
        <select name="genero" required>
            <option value="M" {{ $cliente->genero == 'M' ? 'selected' : '' }}>Masculino</option>
            <option value="F" {{ $cliente->genero == 'F' ? 'selected' : '' }}>Femenino</option>
        </select>
        <br>

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="{{ $cliente->telefono }}" required>
        <br>

        <label>Teléfono Fijo (opcional):</label>
        <input type="text" name="telefono_fijo" value="{{ $cliente->telefono_fijo ?? '' }}">
        <br>

        <label>Código Postal:</label>
        <input type="number" name="cp" value="{{ $cliente->cp }}" required>
        <br>

        <label>Domicilio:</label>
        <input type="text" name="domicilio" value="{{ $cliente->domicilio }}" required>
        <br>

        <label>Referencias:</label>
        <textarea name="referencias">{{ $cliente->referencias }}</textarea>
        <br>

        <label>Nueva Contraseña (dejar en blanco para no cambiar):</label>
        <input type="password" name="contrasena">
        <br>

        <button type="submit">Actualizar Perfil</button>
    </form>
</div>
@endsection