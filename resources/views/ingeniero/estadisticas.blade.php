@extends('layouts.app')
@section('title', 'Estadísticas')

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

    /* stat cards */
    .stats-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:1rem; margin-bottom:2.5rem; }
    .stat-card { background:rgba(255,255,255,.03); border:1px solid var(--border); border-radius:1rem; padding:1.5rem; position:relative; overflow:hidden; }
    .stat-card::before { content:''; position:absolute; top:-30px; right:-30px; width:80px; height:80px; background:var(--cyan); border-radius:50%; filter:blur(35px); opacity:.07; pointer-events:none; }
    .stat-icon { width:36px; height:36px; border-radius:.65rem; background:rgba(0,195,255,.1); border:1px solid rgba(0,195,255,.2); display:flex; align-items:center; justify-content:center; color:var(--cyan); margin-bottom:.75rem; }
    .stat-label { font-size:.75rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
    .stat-value { font-family:'Syne',sans-serif; font-size:2rem; font-weight:800; color:var(--white); letter-spacing:-1px; }
    .stat-value.cyan  { color:var(--cyan); }
    .stat-value.green { color:#00d68f; }

    /* tabla servicios por tipo */
    .section-title { font-family:'Syne',sans-serif; font-size:.85rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; }
    .section-title::after { content:''; flex:1; height:1px; background:var(--border); }

    .table-wrap { overflow-x:auto; border-radius:1rem; border:1px solid var(--border); }
    table { width:100%; border-collapse:collapse; }
    thead tr { border-bottom:1px solid var(--border); }
    thead th { padding:.85rem 1rem; text-align:left; font-size:.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.8px; }
    tbody tr { border-bottom:1px solid rgba(0,195,255,.07); transition:background .15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(0,195,255,.03); }
    td { padding:.85rem 1rem; font-size:.88rem; color:var(--white); vertical-align:middle; }
    .text-muted { color:var(--text-muted); font-size:.8rem; }

    /* barra de progreso visual */
    .bar-wrap { width:100%; max-width:240px; background:rgba(0,195,255,.08); border-radius:100px; height:6px; overflow:hidden; }
    .bar-fill  { height:100%; background:linear-gradient(90deg,var(--cyan),#0094cc); border-radius:100px; transition:width .6s ease; }
    .count-badge { display:inline-block; font-family:'Syne',sans-serif; font-weight:700; font-size:.88rem; color:var(--cyan); min-width:30px; }

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
            <a href="{{ route('ingeniero.dashboard') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Contrataciones
            </a>
            <a href="{{ route('ingeniero.pagos') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Pagos
            </a>
            <a href="{{ route('ingeniero.estadisticas') }}" class="active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Estadísticas
            </a>
            <a href="{{ route('ingeniero.historial') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Historial
            </a>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
        <button class="sidebar-logout" onclick="document.getElementById('logout-form').submit()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Cerrar sesión
        </button>
    </aside>

    <main class="cj-main">
        <div class="page-header">
            <h1 class="page-title">Estadísticas de <span>Servicios</span></h1>
            <a href="{{ route('ingeniero.dashboard') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Volver al monitoreo
            </a>
        </div>

        {{-- STAT CARDS --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                <span class="stat-label">Total servicios</span>
                <div class="stat-value">{{ $stats['total_servicios'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <span class="stat-label">Activos</span>
                <div class="stat-value cyan">{{ $stats['servicios_activos'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                <span class="stat-label">Completados</span>
                <div class="stat-value green">{{ $stats['servicios_completados'] }}</div>
            </div>
        </div>

        {{-- SERVICIOS POR TIPO --}}
        <p class="section-title">Contrataciones por tipo de servicio</p>

        @if($stats['servicios_por_tipo']->count() > 0)
            @php $maxVal = $stats['servicios_por_tipo']->max('total') ?: 1; @endphp
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Contrataciones</th>
                            <th style="min-width:200px">Proporción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['servicios_por_tipo'] as $s)
                            <tr>
                                <td style="font-weight:600">{{ $s->nombre_servicio }}</td>
                                <td><span class="count-badge">{{ $s->total }}</span></td>
                                <td>
                                    <div class="bar-wrap">
                                        <div class="bar-fill" style="width:{{ round(($s->total / $maxVal) * 100) }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state"><p>No hay datos disponibles.</p></div>
        @endif
    </main>
</div>
@endsection