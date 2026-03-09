@extends('layouts.app')
@section('title', 'Catálogo de Servicios')

@section('content')
<style>
    :root {
        --cyan:       #00C3FF;
        --cyan-dim:   #0094cc;
        --navy:       #00152B;
        --navy-mid:   #002647;
        --navy-light: #003B73;
        --text-muted: #8BAAC8;
        --border:     rgba(0,195,255,0.15);
        --white:      #FFFFFF;
    }

    .cj-page { display:flex; min-height:100vh; background:var(--navy); font-family:'Instrument Sans',sans-serif; }

    /* SIDEBAR */
    .cj-sidebar {
        width:200px; flex-shrink:0;
        background:rgba(0,21,43,0.95);
        border-right:1px solid var(--border);
        display:flex; flex-direction:column;
        padding:1.75rem 1rem;
        position:sticky; top:0; height:100vh;
    }
    .sidebar-brand { display:flex; align-items:center; gap:.55rem; margin-bottom:2rem; padding:0 .5rem; }
    .sidebar-brand img { width:28px; height:28px; object-fit:contain; filter:drop-shadow(0 0 5px rgba(0,195,255,.5)); }
    .sidebar-brand span { font-family:'Syne',sans-serif; font-weight:800; font-size:1.1rem; color:var(--white); letter-spacing:-.5px; }
    .sidebar-brand span em { font-style:normal; color:var(--cyan); }
    .sidebar-nav { display:flex; flex-direction:column; gap:.15rem; flex:1; }
    .sidebar-nav a {
        display:flex; align-items:center; gap:.6rem;
        padding:.6rem .75rem; border-radius:.6rem;
        color:var(--text-muted); text-decoration:none;
        font-size:.88rem; font-weight:600; transition:all .2s;
    }
    .sidebar-nav a:hover { background:rgba(0,195,255,.07); color:var(--white); }
    .sidebar-nav a.active { background:rgba(0,195,255,.12); color:var(--cyan); border:1px solid rgba(0,195,255,.2); }
    .sidebar-nav a svg { flex-shrink:0; opacity:.7; }
    .sidebar-nav a:hover svg, .sidebar-nav a.active svg { opacity:1; }
    .sidebar-divider { height:1px; background:var(--border); margin:.75rem 0; }
    .sidebar-logout {
        display:flex; align-items:center; gap:.6rem;
        padding:.6rem .75rem; border-radius:.6rem;
        color:rgba(255,100,100,.6); font-size:.85rem; font-weight:600;
        cursor:pointer; transition:all .2s;
        background:none; border:none; width:100%; text-align:left; font-family:inherit;
    }
    .sidebar-logout:hover { background:rgba(255,80,80,.08); color:#ff6b6b; }

    /* MAIN */
    .cj-main { flex:1; padding:2.5rem; overflow-y:auto; }

    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; letter-spacing:-.5px; }
    .page-title span { color:var(--cyan); }
    .btn-back {
        display:inline-flex; align-items:center; gap:.4rem;
        color:var(--text-muted); text-decoration:none; font-size:.85rem; font-weight:600;
        transition:color .2s;
    }
    .btn-back:hover { color:var(--cyan); }

    /* FILTROS */
    .filter-card {
        background:rgba(255,255,255,.03);
        border:1px solid var(--border);
        border-radius:1rem;
        padding:1.5rem;
        margin-bottom:2rem;
    }
    .filter-title { font-family:'Syne',sans-serif; font-size:.9rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:1rem; }
    .filter-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-bottom:1rem; }
    .filter-group { display:flex; flex-direction:column; gap:.4rem; }
    .filter-group label { font-size:.82rem; font-weight:600; color:#a8c5e0; }
    .filter-group input {
        padding:.6rem .9rem;
        background:rgba(255,255,255,.06);
        border:1px solid var(--border);
        border-radius:.6rem;
        color:var(--white);
        font-family:'Instrument Sans',sans-serif;
        font-size:.9rem;
        outline:none;
        transition:border-color .2s, box-shadow .2s;
    }
    .filter-group input:focus { border-color:var(--cyan); box-shadow:0 0 0 3px rgba(0,195,255,.1); }
    .filter-group input::placeholder { color:rgba(139,170,200,.4); }
    .filter-actions { display:flex; gap:.75rem; }
    .btn-cyan {
        background:var(--cyan); color:var(--navy);
        padding:.6rem 1.4rem; border-radius:.6rem;
        font-weight:700; font-size:.88rem; border:none;
        cursor:pointer; transition:all .2s; font-family:'Syne',sans-serif;
    }
    .btn-cyan:hover { background:var(--cyan-dim); transform:translateY(-1px); }
    .btn-ghost {
        background:transparent; color:var(--text-muted);
        padding:.6rem 1.2rem; border-radius:.6rem;
        border:1px solid var(--border);
        font-weight:600; font-size:.88rem;
        text-decoration:none; transition:all .2s;
        display:inline-flex; align-items:center;
    }
    .btn-ghost:hover { border-color:var(--cyan); color:var(--cyan); }

    /* GRID SERVICIOS */
    .servicios-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:1.25rem; }

    .servicio-card {
        background:rgba(255,255,255,.03);
        border:1px solid var(--border);
        border-radius:1.1rem;
        padding:1.5rem;
        display:flex; flex-direction:column; gap:.75rem;
        transition:all .25s;
        position:relative; overflow:hidden;
    }
    .servicio-card::before {
        content:'';
        position:absolute; inset:0;
        background:radial-gradient(circle at 50% 0%, rgba(0,195,255,.06), transparent 65%);
        opacity:0; transition:opacity .25s;
    }
    .servicio-card:hover { border-color:rgba(0,195,255,.35); transform:translateY(-4px); box-shadow:0 12px 28px rgba(0,0,0,.25); }
    .servicio-card:hover::before { opacity:1; }

    .servicio-icon {
        width:44px; height:44px;
        background:rgba(0,195,255,.1);
        border:1px solid rgba(0,195,255,.2);
        border-radius:.75rem;
        display:flex; align-items:center; justify-content:center;
        color:var(--cyan);
    }
    .servicio-nombre { font-family:'Syne',sans-serif; font-weight:700; font-size:1rem; color:var(--white); }
    .servicio-precio { font-size:1.25rem; font-weight:800; color:var(--cyan); font-family:'Syne',sans-serif; }
    .servicio-stats { font-size:.78rem; color:var(--text-muted); }
    .btn-contratar {
        display:block; text-align:center;
        background:var(--cyan); color:var(--navy);
        padding:.65rem; border-radius:.6rem;
        font-weight:700; font-size:.85rem;
        text-decoration:none; transition:all .2s;
        font-family:'Syne',sans-serif;
        margin-top:auto;
        position:relative; z-index:1;
    }
    .btn-contratar:hover { background:var(--cyan-dim); transform:translateY(-1px); }

    /* EMPTY */
    .empty-state {
        text-align:center; padding:4rem 2rem;
        color:var(--text-muted);
    }
    .empty-state svg { color:rgba(0,195,255,.25); margin-bottom:1rem; }
    .empty-state p { margin-bottom:1rem; }

    /* alerts */
    .alert-success { background:rgba(0,195,255,.08); border:1px solid rgba(0,195,255,.2); color:var(--cyan); padding:.75rem 1rem; border-radius:.75rem; font-size:.88rem; margin-bottom:1.5rem; }

    @media(max-width:900px) { .cj-sidebar{display:none} .cj-main{padding:1.5rem 1rem} }
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
            <a href="{{ route('cliente.catalogo') }}" class="active">
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
            <a href="{{ route('cliente.editarPerfil') }}">
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
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <h1 class="page-title">Catálogo de <span>Servicios</span></h1>
            <a href="{{ route('cliente.dashboard') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Volver al inicio
            </a>
        </div>

        {{-- FILTROS --}}
        <div class="filter-card">
            <p class="filter-title">Filtros de búsqueda</p>
            <form method="GET" action="{{ route('cliente.catalogo') }}">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label>Buscar servicio</label>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Ej: Plomería">
                    </div>
                    <div class="filter-group">
                        <label>Precio mínimo</label>
                        <input type="number" name="precio_min" value="{{ request('precio_min') }}" placeholder="$0" step="50">
                    </div>
                    <div class="filter-group">
                        <label>Precio máximo</label>
                        <input type="number" name="precio_max" value="{{ request('precio_max') }}" placeholder="$10,000" step="50">
                    </div>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-cyan">Buscar</button>
                    <a href="{{ route('cliente.catalogo') }}" class="btn-ghost">Limpiar filtros</a>
                </div>
            </form>
        </div>

        {{-- GRID --}}
        @if($servicios->count() > 0)
            <div class="servicios-grid">
                @foreach($servicios as $servicio)
                    <div class="servicio-card">
                        <div class="servicio-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                        </div>
                        <div class="servicio-nombre">{{ $servicio->nombre_servicio }}</div>
                        <div class="servicio-precio">${{ number_format($servicio->precio_base, 2) }} <small style="font-size:.7rem;font-weight:600;color:var(--text-muted)">MXN</small></div>
                        <div class="servicio-stats">{{ $servicio->contrataciones_count }} contrataciones</div>
                        <a href="{{ route('cliente.profesionistas', $servicio->id_servicio) }}" class="btn-contratar">
                            Ver Profesionistas
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <p>No se encontraron servicios con esos filtros.</p>
                <a href="{{ route('cliente.catalogo') }}" class="btn-ghost">Limpiar filtros</a>
            </div>
        @endif
    </main>
</div>
@endsection