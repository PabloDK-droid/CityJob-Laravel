@extends('layouts.app')

@section('content')
<div>
    <h1>Todas las Contrataciones</h1>
    
    <a href="{{ route('admin.dashboard') }}">Volver al panel</a>

    <h2>Historial Completo de Servicios</h2>

    @if($contrataciones->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Profesionista</th>
                    <th>Servicio</th>
                    <th>Ubicación</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contrataciones as $contratacion)
                    <tr>
                        <td>{{ $contratacion->id_contratacion }}</td>
                        <td>{{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }}</td>
                        <td>{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</td>
                        <td>{{ $contratacion->servicio->nombre_servicio }}</td>
                        <td>{{ $contratacion->localizacion }}</td>
                        <td>{{ $contratacion->fecha_realizacion }}</td>
                        <td>{{ $contratacion->estado_emitor ? 'Activo' : 'Cancelado' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay contrataciones registradas.</p>
    @endif
</div>
@endsection