@extends('layouts.app')
@section('title', 'Mis Contrataciones')

@section('content')
<style>
    :root {
        --cyan:#00C3FF; --cyan-dim:#0094cc; --navy:#00152B;
        --navy-mid:#002647; --navy-light:#003B73;
        --text-muted:#8BAAC8; --border:rgba(0,195,255,0.15); --white:#FFFFFF;
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
    .sidebar-nav a:hover svg, .sidebar-nav a.active svg { opacity:1; }
    .sidebar-divider { height:1px; background:var(--border); margin:.75rem 0; }
    .sidebar-logout { display:flex; align-items:center; gap:.6rem; padding:.6rem .75rem; border-radius:.6rem; color:rgba(255,100,100,.6); font-size:.85rem; font-weight:600; cursor:pointer; transition:all .2s; background:none; border:none; width:100%; text-align:left; font-family:inherit; margin-top:auto; }
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

    .table-wrap { overflow-x:auto; border-radius:1rem; border:1px solid var(--border); }
    table { width:100%; border-collapse:collapse; }
    thead tr { border-bottom:1px solid var(--border); }
    thead th { padding:.85rem 1rem; text-align:left; font-size:.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.8px; white-space:nowrap; }
    tbody tr.data-row { border-bottom:1px solid rgba(0,195,255,.07); transition:background .15s; }
    tbody tr.data-row:hover { background:rgba(0,195,255,.03); }
    tbody tr.expand-row { border-bottom:1px solid rgba(0,195,255,.07); }
    tbody tr.expand-row:last-child { border-bottom:none; }
    td { padding:.85rem 1rem; font-size:.88rem; color:var(--white); vertical-align:middle; }

    .badge { padding:.3rem .75rem; border-radius:100px; font-size:.75rem; font-weight:700; display:inline-block; white-space:nowrap; }
    .badge-activo     { background:rgba(0,168,107,.12); color:#00d68f; border:1px solid rgba(0,168,107,.2); }
    .badge-completado { background:rgba(0,195,255,.1);  color:var(--cyan); border:1px solid rgba(0,195,255,.2); }
    .badge-cancelado  { background:rgba(220,53,69,.1);  color:#ff6b7a; border:1px solid rgba(220,53,69,.2); }
    .badge-pago       { background:rgba(255,149,0,.1);  color:#ffb347; border:1px solid rgba(255,149,0,.2); }
    .badge-pendiente  { background:rgba(150,150,150,.1);color:#999; border:1px solid rgba(150,150,150,.2); }

    .action-btns { display:flex; gap:.5rem; flex-wrap:wrap; align-items:center; }
    .btn-action { display:inline-flex; align-items:center; gap:.35rem; padding:.4rem .85rem; border-radius:.5rem; font-size:.78rem; font-weight:700; text-decoration:none; transition:all .2s; white-space:nowrap; border:none; cursor:pointer; font-family:'Instrument Sans',sans-serif; }
    .btn-pagar    { background:rgba(255,149,0,.15);  color:#ffb347; border:1px solid rgba(255,149,0,.25); }
    .btn-pagar:hover { background:rgba(255,149,0,.25); }
    .btn-chat     { background:rgba(108,92,231,.15); color:#a29bfe; border:1px solid rgba(108,92,231,.25); }
    .btn-chat:hover { background:rgba(108,92,231,.25); }
    .btn-calificar { background:rgba(0,195,255,.12); color:var(--cyan); border:1px solid rgba(0,195,255,.2); }
    .btn-calificar:hover { background:rgba(0,195,255,.22); }
    .btn-factura  { background:rgba(0,168,107,.12); color:#00d68f; border:1px solid rgba(0,168,107,.2); }
    .btn-factura:hover { background:rgba(0,168,107,.22); }
    .btn-toggle { background:rgba(255,255,255,.05); color:var(--text-muted); border:1px solid var(--border); }
    .btn-toggle:hover { background:rgba(255,255,255,.1); color:var(--white); }

    .monto { color:#00d68f; font-weight:700; }
    .text-muted-sm { color:var(--text-muted); font-size:.82rem; }

    /* Fila expandible de calificación */
    .calif-row { display:none; background:rgba(0,195,255,.02); }
    .calif-row.visible { display:table-row; }
    .calif-panel {
        padding:1rem 1.5rem 1.25rem;
        display:flex; gap:2rem; flex-wrap:wrap; align-items:flex-start;
    }
    .calif-block { flex:1; min-width:200px; }
    .calif-block-title { font-size:.72rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.8px; margin-bottom:.5rem; }
    .stars-row { color:#ffc107; font-size:1.1rem; letter-spacing:2px; margin-bottom:.35rem; }
    .calif-num { font-family:'Syne',sans-serif; font-size:1.4rem; font-weight:800; color:#ffc107; }
    .calif-label { font-size:.78rem; color:var(--text-muted); margin-left:.3rem; }
    .calif-comment {
        font-size:.88rem; color:var(--text-muted); font-style:italic;
        line-height:1.55; margin-top:.4rem;
        padding:.65rem .9rem;
        background:rgba(255,255,255,.03); border-left:2px solid rgba(0,195,255,.3);
        border-radius:0 .5rem .5rem 0;
    }
    .no-comment { font-size:.82rem; color:rgba(139,170,200,.4); font-style:italic; }
    .calif-pending { font-size:.84rem; color:var(--text-muted); display:flex; align-items:center; gap:.4rem; }

    .empty-state { text-align:center; padding:4rem 2rem; color:var(--text-muted); }
    .empty-state svg { color:rgba(0,195,255,.2); margin-bottom:1rem; }
    .btn-cyan-link { display:inline-flex; align-items:center; gap:.4rem; background:var(--cyan); color:var(--navy); padding:.65rem 1.4rem; border-radius:.6rem; font-weight:700; font-size:.88rem; text-decoration:none; transition:all .2s; font-family:'Syne',sans-serif; margin-top:1rem; }
    .btn-cyan-link:hover { background:var(--cyan-dim); }

    @media(max-width:900px) { .cj-sidebar{display:none} .cj-main{padding:1.5rem 1rem} }
</style>

<div class="cj-page">
    <aside class="cj-sidebar">
        <a href="{{ route('cliente.dashboard') }}" class="sidebar-brand">
            <img src="/img/CityJib_2.png" alt="CityJob">
            <span>City<em>Job</em></span>
        </a>
        <nav class="sidebar-nav">
            <a href="{{ route('cliente.dashboard') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Inicio
            </a>
            <a href="{{ route('cliente.catalogo') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Catálogo
            </a>
            <a href="{{ route('cliente.misContrataciones') }}" class="active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Contrataciones
            </a>
            <a href="{{ route('cliente.historial') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Historial
            </a>
            <a href="{{ route('cliente.misCalificaciones') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Calificaciones
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
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="page-header">
            <h1 class="page-title">Mis <span>Contrataciones</span></h1>
            <a href="{{ route('cliente.dashboard') }}" class="btn-back">
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
                            <th>Profesionista</th>
                            <th>Ubicación</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contrataciones as $c)
                            @php
                                $esCompletado = $c->estado === 'completado';
                                $cliente_id   = session('user_id');

                                $yaCalificado  = false;
                                $califDada     = null;
                                $califRecibida = null;

                                if ($esCompletado) {
                                    $yaCalificado = \App\Models\Calificacion::where('id_cliente', $cliente_id)
                                        ->where('id_profesionista', $c->id_profesionista)
                                        ->where('tipo', 'cliente_a_profesionista')
                                        ->exists();

                                    $califDada = \App\Models\Calificacion::where('id_cliente', $cliente_id)
                                        ->where('id_profesionista', $c->id_profesionista)
                                        ->where('tipo', 'cliente_a_profesionista')
                                        ->first();

                                    $califRecibida = \App\Models\Calificacion::where('id_cliente', $cliente_id)
                                        ->where('id_profesionista', $c->id_profesionista)
                                        ->where('tipo', 'profesionista_a_cliente')
                                        ->first();
                                }

                                $tieneCalifs = $esCompletado && ($califDada || $califRecibida);
                            @endphp

                            {{-- Fila principal --}}
                            <tr class="data-row">
                                <td class="text-muted-sm">{{ $c->id_contratacion }}</td>
                                <td style="font-weight:600">{{ $c->servicio->nombre_servicio }}</td>
                                <td>
                                    {{ $c->profesionista->nombres }} {{ $c->profesionista->apellido_p }}
                                    <div class="text-muted-sm">{{ $c->profesionista->telefono }}</div>
                                </td>
                                <td class="text-muted-sm">{{ $c->localizacion }}</td>
                                <td>
                                    @if($c->monto_acordado > 0)
                                        <span class="monto">${{ number_format($c->monto_acordado, 2) }}</span>
                                    @else
                                        <span style="color:var(--text-muted);font-size:.8rem;font-style:italic">Por definir</span>
                                    @endif
                                </td>
                                <td class="text-muted-sm">{{ \Carbon\Carbon::parse($c->fecha_realizacion)->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($c->estado == 'pago_pendiente')
                                        <span class="badge badge-pago">Pago pendiente</span>
                                    @elseif($c->estado == 'activo')
                                        <span class="badge badge-activo">Activo</span>
                                    @elseif($c->estado == 'completado')
                                        <span class="badge badge-completado">Completado</span>
                                    @elseif($c->estado == 'cancelado')
                                        <span class="badge badge-cancelado">Cancelado</span>
                                    @else
                                        <span class="badge badge-pendiente">{{ ucfirst($c->estado) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-btns">
                                        @if($c->estado == 'pago_pendiente')
                                            <a href="{{ route('cliente.crearPago', $c->id_contratacion) }}" class="btn-action btn-pagar">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                                Pagar
                                            </a>
                                            <a href="{{ route('cliente.chat', $c->id_contratacion) }}" class="btn-action btn-chat">Chat</a>

                                        @elseif($c->estado == 'activo')
                                            <span style="color:#00d68f;font-size:.8rem;font-weight:600">En proceso</span>
                                            <a href="{{ route('cliente.chat', $c->id_contratacion) }}" class="btn-action btn-chat">Chat</a>

                                        @elseif($c->estado == 'completado')
                                            @if(!$yaCalificado)
                                                <a href="{{ route('cliente.calificarServicio', $c->id_contratacion) }}" class="btn-action btn-calificar">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                                    Calificar
                                                </a>
                                            @else
                                                <span style="color:#00d68f;font-size:.78rem;font-weight:700">✓ Calificado</span>
                                            @endif

                                            <a href="{{ route('cliente.descargarFactura', $c->id_contratacion) }}" class="btn-action btn-factura">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                                Factura
                                            </a>

                                            @if($tieneCalifs)
                                                <button class="btn-action btn-toggle" onclick="toggleCalif({{ $c->id_contratacion }}, this)">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                                    Ver calificaciones
                                                </button>
                                            @endif

                                        @else
                                            <span class="text-muted-sm">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- Fila expandible de calificaciones --}}
                            @if($tieneCalifs)
                                <tr class="expand-row calif-row" id="calif-{{ $c->id_contratacion }}">
                                    <td colspan="8" style="padding:0">
                                        <div class="calif-panel">

                                            {{-- Calificación que el cliente dio al profesionista --}}
                                            @if($califDada)
                                                <div class="calif-block">
                                                    <div class="calif-block-title">Tu calificación al profesionista</div>
                                                    <div style="display:flex;align-items:baseline;gap:.4rem;margin-bottom:.4rem">
                                                        <span class="calif-num">{{ $califDada->calificacion }}</span>
                                                        <span class="calif-label">/ 5</span>
                                                        <span class="stars-row" style="font-size:.95rem;margin-left:.25rem">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                {{ $i <= $califDada->calificacion ? '★' : '☆' }}
                                                            @endfor
                                                        </span>
                                                    </div>
                                                    @if($califDada->comentario)
                                                        <div class="calif-comment">"{{ $califDada->comentario }}"</div>
                                                    @else
                                                        <div class="no-comment">Sin comentario</div>
                                                    @endif
                                                </div>
                                            @endif

                                            {{-- Calificación que el profesionista dio al cliente --}}
                                            @if($califRecibida)
                                                <div class="calif-block">
                                                    <div class="calif-block-title">Calificación que recibiste</div>
                                                    <div style="display:flex;align-items:baseline;gap:.4rem;margin-bottom:.4rem">
                                                        <span class="calif-num">{{ $califRecibida->calificacion }}</span>
                                                        <span class="calif-label">/ 5</span>
                                                        <span class="stars-row" style="font-size:.95rem;margin-left:.25rem">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                {{ $i <= $califRecibida->calificacion ? '★' : '☆' }}
                                                            @endfor
                                                        </span>
                                                    </div>
                                                    @if($califRecibida->comentario)
                                                        <div class="calif-comment">"{{ $califRecibida->comentario }}"</div>
                                                    @else
                                                        <div class="no-comment">Sin comentario</div>
                                                    @endif
                                                </div>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endif

                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <p>Aún no has realizado ninguna contratación.</p>
                <a href="{{ route('cliente.catalogo') }}" class="btn-cyan-link">Explorar catálogo</a>
            </div>
        @endif
    </main>
</div>

<script>
    function toggleCalif(id, btn) {
        const row = document.getElementById('calif-' + id);
        const visible = row.classList.toggle('visible');
        btn.innerHTML = visible
            ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg> Ocultar'
            : '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg> Ver calificaciones';
    }
</script>
@endsection