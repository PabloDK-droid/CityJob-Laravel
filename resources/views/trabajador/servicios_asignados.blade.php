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

                        {{-- Badge de estado --}}
                        <td>
                            @if($contratacion->estado == 'pago_pendiente')
                                <span style="color:#ff9500;font-weight:600;">Pago pendiente</span>
                            @elseif($contratacion->estado == 'activo')
                                <span style="color:green;font-weight:600;">Activo</span>
                            @elseif($contratacion->estado == 'completado')
                                <span style="color:blue;font-weight:600;">Completado</span>
                            @else
                                <span style="color:red;font-weight:600;">Cancelado</span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td>
                            <a href="{{ route('trabajador.detalleServicio', $contratacion->id_contratacion) }}"
                               style="font-size:13px;">
                                Ver Detalles
                            </a>

                            @if($contratacion->estado == 'pago_pendiente')
                                <a href="{{ route('trabajador.chat', $contratacion->id_contratacion) }}"
                                   style="background:#6c5ce7;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;font-size:13px;margin-left:5px;">
                                    Chat
                                </a>

                            @elseif($contratacion->estado == 'activo')
                                <a href="{{ route('trabajador.chat', $contratacion->id_contratacion) }}"
                                   style="background:#6c5ce7;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;font-size:13px;margin-left:5px;">
                                    Chat
                                </a>
                                <form action="{{ route('trabajador.completarServicio', $contratacion->id_contratacion) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('¿Marcar este servicio como completado?')"
                                            style="margin-left:5px;font-size:13px;">
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