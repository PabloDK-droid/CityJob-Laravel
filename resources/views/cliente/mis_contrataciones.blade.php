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
    .status-activo { background: rgba(0,168,107,0.1); color: #00a86b; }
    .status-completado { background: rgba(0,102,255,0.1); color: #0066ff; }
    .status-cancelado { background: rgba(220,53,69,0.1); color: #dc3545; }
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
                        <td>
                            @if($contratacion->estado == 'activo')
                                <span class="status-badge status-activo">Activo</span>
                            @elseif($contratacion->estado == 'completado')
                                <span class="status-badge status-completado">Completado</span>
                            @else
                                <span class="status-badge status-cancelado">Cancelado</span>
                            @endif
                        </td>
                        <td>
                        @if($contratacion->estado == 'completado')
                            <a href="{{ route('cliente.calificarServicio', $contratacion->id_contratacion) }}" 
                                style="background: #0066ff; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px;">
                            Calificar
                            </a>
                                <a href="{{ route('cliente.descargarFactura', $contratacion->id_contratacion) }}" 
                                    style="background: #00a86b; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; margin-left: 5px;">
                            Descargar Factura
                                </a>
                                @elseif($contratacion->estado == 'activo')
                                <span style="color: #00a86b;">En proceso...</span>
                            @else
                                <span style="color: #999;">-</span>
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