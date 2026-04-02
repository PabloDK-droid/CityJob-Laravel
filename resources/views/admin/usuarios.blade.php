@extends('layouts.app')
@section('title', 'Gestión de Usuarios')

@section('content')
<style>
    :root {
        --cyan:#00C3FF; --cyan-dim:#0094cc; --navy:#00152B;
        --navy-mid:#002647; --text-muted:#8BAAC8; --border:rgba(0,195,255,0.15); --white:#FFFFFF;
    }
    .cj-page { display:flex; min-height:100vh; background:var(--navy); font-family:'Instrument Sans',sans-serif; }

    .cj-sidebar { width:200px; flex-shrink:0; background:rgba(0,21,43,0.95); border-right:1px solid var(--border); display:flex; flex-direction:column; padding:1.75rem 1rem; position:sticky; top:0; height:100vh; }
    .sidebar-brand { display:flex; align-items:center; gap:.55rem; margin-bottom:2rem; padding:0 .5rem; text-decoration:none; }
    .sidebar-brand img { width:28px; height:28px; object-fit:contain; filter:drop-shadow(0 0 5px rgba(0,195,255,.5)); }
    .sidebar-brand span { font-family:'Syne',sans-serif; font-weight:800; font-size:1.1rem; color:var(--white); letter-spacing:-.5px; }
    .sidebar-brand span em { font-style:normal; color:var(--cyan); }
    .sidebar-nav { display:flex; flex-direction:column; gap:.15rem; flex:1; }
    .sidebar-nav a { display:flex; align-items:center; gap:.6rem; padding:.6rem .75rem; border-radius:.6rem; color:var(--text-muted); text-decoration:none; font-size:.88rem; font-weight:600; transition:all .2s; }
    .sidebar-nav a:hover { background:rgba(0,195,255,.07); color:var(--white); }
    .sidebar-nav a.active { background:rgba(0,195,255,.12); color:var(--cyan); border:1px solid rgba(0,195,255,.2); }
    .sidebar-nav a svg { flex-shrink:0; opacity:.7; }
    .sidebar-divider { height:1px; background:var(--border); margin:.75rem 0; }
    .sidebar-logout {
        display:flex; align-items:center; gap:.6rem; padding:.6rem .75rem; border-radius:.6rem;
        color:rgba(255,100,100,.6); font-size:.85rem; font-weight:600; cursor:pointer;
        transition:all .2s; background:none; border:none; width:100%; text-align:left;
        font-family:inherit; margin-top:auto;
    }
    .sidebar-logout:hover { background:rgba(255,80,80,.08); color:#ff6b6b; }

    .cj-main { flex:1; padding:2.5rem; overflow-y:auto; }

    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; letter-spacing:-.5px; }
    .page-title span { color:var(--cyan); }
    .btn-back { display:inline-flex; align-items:center; gap:.4rem; color:var(--text-muted); text-decoration:none; font-size:.85rem; font-weight:600; transition:color .2s; }
    .btn-back:hover { color:var(--cyan); }

    .alert { padding:.75rem 1rem; border-radius:.75rem; font-size:.88rem; margin-bottom:1.25rem; }
    .alert-success { background:rgba(0,195,255,.08); border:1px solid rgba(0,195,255,.2); color:var(--cyan); }
    .alert-error   { background:rgba(220,53,69,.1);  border:1px solid rgba(220,53,69,.25); color:#ff6b7a; }

    .section-block { margin-bottom:2.5rem; }
    .section-title { font-family:'Syne',sans-serif; font-size:.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; }
    .section-title::after { content:''; flex:1; height:1px; background:var(--border); }

    /* Botón para abrir modal */
    .btn-add-user {
        display:inline-flex; align-items:center; gap:.5rem;
        padding:.6rem 1.25rem; background:var(--cyan); color:var(--navy);
        border-radius:.65rem; font-family:'Syne',sans-serif; font-weight:700;
        font-size:.88rem; border:none; cursor:pointer; transition:all .2s;
        text-decoration:none;
    }
    .btn-add-user:hover { background:var(--cyan-dim); transform:translateY(-1px); }

    .table-wrap { overflow-x:auto; border-radius:1rem; border:1px solid var(--border); margin-bottom:1rem; }
    table { width:100%; border-collapse:collapse; }
    thead tr { border-bottom:1px solid var(--border); }
    thead th { padding:.8rem 1rem; text-align:left; font-size:.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.8px; white-space:nowrap; }
    tbody tr { border-bottom:1px solid rgba(0,195,255,.07); transition:background .15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(0,195,255,.03); }
    td { padding:.8rem 1rem; font-size:.85rem; color:var(--white); vertical-align:middle; }
    .text-muted { color:var(--text-muted); font-size:.78rem; }
    .rating { color:#ffc107; font-size:.82rem; font-weight:700; }

    .td-actions { display:flex; gap:.5rem; align-items:center; flex-wrap:wrap; }
    .inline-select {
        padding:.35rem .6rem; background:rgba(255,255,255,.06);
        border:1px solid var(--border); border-radius:.5rem;
        color:var(--white); font-family:'Instrument Sans',sans-serif;
        font-size:.75rem; outline:none; cursor:pointer;
    }
    .inline-select:focus { border-color:var(--cyan); }
    .inline-select option { background:#002647; color:var(--white); }
    .btn-sm { display:inline-flex; align-items:center; padding:.35rem .75rem; border-radius:.5rem; font-size:.75rem; font-weight:700; border:none; cursor:pointer; transition:all .2s; font-family:'Instrument Sans',sans-serif; white-space:nowrap; }
    .btn-cambiar  { background:rgba(0,195,255,.12); color:var(--cyan); border:1px solid rgba(0,195,255,.2); }
    .btn-cambiar:hover { background:rgba(0,195,255,.22); }
    .btn-eliminar { background:rgba(220,53,69,.1);  color:#ff6b7a; border:1px solid rgba(220,53,69,.2); }
    .btn-eliminar:hover { background:rgba(220,53,69,.2); }

    /* ===== MODAL ===== */
    .modal-overlay {
        display:none; position:fixed; inset:0;
        background:rgba(0,10,25,.75); backdrop-filter:blur(6px);
        z-index:1000; align-items:center; justify-content:center; padding:1.5rem;
    }
    .modal-overlay.open { display:flex; }

    .modal-box {
        background:#001e3c; border:1px solid var(--border);
        border-radius:1.25rem; padding:2rem;
        width:100%; max-width:680px;
        max-height:90vh; overflow-y:auto;
        position:relative;
        animation:modalIn .25s ease both;
    }
    @keyframes modalIn { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }

    .modal-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; }
    .modal-title { font-family:'Syne',sans-serif; font-weight:800; font-size:1.1rem; color:var(--white); }
    .modal-title span { color:var(--cyan); }
    .modal-close {
        width:32px; height:32px; border-radius:.5rem;
        background:rgba(255,255,255,.06); border:1px solid var(--border);
        color:var(--text-muted); cursor:pointer; transition:all .2s;
        display:flex; align-items:center; justify-content:center;
    }
    .modal-close:hover { background:rgba(220,53,69,.1); color:#ff6b7a; border-color:rgba(220,53,69,.2); }

    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .form-full { grid-column:1/-1; }
    .form-group { display:flex; flex-direction:column; gap:.4rem; }
    .form-group label { font-size:.82rem; font-weight:600; color:#a8c5e0; }
    .form-group input, .form-group select {
        padding:.7rem 1rem; background:rgba(255,255,255,.06);
        border:1px solid var(--border); border-radius:.65rem;
        color:var(--white); font-family:'Instrument Sans',sans-serif;
        font-size:.9rem; outline:none; transition:border-color .2s, box-shadow .2s; width:100%;
    }
    .form-group input:focus, .form-group select:focus { border-color:var(--cyan); box-shadow:0 0 0 3px rgba(0,195,255,.1); }
    .form-group input::placeholder { color:rgba(139,170,200,.35); }
    .form-group select option { background:#002647; color:var(--white); }

    .modal-footer { display:flex; gap:.75rem; margin-top:1.5rem; justify-content:flex-end; }
    .btn-submit { background:var(--cyan); color:var(--navy); padding:.7rem 2rem; border-radius:.65rem; font-family:'Syne',sans-serif; font-weight:700; font-size:.95rem; border:none; cursor:pointer; transition:all .2s; }
    .btn-submit:hover { background:var(--cyan-dim); }
    .btn-cancel-modal { background:transparent; color:var(--text-muted); padding:.7rem 1.25rem; border-radius:.65rem; border:1px solid var(--border); font-weight:600; font-size:.9rem; cursor:pointer; transition:all .2s; font-family:'Instrument Sans',sans-serif; }
    .btn-cancel-modal:hover { border-color:var(--cyan); color:var(--cyan); }

    @media(max-width:900px) { .cj-sidebar{display:none} .cj-main{padding:1.5rem 1rem} .form-grid{grid-template-columns:1fr} }
</style>

<div class="cj-page">
    <aside class="cj-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="/img/CityJib_2.png" alt="CityJob">
            <span>City<em>Job</em></span>
        </a>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Inicio
            </a>
            <a href="{{ route('admin.usuarios') }}" class="active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Usuarios
            </a>
            <a href="{{ route('admin.servicios') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                Servicios
            </a>
            <a href="{{ route('admin.contrataciones') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Contrataciones
            </a>
            <a href="{{ route('admin.historial') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Historial
            </a>
            <div class="sidebar-divider"></div>
            <a href="{{ route('admin.downloadLogs') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Reportes CSV
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
            <h1 class="page-title">Gestión de <span>Usuarios</span></h1>
            <div style="display:flex;gap:.75rem;align-items:center;flex-wrap:wrap">
                <button class="btn-add-user" onclick="openModal()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Nuevo trabajador
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    Volver al panel
                </a>
            </div>
        </div>

        @php
            function rolOptions($rolActual) {
                $roles = ['cliente','trabajador','admin','ingeniero'];
                $opts = '<option value="">Cambiar rol...</option>';
                foreach($roles as $r) {
                    if($r !== $rolActual) $opts .= "<option value=\"$r\">".ucfirst($r)."</option>";
                }
                return $opts;
            }
        @endphp

        {{-- CLIENTES --}}
        <div class="section-block">
            <p class="section-title">Clientes ({{ $clientes->count() }})</p>
            @if($clientes->count() > 0)
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>#</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Acciones</th></tr></thead>
                        <tbody>
                            @foreach($clientes as $c)
                                <tr>
                                    <td class="text-muted">{{ $c->id_cliente }}</td>
                                    <td style="font-weight:600">{{ $c->nombres }} {{ $c->apellido_p }}</td>
                                    <td class="text-muted">{{ $c->correo_electronico }}</td>
                                    <td class="text-muted">{{ $c->telefono }}</td>
                                    <td>
                                        <div class="td-actions">
                                            <form action="{{ route('admin.cambiarRol') }}" method="POST" style="display:contents">
                                                @csrf
                                                <input type="hidden" name="usuario_id" value="{{ $c->id_cliente }}">
                                                <input type="hidden" name="rol_actual" value="cliente">
                                                <select name="rol_nuevo" class="inline-select">{!! rolOptions('cliente') !!}</select>
                                                <button type="submit" class="btn-sm btn-cambiar">Cambiar</button>
                                            </form>
                                            <form action="{{ route('admin.eliminarUsuario') }}" method="POST" style="display:contents">
                                                @csrf
                                                <input type="hidden" name="usuario_id" value="{{ $c->id_cliente }}">
                                                <input type="hidden" name="rol" value="cliente">
                                                <button type="submit" class="btn-sm btn-eliminar" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- PROFESIONISTAS --}}
        <div class="section-block">
            <p class="section-title">Profesionistas ({{ $profesionistas->count() }})</p>
            @if($profesionistas->count() > 0)
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>#</th><th>Nombre</th><th>Email</th><th>Especialidad</th><th>Calificación</th><th>Acciones</th></tr></thead>
                        <tbody>
                            @foreach($profesionistas as $p)
                                <tr>
                                    <td class="text-muted">{{ $p->id_profesionista }}</td>
                                    <td style="font-weight:600">{{ $p->nombres }} {{ $p->apellido_p }}</td>
                                    <td class="text-muted">{{ $p->correo_electronico }}</td>
                                    <td class="text-muted">{{ $p->especializado }}</td>
                                    <td><span class="rating">★ {{ number_format($p->calificacion_profesionista,1) }}</span></td>
                                    <td>
                                        <div class="td-actions">
                                            <form action="{{ route('admin.cambiarRol') }}" method="POST" style="display:contents">
                                                @csrf
                                                <input type="hidden" name="usuario_id" value="{{ $p->id_profesionista }}">
                                                <input type="hidden" name="rol_actual" value="trabajador">
                                                <select name="rol_nuevo" class="inline-select">{!! rolOptions('trabajador') !!}</select>
                                                <button type="submit" class="btn-sm btn-cambiar">Cambiar</button>
                                            </form>
                                            <form action="{{ route('admin.eliminarUsuario') }}" method="POST" style="display:contents">
                                                @csrf
                                                <input type="hidden" name="usuario_id" value="{{ $p->id_profesionista }}">
                                                <input type="hidden" name="rol" value="trabajador">
                                                <button type="submit" class="btn-sm btn-eliminar" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- ADMINS --}}
        @if($administradores->count() > 0)
        <div class="section-block">
            <p class="section-title">Administradores ({{ $administradores->count() }})</p>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>#</th><th>Nombre</th><th>Email</th><th>Acciones</th></tr></thead>
                    <tbody>
                        @foreach($administradores as $a)
                            <tr>
                                <td class="text-muted">{{ $a->id_administrador }}</td>
                                <td style="font-weight:600">{{ $a->nombres }} {{ $a->apellido_p }}</td>
                                <td class="text-muted">{{ $a->correo_electronico }}</td>
                                <td>
                                    <div class="td-actions">
                                        <form action="{{ route('admin.eliminarUsuario') }}" method="POST" style="display:contents">
                                            @csrf
                                            <input type="hidden" name="usuario_id" value="{{ $a->id_administrador }}">
                                            <input type="hidden" name="rol" value="admin">
                                            <button type="submit" class="btn-sm btn-eliminar" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- ENCARGADOS --}}
        @if($encargados->count() > 0)
        <div class="section-block">
            <p class="section-title">Ingenieros / Encargados ({{ $encargados->count() }})</p>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>#</th><th>Nombre</th><th>Email</th><th>Acciones</th></tr></thead>
                    <tbody>
                        @foreach($encargados as $e)
                            <tr>
                                <td class="text-muted">{{ $e->id_encargado }}</td>
                                <td style="font-weight:600">{{ $e->nombres }} {{ $e->apellido_p }}</td>
                                <td class="text-muted">{{ $e->correo_electronico }}</td>
                                <td>
                                    <div class="td-actions">
                                        <form action="{{ route('admin.eliminarUsuario') }}" method="POST" style="display:contents">
                                            @csrf
                                            <input type="hidden" name="usuario_id" value="{{ $e->id_encargado }}">
                                            <input type="hidden" name="rol" value="ingeniero">
                                            <button type="submit" class="btn-sm btn-eliminar" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </main>
