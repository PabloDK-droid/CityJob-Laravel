@extends('layouts.app')
@section('title', 'Pago Exitoso')

@section('content')
<style>
    :root {
        --cyan:#00C3FF; --cyan-dim:#0094cc; --navy:#00152B;
        --navy-mid:#002647; --text-muted:#8BAAC8; --border:rgba(0,195,255,0.15); --white:#FFFFFF;
    }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Instrument Sans',sans-serif; }

    .page-wrap {
        min-height:100vh; background:var(--navy);
        display:flex; align-items:center; justify-content:center;
        padding:2rem 1.5rem;
        position:relative; overflow:hidden;
    }
    .page-wrap::before {
        content:''; position:fixed; inset:0;
        background-image:radial-gradient(circle at 2px 2px,rgba(0,195,255,.04) 1.5px,transparent 0);
        background-size:36px 36px; pointer-events:none;
    }
    .blob { position:fixed; border-radius:50%; filter:blur(100px); pointer-events:none; z-index:0; }
    .blob-1 { width:400px; height:400px; background:#00d68f; top:-120px; right:-120px; opacity:.1; }
    .blob-2 { width:300px; height:300px; background:var(--cyan); bottom:-80px; left:-80px; opacity:.08; }

    .success-card {
        position:relative; z-index:1;
        width:100%; max-width:520px;
        background:rgba(255,255,255,.04);
        border:1px solid var(--border);
        border-radius:1.5rem;
        padding:3rem 2.5rem;
        backdrop-filter:blur(16px);
        text-align:center;
        animation:slideUp .55s ease both;
    }
    @keyframes slideUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }

    .check-wrap {
        width:80px; height:80px; border-radius:50%;
        background:rgba(0,214,143,.12);
        border:1px solid rgba(0,214,143,.3);
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 1.75rem;
        animation:popIn .5s .3s ease both;
    }
    @keyframes popIn { from{transform:scale(.6);opacity:0} to{transform:scale(1);opacity:1} }
    .check-wrap svg { color:#00d68f; }

    .success-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; color:var(--white); letter-spacing:-.5px; margin-bottom:.5rem; }
    .success-sub { color:var(--text-muted); font-size:.9rem; line-height:1.6; margin-bottom:2rem; }

    .detail-box {
        background:rgba(255,255,255,.03);
        border:1px solid var(--border);
        border-radius:1rem;
        padding:1.25rem;
        text-align:left;
        margin-bottom:2rem;
    }
    .detail-row { display:flex; justify-content:space-between; align-items:center; padding:.6rem 0; border-bottom:1px solid rgba(0,195,255,.07); }
    .detail-row:last-child { border-bottom:none; padding-bottom:0; }
    .detail-label { font-size:.82rem; color:var(--text-muted); }
    .detail-value { font-size:.88rem; font-weight:600; color:var(--white); text-align:right; max-width:60%; }
    .detail-row.total .detail-label { font-weight:700; color:var(--white); font-size:.9rem; }
    .detail-row.total .detail-value { color:#00d68f; font-size:1.1rem; font-weight:800; font-family:'Syne',sans-serif; }

    .btn-group { display:flex; gap:.75rem; justify-content:center; flex-wrap:wrap; }
    .btn-cyan {
        background:var(--cyan); color:var(--navy);
        padding:.75rem 1.6rem; border-radius:.6rem;
        font-weight:700; font-size:.9rem;
        text-decoration:none; transition:all .2s;
        font-family:'Syne',sans-serif;
    }
    .btn-cyan:hover { background:var(--cyan-dim); transform:translateY(-2px); }
    .btn-outline {
        background:transparent; color:var(--white);
        padding:.75rem 1.4rem; border-radius:.6rem;
        border:1px solid var(--border); font-weight:600;
        font-size:.9rem; text-decoration:none; transition:all .2s;
    }
    .btn-outline:hover { border-color:var(--cyan); color:var(--cyan); }
</style>

<div class="page-wrap">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="success-card">
        <div class="check-wrap">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>

        <h1 class="success-title">¡Pago realizado con éxito!</h1>
        <p class="success-sub">Tu servicio ha sido confirmado. El profesionista ya puede comenzar a trabajar.</p>

        <div class="detail-box">
            <div class="detail-row">
                <span class="detail-label">Servicio</span>
                <span class="detail-value">{{ $contratacion->servicio->nombre_servicio }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Profesionista</span>
                <span class="detail-value">{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Teléfono</span>
                <span class="detail-value">{{ $contratacion->profesionista->telefono }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Ubicación</span>
                <span class="detail-value">{{ $contratacion->localizacion }}</span>
            </div>
            <div class="detail-row total">
                <span class="detail-label">Total pagado</span>
                <span class="detail-value">${{ number_format($contratacion->monto_acordado, 2) }} MXN</span>
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('cliente.misContrataciones') }}" class="btn-cyan">Ver contrataciones</a>
            <a href="{{ route('cliente.descargarFactura', $contratacion->id_contratacion) }}" class="btn-outline">Descargar factura</a>
        </div>
    </div>
</div>
@endsection