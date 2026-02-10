@extends('layouts.app')

@section('content')
<div>
    <h1>Catálogo de Servicios</h1>
    
    <a href="{{ route('cliente.dashboard') }}">Volver al inicio</a>

    <h2>Servicios Disponibles</h2>

    @if($servicios->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Servicio</th>
                    <th>Contrataciones Realizadas</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->id_servicio }}</td>
                        <td>{{ $servicio->nombre_servicio }}</td>
                        <td>{{ $servicio->contrataciones_count }}</td>
                        <td>
                            <a href="{{ route('cliente.profesionistas', $servicio->id_servicio) }}">
                                Ver Profesionistas
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay servicios disponibles actualmente.</p>
    @endif
</div>
@endsection