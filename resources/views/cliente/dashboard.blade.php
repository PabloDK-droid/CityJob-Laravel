@extends('layouts.app')

@section('title', 'Dashboard Cliente')

@section('content')
<style>
    :root {
        --cyan:       #00C3FF;
        --cyan-dim:   #0094cc;
        --navy:       #00152B;
        --navy-mid:   #002647;
        --navy-light: #003B73;
        --text-muted: #8BAAC8;
        --border:     rgba(0,195,255,0.15);
        --white:      #FFFFFF;
    }

    /* ── layout ── */
    .cj-page {
        display: flex;
        min-height: calc(100vh - 56px);
        background: var(--navy);
        font-family: 'Instrument Sans', sans-serif;
    }

    /* ── sidebar ── */
    .cj-sidebar {
        width: 200px;
        flex-shrink: 0;
        background: rgba(0,21,43,0.95);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        padding: 1.75rem 1rem;
        position: sticky;
        top: 56px;
        height: calc(100vh - 56px);
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin-bottom: 2rem;
        padding: 0 .5rem;
    }
    .sidebar-brand img {
        width: 28px; height: 28px;
        object-fit: contain;
        filter: drop-shadow(0 0 5px rgba(0,195,255,.5));
    }
    .sidebar-brand span {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 1.1rem;
        color: var(--white);
        letter-spacing: -.5px;
    }
    .sidebar-brand span em { font-style:normal; color:var(--cyan); }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: .15rem;
        flex: 1;
    }

    .sidebar-nav a {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .6rem .75rem;
        border-radius: .6rem;
        color: var(--text-muted);
        text-decoration: none;
        font-size: .88rem;
        font-weight: 600;
        transition: all .2s;
    }
    .sidebar-nav a:hover {
        background: rgba(0,195,255,.07);
        color: var(--white);
    }
    .sidebar-nav a.active {
        background: rgba(0,195,255,.12);
        color: var(--cyan);
        border: 1px solid rgba(0,195,255,.2);
    }
    .sidebar-nav a svg { flex-shrink: 0; opacity: .7; }
    .sidebar-nav a:hover svg, .sidebar-nav a.active svg { opacity: 1; }

    .sidebar-divider {
        height: 1px;
        background: var(--border);
        margin: .75rem 0;
    }

    .sidebar-logout {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .6rem .75rem;
        border-radius: .6rem;
        color: rgba(255,100,100,.6);
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        font-family: inherit;
    }
    .sidebar-logout:hover {
        background: rgba(255,80,80,.08);
        color: #ff6b6b;
    }

    /* ── main ── */
    .cj-main {
        flex: 1;
        padding: 2.5rem 2.5rem;
        overflow-y: auto;
    }

    /* hero card */
    .hero-card {
        background: linear-gradient(135deg, var(--navy-mid) 0%, var(--navy-light) 100%);
        border: 1px solid var(--border);
        border-radius: 1.5rem;
        padding: 3rem;
        display: flex;
        align-items: center;
        gap: 3rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .hero-card::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 300px; height: 300px;
        background: var(--cyan);
        border-radius: 50%;
        filter: blur(100px);
        opacity: .08;
        pointer-events: none;
    }
    .hero-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 2px 2px, rgba(0,195,255,.04) 1.5px, transparent 0);
        background-size: 28px 28px;
        pointer-events: none;
    }

    .hero-avatar {
        width: 110px; height: 110px;
        border-radius: 1.25rem;
        background: rgba(0,195,255,.08);
        border: 1px dashed rgba(0,195,255,.25);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }
    .hero-avatar svg { color: rgba(0,195,255,.7); }

    .hero-text { position: relative; z-index: 1; }
    .hero-greeting {
        font-family: 'Syne', sans-serif;
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--white);
        letter-spacing: -.5px;
        margin-bottom: .4rem;
    }
    .hero-greeting span { color: var(--cyan); }
    .hero-desc {
        color: var(--text-muted);
        font-size: .92rem;
        line-height: 1.6;
        max-width: 520px;
        margin-bottom: 1.5rem;
    }
    .hero-btns {
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
    }
    .btn-cyan {
        background: var(--cyan);
        color: var(--navy);
        padding: .65rem 1.4rem;
        border-radius: .6rem;
        font-weight: 700;
        font-size: .88rem;
        text-decoration: none;
        transition: all .2s;
        font-family: 'Syne', sans-serif;
    }
    .btn-cyan:hover {
        background: var(--cyan-dim);
        transform: translateY(-2px);
    }
    .btn-outline {
        background: transparent;
        color: var(--white);
        padding: .65rem 1.4rem;
        border-radius: .6rem;
        border: 1px solid var(--border);
        font-weight: 600;
        font-size: .88rem;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-outline:hover {
        border-color: var(--cyan);
        color: var(--cyan);
        background: rgba(0,195,255,.05);
    }

    /* quick access grid */
    .section-title {
        font-family: 'Syne', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1rem;
    }

    .quick-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .quick-card {
        background: rgba(255,255,255,.03);
        border: 1px solid var(--border);
        border-radius: 1rem;
        padding: 1.4rem 1.25rem;
        text-decoration: none;
        transition: all .25s;
        display: flex;
        flex-direction: column;
        gap: .6rem;
        position: relative;
        overflow: hidden;
    }
    .quick-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 0%, rgba(0,195,255,.05), transparent 65%);
        opacity: 0;
        transition: opacity .25s;
    }
    .quick-card:hover {
        border-color: rgba(0,195,255,.35);
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,.25);
    }
    .quick-card:hover::before { opacity: 1; }

    .quick-icon {
        width: 42px; height: 42px;
        border-radius: .75rem;
        background: rgba(0,195,255,.1);
        border: 1px solid rgba(0,195,255,.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--cyan);
    }
    .quick-label {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: .92rem;
        color: var(--white);
    }
    .quick-sub {
        font-size: .78rem;
        color: var(--text-muted);
        line-height: 1.4;
    }

    /* alerts */
    .alert-success {
        background: rgba(0,195,255,.08);
        border: 1px solid rgba(0,195,255,.2);
        color: var(--cyan);
        padding: .75rem 1rem;
        border-radius: .75rem;
        font-size: .88rem;
        margin-bottom: 1.5rem;
    }

    /* responsive */
    @media (max-width: 900px) {
        .cj-sidebar { display: none; }
        .cj-main { padding: 1.5rem 1rem; }
        .hero-card { flex-direction: column; gap: 1.5rem; padding: 2rem; }
        .hero-greeting { font-size: 1.4rem; }
    }
