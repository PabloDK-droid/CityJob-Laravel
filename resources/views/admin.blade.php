@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Panel de Administración</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>

    <div class="card">
        <div class="card-header">Control de Negocio (Hechos)</div>
        <div class="card-body">
            <p>Gestión global de datos y reportes.</p>
            <ul>
                <li><a href="#">Registrar nuevos Trabajadores</a></li>
                <li><a href="#">Descargar Reportes de Contratación</a></li>
                <li><a href="#">Estadísticas de Ingresos</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection