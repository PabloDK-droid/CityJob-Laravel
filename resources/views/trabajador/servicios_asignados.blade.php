@extends('layouts.app')

@section('content')
<div>
    <h1>Servicios Asignados</h1>
    
    <a href="{{ route('trabajador.dashboard') }}">Volver al inicio</a>

    <h2>Mis Trabajos Activos</h2>

    @if($contrataciones->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Cliente</th>
                    <th>Teléfono Cliente</th>
                    <th>Ubicación</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contrataciones as $contratacion)
                    <tr>
                        <td>{{ $contratacion->id_contratacion }}</td>
                        <td>{{ $contratacion->servicio->nombre_servicio }}</td>
                        <td>{{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }}</td>
                        <td>{{ $contratacion->cliente->telefono }}</td>
                        <td>{{ $contratacion->localizacion }}</td>
                        <td>{{ $contratacion->fecha_realizacion }}</td>
                        <td>
                            <a href="{{ route('trabajador.detalleServicio', $contratacion->id_contratacion) }}">
                                Ver Detalles
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No tienes servicios asignados actualmente.</p>
    @endif
</div>
@endsection