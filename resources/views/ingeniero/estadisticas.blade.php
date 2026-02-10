@extends('layouts.app')

@section('content')
<div>
    <h1>Estadísticas de Servicios</h1>
    
    <a href="{{ route('ingeniero.dashboard') }}">Volver al monitoreo</a>

    <h2>Resumen General</h2>

    <table border="1">
        <tr>
            <td><strong>Total de Servicios:</strong></td>
            <td>{{ $stats['total_servicios'] }}</td>
        </tr>
        <tr>
            <td><strong>Servicios Activos:</strong></td>
            <td>{{ $stats['servicios_activos'] }}</td>
        </tr>
        <tr>
            <td><strong>Servicios Completados:</strong></td>
            <td>{{ $stats['servicios_completados'] }}</td>
        </tr>
    </table>

    <h2>Servicios por Tipo</h2>

    @if($stats['servicios_por_tipo']->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>Tipo de Servicio</th>
                    <th>Total Contrataciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stats['servicios_por_tipo'] as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre_servicio }}</td>
                        <td>{{ $servicio->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay datos disponibles.</p>
    @endif
</div>
@endsection