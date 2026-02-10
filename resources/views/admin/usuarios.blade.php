@extends('layouts.app')

@section('content')
<div>
    <h1>Gestión de Usuarios</h1>
    
    <a href="{{ route('admin.dashboard') }}">Volver al panel</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <!-- CLIENTES -->
    <h2>Clientes</h2>
    @if($clientes->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id_cliente }}</td>
                        <td>{{ $cliente->nombres }} {{ $cliente->apellido_p }}</td>
                        <td>{{ $cliente->correo_electronico }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>
                            <form action="{{ route('admin.cambiarRol') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ $cliente->id_cliente }}">
                                <input type="hidden" name="rol_actual" value="cliente">
                                <select name="rol_nuevo">
                                    <option value="">Cambiar rol a...</option>
                                    <option value="trabajador">Trabajador</option>
                                    <option value="admin">Admin</option>
                                    <option value="ingeniero">Ingeniero</option>
                                </select>
                                <button type="submit">Cambiar</button>
                            </form>
                            
                            <form action="{{ route('admin.eliminarUsuario') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ $cliente->id_cliente }}">
                                <input type="hidden" name="rol" value="cliente">
                                <button type="submit" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay clientes registrados.</p>
    @endif

    <!-- PROFESIONISTAS -->
    <h2>Profesionistas</h2>
    @if($profesionistas->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Especialidad</th>
                    <th>Calificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profesionistas as $profesionista)
                    <tr>
                        <td>{{ $profesionista->id_profesionista }}</td>
                        <td>{{ $profesionista->nombres }} {{ $profesionista->apellido_p }}</td>
                        <td>{{ $profesionista->correo_electronico }}</td>
                        <td>{{ $profesionista->telefono }}</td>
                        <td>{{ $profesionista->especializado }}</td>
                        <td>{{ $profesionista->calificacion_profesionista }}</td>
                        <td>
                            <form action="{{ route('admin.cambiarRol') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ $profesionista->id_profesionista }}">
                                <input type="hidden" name="rol_actual" value="trabajador">
                                <select name="rol_nuevo">
                                    <option value="">Cambiar rol a...</option>
                                    <option value="cliente">Cliente</option>
                                    <option value="admin">Admin</option>
                                    <option value="ingeniero">Ingeniero</option>
                                </select>
                                <button type="submit">Cambiar</button>
                            </form>
                            
                            <form action="{{ route('admin.eliminarUsuario') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ $profesionista->id_profesionista }}">
                                <input type="hidden" name="rol" value="trabajador">
                                <button type="submit" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay profesionistas registrados.</p>
    @endif

    <!-- ADMINISTRADORES -->
    <h2>Administradores</h2>
    @if($administradores->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($administradores as $admin)
                    <tr>
                        <td>{{ $admin->id_administrador }}</td>
                        <td>{{ $admin->nombres }} {{ $admin->apellido_p }}</td>
                        <td>{{ $admin->correo_electronico }}</td>
                        <td>{{ $admin->telefono }}</td>
                        <td>
                            <form action="{{ route('admin.cambiarRol') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ $admin->id_administrador }}">
                                <input type="hidden" name="rol_actual" value="admin">
                                <select name="rol_nuevo">
                                    <option value="">Cambiar rol a...</option>
                                    <option value="cliente">Cliente</option>
                                    <option value="trabajador">Trabajador</option>
                                    <option value="ingeniero">Ingeniero</option>
                                </select>
                                <button type="submit">Cambiar</button>
                            </form>
                            
                            <form action="{{ route('admin.eliminarUsuario') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ $admin->id_administrador }}">
                                <input type="hidden" name="rol" value="admin">
                                <button type="submit" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay administradores registrados.</p>
    @endif

    <!-- INGENIEROS -->
    <h2>Ingenieros/Encargados</h2>
    @if($encargados->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($encargados as $encargado)
                    <tr>
                        <td>{{ $encargado->id_encargado }}</td>
                        <td>{{ $encargado->nombres }} {{ $encargado->apellido_p }}</td>
                        <td>{{ $encargado->correo_electronico }}</td>
                        <td>{{ $encargado->telefono }}</td>
                        <td>
                            <form action="{{ route('admin.cambiarRol') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ $encargado->id_encargado }}">
                                <input type="hidden" name="rol_actual" value="ingeniero">
                                <select name="rol_nuevo">
                                    <option value="">Cambiar rol a...</option>
                                    <option value="cliente">Cliente</option>
                                    <option value="trabajador">Trabajador</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <button type="submit">Cambiar</button>
                            </form>
                            
                            <form action="{{ route('admin.eliminarUsuario') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ $encargado->id_encargado }}">
                                <input type="hidden" name="rol" value="ingeniero">
                                <button type="submit" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay ingenieros registrados.</p>
    @endif

    <!-- REGISTRAR NUEVO TRABAJADOR -->
    <h2>Registrar Nuevo Trabajador</h2>
    <form action="{{ route('admin.registerWorker') }}" method="POST">
        @csrf
        <label>Nombres:</label>
        <input type="text" name="nombres" required>
        <br>

        <label>Apellido Paterno:</label>
        <input type="text" name="apellido_p" required>
        <br>

        <label>Apellido Materno:</label>
        <input type="text" name="apellido_m">
        <br>

        <label>Género:</label>
        <select name="genero" required>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
        </select>
        <br>

        <label>Teléfono:</label>
        <input type="text" name="telefono" required>
        <br>

        <label>Email:</label>
        <input type="email" name="correo_electronico" required>
        <br>

        <label>Nivel de Estudios:</label>
        <input type="text" name="nivel_estudios" required>
        <br>

        <label>Especialidad:</label>
        <input type="text" name="especializado" required>
        <br>

        <label>Domicilio:</label>
        <input type="text" name="domicilio" required>
        <br>

        <label>Código Postal:</label>
        <input type="number" name="cp" required>
        <br>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>

        <button type="submit">Registrar Trabajador</button>
    </form>
</div>
@endsection