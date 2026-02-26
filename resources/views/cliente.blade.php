@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Bienvenido, {{ session('user_name') }}</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>

    <div class="card">
        <div class="card-header">Panel de Cliente (CityJob)</div>
        <div class="card-body">
            <p>Aquí puedes buscar servicios técnicos y profesionales.</p>
            <ul>
                <li><a href="#">Buscar Profesionistas</a></li>
                <li><a href="#">Mis Contrataciones</a></li>
                <li><a href="#">Ayuda al Cliente</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection