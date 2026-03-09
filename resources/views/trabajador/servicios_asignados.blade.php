@extends('layouts.app')
@section('title', 'Servicios Asignados')

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

    .table-wrap { overflow-x:auto; border-radius:1rem; border:1px solid var(--border); }
    table { width:100%; border-collapse:collapse; }
    thead tr { border-bottom:1px solid var(--border); }
    thead th { padding:.85rem 1rem; text-align:left; font-size:.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.8px; white-space:nowrap; }
    tbody tr { border-bottom:1px solid rgba(0,195,255,.07); transition:background .15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(0,195,255,.03); }
    td { padding:.85rem 1rem; font-size:.88rem; color:var(--white); vertical-align:middle; }
    .text-muted { color:var(--text-muted); font-size:.82rem; }

    .badge { padding:.3rem .75rem; border-radius:100px; font-size:.75rem; font-weight:700; display:inline-block; white-space:nowrap; }
    .badge-activo     { background:rgba(0,168,107,.12); color:#00d68f;   border:1px solid rgba(0,168,107,.2); }
    .badge-completado { background:rgba(0,195,255,.1);  color:var(--cyan);border:1px solid rgba(0,195,255,.2); }
    .badge-cancelado  { background:rgba(220,53,69,.1);  color:#ff6b7a;   border:1px solid rgba(220,53,69,.2); }
    .badge-pago       { background:rgba(255,149,0,.1);  color:#ffb347;   border:1px solid rgba(255,149,0,.2); }

    .action-btns { display:flex; gap:.5rem; flex-wrap:wrap; align-items:center; }
    .btn-action { display:inline-flex; align-items:center; gap:.35rem; padding:.4rem .85rem; border-radius:.5rem; font-size:.78rem; font-weight:700; text-decoration:none; transition:all .2s; white-space:nowrap; border:none; cursor:pointer; font-family:'Instrument Sans',sans-serif; }
    .btn-detalle  { background:rgba(0,195,255,.1);  color:var(--cyan);  border:1px solid rgba(0,195,255,.2); }
    .btn-detalle:hover { background:rgba(0,195,255,.2); }
    .btn-chat     { background:rgba(108,92,231,.15); color:#a29bfe; border:1px solid rgba(108,92,231,.25); }
    .btn-chat:hover { background:rgba(108,92,231,.25); }
    .btn-completar { background:rgba(0,214,143,.12); color:#00d68f; border:1px solid rgba(0,214,143,.2); }
    .btn-completar:hover { background:rgba(0,214,143,.22); }

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
            <a href="{{ route('trabajador.peticionesPendientes') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                Peticiones
            </a>
            <a href="{{ route('trabajador.serviciosAsignados') }}" class="active">
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
            <h1 class="page-title">Servicios <span>Asignados</span></h1>
            <a href="{{ route('trabajador.dashboard') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Volver al inicio
            </a>
        </div>

        @if($contrataciones->count() > 0)
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Servicio</th>
                            <th>Cliente</th>
                            <th>Ubicación</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contrataciones as $c)
                            <tr>
                                <td class="text-muted">{{ $c->id_contratacion }}</td>
                                <td style="font-weight:600">{{ $c->servicio->nombre_servicio }}</td>
                                <td>
                                    {{ $c->cliente->nombres }} {{ $c->cliente->apellido_p }}
                                    <div class="text-muted">{{ $c->cliente->telefono }}</div>
                                </td>
                                <td class="text-muted">{{ $c->localizacion }}</td>
                                <td class="text-muted">{{ \Carbon\Carbon::parse($c->fecha_realizacion)->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($c->estado == 'pago_pendiente')
                                        <span class="badge badge-pago">Pago pendiente</span>
                                    @elseif($c->estado == 'activo')
                                        <span class="badge badge-activo">Activo</span>
                                    @elseif($c->estado == 'completado')
                                        <span class="badge badge-completado">Completado</span>
                                    @else
                                        <span class="badge badge-cancelado">Cancelado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('trabajador.detalleServicio', $c->id_contratacion) }}" class="btn-action btn-detalle">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            Detalle
                                        </a>
                                        @if($c->estado == 'pago_pendiente' || $c->estado == 'activo')
                                            <a href="{{ route('trabajador.chat', $c->id_contratacion) }}" class="btn-action btn-chat">Chat</a>
                                        @endif
                                        @if($c->estado == 'activo')
                                            <form action="{{ route('trabajador.completarServicio', $c->id_contratacion) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-action btn-completar" onclick="return confirm('¿Marcar como completado?')">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                                    Completar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <p>No tienes servicios asignados actualmente.</p>
            </div>
        @endif
    </main>
</div>
@endsection