@extends('layouts.app')
@section('title', 'Contrataciones')

@section('content')
<style>
    :root {
        --cyan:#00C3FF; --cyan-dim:#0094cc; --navy:#00152B;
        --navy-mid:#002647; --text-muted:#8BAAC8; --border:rgba(0,195,255,0.15); --white:#FFFFFF;
    }
    .cj-page { display:flex; min-height:100vh; background:var(--navy); font-family:'Instrument Sans',sans-serif; }

    /* ── sidebar ── */
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
    .sidebar-nav a:hover svg, .sidebar-nav a.active svg { opacity:1; }
    .sidebar-divider { height:1px; background:var(--border); margin:.75rem 0; }
    .sidebar-logout { display:flex; align-items:center; gap:.6rem; padding:.6rem .75rem; border-radius:.6rem; color:rgba(255,100,100,.6); font-size:.85rem; font-weight:600; cursor:pointer; transition:all .2s; background:none; border:none; width:100%; text-align:left; font-family:inherit; }
    .sidebar-logout:hover { background:rgba(255,80,80,.08); color:#ff6b6b; }

    /* ── main ── */
    .cj-main { flex:1; padding:2.5rem; overflow-y:auto; }

    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; letter-spacing:-.5px; }
    .page-title span { color:var(--cyan); }
    .btn-back { display:inline-flex; align-items:center; gap:.4rem; color:var(--text-muted); text-decoration:none; font-size:.85rem; font-weight:600; transition:color .2s; }
    .btn-back:hover { color:var(--cyan); }

    /* filtro search */
    .filter-bar { margin-bottom:1.5rem; display:flex; gap:.75rem; align-items:center; flex-wrap:wrap; }
    .search-wrap { position:relative; flex:1; min-width:200px; max-width:360px; }
    .search-wrap svg { position:absolute; left:.85rem; top:50%; transform:translateY(-50%); color:var(--text-muted); pointer-events:none; }
    .search-input {
        width:100%; padding:.65rem 1rem .65rem 2.4rem;
        background:rgba(255,255,255,.05); border:1px solid var(--border);
        border-radius:.7rem; color:var(--white); font-family:'Instrument Sans',sans-serif;
        font-size:.88rem; outline:none; transition:border-color .2s;
    }
    .search-input:focus { border-color:var(--cyan); }
    .search-input::placeholder { color:rgba(139,170,200,.4); }

    .filter-select {
        padding:.65rem 1rem; background:rgba(255,255,255,.05);
        border:1px solid var(--border); border-radius:.7rem;
        color:var(--white); font-family:'Instrument Sans',sans-serif;
        font-size:.88rem; outline:none; cursor:pointer;
    }
    .filter-select:focus { border-color:var(--cyan); }
    .filter-select option { background:#002647; }

    /* tabla */
    .table-wrap { overflow-x:auto; border-radius:1rem; border:1px solid var(--border); }
    table { width:100%; border-collapse:collapse; }
    thead tr { border-bottom:1px solid var(--border); }
    thead th { padding:.85rem 1rem; text-align:left; font-size:.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.8px; white-space:nowrap; }
    tbody tr { border-bottom:1px solid rgba(0,195,255,.07); transition:background .15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(0,195,255,.03); }
    td { padding:.85rem 1rem; font-size:.85rem; color:var(--white); vertical-align:middle; }
    .text-muted { color:var(--text-muted); font-size:.8rem; }

    .badge { padding:.28rem .7rem; border-radius:100px; font-size:.72rem; font-weight:700; display:inline-block; white-space:nowrap; }
    .badge-activo     { background:rgba(0,168,107,.12); color:#00d68f;   border:1px solid rgba(0,168,107,.2); }
    .badge-cancelado  { background:rgba(220,53,69,.1);  color:#ff6b7a;   border:1px solid rgba(220,53,69,.2); }

    .empty-state { text-align:center; padding:4rem 2rem; color:var(--text-muted); }
    .empty-state svg { color:rgba(0,195,255,.15); margin-bottom:1rem; display:block; margin-inline:auto; }

    @media(max-width:900px) { .cj-sidebar{display:none} .cj-main{padding:1.5rem 1rem} }
</style>

<div class="cj-page">
    <!-- sidebar -->
    <aside class="cj-sidebar">
        <div class="sidebar-brand">
            <img src="/img/CityJib_2.png" alt="CityJob">
            <span>City<em>Job</em></span>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}">
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
            <a href="{{ route('admin.contrataciones') }}" class="active">
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

    <!-- main -->
    <main class="cj-main">
        <div class="page-header">
            <h1 class="page-title">Todas las <span>Contrataciones</span></h1>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Volver al panel
            </a>
        </div>

        <!-- filtro cliente-side -->
        <div class="filter-bar">
            <div class="search-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" id="searchInput" class="search-input" placeholder="Buscar cliente, profesionista o servicio...">
            </div>
            <select id="filterEstado" class="filter-select">
                <option value="">Todos los estados</option>
                <option value="activo">Activo</option>
                <option value="cancelado">Cancelado</option>
            </select>
        </div>

        @if($contrataciones->count() > 0)
            <div class="table-wrap">
                <table id="contratacionesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Profesionista</th>
                            <th>Servicio</th>
                            <th>Ubicación</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contrataciones as $c)
                            <tr data-estado="{{ $c->estado_emitor ? 'activo' : 'cancelado' }}">
                                <td class="text-muted">{{ $c->id_contratacion }}</td>
                                <td style="font-weight:600">
                                    {{ $c->cliente->nombres }} {{ $c->cliente->apellido_p }}
                                </td>
                                <td>
                                    {{ $c->profesionista->nombres }} {{ $c->profesionista->apellido_p }}
                                </td>
                                <td class="text-muted">{{ $c->servicio->nombre_servicio }}</td>
                                <td class="text-muted">{{ $c->localizacion }}</td>
                                <td class="text-muted">{{ \Carbon\Carbon::parse($c->fecha_realizacion)->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($c->estado_emitor)
                                        <span class="badge badge-activo">Activo</span>
                                    @else
                                        <span class="badge badge-cancelado">Cancelado</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <p>No hay contrataciones registradas.</p>
            </div>
        @endif
    </main>
</div>

<script>
    const searchInput  = document.getElementById('searchInput');
    const filterEstado = document.getElementById('filterEstado');
    const rows = document.querySelectorAll('#contratacionesTable tbody tr');

    function filterTable() {
        const q     = searchInput.value.toLowerCase();
        const est   = filterEstado.value;
        rows.forEach(row => {
            const text  = row.textContent.toLowerCase();
            const estado = row.dataset.estado;
            const matchQ = !q   || text.includes(q);
            const matchE = !est || estado === est;
            row.style.display = (matchQ && matchE) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    filterEstado.addEventListener('change', filterTable);
</script>
@endsection