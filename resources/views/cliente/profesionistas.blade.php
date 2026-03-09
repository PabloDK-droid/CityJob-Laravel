@extends('layouts.app')
@section('title', 'Profesionistas')

@section('content')
<style>
    :root {
        --cyan:#00C3FF; --cyan-dim:#0094cc; --navy:#00152B;
        --navy-mid:#002647; --navy-light:#003B73;
        --text-muted:#8BAAC8; --border:rgba(0,195,255,0.15); --white:#FFFFFF;
    }
    .cj-page { display:flex; min-height:100vh; background:var(--navy); font-family:'Instrument Sans',sans-serif; }

    .cj-sidebar {
        width:200px; flex-shrink:0; background:rgba(0,21,43,0.95);
        border-right:1px solid var(--border); display:flex; flex-direction:column;
        padding:1.75rem 1rem; position:sticky; top:0; height:100vh;
    }
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

    .cj-main { flex:1; padding:2.5rem; overflow-y:auto; }

    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:.5rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; letter-spacing:-.5px; }
    .page-title span { color:var(--cyan); }
    .page-sub { color:var(--text-muted); font-size:.9rem; margin-bottom:2rem; }
    .btn-back { display:inline-flex; align-items:center; gap:.4rem; color:var(--text-muted); text-decoration:none; font-size:.85rem; font-weight:600; transition:color .2s; }
    .btn-back:hover { color:var(--cyan); }

    /* filtro */
    .filter-card { background:rgba(255,255,255,.03); border:1px solid var(--border); border-radius:1rem; padding:1.25rem 1.5rem; margin-bottom:2rem; display:flex; align-items:flex-end; gap:1rem; flex-wrap:wrap; }
    .filter-group { display:flex; flex-direction:column; gap:.4rem; }
    .filter-group label { font-size:.82rem; font-weight:600; color:#a8c5e0; }
    .filter-group select {
        padding:.6rem .9rem; background:rgba(255,255,255,.06); border:1px solid var(--border);
        border-radius:.6rem; color:var(--white); font-family:'Instrument Sans',sans-serif;
        font-size:.9rem; outline:none; transition:border-color .2s; cursor:pointer;
    }
    .filter-group select:focus { border-color:var(--cyan); }
    .filter-group select option { background:#002647; color:var(--white); }
    .btn-cyan { background:var(--cyan); color:var(--navy); padding:.6rem 1.4rem; border-radius:.6rem; font-weight:700; font-size:.88rem; border:none; cursor:pointer; transition:all .2s; font-family:'Syne',sans-serif; }
    .btn-cyan:hover { background:var(--cyan-dim); }
    .btn-ghost { background:transparent; color:var(--text-muted); padding:.6rem 1.2rem; border-radius:.6rem; border:1px solid var(--border); font-weight:600; font-size:.88rem; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; }
    .btn-ghost:hover { border-color:var(--cyan); color:var(--cyan); }

    /* cards profesionistas */
    .prof-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:1.25rem; }

    .prof-card {
        background:rgba(255,255,255,.03); border:1px solid var(--border);
        border-radius:1.1rem; padding:1.5rem;
        display:flex; flex-direction:column; gap:1rem;
        transition:all .25s; position:relative; overflow:hidden;
    }
    .prof-card:hover { border-color:rgba(0,195,255,.3); transform:translateY(-3px); box-shadow:0 12px 28px rgba(0,0,0,.25); }

    .prof-header { display:flex; align-items:center; gap:1rem; }
    .prof-avatar {
        width:52px; height:52px; border-radius:50%;
        background:rgba(0,195,255,.1); border:1px dashed rgba(0,195,255,.25);
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
        color:rgba(0,195,255,.7);
    }
    .prof-name { font-family:'Syne',sans-serif; font-weight:700; font-size:1rem; color:var(--white); }
    .prof-meta { font-size:.78rem; color:var(--text-muted); margin-top:.15rem; }

    .prof-stars { display:flex; align-items:center; gap:.35rem; }
    .stars { color:#ffc107; font-size:1rem; letter-spacing:1px; }
    .rating-num { font-size:.8rem; color:var(--text-muted); }

    .prof-info { display:flex; flex-direction:column; gap:.4rem; }
    .prof-info-row { display:flex; align-items:center; gap:.5rem; font-size:.82rem; color:var(--text-muted); }
    .prof-info-row svg { flex-shrink:0; color:var(--cyan); opacity:.7; }

    /* form contratar inline */
    .contratar-form { border-top:1px solid var(--border); padding-top:1rem; display:flex; flex-direction:column; gap:.6rem; }
    .contratar-label { font-size:.82rem; font-weight:600; color:#a8c5e0; }
    .contratar-input {
        width:100%; padding:.65rem .9rem;
        background:rgba(255,255,255,.06); border:1px solid var(--border);
        border-radius:.6rem; color:var(--white);
        font-family:'Instrument Sans',sans-serif; font-size:.88rem;
        outline:none; transition:border-color .2s, box-shadow .2s;
    }
    .contratar-input:focus { border-color:var(--cyan); box-shadow:0 0 0 3px rgba(0,195,255,.1); }
    .contratar-input::placeholder { color:rgba(139,170,200,.4); }
    .btn-contratar { background:var(--cyan); color:var(--navy); padding:.65rem; border:none; border-radius:.6rem; font-weight:700; font-size:.88rem; cursor:pointer; transition:all .2s; font-family:'Syne',sans-serif; width:100%; }
    .btn-contratar:hover { background:var(--cyan-dim); transform:translateY(-1px); }

    .empty-state { text-align:center; padding:4rem 2rem; color:var(--text-muted); }
    .empty-state svg { color:rgba(0,195,255,.25); margin-bottom:1rem; }

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
            <a href="{{ route('cliente.catalogo') }}" class="active">
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

    <main class="cj-main">
        <div class="page-header">
            <h1 class="page-title">Profesionistas — <span>{{ $servicio->nombre_servicio }}</span></h1>
            <a href="{{ route('cliente.catalogo') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Volver al catálogo
            </a>
        </div>
        <p class="page-sub">Selecciona un profesionista e ingresa la ubicación del servicio para contratar.</p>

        {{-- FILTRO --}}
        <div class="filter-card">
            <div class="filter-group">
                <label>Calificación mínima</label>
                <form method="GET" action="{{ route('cliente.profesionistas', $servicio->id_servicio) }}" style="display:contents">
                    <select name="calificacion_min" onchange="this.form.submit()">
                        <option value="">Todas</option>
                        <option value="3"   {{ request('calificacion_min') == 3   ? 'selected' : '' }}>★★★ 3+</option>
                        <option value="4"   {{ request('calificacion_min') == 4   ? 'selected' : '' }}>★★★★ 4+</option>
                        <option value="4.5" {{ request('calificacion_min') == 4.5 ? 'selected' : '' }}>★★★★★ 4.5+</option>
                    </select>
                </form>
            </div>
            @if(request('calificacion_min'))
                <a href="{{ route('cliente.profesionistas', $servicio->id_servicio) }}" class="btn-ghost">Limpiar filtro</a>
            @endif
        </div>

        @if($profesionistas->count() > 0)
            <div class="prof-grid">
                @foreach($profesionistas as $profesionista)
                    <div class="prof-card">
                        <div class="prof-header">
                            <div class="prof-avatar">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <div>
                                <div class="prof-name">{{ $profesionista->nombres }} {{ $profesionista->apellido_p }}</div>
                                <div class="prof-meta">{{ $profesionista->nivel_estudios }}</div>
                            </div>
                        </div>

                        <div class="prof-stars">
                            @php
                                $full  = floor($profesionista->calificacion_profesionista);
                                $empty = 5 - $full;
                            @endphp
                            <span class="stars">
                                @for($i=0;$i<$full;$i++)★@endfor
                                @for($i=0;$i<$empty;$i++)<span style="opacity:.3">★</span>@endfor
                            </span>
                            <span class="rating-num">{{ number_format($profesionista->calificacion_profesionista,1) }}</span>
                        </div>

                        <div class="prof-info">
                            <div class="prof-info-row">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.77 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.68 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                {{ $profesionista->telefono }}
                            </div>
                            <div class="prof-info-row">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                {{ $profesionista->correo_electronico }}
                            </div>
                        </div>

                        <form action="{{ route('cliente.contratar') }}" method="POST" class="contratar-form">
                            @csrf
                            <input type="hidden" name="id_profesionista" value="{{ $profesionista->id_profesionista }}">
                            <input type="hidden" name="id_servicio" value="{{ $servicio->id_servicio }}">
                            <label class="contratar-label">Ubicación del servicio</label>
                            <input type="text" name="localizacion" required placeholder="Ej: Calle 5 #123, Col. Centro" class="contratar-input">
                            <button type="submit" class="btn-contratar">Contratar ahora</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <p>No hay profesionistas disponibles para este servicio.</p>
            </div>
        @endif
    </main>
</div>
@endsection