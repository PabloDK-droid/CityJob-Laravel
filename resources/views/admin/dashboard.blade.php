@extends('layouts.app')

@section('content')
<div>
    <h1>Panel de Administración</h1>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>

    <h2>Estadísticas Generales</h2>

    <table border="1">
        <tr>
            <td><strong>Total Clientes:</strong></td>
            <td>{{ $stats['total_clientes'] }}</td>
        </tr>
        <tr>
            <td><strong>Total Profesionistas:</strong></td>
            <td>{{ $stats['total_profesionistas'] }}</td>
        </tr>
        <tr>
            <td><strong>Total Servicios:</strong></td>
            <td>{{ $stats['total_servicios'] }}</td>
        </tr>
        <tr>
            <td><strong>Total Contrataciones:</strong></td>
            <td>{{ $stats['total_contrataciones'] }}</td>
        </tr>
        <tr>
            <td><strong>Total Recaudado:</strong></td>
            <td>${{ number_format($stats['total_recaudado'], 2) }}</td>
        </tr>
        <tr>
            <td><strong>Comisiones Plataforma:</strong></td>
            <td>${{ number_format($stats['comisiones_plataforma'], 2) }}</td>
        </tr>
    </table>

    <h2>Gestión del Sistema</h2>

    <nav>
        <ul>
            <li><a href="{{ route('admin.usuarios') }}">Gestionar Usuarios</a></li>
            <li><a href="{{ route('admin.servicios') }}">Gestionar Servicios</a></li>
            <li><a href="{{ route('admin.contrataciones') }}">Ver Contrataciones</a></li>
            <li><a href="{{ route('admin.downloadLogs') }}">Descargar Reportes</a></li>
        </ul>
    </nav>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
</div>
@endsection