</style>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=syne:700,800|instrument-sans:400,600" rel="stylesheet"/>

<div class="cj-page">

    {{-- SIDEBAR --}}
    <aside class="cj-sidebar">
        <div class="sidebar-brand">
            <img src="/img/CityJib_2.png" alt="CityJob">
            <span>City<em>Job</em></span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('cliente.dashboard') }}" class="active">
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

    {{-- MAIN --}}
    <main class="cj-main">

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- HERO --}}
        <div class="hero-card">
            <div class="hero-avatar">
                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="hero-text">
                <div class="hero-greeting">
                    Bienvenido, <span>{{ $cliente->nombres ?? 'Usuario' }}</span>
                </div>
                <p class="hero-desc">
                    Explora el catálogo, contrata profesionales y gestiona todos tus servicios desde aquí. Todo en un solo lugar.
                </p>
                <div class="hero-btns">
                    <a href="{{ route('cliente.catalogo') }}" class="btn-cyan">Explorar catálogo</a>
                    <a href="{{ route('cliente.misContrataciones') }}" class="btn-outline">Mis contrataciones</a>
                    <a href="{{ route('cliente.historial') }}" class="btn-outline">Mi historial</a>
                </div>
            </div>
        </div>

        {{-- QUICK ACCESS --}}
        <p class="section-title">Acceso rápido</p>
        <div class="quick-grid">
            <a href="{{ route('cliente.catalogo') }}" class="quick-card">
                <div class="quick-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                </div>
                <div class="quick-label">Catálogo</div>
                <div class="quick-sub">Busca y filtra servicios disponibles</div>
            </a>

            <a href="{{ route('cliente.misContrataciones') }}" class="quick-card">
                <div class="quick-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div class="quick-label">Contrataciones</div>
                <div class="quick-sub">Revisa el estado de tus servicios</div>
            </a>

            <a href="{{ route('cliente.historial') }}" class="quick-card">
                <div class="quick-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="quick-label">Historial</div>
                <div class="quick-sub">Todos tus servicios pasados</div>
            </a>

            <a href="{{ route('cliente.editarPerfil') }}" class="quick-card">
                <div class="quick-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="quick-label">Mi Perfil</div>
                <div class="quick-sub">Actualiza tus datos personales</div>
            </a>

            <a href="{{ route('ayuda') }}" class="quick-card">
                <div class="quick-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <div class="quick-label">Ayuda</div>
                <div class="quick-sub">Preguntas frecuentes y soporte</div>
            </a>
        </div>

    </main>
</div>

@endsection