</div>

{{-- ===== MODAL NUEVO TRABAJADOR ===== --}}
<div class="modal-overlay" id="modalOverlay" onclick="closeOnBackdrop(event)">
    <div class="modal-box" id="modalBox">
        <div class="modal-header">
            <span class="modal-title">Registrar nuevo <span>trabajador</span></span>
            <button class="modal-close" onclick="closeModal()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.registerWorker') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group"><label>Nombres</label><input type="text" name="nombres" required placeholder="Nombres"></div>
                <div class="form-group"><label>Género</label>
                    <select name="genero" required>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div class="form-group"><label>Apellido Paterno</label><input type="text" name="apellido_p" required placeholder="Apellido paterno"></div>
                <div class="form-group"><label>Apellido Materno</label><input type="text" name="apellido_m" placeholder="Apellido materno"></div>
                <div class="form-group"><label>Teléfono</label><input type="text" name="telefono" required placeholder="10 dígitos"></div>
                <div class="form-group"><label>Email</label><input type="email" name="correo_electronico" required placeholder="correo@ejemplo.com"></div>
                <div class="form-group"><label>Nivel de Estudios</label><input type="text" name="nivel_estudios" required placeholder="Ej: Licenciatura"></div>
                <div class="form-group"><label>Especialidad</label><input type="text" name="especializado" required placeholder="Ej: Plomería"></div>
                <div class="form-group"><label>Código Postal</label><input type="number" name="cp" required placeholder="00000"></div>
                <div class="form-group"><label>Contraseña</label><input type="password" name="contrasena" required placeholder="••••••••"></div>
                <div class="form-group form-full"><label>Domicilio</label><input type="text" name="domicilio" required placeholder="Calle, número, colonia..."></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel-modal" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn-submit">Registrar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        document.getElementById('modalOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }
    function closeOnBackdrop(e) {
        if (e.target === document.getElementById('modalOverlay')) closeModal();
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    // Si hubo error de validación, abrir el modal automáticamente
    @if($errors->any())
        openModal();
    @endif
</script>
@endsection