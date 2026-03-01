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
    .status-activo       { background: rgba(0,168,107,0.1);  color: #00a86b; }
    .status-completado   { background: rgba(0,102,255,0.1);  color: #0066ff; }
    .status-cancelado    { background: rgba(220,53,69,0.1);  color: #dc3545; }
    .status-pago         { background: rgba(255,149,0,0.1);  color: #ff9500; }
    .status-pendiente    { background: rgba(150,150,150,0.1);color: #888;    }
</style>

<div>
    <h1>Mis Contrataciones</h1>

    <a href="{{ route('cliente.dashboard') }}">Volver al inicio</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
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
                        <td>{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</td>
                        <td>{{ $contratacion->profesionista->telefono }}</td>
                        <td>{{ $contratacion->localizacion }}</td>
                        <td style="color: green; font-weight: bold;">${{ number_format($contratacion->monto_acordado, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($contratacion->fecha_realizacion)->format('d/m/Y H:i') }}</td>

                        {{-- Badge de estado --}}
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

                        {{-- Acciones --}}
                        <td>
                            @if($contratacion->estado == 'pago_pendiente')
                                <a href="{{ route('cliente.crearPago', $contratacion->id_contratacion) }}"
                                   style="background:#ff9500;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;font-size:13px;">
                                    Pagar ahora
                                </a>
                                <a href="{{ route('cliente.chat', $contratacion->id_contratacion) }}"
                                   style="background:#6c5ce7;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;font-size:13px;margin-left:5px;">
                                    Chat
                                </a>

                            @elseif($contratacion->estado == 'activo')
                                <span style="color:#00a86b;">En proceso...</span>
                                <a href="{{ route('cliente.chat', $contratacion->id_contratacion) }}"
                                   style="background:#6c5ce7;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;font-size:13px;margin-left:5px;">
                                    Chat
                                </a>

                            @elseif($contratacion->estado == 'completado')
                                <a href="{{ route('cliente.calificarServicio', $contratacion->id_contratacion) }}"
                                   style="background:#0066ff;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;font-size:13px;">
                                    Calificar
                                </a>
                                <a href="{{ route('cliente.descargarFactura', $contratacion->id_contratacion) }}"
                                   style="background:#00a86b;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;font-size:13px;margin-left:5px;">
                                    Descargar Factura
                                </a>

                            @else
                                <span style="color:#999;">-</span>
                            @endif
                        </td>
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