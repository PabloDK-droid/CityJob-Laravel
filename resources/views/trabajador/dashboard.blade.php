@extends('layouts.app')

@section('title', 'Dashboard Profesionista')

@section('content')
<style>
    :root{--d1:#0066ff;--d2:#00a8ff}
    .worker-sidebar .brand{color:var(--d1);font-weight:600;margin-bottom:30px;font-size:18px}
    .worker-sidebar nav{display:flex;flex-direction:column;gap:0}
    .worker-sidebar a{color:#222;text-decoration:none;font-weight:600;padding:6px 8px;border-radius:6px}
    .worker-sidebar a:hover{background:rgba(0,0,0,0.03)}
    .worker-sidebar .spacer{flex:1}
    .worker-sidebar .logout-link{font-size:13px;color:#111;text-decoration:none;padding:4px 6px;border-radius:6px}
    .worker-sidebar .logout-link:hover{background:rgba(0,0,0,0.03)}
    .worker-page{display:flex;gap:15px;min-height:44vh}
    .worker-sidebar{width:140px;background:#fff;padding:24px 12px;display:flex;flex-direction:column}
    .worker-main{flex:1;display:flex;align-items:center;justify-content:center;padding:10px}

    .hero-panel{width:100%;max-width:2500px;min-height:610px;border-radius:18px;display:flex;align-items:center;gap:40px;padding:64px;background:linear-gradient(135deg,var(--d1) 0%,var(--d2) 100%);box-shadow:0 40px 120px rgba(2,6,23,0.14);color:#06283d}
    .hero-left{flex:0 0 340px;display:flex;flex-direction:column;align-items:center;gap:22px}
    .hero-avatar{width:320px;height:320px;border-radius:18px;border:3px dashed rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.04)}
    .hero-avatar svg{width:70%;height:70%;color:rgba(255,255,255,0.95);}
    .hero-content{flex:1;color:rgba(0,0,0,0.85)}
    .hero-title{font-size:44px;font-weight:800;margin-bottom:12px;color:#04142b}
    .hero-text{color:rgba(0,0,0,0.6);line-height:1.6}
    .cta-row{margin-top:22px;display:flex;gap:12px}
    .btn-primary{background:#041b4a;color:#fff;padding:12px 20px;border-radius:10px;text-decoration:none;font-weight:700}
    .btn-secondary{background:transparent;color:#041b4a;padding:12px 18px;border-radius:10px;border:2px solid rgba(255,255,255,0.25);text-decoration:none;font-weight:700}

    @media(max-width:1200px){
        .hero-panel{flex-direction:column;align-items:center;height:auto;padding:32px}
        .hero-left{flex:0 0 auto}
        .hero-avatar{width:160px;height:160px}
        .hero-title{font-size:28px;text-align:center}
        .worker-sidebar{display:none}
    }
</style>

<div class="worker-page">
    <aside class="worker-sidebar">
        <div class="brand">CityJob</div>
            <nav>
                <a href="{{ route('trabajador.peticionesPendientes') }}">Peticiones</a>
                <a href="{{ route('trabajador.editarPerfil') }}">Perfil</a>
                <a href="{{ route('trabajador.serviciosAsignados') }}">Servicios</a>
                <a href="{{ route('ayuda') }}">Ayuda</a>
            </nav>
        <div class="spacer"></div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
        <a href="#" class="logout-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar sesión</a>
    </aside>

    <section class="worker-main">
        <div class="hero-panel">
            <div class="hero-left">
                <div class="hero-avatar" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="small">Profesional</div>
            </div>

            <div class="hero-content">
                <div class="hero-title">Hola, {{ $profesionista->nombres }}</div>
                <div class="hero-text">Panel de control para gestionar tus servicios asignados, actualizar tu perfil y revisar historial de contrataciones. Mantén tu disponibilidad y calificación actualizadas para recibir más solicitudes.</div>

                <div class="cta-row">
                    <a href="{{ route('trabajador.peticionesPendientes') }}" class="btn-primary">Ver Peticiones Pendientes</a>
                    <a href="{{ route('trabajador.serviciosAsignados') }}" class="btn-primary">Servicios</a>
                    <a href="{{ route('trabajador.editarPerfil') }}" class="btn-secondary">Actualizar perfil</a>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection