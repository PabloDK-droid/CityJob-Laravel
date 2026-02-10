@extends('layouts.app')

@section('content')
<div>
    <h1>Detalle de Contratación</h1>
    
    <a href="{{ route('ingeniero.dashboard') }}">Volver al monitoreo</a>

    <h2>Información del Servicio</h2>

    <p><strong>ID Contratación:</strong> {{ $contratacion->id_contratacion }}</p>
    <p><strong>Servicio:</strong> {{ $contratacion->servicio->nombre_servicio }}</p>
    <p><strong>Estado:</strong> {{ $contratacion->estado_emitor ? 'Activo' : 'Cancelado' }}</p>
    <p><strong>Fecha de Realización:</strong> {{ $contratacion->fecha_realizacion }}</p>
    <p><strong>Emisor:</strong> {{ $contratacion->nombres_emitor }}</p>

    <h3>Ubicación del Servicio</h3>
    <p><strong>Dirección:</strong> {{ $contratacion->localizacion }}</p>

    <h3>Datos del Cliente</h3>
    <p><strong>Nombre:</strong> {{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }} {{ $contratacion->cliente->apellido_m }}</p>
    <p><strong>Teléfono:</strong> {{ $contratacion->cliente->telefono }}</p>
    <p><strong>Email:</strong> {{ $contratacion->cliente->correo_electronico }}</p>
    <p><strong>Domicilio:</strong> {{ $contratacion->cliente->domicilio }}</p>

    <h3>Datos del Profesionista</h3>
    <p><strong>Nombre:</strong> {{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</p>
    <p><strong>Teléfono:</strong> {{ $contratacion->profesionista->telefono }}</p>
    <p><strong>Email:</strong> {{ $contratacion->profesionista->correo_electronico }}</p>
    <p><strong>Especialidad:</strong> {{ $contratacion->profesionista->especializado }}</p>
    <p><strong>Calificación:</strong> {{ $contratacion->profesionista->calificacion_profesionista }}</p>

    @if($hecho)
        <h3>Información de Pago</h3>
        <p><strong>Monto Total:</strong> ${{ number_format($hecho->monto_total, 2) }}</p>
        <p><strong>Comisión Plataforma:</strong> ${{ number_format($hecho->comision_plataforma, 2) }}</p>
        <p><strong>Duración del Servicio:</strong> {{ $hecho->duracion_servicio_minutos }} minutos</p>
        
        @if($factura)
            <h4>Factura</h4>
            <p><strong>ID Factura:</strong> {{ $factura->id_factura }}</p>
            <p><strong>Stripe ID:</strong> {{ $factura->stripe_id }}</p>
            <p><strong>Fecha Emisión:</strong> {{ $factura->fecha_emision }}</p>
        @endif
    @else
        <p style="color: orange;"><strong>Estado de Pago:</strong> Pendiente de pago</p>
    @endif

    @if($contratacion->estado_emitor)
        <h3>Acciones</h3>
        <form action="{{ route('ingeniero.cancelar', $contratacion->id_contratacion) }}" method="POST">
            @csrf
            <button type="submit" onclick="return confirm('¿Cancelar este servicio?')">Cancelar Servicio</button>
        </form>
    @endif
</div>
@endsection