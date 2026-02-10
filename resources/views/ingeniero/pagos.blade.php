@extends('layouts.app')

@section('content')
<div>
    <h1>Estado de Pagos</h1>
    
    <a href="{{ route('ingeniero.dashboard') }}">Volver al monitoreo</a>

    <h2>Servicios Pagados</h2>

    @if($pagados->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID Contratación</th>
                    <th>Cliente</th>
                    <th>Profesionista</th>
                    <th>Servicio</th>
                    <th>Monto Total</th>
                    <th>Comisión</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pagados as $hecho)
                    <tr>
                        <td>{{ $hecho->id_contratacion }}</td>
                        <td>{{ $hecho->contratacion->cliente->nombres ?? 'N/A' }}</td>
                        <td>{{ $hecho->contratacion->profesionista->nombres ?? 'N/A' }}</td>
                        <td>{{ $hecho->contratacion->servicio->nombre_servicio ?? 'N/A' }}</td>
                        <td>${{ number_format($hecho->monto_total, 2) }}</td>
                        <td>${{ number_format($hecho->comision_plataforma, 2) }}</td>
                        <td>{{ $hecho->fecha_registro }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay servicios con pago registrado.</p>
    @endif

    <h2>Servicios Pendientes de Pago</h2>

    @if($pendientes->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID Contratación</th>
                    <th>Cliente</th>
                    <th>Profesionista</th>
                    <th>Servicio</th>
                    <th>Ubicación</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendientes as $contratacion)
                    <tr>
                        <td>{{ $contratacion->id_contratacion }}</td>
                        <td>{{ $contratacion->cliente->nombres ?? 'N/A' }}</td>
                        <td>{{ $contratacion->profesionista->nombres ?? 'N/A' }}</td>
                        <td>{{ $contratacion->servicio->nombre_servicio ?? 'N/A' }}</td>
                        <td>{{ $contratacion->localizacion }}</td>
                        <td>{{ $contratacion->fecha_realizacion }}</td>
                        <td style="color: orange;">Pendiente</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay servicios pendientes de pago.</p>
    @endif
</div>
@endsection