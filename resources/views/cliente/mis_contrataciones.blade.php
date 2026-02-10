@extends('layouts.app')

@section('content')
<div>
    <h1>Mis Contrataciones</h1>
    
    <a href="{{ route('cliente.dashboard') }}">Volver al inicio</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <h2>Historial de Servicios Contratados</h2>

    @if($contrataciones->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Profesionista</th>
                    <th>Teléfono</th>
                    <th>Ubicación</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contrataciones as $contratacion)
                    <tr>
                        <td>{{ $contratacion->id_contratacion }}</td>
                        <td>{{ $contratacion->servicio->nombre_servicio }}</td>
                        <td>{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</td>
                        <td>{{ $contratacion->profesionista->telefono }}</td>
                        <td>{{ $contratacion->localizacion }}</td>
                        <td>{{ $contratacion->fecha_realizacion }}</td>
                        <td>{{ $contratacion->estado_emitor ? 'Activo' : 'Cancelado' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No has realizado ninguna contratación todavía.</p>
        <a href="{{ route('cliente.catalogo') }}">Ver servicios disponibles</a>
    @endif
</div>
@endsection