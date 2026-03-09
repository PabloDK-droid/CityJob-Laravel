@extends('layouts.app')
@section('title', 'Detalle de Contratación')

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
    .sidebar-nav a svg { flex-shrink:0; opacity:.7; }
    .sidebar-nav a:hover svg { opacity:1; }
    .sidebar-divider { height:1px; background:var(--border); margin:.75rem 0; }
    .sidebar-logout { display:flex; align-items:center; gap:.6rem; padding:.6rem .75rem; border-radius:.6rem; color:rgba(255,100,100,.6); font-size:.85rem; font-weight:600; cursor:pointer; transition:all .2s; background:none; border:none; width:100%; text-align:left; font-family:inherit; }
    .sidebar-logout:hover { background:rgba(255,80,80,.08); color:#ff6b6b; }

    .cj-main { flex:1; padding:2.5rem; overflow-y:auto; }

    .page-header { margin-bottom:2rem; }
    .btn-back { display:inline-flex; align-items:center; gap:.4rem; color:var(--text-muted); text-decoration:none; font-size:.85rem; font-weight:600; transition:color .2s; margin-bottom:1rem; }
    .btn-back:hover { color:var(--cyan); }
    .page-title { font-family:'Syne',sans-serif; font-size:1.5rem; font-weight:800; letter-spacing:-.5px; }
    .page-title span { color:var(--cyan); }

    .detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; max-width:920px; }
    .full { grid-column:1/-1; }

    .detail-card { background:rgba(255,255,255,.03); border:1px solid var(--border); border-radius:1rem; padding:1.5rem; }
    .card-title { font-family:'Syne',sans-serif; font-size:.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:1rem; padding-bottom:.6rem; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:.5rem; }
    .card-title svg { color:var(--cyan); }

    .info-row { display:flex; justify-content:space-between; align-items:flex-start; padding:.5rem 0; border-bottom:1px solid rgba(0,195,255,.06); gap:1rem; }
    .info-row:last-child { border-bottom:none; padding-bottom:0; }
    .info-label { font-size:.82rem; color:var(--text-muted); flex-shrink:0; }
    .info-value { font-size:.88rem; color:var(--white); font-weight:600; text-align:right; }
    .info-value.money { color:#00d68f; font-family:'Syne',sans-serif; font-size:.95rem; }
    .info-value.commission { color:var(--cyan); }

    .badge-activo    { display:inline-block; padding:.28rem .7rem; border-radius:100px; font-size:.72rem; font-weight:700; background:rgba(0,168,107,.12); color:#00d68f; border:1px solid rgba(0,168,107,.2); }
    .badge-cancelado { display:inline-block; padding:.28rem .7rem; border-radius:100px; font-size:.72rem; font-weight:700; background:rgba(220,53,69,.1); color:#ff6b7a; border:1px solid rgba(220,53,69,.2); }
    .badge-pendiente { display:inline-block; padding:.28rem .7rem; border-radius:100px; font-size:.72rem; font-weight:700; background:rgba(255,149,0,.1); color:#ffb347; border:1px solid rgba(255,149,0,.2); }

    .action-card { background:rgba(220,53,69,.05); border:1px solid rgba(220,53,69,.15); border-radius:1rem; padding:1.5rem; max-width:920px; margin-top:1.25rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; }
    .action-card p { font-size:.88rem; color:var(--text-muted); margin:0; }
    .btn-cancelar { display:inline-flex; align-items:center; gap:.5rem; padding:.65rem 1.5rem; background:rgba(220,53,69,.15); color:#ff6b7a; border:1px solid rgba(220,53,69,.25); border-radius:.65rem; font-family:'Syne',sans-serif; font-weight:700; font-size:.88rem; cursor:pointer; transition:all .2s; }
    .btn-cancelar:hover { background:rgba(220,53,69,.3); transform:translateY(-1px); }

    @media(max-width:900px) { .cj-sidebar{display:none} .cj-main{padding:1.5rem 1rem} .detail-grid{grid-template-columns:1fr} }
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
            <a href="{{ route('ingeniero.estadisticas') }}">
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
            <a href="{{ route('ingeniero.dashboard') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Volver al monitoreo
            </a>
            <h1 class="page-title">Detalle de <span>Contratación</span></h1>
        </div>

        <div class="detail-grid">
            {{-- Servicio --}}
            <div class="detail-card">
                <p class="card-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Información del servicio
                </p>
                <div class="info-row">
                    <span class="info-label">ID</span>
                    <span class="info-value">#{{ $contratacion->id_contratacion }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Servicio</span>
                    <span class="info-value">{{ $contratacion->servicio->nombre_servicio }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Estado</span>
                    <span class="info-value">
                        @if($contratacion->estado_emitor)
                            <span class="badge-activo">Activo</span>
                        @else
                            <span class="badge-cancelado">Cancelado</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($contratacion->fecha_realizacion)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Emisor</span>
                    <span class="info-value">{{ $contratacion->nombres_emitor }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Dirección</span>
                    <span class="info-value">{{ $contratacion->localizacion }}</span>
                </div>
            </div>

            {{-- Pago --}}
            <div class="detail-card">
                <p class="card-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Información de pago
                </p>
                @if($hecho)
                    <div class="info-row">
                        <span class="info-label">Monto total</span>
                        <span class="info-value money">${{ number_format($hecho->monto_total, 2) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Comisión</span>
                        <span class="info-value commission">${{ number_format($hecho->comision_plataforma, 2) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Duración</span>
                        <span class="info-value">{{ $hecho->duracion_servicio_minutos }} min</span>
                    </div>
                    @if($factura)
                        <div class="info-row">
                            <span class="info-label">ID Factura</span>
                            <span class="info-value">#{{ $factura->id_factura }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Stripe ID</span>
                            <span class="info-value" style="font-size:.75rem;word-break:break-all">{{ $factura->stripe_id }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Fecha emisión</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</span>
                        </div>
                    @endif
                @else
                    <div style="display:flex;align-items:center;justify-content:center;height:80px">
                        <span class="badge-pendiente">Pago pendiente</span>
                    </div>
                @endif
            </div>

            {{-- Cliente --}}
            <div class="detail-card">
                <p class="card-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Datos del cliente
                </p>
                <div class="info-row">
                    <span class="info-label">Nombre</span>
                    <span class="info-value">{{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }} {{ $contratacion->cliente->apellido_m }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Teléfono</span>
                    <span class="info-value">{{ $contratacion->cliente->telefono }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value" style="font-size:.8rem">{{ $contratacion->cliente->correo_electronico }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Domicilio</span>
                    <span class="info-value">{{ $contratacion->cliente->domicilio }}</span>
                </div>
            </div>

            {{-- Profesionista --}}
            <div class="detail-card">
                <p class="card-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                    Datos del profesionista
                </p>
                <div class="info-row">
                    <span class="info-label">Nombre</span>
                    <span class="info-value">{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Teléfono</span>
                    <span class="info-value">{{ $contratacion->profesionista->telefono }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value" style="font-size:.8rem">{{ $contratacion->profesionista->correo_electronico }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Especialidad</span>
                    <span class="info-value">{{ $contratacion->profesionista->especializado }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Calificación</span>
                    <span class="info-value" style="color:#ffc107">★ {{ number_format($contratacion->profesionista->calificacion_profesionista, 1) }}</span>
                </div>
            </div>
        </div>

        {{-- ACCIÓN CANCELAR --}}
        @if($contratacion->estado_emitor)
            <div class="action-card">
                <p>Esta contratación está activa. Como ingeniero encargado puedes cancelarla si es necesario.</p>
                <form action="{{ route('ingeniero.cancelar', $contratacion->id_contratacion) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-cancelar" onclick="return confirm('¿Cancelar este servicio?')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Cancelar Servicio
                    </button>
                </form>
            </div>
        @endif
    </main>
</div>
@endsection