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

    /* grid de secciones */
    .detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; max-width:900px; }
    .detail-grid .full { grid-column:1/-1; }

    .detail-card { background:rgba(255,255,255,.03); border:1px solid var(--border); border-radius:1rem; padding:1.5rem; }
    .detail-card-title { font-family:'Syne',sans-serif; font-size:.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:1rem; padding-bottom:.6rem; border-bottom:1px solid var(--border); }

    .info-row { display:flex; justify-content:space-between; align-items:flex-start; padding:.5rem 0; border-bottom:1px solid rgba(0,195,255,.06); gap:1rem; }
    .info-row:last-child { border-bottom:none; padding-bottom:0; }
    .info-label { font-size:.82rem; color:var(--text-muted); flex-shrink:0; }
    .info-value { font-size:.88rem; color:var(--white); font-weight:600; text-align:right; }
    .info-value.green { color:#00d68f; }
    .info-value.cyan  { color:var(--cyan); }

    .badge { padding:.3rem .75rem; border-radius:100px; font-size:.75rem; font-weight:700; display:inline-block; }
    .badge-activo     { background:rgba(0,168,107,.12); color:#00d68f;   border:1px solid rgba(0,168,107,.2); }
    .badge-completado { background:rgba(0,195,255,.1);  color:var(--cyan);border:1px solid rgba(0,195,255,.2); }
    .badge-cancelado  { background:rgba(220,53,69,.1);  color:#ff6b7a;   border:1px solid rgba(220,53,69,.2); }
    .badge-pago       { background:rgba(255,149,0,.1);  color:#ffb347;   border:1px solid rgba(255,149,0,.2); }
    .badge-pendiente  { background:rgba(150,150,150,.1);color:#999;       border:1px solid rgba(150,150,150,.2); }

    /* acciones */
    .action-row { display:flex; gap:.75rem; flex-wrap:wrap; margin-top:1.5rem; max-width:900px; }
    .btn-cyan { background:var(--cyan); color:var(--navy); padding:.7rem 1.6rem; border-radius:.6rem; font-weight:700; font-size:.88rem; text-decoration:none; transition:all .2s; font-family:'Syne',sans-serif; display:inline-flex; align-items:center; gap:.4rem; }
    .btn-cyan:hover { background:var(--cyan-dim); transform:translateY(-1px); }
    .btn-danger { background:rgba(220,53,69,.12); color:#ff6b7a; padding:.7rem 1.6rem; border-radius:.6rem; font-weight:700; font-size:.88rem; border:1px solid rgba(220,53,69,.25); cursor:pointer; transition:all .2s; font-family:'Syne',sans-serif; font-family:inherit; display:inline-flex; align-items:center; gap:.4rem; }
    .btn-danger:hover { background:rgba(220,53,69,.22); }

    @media(max-width:900px) { .cj-sidebar{display:none} .cj-main{padding:1.5rem 1rem} .detail-grid{grid-template-columns:1fr} }
</style>

@php $rol = session('role'); @endphp

<div class="cj-page">
    <aside class="cj-sidebar">
        <div class="sidebar-brand">
            <img src="/img/CityJib_2.png" alt="CityJob">
            <span>City<em>Job</em></span>
        </div>
        <nav class="sidebar-nav">
            @if($rol === 'cliente')
                <a href="{{ route('cliente.dashboard') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Inicio
                </a>
                <a href="{{ route('cliente.historial') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Historial
                </a>
            @elseif($rol === 'trabajador')
                <a href="{{ route('trabajador.dashboard') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Inicio
                </a>
                <a href="{{ route('trabajador.historial') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Historial
                </a>
            @elseif($rol === 'admin')
                <a href="{{ route('admin.dashboard') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Inicio
                </a>
                <a href="{{ route('admin.historial') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Historial
                </a>
            @else
                <a href="{{ route('ingeniero.dashboard') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Inicio
                </a>
                <a href="{{ route('ingeniero.historial') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Historial
                </a>
            @endif
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
        <button class="sidebar-logout" onclick="document.getElementById('logout-form').submit()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Cerrar sesión
        </button>
    </aside>

    <main class="cj-main">
        <div class="page-header">
            @if($rol === 'cliente')
                <a href="{{ route('cliente.historial') }}" class="btn-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    Volver al historial
                </a>
            @elseif($rol === 'trabajador')
                <a href="{{ route('trabajador.historial') }}" class="btn-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    Volver al historial
                </a>
            @elseif($rol === 'admin')
                <a href="{{ route('admin.historial') }}" class="btn-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    Volver al historial
                </a>
            @else
                <a href="{{ route('ingeniero.historial') }}" class="btn-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    Volver al historial
                </a>
            @endif
            <h1 class="page-title">Contratación <span>#{{ $contratacion->id_contratacion }}</span></h1>
        </div>

        <div class="detail-grid">

            {{-- Servicio --}}
            <div class="detail-card">
                <p class="detail-card-title">Información del servicio</p>
                <div class="info-row">
                    <span class="info-label">Servicio</span>
                    <span class="info-value">{{ $contratacion->servicio->nombre_servicio }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ubicación</span>
                    <span class="info-value">{{ $contratacion->localizacion }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($contratacion->fecha_realizacion)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Estado</span>
                    <span class="info-value">
                        @if($contratacion->estado == 'pago_pendiente')
                            <span class="badge badge-pago">Pago pendiente</span>
                        @elseif($contratacion->estado == 'activo')
                            <span class="badge badge-activo">Activo</span>
                        @elseif($contratacion->estado == 'completado')
                            <span class="badge badge-completado">Completado</span>
                        @elseif($contratacion->estado == 'cancelado')
                            <span class="badge badge-cancelado">Cancelado</span>
                        @else
                            <span class="badge badge-pendiente">{{ ucfirst($contratacion->estado) }}</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Monto</span>
                    <span class="info-value green">${{ number_format($contratacion->monto_acordado, 2) }} MXN</span>
                </div>
            </div>

            {{-- Pago --}}
            <div class="detail-card">
                <p class="detail-card-title">Información de pago</p>
                @if($hecho)
                    <div class="info-row">
                        <span class="info-label">Monto total</span>
                        <span class="info-value green">${{ number_format($hecho->monto_total, 2) }} MXN</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Comisión plataforma (10%)</span>
                        <span class="info-value">${{ number_format($hecho->comision_plataforma, 2) }} MXN</span>
                    </div>
                    @if($factura)
                        <div class="info-row">
                            <span class="info-label">ID Factura</span>
                            <span class="info-value cyan">{{ $factura->id_factura }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Stripe ID</span>
                            <span class="info-value" style="font-size:.75rem;word-break:break-all">{{ $factura->stripe_id }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Fecha emisión</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                @else
                    <div style="padding:1.5rem 0; text-align:center; color:var(--text-muted); font-size:.88rem;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="display:block;margin:0 auto .5rem;color:rgba(255,149,0,.4)"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        Pago pendiente
                    </div>
                @endif
            </div>

            {{-- Cliente --}}
            <div class="detail-card">
                <p class="detail-card-title">Cliente</p>
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
                    <span class="info-value">{{ $contratacion->cliente->correo_electronico }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Domicilio</span>
                    <span class="info-value">{{ $contratacion->cliente->domicilio }}</span>
                </div>
            </div>

            {{-- Profesionista --}}
            <div class="detail-card">
                <p class="detail-card-title">Profesionista</p>
                <div class="info-row">
                    <span class="info-label">Nombre</span>
                    <span class="info-value">{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }} {{ $contratacion->profesionista->apellido_m }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Teléfono</span>
                    <span class="info-value">{{ $contratacion->profesionista->telefono }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $contratacion->profesionista->correo_electronico }}</span>
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

            {{-- Cierre --}}
            @if($historial)
                <div class="detail-card full">
                    <p class="detail-card-title">Registro de cierre</p>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem">
                        <div class="info-row" style="flex-direction:column;gap:.25rem;border:none;padding:0">
                            <span class="info-label">Fecha de cierre</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($historial->fecha_factura)->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-row" style="flex-direction:column;gap:.25rem;border:none;padding:0">
                            <span class="info-label">Hora</span>
                            <span class="info-value">{{ $historial->hora }}</span>
                        </div>
                        <div class="info-row" style="flex-direction:column;gap:.25rem;border:none;padding:0">
                            <span class="info-label">Monto registrado</span>
                            <span class="info-value green">${{ number_format($historial->monto, 2) }} MXN</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        {{-- Acciones --}}
        <div class="action-row">
            @if($rol === 'cliente' && $contratacion->estado === 'completado')
                <a href="{{ route('cliente.descargarFactura', $contratacion->id_contratacion) }}" class="btn-cyan">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Descargar Factura PDF
                </a>
            @endif

            @if(($rol === 'admin' || $rol === 'ingeniero') && $contratacion->estado_emitor)
                <form action="{{ route('ingeniero.cancelar', $contratacion->id_contratacion) }}" method="POST" onsubmit="return confirm('¿Cancelar este servicio?')">
                    @csrf
                    <button type="submit" class="btn-danger">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        Cancelar Servicio
                    </button>
                </form>
            @endif
        </div>
    </main>
</div>
@endsection