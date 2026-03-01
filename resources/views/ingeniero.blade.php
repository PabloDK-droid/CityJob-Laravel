@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Panel de Soporte Técnico (Ingeniería)</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>

    <div class="card">
        <div class="card-header">Mantenimiento de CityJob</div>
        <div class="card-body">
            <p>Acceso a logs y soporte directo</p>
            <ul>
                <li><a href="#">Descargar Manuales y Logs</a></li>
                <li><a href="#">Mensajería de Soporte</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection