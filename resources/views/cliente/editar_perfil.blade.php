@extends('layouts.app')
@section('title', 'Editar Perfil')

@section('content')
<style>
    :root {
        --cyan:#00C3FF; --cyan-dim:#0094cc; --navy:#00152B;
        --navy-mid:#002647; --text-muted:#8BAAC8; --border:rgba(0,195,255,0.15); --white:#FFFFFF;
    }
    .cj-page { display:flex; min-height:100vh; background:var(--navy); font-family:'Instrument Sans',sans-serif; }

    .cj-sidebar { width:200px; flex-shrink:0; background:rgba(0,21,43,0.95); border-right:1px solid var(--border); display:flex; flex-direction:column; padding:1.75rem 1rem; position:sticky; top:0; height:100vh; }
    .sidebar-brand { display:flex; align-items:center; gap:.55rem; margin-bottom:2rem; padding:0 .5rem; }
    .sidebar-brand img { width:28px; height:28px; object-fit:contain; filter:drop-shadow(0 0 5px rgba(0,195,255,.5)); }
    .sidebar-brand span { font-family:'Syne',sans-serif; font-weight:800; font-size:1.1rem; color:var(--white); letter-spacing:-.5px; }
    .sidebar-brand span em { font-style:normal; color:var(--cyan); }
    .sidebar-nav { display:flex; flex-direction:column; gap:.15rem; flex:1; }
    .sidebar-nav a { display:flex; align-items:center; gap:.6rem; padding:.6rem .75rem; border-radius:.6rem; color:var(--text-muted); text-decoration:none; font-size:.88rem; font-weight:600; transition:all .2s; }
    .sidebar-nav a:hover { background:rgba(0,195,255,.07); color:var(--white); }
    .sidebar-nav a.active { background:rgba(0,195,255,.12); color:var(--cyan); border:1px solid rgba(0,195,255,.2); }
    .sidebar-nav a svg { flex-shrink:0; opacity:.7; }
    .sidebar-nav a:hover svg,.sidebar-nav a.active svg { opacity:1; }
    .sidebar-divider { height:1px; background:var(--border); margin:.75rem 0; }
    .sidebar-logout { display:flex; align-items:center; gap:.6rem; padding:.6rem .75rem; border-radius:.6rem; color:rgba(255,100,100,.6); font-size:.85rem; font-weight:600; cursor:pointer; transition:all .2s; background:none; border:none; width:100%; text-align:left; font-family:inherit; }
    .sidebar-logout:hover { background:rgba(255,80,80,.08); color:#ff6b6b; }

    .cj-main { flex:1; padding:2.5rem; overflow-y:auto; }

    .page-header { margin-bottom:2rem; }
    .btn-back { display:inline-flex; align-items:center; gap:.4rem; color:var(--text-muted); text-decoration:none; font-size:.85rem; font-weight:600; transition:color .2s; margin-bottom:1rem; }
    .btn-back:hover { color:var(--cyan); }
    .page-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; letter-spacing:-.5px; margin-bottom:.25rem; }
    .page-sub { color:var(--text-muted); font-size:.9rem; }

    /* alerts */
    .alert { padding:.75rem 1rem; border-radius:.75rem; font-size:.88rem; margin-bottom:1.5rem; }
    .alert-success { background:rgba(0,195,255,.08); border:1px solid rgba(0,195,255,.2); color:var(--cyan); }
    .alert-error { background:rgba(220,53,69,.1); border:1px solid rgba(220,53,69,.25); color:#ff6b7a; }

    /* form layout */
    .form-card {
        background:rgba(255,255,255,.03);
        border:1px solid var(--border);
        border-radius:1.25rem;
        padding:2rem;
        max-width:700px;
    }

    .form-section { margin-bottom:2rem; }
    .form-section-title {
        font-family:'Syne',sans-serif; font-size:.8rem; font-weight:700;
        color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;
        margin-bottom:1.1rem; padding-bottom:.6rem;
        border-bottom:1px solid var(--border);
    }

    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .form-grid.cols-3 { grid-template-columns:1fr 1fr 1fr; }
    .form-full { grid-column:1/-1; }

    .form-group { display:flex; flex-direction:column; gap:.4rem; }
    .form-group label { font-size:.82rem; font-weight:600; color:#a8c5e0; }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding:.7rem 1rem;
        background:rgba(255,255,255,.06);
        border:1px solid var(--border);
        border-radius:.65rem;
        color:var(--white);
        font-family:'Instrument Sans',sans-serif;
        font-size:.9rem;
        outline:none;
        transition:border-color .2s, box-shadow .2s;
        width:100%;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus { border-color:var(--cyan); box-shadow:0 0 0 3px rgba(0,195,255,.1); }
    .form-group input::placeholder,
    .form-group textarea::placeholder { color:rgba(139,170,200,.35); }
    .form-group select option { background:#002647; color:var(--white); }
    .form-group textarea { min-height:80px; resize:vertical; }
    .field-error { color:#ff6b7a; font-size:.78rem; }

    .form-actions { display:flex; gap:.75rem; margin-top:1.5rem; }
    .btn-submit {
        background:var(--cyan); color:var(--navy);
        padding:.75rem 2rem; border-radius:.65rem;
        font-family:'Syne',sans-serif; font-weight:700; font-size:.95rem;
        border:none; cursor:pointer; transition:all .2s;
        box-shadow:0 4px 20px rgba(0,195,255,.25);
    }
    .btn-submit:hover { background:var(--cyan-dim); transform:translateY(-2px); }
    .btn-cancel {
        background:transparent; color:var(--text-muted);
        padding:.75rem 1.5rem; border-radius:.65rem;
        border:1px solid var(--border); font-weight:600; font-size:.9rem;
        text-decoration:none; transition:all .2s;
    }
    .btn-cancel:hover { border-color:var(--cyan); color:var(--cyan); }

    @media(max-width:900px) { .cj-sidebar{display:none} .cj-main{padding:1.5rem 1rem} .form-grid,.form-grid.cols-3{grid-template-columns:1fr} }
</style>

<div class="cj-page">
    <aside class="cj-sidebar">
        <div class="sidebar-brand">
            <img src="/img/CityJib_2.png" alt="CityJob">
            <span>City<em>Job</em></span>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('cliente.dashboard') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Inicio
            </a>
            <a href="{{ route('cliente.catalogo') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Catálogo
            </a>
            <a href="{{ route('cliente.misContrataciones') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Contrataciones
            </a>
            <a href="{{ route('cliente.historial') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Historial
            </a>
            <div class="sidebar-divider"></div>
            <a href="{{ route('cliente.editarPerfil') }}" class="active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Mi Perfil
            </a>
            <a href="{{ route('ayuda') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Ayuda
            </a>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
        <button class="sidebar-logout" onclick="document.getElementById('logout-form').submit()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Cerrar sesión
        </button>
    </aside>

    <main class="cj-main">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <div class="page-header">
            <a href="{{ route('cliente.dashboard') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Volver al inicio
            </a>
            <h1 class="page-title">Mi Perfil</h1>
            <p class="page-sub">Actualiza tu información personal</p>
        </div>

        <div class="form-card">
            <form action="{{ route('cliente.actualizarPerfil') }}" method="POST">
                @csrf

                {{-- Datos personales --}}
                <div class="form-section">
                    <p class="form-section-title">Datos personales</p>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" name="nombres" value="{{ old('nombres', $cliente->nombres) }}" required>
                            @error('nombres')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Apellido Paterno</label>
                            <input type="text" name="apellido_p" value="{{ old('apellido_p', $cliente->apellido_p) }}" required>
                            @error('apellido_p')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Apellido Materno</label>
                            <input type="text" name="apellido_m" value="{{ old('apellido_m', $cliente->apellido_m) }}">
                        </div>
                        <div class="form-group">
                            <label>Género</label>
                            <select name="genero" required>
                                <option value="M" {{ $cliente->genero == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ $cliente->genero == 'F' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Contacto --}}
                <div class="form-section">
                    <p class="form-section-title">Contacto</p>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Teléfono celular</label>
                            <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" required>
                            @error('telefono')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Teléfono fijo (opcional)</label>
                            <input type="text" name="telefono_fijo" value="{{ old('telefono_fijo', $cliente->telefono_fijo ?? '') }}">
                        </div>
                    </div>
                </div>

                {{-- Domicilio --}}
                <div class="form-section">
                    <p class="form-section-title">Domicilio</p>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Código Postal</label>
                            <input type="number" name="cp" value="{{ old('cp', $cliente->cp) }}" required>
                            @error('cp')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group form-full">
                            <label>Domicilio</label>
                            <input type="text" name="domicilio" value="{{ old('domicilio', $cliente->domicilio) }}" required>
                            @error('domicilio')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group form-full">
                            <label>Referencias</label>
                            <textarea name="referencias" placeholder="Ej: Casa color azul, frente al parque...">{{ old('referencias', $cliente->referencias) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Seguridad --}}
                <div class="form-section">
                    <p class="form-section-title">Seguridad</p>
                    <div class="form-grid">
                        <div class="form-group form-full">
                            <label>Nueva contraseña <span style="color:var(--text-muted);font-weight:400">(dejar en blanco para no cambiar)</span></label>
                            <input type="password" name="contrasena" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar cambios</button>
                    <a href="{{ route('cliente.dashboard') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection