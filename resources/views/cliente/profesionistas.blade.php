@extends('layouts.app')

@section('content')
<div>
    <h1>Profesionistas - {{ $servicio->nombre_servicio }}</h1>
    
    <a href="{{ route('cliente.catalogo') }}">Volver al catálogo</a>

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
                        <td>{{ $profesionista->calificacion_profesionista }}</td>
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