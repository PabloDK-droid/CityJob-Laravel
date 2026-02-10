@extends('layouts.app')

@section('content')
<div>
    <h1>Panel de Profesionista: {{ $profesionista->nombres }} {{ $profesionista->apellido_p }}</h1>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>

    <h2>Gestión de Servicios</h2>

    <p><strong>Especialidad:</strong> {{ $profesionista->especializado }}</p>
    <p><strong>Calificación:</strong> {{ $profesionista->calificacion_profesionista }}</p>
    <p><strong>Estado:</strong> Disponible</p>

    <nav>
        <ul>
            <li><a href="{{ route('trabajador.serviciosAsignados') }}">Ver Servicios Asignados</a></li>
            <li><a href="{{ route('trabajador.editarPerfil') }}">Actualizar mi Perfil</a></li>
        </ul>
    </nav>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
</div>
@endsection