@extends('layouts.app')

@section('content')
<style>
    .star-display {
        color: #ffc107;
        font-size: 18px;
        letter-spacing: 2px;
    }
</style>

<div>
    <h1>Profesionistas - {{ $servicio->nombre_servicio }}</h1>
    
    <a href="{{ route('cliente.catalogo') }}">Volver al catálogo</a>

    <!-- Filtro de calificación -->
    <form method="GET" action="{{ route('cliente.profesionistas', $servicio->id_servicio) }}" style="background: #fff; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <label style="font-weight: 600; margin-right: 10px;">Calificación mínima:</label>
        <select name="calificacion_min" style="padding: 8px; border: 1px solid #ddd; border-radius: 6px; margin-right: 10px;">
            <option value="">Todas</option>
            <option value="3" {{ request('calificacion_min') == 3 ? 'selected' : '' }}>⭐⭐⭐ 3+</option>
            <option value="4" {{ request('calificacion_min') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ 4+</option>
            <option value="4.5" {{ request('calificacion_min') == 4.5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 4.5+</option>
        </select>
        <button type="submit" style="background: #0066ff; color: white; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer;">Filtrar</button>
        <a href="{{ route('cliente.profesionistas', $servicio->id_servicio) }}" style="margin-left: 10px; color: #0066ff; text-decoration: none;">Limpiar</a>
    </form>

    <h2>Profesionistas Disponibles</h2>

    @if($profesionistas->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Nivel de Estudios</th>
                    <th>Calificación</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profesionistas as $profesionista)
                    <tr>
                        <td>{{ $profesionista->id_profesionista }}</td>
                        <td>{{ $profesionista->nombres }} {{ $profesionista->apellido_p }}</td>
                        <td>{{ $profesionista->telefono }}</td>
                        <td>{{ $profesionista->correo_electronico }}</td>
                        <td>{{ $profesionista->nivel_estudios }}</td>
                        <td>
                            @php
                                $rating = round($profesionista->calificacion_profesionista);
                                $fullStars = floor($rating);
                                $emptyStars = 5 - $fullStars;
                            @endphp
                            <div class="star-display">
                                @for($i = 0; $i < $fullStars; $i++)
                                    ★
                                @endfor
                                @for($i = 0; $i < $emptyStars; $i++)
                                    ☆
                                @endfor
                            </div>
                            <small style="color: #666;">({{ number_format($profesionista->calificacion_profesionista, 1) }})</small>
                        </td>
                        <td>
                            <form action="{{ route('cliente.contratar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_profesionista" value="{{ $profesionista->id_profesionista }}">
                                <input type="hidden" name="id_servicio" value="{{ $servicio->id_servicio }}">
                                
                                <label>Ubicación del servicio:</label>
                                <input type="text" name="localizacion" required placeholder="Ej: Calle 5 #123, Col. Centro">
                                
                                <button type="submit">Contratar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay profesionistas disponibles para este servicio.</p>
    @endif
</div>
@endsection