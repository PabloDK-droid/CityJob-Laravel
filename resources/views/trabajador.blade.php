@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Panel de Profesionista: {{ session('user_name') }}</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>

    <div class="card">
        <div class="card-header">Gestión de Servicios</div>
        <div class="card-body">
            <p>Estado actual: Disponible</p>
            <ul>
                <li><a href="#">Ver Peticiones de Trabajo</a></li>
                <li><a href="#">Actualizar mi Perfil</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection