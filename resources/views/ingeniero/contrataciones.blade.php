@extends('layouts.app')

@section('content')
<div>
    <h1>Panel de Ingeniería - Monitoreo de Servicios</h1>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <nav>
        <ul>
            <li><a href="{{ route('ingeniero.dashboard') }}">Ver Contrataciones</a></li>
            <li><a href="{{ route('ingeniero.pagos') }}">Estado de Pagos</a></li>
            <li><a href="{{ route('ingeniero.estadisticas') }}">Estadísticas</a></li>
            <li><a href="{{ route('ingeniero.historial') }}">Historial Global</a></li>
        </ul>
    </nav>

    <h2>Contrataciones Activas</h2>

    @if($contrataciones->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Profesionista</th>
                    <th>Servicio</th>
                    <th>Ubicación</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contrataciones as $contratacion)
                    <tr>
                        <td>{{ $contratacion->id_contratacion }}</td>
                        <td>{{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }}</td>
                        <td>{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</td>
                        <td>{{ $contratacion->servicio->nombre_servicio }}</td>
                        <td>{{ $contratacion->localizacion }}</td>
                        <td>{{ $contratacion->fecha_realizacion }}</td>
                        <td>{{ $contratacion->estado_emitor ? 'Activo' : 'Cancelado' }}</td>
                        <td>
                            <a href="{{ route('ingeniero.historial.detalle', $contratacion->id_contratacion) }}">Ver Detalles</a>

                            @if($contratacion->estado_emitor)
                                <form action="{{ route('ingeniero.cancelar', $contratacion->id_contratacion) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" onclick="return confirm('¿Cancelar este servicio?')">Cancelar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay contrataciones registradas.</p>
    @endif
</div>
@endsection