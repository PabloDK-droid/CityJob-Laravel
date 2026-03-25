@extends('layouts.app')
@section('title', 'Mis Calificaciones')

@section('content')
<style>
    :root { --cyan:#00C3FF; --cyan-dim:#0094cc; --navy:#00152B; --text-muted:#8BAAC8; --border:rgba(0,195,255,0.15); --white:#FFFFFF; }
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
    .sidebar-divider { height:1px; background:var(--border); margin:.75rem 0; }
    .sidebar-logout { display:flex; align-items:center; gap:.6rem; padding:.6rem .75rem; border-radius:.6rem; color:rgba(255,100,100,.6); font-size:.85rem; font-weight:600; cursor:pointer; transition:all .2s; background:none; border:none; width:100%; text-align:left; font-family:inherit; }
    .sidebar-logout:hover { background:rgba(255,80,80,.08); color:#ff6b6b; }
    .cj-main { flex:1; padding:2.5rem; overflow-y:auto; }
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; }
    .page-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; letter-spacing:-.5px; }
    .page-title span { color:var(--cyan); }
    .alert { padding:.75rem 1rem; border-radius:.75rem; font-size:.88rem; margin-bottom:1.5rem; }
    .alert-success { background:rgba(0,195,255,.08); border:1px solid rgba(0,195,255,.2); color:var(--cyan); }
    .alert-error   { background:rgba(220,53,69,.1); border:1px solid rgba(220,53,69,.25); color:#ff6b7a; }
    .section-title { font-family:'Syne',sans-serif; font-size:.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; }
    .section-title::after { content:''; flex:1; height:1px; background:var(--border); }
    .pendientes-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:1rem; margin-bottom:2.5rem; }
    .pendiente-card { background:rgba(255,255,255,.03); border:1px solid var(--border); border-radius:1rem; padding:1.25rem; display:flex; flex-direction:column; gap:.75rem; }
    .pendiente-nombre { font-weight:700; color:var(--white); }
    .pendiente-sub { font-size:.82rem; color:var(--text-muted); }
    .btn-calificar { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1rem; background:var(--cyan); color:var(--navy); border-radius:.55rem; font-weight:700; font-size:.82rem; text-decoration:none; font-family:'Syne',sans-serif; transition:all .2s; }
    .btn-calificar:hover { background:var(--cyan-dim); }
    .table-wrap { overflow-x:auto; border-radius:1rem; border:1px solid var(--border); }
    table { width:100%; border-collapse:collapse; }
    thead tr { border-bottom:1px solid var(--border); }
    thead th { padding:.85rem 1rem; text-align:left; font-size:.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.8px; }
    tbody tr { border-bottom:1px solid rgba(0,195,255,.07); }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(0,195,255,.03); }
    td { padding:.85rem 1rem; font-size:.88rem; color:var(--white); vertical-align:middle; }
    .text-muted { color:var(--text-muted); font-size:.82rem; }
    .stars-display { color:#ffc107; font-size:1rem; letter-spacing:2px; }
    .empty-state { text-align:center; padding:3rem; color:var(--text-muted); }
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
            <a href="{{ route('trabajador.peticionesPendientes') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
                Peticiones
            </a>
            <a href="{{ route('trabajador.serviciosAsignados') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Servicios
            </a>
            <a href="{{ route('trabajador.misCalificaciones') }}" class="active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Calificaciones
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
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/></svg>
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
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="page-header">
            <h1 class="page-title">Mis <span>Calificaciones</span></h1>
        </div>

        <p class="section-title">Pendientes de calificar ({{ $pendientes->count() }})</p>
        @if($pendientes->count() > 0)
            <div class="pendientes-grid">
                @foreach($pendientes as $p)
                    <div class="pendiente-card">
                        <div>
                            <div class="pendiente-nombre">{{ $p->cliente->nombres }} {{ $p->cliente->apellido_p }}</div>
                            <div class="pendiente-sub">{{ $p->servicio->nombre_servicio }} — {{ \Carbon\Carbon::parse($p->fecha_realizacion)->format('d/m/Y') }}</div>
                        </div>
                        <a href="{{ route('trabajador.calificarCliente', $p->id_contratacion) }}" class="btn-calificar">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            Calificar
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state" style="margin-bottom:2rem"><p>No tienes clientes pendientes de calificar.</p></div>
        @endif

        <p class="section-title">Calificaciones registradas ({{ $calificaciones->count() }})</p>
        @if($calificaciones->count() > 0)
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Calificación</th>
                            <th>Comentario</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calificaciones as $c)
                            <tr>
                                <td style="font-weight:600">{{ $c->cliente->nombres }} {{ $c->cliente->apellido_p }}</td>
                                <td>
                                    <span class="stars-display">
                                        @for($i = 1; $i <= 5; $i++)
                                            {{ $i <= $c->calificacion ? '★' : '☆' }}
                                        @endfor
                                    </span>
                                </td>
                                <td class="text-muted">{{ $c->comentario ?? '—' }}</td>
                                <td class="text-muted">{{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state"><p>Aún no has calificado a ningún cliente.</p></div>
        @endif
    </main>
</div>
@endsection