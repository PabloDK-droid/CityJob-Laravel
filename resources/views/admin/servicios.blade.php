@extends('layouts.app')

@section('content')
<div>
    <h1>Gestión de Servicios</h1>
    
    <a href="{{ route('admin.dashboard') }}">Volver al panel</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <h2>Servicios Registrados</h2>

    @if($servicios->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Servicio</th>
                    <th>Precio Base</th>
                    <th>Total Contrataciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->id_servicio }}</td>
                        <td>{{ $servicio->nombre_servicio }}</td>
                        <td>${{ number_format($servicio->precio_base, 2) }}</td>
                        <td>{{ $servicio->contrataciones_count }}</td>
                        <td>
                            <!-- Formulario para editar -->
                            <form action="{{ route('admin.actualizarServicio', $servicio->id_servicio) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="text" name="nombre_servicio" value="{{ $servicio->nombre_servicio }}" required style="width: 150px;">
                                <input type="number" name="precio_base" value="{{ $servicio->precio_base }}" required step="0.01" min="0" style="width: 100px;" placeholder="Precio">
                                <button type="submit">Actualizar</button>
                            </form>
                            
                            <!-- Formulario para eliminar -->
                            <form action="{{ route('admin.eliminarServicio', $servicio->id_servicio) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" onclick="return confirm('¿Eliminar este servicio?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay servicios registrados.</p>
    @endif

    <h2>Crear Nuevo Servicio</h2>

    <form action="{{ route('admin.crearServicio') }}" method="POST">
        @csrf
        <label>Nombre del Servicio:</label>
        <input type="text" name="nombre_servicio" required placeholder="Ej: Plomería, Electricidad, etc.">
        <br><br>
        
        <label>Precio Base (MXN):</label>
        <input type="number" name="precio_base" required step="0.01" min="0" placeholder="Ej: 500.00">
        <br><br>
        
        <button type="submit">Crear Servicio</button>
    </form>
</div>
@endsection