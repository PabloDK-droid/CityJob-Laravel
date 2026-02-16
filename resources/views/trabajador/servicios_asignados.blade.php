@extends('layouts.app')

@section('content')
<div>
    <h1>Servicios Asignados</h1>
    <a href="{{ route('trabajador.dashboard') }}">← Volver al dashboard</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <h2>Mis Trabajos</h2>

    @if($contrataciones->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Ubicación</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
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
                        <td>{{ \Carbon\Carbon::parse($contratacion->fecha_realizacion)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($contratacion->estado == 'activo')
                                <span style="color: green;">Activo</span>
                            @elseif($contratacion->estado == 'completado')
                                <span style="color: blue;">Completado</span>
                            @else
                                <span style="color: red;">Cancelado</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('trabajador.detalleServicio', $contratacion->id_contratacion) }}">Ver Detalles</a>
                            
                            @if($contratacion->estado == 'activo')
                                <form action="{{ route('trabajador.completarServicio', $contratacion->id_contratacion) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" onclick="return confirm('¿Marcar este servicio como completado?')">
                                        Completar
                                    </button>
                                </form>
                            @endif
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