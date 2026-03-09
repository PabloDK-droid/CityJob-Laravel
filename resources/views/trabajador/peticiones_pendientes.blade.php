@extends('layouts.app')
@section('title', 'Peticiones Pendientes')

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

    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; letter-spacing:-.5px; }
    .page-title span { color:var(--cyan); }
    .btn-back { display:inline-flex; align-items:center; gap:.4rem; color:var(--text-muted); text-decoration:none; font-size:.85rem; font-weight:600; transition:color .2s; }
    .btn-back:hover { color:var(--cyan); }

    .alert-success { background:rgba(0,195,255,.08); border:1px solid rgba(0,195,255,.2); color:var(--cyan); padding:.75rem 1rem; border-radius:.75rem; font-size:.88rem; margin-bottom:1.5rem; }

    /* cards peticiones */
    .peticiones-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(340px,1fr)); gap:1.25rem; }

    .peticion-card {
        background:rgba(255,255,255,.03); border:1px solid var(--border);
        border-radius:1.1rem; padding:1.5rem;
        display:flex; flex-direction:column; gap:1rem;
        transition:all .25s; position:relative; overflow:hidden;
    }
    .peticion-card::before {
        content:''; position:absolute; top:-40px; right:-40px;
        width:120px; height:120px; background:var(--cyan);
        border-radius:50%; filter:blur(50px); opacity:.05;
        pointer-events:none;
    }
    .peticion-card:hover { border-color:rgba(0,195,255,.3); box-shadow:0 8px 24px rgba(0,0,0,.2); }

    .peticion-header { display:flex; justify-content:space-between; align-items:flex-start; }
    .peticion-id { font-size:.75rem; color:var(--text-muted); font-weight:600; }
    .peticion-servicio { font-family:'Syne',sans-serif; font-weight:700; font-size:1.05rem; color:var(--white); margin-top:.25rem; }

    .peticion-info { display:flex; flex-direction:column; gap:.45rem; }
    .info-row { display:flex; align-items:center; gap:.5rem; font-size:.83rem; color:var(--text-muted); }
    .info-row svg { flex-shrink:0; color:var(--cyan); opacity:.7; }
    .info-row strong { color:var(--white); font-weight:600; }

    .peticion-monto { font-family:'Syne',sans-serif; font-size:1.3rem; font-weight:800; color:#00d68f; }
    .peticion-monto small { font-size:.7rem; font-weight:600; color:var(--text-muted); }

    .peticion-actions { display:flex; gap:.75rem; padding-top:.5rem; border-top:1px solid var(--border); }
    .btn-aceptar {
        flex:1; padding:.65rem; background:rgba(0,214,143,.12);
        border:1px solid rgba(0,214,143,.25); color:#00d68f;
        border-radius:.6rem; font-weight:700; font-size:.88rem;
        cursor:pointer; transition:all .2s; font-family:'Syne',sans-serif;
        display:flex; align-items:center; justify-content:center; gap:.4rem;
    }
    .btn-aceptar:hover { background:rgba(0,214,143,.22); transform:translateY(-1px); }
    .btn-rechazar {
        flex:1; padding:.65rem; background:rgba(220,53,69,.1);
        border:1px solid rgba(220,53,69,.2); color:#ff6b7a;
        border-radius:.6rem; font-weight:700; font-size:.88rem;
        cursor:pointer; transition:all .2s; font-family:'Syne',sans-serif;
        display:flex; align-items:center; justify-content:center; gap:.4rem;
    }
    .btn-rechazar:hover { background:rgba(220,53,69,.2); transform:translateY(-1px); }

    .empty-state { text-align:center; padding:4rem 2rem; color:var(--text-muted); }
    .empty-state svg { color:rgba(0,195,255,.2); margin-bottom:1rem; }

    @media(max-width:900px) { .cj-sidebar{display:none} .cj-main{padding:1.5rem 1rem} }
</style>

<div class="cj-page">
    <aside class="cj-sidebar">
        <div class="sidebar-brand">
            <img src="/img/CityJib_2.png" alt="CityJob">
            <span>City<em>Job</em></span>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('trabajador.dashboard') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Inicio
            </a>
            <a href="{{ route('trabajador.peticionesPendientes') }}" class="active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                Peticiones
            </a>
            <a href="{{ route('trabajador.serviciosAsignados') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Servicios
            </a>
            <a href="{{ route('trabajador.historial') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Historial
            </a>
            <div class="sidebar-divider"></div>
            <a href="{{ route('trabajador.editarPerfil') }}">
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
            <h1 class="page-title">Peticiones <span>Pendientes</span></h1>
            <a href="{{ route('trabajador.dashboard') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Volver al inicio
            </a>
        </div>

        @if($peticiones->count() > 0)
            <div class="peticiones-grid">
                @foreach($peticiones as $p)
                    <div class="peticion-card">
                        <div class="peticion-header">
                            <div>
                                <div class="peticion-id">#{{ $p->id_contratacion }}</div>
                                <div class="peticion-servicio">{{ $p->servicio->nombre_servicio }}</div>
                            </div>
                            <div class="peticion-monto">
                                ${{ number_format($p->monto_acordado, 2) }}
                                <small>MXN</small>
                            </div>
                        </div>

                        <div class="peticion-info">
                            <div class="info-row">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <strong>{{ $p->cliente->nombres }} {{ $p->cliente->apellido_p }}</strong>
                            </div>
                            <div class="info-row">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.77 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.68 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                {{ $p->cliente->telefono }}
                            </div>
                            <div class="info-row">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $p->localizacion }}
                            </div>
                            <div class="info-row">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ \Carbon\Carbon::parse($p->fecha_realizacion)->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="peticion-actions">
                            <form action="{{ route('trabajador.aceptarTrabajo', $p->id_contratacion) }}" method="POST" style="flex:1">
                                @csrf
                                <button type="submit" class="btn-aceptar" style="width:100%">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Aceptar
                                </button>
                            </form>
                            <form action="{{ route('trabajador.rechazarTrabajo', $p->id_contratacion) }}" method="POST" style="flex:1">
                                @csrf
                                <button type="submit" class="btn-rechazar" style="width:100%" onclick="return confirm('¿Rechazar este trabajo?')">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                <p>No tienes peticiones pendientes en este momento.</p>
            </div>
        @endif
    </main>
</div>
@endsection