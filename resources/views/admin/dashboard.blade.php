@extends('layouts.app')
@section('title', 'Panel de Administración')

@section('content')
<style>
    :root {
        --cyan:#00C3FF; --cyan-dim:#0094cc; --navy:#00152B;
        --navy-mid:#002647; --navy-light:#003B73;
        --text-muted:#8BAAC8; --border:rgba(0,195,255,0.15); --white:#FFFFFF;
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

    .page-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; letter-spacing:-.5px; margin-bottom:.25rem; }
    .page-title span { color:var(--cyan); }
    .page-sub { color:var(--text-muted); font-size:.9rem; margin-bottom:2rem; }

    .alert-success { background:rgba(0,195,255,.08); border:1px solid rgba(0,195,255,.2); color:var(--cyan); padding:.75rem 1rem; border-radius:.75rem; font-size:.88rem; margin-bottom:1.5rem; }

    /* stats grid */
    .stats-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1rem; margin-bottom:2.5rem; }
    .stat-card {
        background:rgba(255,255,255,.03); border:1px solid var(--border);
        border-radius:1rem; padding:1.5rem;
        display:flex; flex-direction:column; gap:.5rem;
        position:relative; overflow:hidden;
    }
    .stat-card::before { content:''; position:absolute; top:-30px; right:-30px; width:90px; height:90px; background:var(--cyan); border-radius:50%; filter:blur(40px); opacity:.07; pointer-events:none; }
    .stat-icon { width:38px; height:38px; border-radius:.65rem; background:rgba(0,195,255,.1); border:1px solid rgba(0,195,255,.2); display:flex; align-items:center; justify-content:center; color:var(--cyan); }
    .stat-label { font-size:.78rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
    .stat-value { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; color:var(--white); letter-spacing:-.5px; }
    .stat-value.green { color:#00d68f; }

    /* accesos */
    .section-title { font-family:'Syne',sans-serif; font-size:.9rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:1rem; }
    .quick-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1rem; }
    .quick-card {
        background:rgba(255,255,255,.03); border:1px solid var(--border);
        border-radius:1rem; padding:1.4rem 1.25rem;
        text-decoration:none; transition:all .25s;
        display:flex; flex-direction:column; gap:.6rem;
        position:relative; overflow:hidden;
    }
    .quick-card::before { content:''; position:absolute; inset:0; background:radial-gradient(circle at 50% 0%,rgba(0,195,255,.06),transparent 65%); opacity:0; transition:opacity .25s; }
    .quick-card:hover { border-color:rgba(0,195,255,.35); transform:translateY(-4px); box-shadow:0 12px 28px rgba(0,0,0,.25); }
    .quick-card:hover::before { opacity:1; }
    .quick-icon { width:42px; height:42px; border-radius:.75rem; background:rgba(0,195,255,.1); border:1px solid rgba(0,195,255,.2); display:flex; align-items:center; justify-content:center; color:var(--cyan); }
    .quick-label { font-family:'Syne',sans-serif; font-weight:700; font-size:.92rem; color:var(--white); }
    .quick-sub { font-size:.78rem; color:var(--text-muted); line-height:1.4; }

    @media(max-width:900px) { .cj-sidebar{display:none} .cj-main{padding:1.5rem 1rem} }
</style>

<div class="cj-page">
    <aside class="cj-sidebar">
        <div class="sidebar-brand">
            <img src="/img/CityJib_2.png" alt="CityJob">
            <span>City<em>Job</em></span>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Inicio
            </a>
            <a href="{{ route('admin.usuarios') }}">
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
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <h1 class="page-title">Panel de <span>Administración</span></h1>
        <p class="page-sub">Vista general del sistema CityJob</p>

        {{-- STATS --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                <span class="stat-label">Clientes</span>
                <span class="stat-value">{{ $stats['total_clientes'] }}</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></div>
                <span class="stat-label">Profesionistas</span>
                <span class="stat-value">{{ $stats['total_profesionistas'] }}</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></div>
                <span class="stat-label">Servicios</span>
                <span class="stat-value">{{ $stats['total_servicios'] }}</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                <span class="stat-label">Contrataciones</span>
                <span class="stat-value">{{ $stats['total_contrataciones'] }}</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                <span class="stat-label">Total Recaudado</span>
                <span class="stat-value green">${{ number_format($stats['total_recaudado'], 0) }}</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div>
                <span class="stat-label">Comisiones</span>
                <span class="stat-value green">${{ number_format($stats['comisiones_plataforma'], 0) }}</span>
            </div>
        </div>

        {{-- ACCESOS --}}
        <p class="section-title">Gestión del sistema</p>
        <div class="quick-grid">
            <a href="{{ route('admin.usuarios') }}" class="quick-card">
                <div class="quick-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <div class="quick-label">Usuarios</div>
                <div class="quick-sub">Gestionar clientes, trabajadores y roles</div>
            </a>
            <a href="{{ route('admin.servicios') }}" class="quick-card">
                <div class="quick-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></div>
                <div class="quick-label">Servicios</div>
                <div class="quick-sub">Crear, editar y eliminar servicios</div>
            </a>
            <a href="{{ route('admin.contrataciones') }}" class="quick-card">
                <div class="quick-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                <div class="quick-label">Contrataciones</div>
                <div class="quick-sub">Ver todos los servicios activos</div>
            </a>
            <a href="{{ route('admin.historial') }}" class="quick-card">
                <div class="quick-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div class="quick-label">Historial Global</div>
                <div class="quick-sub">Registro completo de contrataciones</div>
            </a>
            <a href="{{ route('admin.downloadLogs') }}" class="quick-card">
                <div class="quick-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></div>
                <div class="quick-label">Reportes CSV</div>
                <div class="quick-sub">Descargar logs del sistema</div>
            </a>
        </div>
    </main>
</div>
@endsection