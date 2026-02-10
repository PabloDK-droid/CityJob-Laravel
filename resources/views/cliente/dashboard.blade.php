@extends('layouts.app')

@section('content')
<div>
    <h1>Bienvenido, {{ $cliente->nombres }} {{ $cliente->apellido_p }}</h1>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>

    <h2>Panel de Cliente - CityJob</h2>

    <nav>
        <ul>
            <li><a href="{{ route('cliente.catalogo') }}">Ver Catálogo de Servicios</a></li>
            <li><a href="{{ route('cliente.misContrataciones') }}">Mis Contrataciones</a></li>
            <li><a href="{{ route('cliente.editarPerfil') }}">Editar mi Perfil</a></li>
        </ul>
    </nav>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
</div>
@endsection