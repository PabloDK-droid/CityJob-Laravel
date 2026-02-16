@extends('layouts.app')

@section('content')
<style>
    :root{--d1:#0066ff;--d2:#00a8ff}
    .worker-sidebar .brand{color:var(--d1);font-weight:700;margin-bottom:30px;font-size:18px}
    .worker-sidebar nav{display:flex;flex-direction:column;gap:0}
    .worker-sidebar a{color:#222;text-decoration:none;font-weight:600;padding:6px 8px;border-radius:6px}
    .worker-sidebar a:hover{background:rgba(0,0,0,0.03)}
    .worker-sidebar .spacer{flex:1}
    .worker-sidebar .logout-link{font-size:13px;color:#111;text-decoration:none;padding:4px 6px;border-radius:6px}
    .worker-sidebar .logout-link:hover{background:rgba(0,0,0,0.03)}
    .worker-page{display:flex;gap:30px;min-height:100vh}
    .worker-sidebar{width:140px;background:#fff;padding:24px 12px;display:flex;flex-direction:column}
    .worker-main{flex:1;display:flex;align-items:center;justify-content:center;padding:30px}

    .form-panel{width:100%;max-width:700px;border-radius:18px;display:flex;flex-direction:column;gap:20px;padding:48px;background:#fff;box-shadow:0 10px 40px rgba(2,6,23,0.08)}
    .form-panel h2{font-size:28px;font-weight:800;color:#04142b;margin:0 0 20px 0}
    .form-group{display:flex;flex-direction:column;gap:8px}
    .form-group label{font-weight:600;color:#222;font-size:14px}
    .form-group input,
    .form-group select{padding:10px 12px;border:1px solid #ddd;border-radius:6px;font-size:14px;font-family:inherit}
    .form-group input:focus,
    .form-group select:focus{outline:none;border-color:var(--d1);box-shadow:0 0 0 3px rgba(0,102,255,0.1)}
    .form-row{display:flex;gap:20px}
    .form-row .form-group{flex:1}
    .form-actions{display:flex;gap:12px;margin-top:20px}
    .btn-submit{background:var(--d1);color:#fff;padding:12px 20px;border-radius:10px;border:none;font-weight:700;cursor:pointer;transition:all 0.2s}
    .btn-submit:hover{background:#0052cc;transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,102,255,0.3)}
    .btn-back{background:#f0f0f0;color:#222;padding:12px 20px;border-radius:10px;border:none;font-weight:600;cursor:pointer;text-decoration:none;display:inline-block;transition:all 0.2s}
    .btn-back:hover{background:#e0e0e0}

    @media(max-width:1200px){
        .worker-page{flex-direction:column;gap:0}
        .worker-sidebar{display:none}
        .form-panel{margin:0}
    }
</style>

<div class="worker-page">


    <section class="worker-main">
        <div class="form-panel">
            <h2>Actualizar Perfil</h2>

            <form action="{{ route('trabajador.actualizarPerfil') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Nombres:</label>
                        <input type="text" name="nombres" value="{{ $profesionista->nombres }}" required>
                    </div>
                    <div class="form-group">
                        <label>Género:</label>
                        <select name="genero" required>
                            <option value="M" {{ $profesionista->genero == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ $profesionista->genero == 'F' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Apellido Paterno:</label>
                        <input type="text" name="apellido_p" value="{{ $profesionista->apellido_p }}" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido Materno:</label>
                        <input type="text" name="apellido_m" value="{{ $profesionista->apellido_m }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Teléfono:</label>
                        <input type="text" name="telefono" value="{{ $profesionista->telefono }}" required>
                    </div>
                    <div class="form-group">
                        <label>Código Postal:</label>
                        <input type="number" name="cp" value="{{ $profesionista->cp }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Domicilio:</label>
                    <input type="text" name="domicilio" value="{{ $profesionista->domicilio }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nivel de Estudios:</label>
                        <input type="text" name="nivel_estudios" value="{{ $profesionista->nivel_estudios }}" required>
                    </div>
                    <div class="form-group">
                        <label>Especialidad:</label>
                        <input type="text" name="especializado" value="{{ $profesionista->especializado }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nueva Contraseña (dejar en blanco para no cambiar):</label>
                    <input type="password" name="contrasena">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Actualizar Perfil</button>
                    <a href="{{ route('trabajador.dashboard') }}" class="btn-back">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</div>

@endsection