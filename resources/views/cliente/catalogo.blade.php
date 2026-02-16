@extends('layouts.app')
@section('content')

<div class="catalogo-container">
    <div class="catalogo-header">
        <a href="{{ route('cliente.dashboard') }}" class="btn-back">← Volver al inicio</a>
        <h1>Catálogo de Servicios</h1>
    </div>

    <h2>Servicios Disponibles</h2>

    <!-- Formulario de filtros -->
    <form method="GET" action="{{ route('cliente.catalogo') }}" style="background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h3 style="margin-bottom: 15px;">Filtros de Búsqueda</h3>
    
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Buscar servicio:</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Ej: Plomería" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
        
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Precio mínimo:</label>
                <input type="number" name="precio_min" value="{{ request('precio_min') }}" placeholder="$0" step="50" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
        
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Precio máximo:</label>
                <input type="number" name="precio_max" value="{{ request('precio_max') }}" placeholder="$10000" step="50" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
        </div>
    
        <div style="margin-top: 15px; display: flex; gap: 10px;">
            <button type="submit" style="background: #0066ff; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
                Buscar
            </button>
            <a href="{{ route('cliente.catalogo') }}" style="background: #f0f0f0; color: #333; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                Limpiar filtros
                </a>
            </div>
        </form>

    @if($servicios->count() > 0)
        <div class="servicios-grid">
            @foreach($servicios as $servicio)
                <div class="servicio-card">
                    <div class="servicio-nombre">{{ $servicio->nombre_servicio }}</div>
                    <div class="servicio-precio">${{ number_format($servicio->precio_base, 2) }} MXN</div>
                    <div class="servicio-stats">
                        {{ $servicio->contrataciones_count }} contrataciones realizadas
                    </div>
                    <a href="{{ route('cliente.profesionistas', $servicio->id_servicio) }}" class="btn-contratar">
                        Ver Profesionistas y Contratar
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p>No hay servicios disponibles actualmente.</p>
    @endif
</div>
@endsection