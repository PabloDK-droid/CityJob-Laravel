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
    .sidebar-logout { display:flex; align-items:center; gap:.6rem; padding:.6rem .75rem; border-radius:.6rem; color:rgba(255,100,100,.6); font-size:.85rem; font-weight:600; cursor:pointer; transition:all .2s; background:none; border:none; width:100%; text-align:left; font-family:inherit; margin-top:auto; }    
    .sidebar-logout:hover { background:rgba(255,80,80,.08); color:#ff6b6b; }
    .cj-main { flex:1; padding:2.5rem; overflow-y:auto; }
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; }
    .page-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; letter-spacing:-.5px; }
    .page-title span { color:var(--cyan); }
    .alert-success { background:rgba(0,195,255,.08); border:1px solid rgba(0,195,255,.2); color:var(--cyan); padding:.75rem 1rem; border-radius:.75rem; font-size:.88rem; margin-bottom:1.5rem; }
    /* resumen promedio */
    .promedio-card { background:rgba(255,255,255,.03); border:1px solid var(--border); border-radius:1.25rem; padding:2rem; display:flex; align-items:center; gap:2rem; margin-bottom:2rem; }
    .promedio-numero { font-family:'Syne',sans-serif; font-size:3.5rem; font-weight:800; color:var(--cyan); line-height:1; }
    .promedio-stars { color:#ffc107; font-size:1.5rem; letter-spacing:3px; margin:.25rem 0; }
    .promedio-sub { font-size:.85rem; color:var(--text-muted); }
    /* cards calificaciones */
    .califs-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:1rem; }
    .calif-card { background:rgba(255,255,255,.03); border:1px solid var(--border); border-radius:1rem; padding:1.25rem; display:flex; flex-direction:column; gap:.75rem; }
    .calif-header { display:flex; justify-content:space-between; align-items:flex-start; }
    .calif-profesionista { font-weight:700; color:var(--white); font-size:.95rem; }
    .calif-servicio { font-size:.8rem; color:var(--text-muted); margin-top:.15rem; }
    .stars-display { color:#ffc107; font-size:1.1rem; letter-spacing:2px; }
    .calif-comentario { font-size:.85rem; color:var(--text-muted); font-style:italic; line-height:1.5; }
    .calif-fecha { font-size:.78rem; color:var(--text-muted); }
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
            <a href="{{ route('cliente.misCalificaciones') }}" class="active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Calificaciones
            </a>
            <div class="sidebar-divider"></div>
            <a href="{{ route('cliente.editarPerfil') }}">
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
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <h1 class="page-title">Mis <span>Calificaciones</span></h1>
        </div>

        @if($calificaciones->count() > 0)
            <div class="promedio-card">
                <div class="promedio-numero">{{ number_format($promedio, 1) }}</div>
                <div>
                    <div class="promedio-stars">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= round($promedio) ? '★' : '☆' }}
                        @endfor
                    </div>
                    <div class="promedio-sub">Promedio de {{ $calificaciones->count() }} {{ $calificaciones->count() == 1 ? 'calificación recibida' : 'calificaciones recibidas' }}</div>
                </div>
            </div>

            <div class="califs-grid">
                @foreach($calificaciones as $c)
                    <div class="calif-card">
                        <div class="calif-header">
                            <div>
                                <div class="calif-profesionista">{{ $c->profesionista->nombres }} {{ $c->profesionista->apellido_p }}</div>
                                <div class="calif-servicio">Profesionista</div>
                            </div>
                            <span class="stars-display">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $c->calificacion ? '★' : '☆' }}
                                @endfor
                            </span>
                        </div>
                        @if($c->comentario)
                            <p class="calif-comentario">"{{ $c->comentario }}"</p>
                        @endif
                        <span class="calif-fecha">{{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y') }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <p>Aún no has recibido calificaciones.</p>
            </div>
        @endif
    </main>
</div>
@endsection