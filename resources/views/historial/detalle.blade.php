@extends('layouts.app')

@section('content')
@php $rol = session('role'); @endphp

<div>
    {{-- Botón volver según rol --}}
    @if($rol === 'cliente')
        <a href="{{ route('cliente.historial') }}">← Volver al historial</a>
    @elseif($rol === 'trabajador')
        <a href="{{ route('trabajador.historial') }}">← Volver al historial</a>
    @elseif($rol === 'admin')
        <a href="{{ route('admin.historial') }}">← Volver al historial</a>
    @else
        <a href="{{ route('ingeniero.historial') }}">← Volver al historial</a>
    @endif

    <h1>Detalle de Contratación #{{ $contratacion->id_contratacion }}</h1>

    {{-- Info general --}}
    <h3>Información del Servicio</h3>
    <p><strong>Servicio:</strong> {{ $contratacion->servicio->nombre_servicio }}</p>
    <p><strong>Ubicación:</strong> {{ $contratacion->localizacion }}</p>
    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($contratacion->fecha_realizacion)->format('d/m/Y H:i') }}</p>
    <p><strong>Estado:</strong> {{ ucfirst($contratacion->estado) }}</p>
    <p><strong>Monto:</strong> ${{ number_format($contratacion->monto_acordado, 2) }} MXN</p>

    {{-- Datos del cliente --}}
    <h3>Cliente</h3>
    <p><strong>Nombre:</strong> {{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }} {{ $contratacion->cliente->apellido_m }}</p>
    <p><strong>Teléfono:</strong> {{ $contratacion->cliente->telefono }}</p>
    <p><strong>Email:</strong> {{ $contratacion->cliente->correo_electronico }}</p>
    <p><strong>Domicilio:</strong> {{ $contratacion->cliente->domicilio }}</p>

    {{-- Datos del profesionista --}}
    <h3>Profesionista</h3>
    <p><strong>Nombre:</strong> {{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }} {{ $contratacion->profesionista->apellido_m }}</p>
    <p><strong>Teléfono:</strong> {{ $contratacion->profesionista->telefono }}</p>
    <p><strong>Email:</strong> {{ $contratacion->profesionista->correo_electronico }}</p>
    <p><strong>Especialidad:</strong> {{ $contratacion->profesionista->especializado }}</p>
    <p><strong>Calificación:</strong> {{ $contratacion->profesionista->calificacion_profesionista }}</p>

    {{-- Datos del pago --}}
    @if($hecho)
        <h3>Información de Pago</h3>
        <p><strong>Monto Total:</strong> ${{ number_format($hecho->monto_total, 2) }} MXN</p>
        <p><strong>Comisión Plataforma (10%):</strong> ${{ number_format($hecho->comision_plataforma, 2) }} MXN</p>

        @if($factura)
            <h3>Factura</h3>
            <p><strong>ID Factura:</strong> {{ $factura->id_factura }}</p>
            <p><strong>Stripe ID:</strong> {{ $factura->stripe_id }}</p>
            <p><strong>Fecha Emisión:</strong> {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y H:i') }}</p>
        @endif
    @else
        <p style="color: orange;"><strong>Pago:</strong> Pendiente</p>
    @endif

    {{-- Datos del historial --}}
    @if($historial)
        <h3>Registro de Cierre</h3>
        <p><strong>Fecha de Cierre:</strong> {{ \Carbon\Carbon::parse($historial->fecha_factura)->format('d/m/Y') }}</p>
        <p><strong>Hora de Cierre:</strong> {{ $historial->hora }}</p>
        <p><strong>Monto Registrado:</strong> ${{ number_format($historial->monto, 2) }} MXN</p>
    @endif

    {{-- Acciones según rol --}}
    @if($rol === 'cliente' && $contratacion->estado === 'completado')
        <br>
        <a href="{{ route('cliente.descargarFactura', $contratacion->id_contratacion) }}"
           style="background:#00a86b;color:white;padding:10px 20px;border-radius:6px;text-decoration:none;font-weight:600;">
            Descargar Factura PDF
        </a>
    @endif

    @if(($rol === 'admin' || $rol === 'ingeniero') && $contratacion->estado_emitor)
        <br><br>
        <form action="{{ route('ingeniero.cancelar', $contratacion->id_contratacion) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" onclick="return confirm('¿Cancelar este servicio?')"
                    style="background:#dc3545;color:white;padding:10px 20px;border-radius:6px;border:none;cursor:pointer;font-weight:600;">
                Cancelar Servicio
            </button>
        </form>
    @endif
</div>
@endsection