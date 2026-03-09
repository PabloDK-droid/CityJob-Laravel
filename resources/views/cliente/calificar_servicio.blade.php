@extends('layouts.app')
@section('title', 'Calificar Servicio')

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

    .cj-main { flex:1; padding:2.5rem; overflow-y:auto; display:flex; align-items:flex-start; justify-content:center; }

    .rating-wrap { width:100%; max-width:560px; }

    .page-header { margin-bottom:2rem; }
    .btn-back { display:inline-flex; align-items:center; gap:.4rem; color:var(--text-muted); text-decoration:none; font-size:.85rem; font-weight:600; transition:color .2s; margin-bottom:1.25rem; }
    .btn-back:hover { color:var(--cyan); }
    .page-title { font-family:'Syne',sans-serif; font-size:1.5rem; font-weight:800; letter-spacing:-.5px; margin-bottom:.35rem; }
    .page-sub { color:var(--text-muted); font-size:.9rem; }

    .info-card { background:rgba(255,255,255,.03); border:1px solid var(--border); border-radius:1rem; padding:1.25rem 1.5rem; margin-bottom:1.5rem; display:flex; flex-direction:column; gap:.5rem; }
    .info-row { display:flex; gap:.5rem; font-size:.88rem; }
    .info-label { color:var(--text-muted); min-width:110px; }
    .info-value { color:var(--white); font-weight:600; }

    /* estrellas */
    .stars-section { text-align:center; margin-bottom:2rem; }
    .stars-label { font-size:.88rem; font-weight:600; color:#a8c5e0; margin-bottom:1.25rem; }
    .star-rating { display:flex; gap:.75rem; justify-content:center; font-size:2.5rem; cursor:default; }
    .star { cursor:pointer; color:rgba(255,193,7,.2); transition:all .2s; line-height:1; }
    .star:hover, .star.active { color:#ffc107; transform:scale(1.15); }
    .rating-text { margin-top:.75rem; font-size:1rem; font-weight:700; color:var(--cyan); min-height:1.5rem; font-family:'Syne',sans-serif; }

    /* form */
    .form-group { display:flex; flex-direction:column; gap:.45rem; margin-bottom:1.5rem; }
    .form-group label { font-size:.85rem; font-weight:600; color:#a8c5e0; }
    textarea {
        width:100%; padding:.85rem 1rem; min-height:120px;
        background:rgba(255,255,255,.06); border:1px solid var(--border);
        border-radius:.75rem; color:var(--white);
        font-family:'Instrument Sans',sans-serif; font-size:.92rem;
        resize:vertical; outline:none; transition:border-color .2s, box-shadow .2s;
    }
    textarea:focus { border-color:var(--cyan); box-shadow:0 0 0 3px rgba(0,195,255,.1); }
    textarea::placeholder { color:rgba(139,170,200,.35); }
    .field-error { color:#ff6b7a; font-size:.8rem; }

    .btn-submit {
        width:100%; padding:.9rem; background:var(--cyan); color:var(--navy);
        font-family:'Syne',sans-serif; font-weight:700; font-size:1rem;
        border:none; border-radius:.75rem; cursor:pointer;
        transition:all .25s; box-shadow:0 4px 20px rgba(0,195,255,.25);
    }
    .btn-submit:hover { background:var(--cyan-dim); transform:translateY(-2px); }
    .btn-submit:disabled { background:rgba(0,195,255,.2); color:rgba(255,255,255,.3); cursor:not-allowed; transform:none; box-shadow:none; }

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
        <div class="rating-wrap">
            <div class="page-header">
                <a href="{{ route('cliente.misContrataciones') }}" class="btn-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    Volver a mis contrataciones
                </a>
                <h1 class="page-title">Calificar Servicio</h1>
                <p class="page-sub">Comparte tu experiencia con este profesionista</p>
            </div>

            <div class="info-card">
                <div class="info-row">
                    <span class="info-label">Servicio</span>
                    <span class="info-value">{{ $contratacion->servicio->nombre_servicio }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Profesionista</span>
                    <span class="info-value">{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($contratacion->fecha_realizacion)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ubicación</span>
                    <span class="info-value">{{ $contratacion->localizacion }}</span>
                </div>
            </div>

            <form action="{{ route('cliente.guardarCalificacion') }}" method="POST" id="rating-form">
                @csrf
                <input type="hidden" name="id_contratacion" value="{{ $contratacion->id_contratacion }}">
                <input type="hidden" name="id_profesionista" value="{{ $contratacion->id_profesionista }}">
                <input type="hidden" name="calificacion" id="calificacion-input" value="0">

                <div class="stars-section">
                    <p class="stars-label">¿Cómo calificarías este servicio?</p>
                    <div class="star-rating">
                        <span class="star" data-rating="1">★</span>
                        <span class="star" data-rating="2">★</span>
                        <span class="star" data-rating="3">★</span>
                        <span class="star" data-rating="4">★</span>
                        <span class="star" data-rating="5">★</span>
                    </div>
                    <div id="rating-text" class="rating-text"></div>
                    @error('calificacion')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Comentario (opcional)</label>
                    <textarea name="comentario" placeholder="Cuéntanos sobre tu experiencia...">{{ old('comentario') }}</textarea>
                    @error('comentario')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit" id="submit-btn" disabled>
                    Enviar Calificación
                </button>
            </form>
        </div>
    </main>
</div>

<script>
    const stars = document.querySelectorAll('.star');
    const input = document.getElementById('calificacion-input');
    const text  = document.getElementById('rating-text');
    const btn   = document.getElementById('submit-btn');
    const labels = { 1:'Muy malo', 2:'Malo', 3:'Regular', 4:'Bueno', 5:'Excelente' };
    let selected = 0;

    function highlight(n) {
        stars.forEach(s => {
            parseInt(s.dataset.rating) <= n
                ? s.classList.add('active')
                : s.classList.remove('active');
        });
    }

    stars.forEach(s => {
        s.addEventListener('click', () => {
            selected = parseInt(s.dataset.rating);
            input.value = selected;
            text.textContent = labels[selected];
            btn.disabled = false;
            highlight(selected);
        });
        s.addEventListener('mouseover', () => highlight(parseInt(s.dataset.rating)));
    });
    document.querySelector('.star-rating').addEventListener('mouseleave', () => highlight(selected));
</script>
@endsection