@extends('layouts.app')

@section('content')
<div>
    <h1>Peticiones Pendientes</h1>
    
    <a href="{{ route('trabajador.dashboard') }}">← Volver al dashboard</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <h2>Nuevas Solicitudes de Servicio</h2>

    @if($peticiones->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Ubicación</th>
                    <th>Monto</th>
                    <th>Fecha Solicitud</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peticiones as $peticion)
                    <tr>
                        <td>{{ $peticion->id_contratacion }}</td>
                        <td>{{ $peticion->servicio->nombre_servicio }}</td>
                        <td>{{ $peticion->cliente->nombres }} {{ $peticion->cliente->apellido_p }}</td>
                        <td>{{ $peticion->cliente->telefono }}</td>
                        <td>{{ $peticion->localizacion }}</td>
                        <td style="color: green; font-weight: bold;">${{ number_format($peticion->monto_acordado, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($peticion->fecha_realizacion)->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="{{ route('trabajador.aceptarTrabajo', $peticion->id_contratacion) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: #00a86b; color: white; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer;">
                                    Aceptar
                                </button>
                            </form>
                            
                            <form action="{{ route('trabajador.rechazarTrabajo', $peticion->id_contratacion) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" onclick="return confirm('¿Seguro que deseas rechazar este trabajo?')" style="background: #dc3545; color: white; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer;">
                                    Rechazar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No tienes peticiones pendientes en este momento.</p>
    @endif
</div>
@endsection