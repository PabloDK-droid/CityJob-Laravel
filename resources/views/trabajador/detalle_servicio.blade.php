@extends('layouts.app')

@section('content')
<div>
    <h1>Detalle del Servicio</h1>
    
    <a href="{{ route('trabajador.serviciosAsignados') }}">Volver a mis servicios</a>

    <h2>Información del Trabajo</h2>

    <p><strong>ID Contratación:</strong> {{ $contratacion->id_contratacion }}</p>
    <p><strong>Servicio:</strong> {{ $contratacion->servicio->nombre_servicio }}</p>
    <p><strong>Estado:</strong> {{ $contratacion->estado_emitor ? 'Activo' : 'Cancelado' }}</p>
    <p><strong>Fecha de Realización:</strong> {{ $contratacion->fecha_realizacion }}</p>

    <h3>Ubicación del Servicio</h3>
    <p><strong>Dirección:</strong> {{ $contratacion->localizacion }}</p>

    <h3>Datos del Cliente</h3>
    <p><strong>Nombre:</strong> {{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }} {{ $contratacion->cliente->apellido_m }}</p>
    <p><strong>Teléfono:</strong> {{ $contratacion->cliente->telefono }}</p>
    @if($contratacion->cliente->telefono_fijo)
        <p><strong>Teléfono Fijo:</strong> {{ $contratacion->cliente->telefono_fijo }}</p>
    @endif
    <p><strong>Correo:</strong> {{ $contratacion->cliente->correo_electronico }}</p>
    <p><strong>Domicilio:</strong> {{ $contratacion->cliente->domicilio }}</p>
    @if($contratacion->cliente->referencias)
        <p><strong>Referencias:</strong> {{ $contratacion->cliente->referencias }}</p>
    @endif
</div>
@endsection