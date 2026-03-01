@extends('layouts.app')

@section('content')
<style>
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    .status-activo     { background: rgba(0,168,107,0.1); color: #00a86b; }
    .status-completado { background: rgba(0,102,255,0.1); color: #0066ff; }
    .status-cancelado  { background: rgba(220,53,69,0.1); color: #dc3545; }
    .status-pago       { background: rgba(255,149,0,0.1); color: #ff9500; }
    .status-pendiente  { background: rgba(150,150,150,0.1); color: #888;  }
</style>

@php $rol = session('role'); @endphp

<div>
    <h1>Mi Historial</h1>

    @if($rol === 'cliente')
        <a href="{{ route('cliente.dashboard') }}">← Volver al inicio</a>
    @else
        <a href="{{ route('trabajador.dashboard') }}">← Volver al inicio</a>
    @endif

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <h2>{{ $rol === 'cliente' ? 'Mis Contrataciones' : 'Trabajos Realizados' }}</h2>

    @if($contrataciones->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    @if($rol === 'cliente')
                        <th>Profesionista</th>
                    @else
                        <th>Cliente</th>
                    @endif
                    <th>Monto</th>
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
                        @if($rol === 'cliente')
                            <td>{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</td>
                        @else
                            <td>{{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }}</td>
                        @endif
                        <td style="font-weight:bold;color:green;">
                            ${{ number_format($contratacion->monto_acordado, 2) }} MXN
                        </td>
                        <td>{{ \Carbon\Carbon::parse($contratacion->fecha_realizacion)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($contratacion->estado == 'pago_pendiente')
                                <span class="status-badge status-pago">Pago pendiente</span>
                            @elseif($contratacion->estado == 'activo')
                                <span class="status-badge status-activo">Activo</span>
                            @elseif($contratacion->estado == 'completado')
                                <span class="status-badge status-completado">Completado</span>
                            @elseif($contratacion->estado == 'cancelado')
                                <span class="status-badge status-cancelado">Cancelado</span>
                            @else
                                <span class="status-badge status-pendiente">{{ ucfirst($contratacion->estado) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($rol === 'cliente')
                                <a href="{{ route('cliente.historial.detalle', $contratacion->id_contratacion) }}"
                                   style="background:#0066ff;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;font-size:13px;">
                                    Ver Detalle
                                </a>
                            @else
                                <a href="{{ route('trabajador.historial.detalle', $contratacion->id_contratacion) }}"
                                   style="background:#0066ff;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;font-size:13px;">
                                    Ver Detalle
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay registros en tu historial todavía.</p>
    @endif
</div>
@endsection