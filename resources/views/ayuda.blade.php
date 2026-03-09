@extends('layouts.app')
@section('title', 'Centro de Ayuda')

@section('content')
<style>
    :root {
        --cyan:#00C3FF; --cyan-dim:#0094cc; --navy:#00152B;
        --navy-mid:#002647; --text-muted:#8BAAC8; --border:rgba(0,195,255,0.15); --white:#FFFFFF;
    }
    .ayuda-page {
        background:var(--navy); min-height:100vh;
        font-family:'Instrument Sans',sans-serif;
        padding:3rem 1.5rem;
    }
    .ayuda-wrap { max-width:820px; margin:0 auto; }

    /* back btn */
    .btn-back {
        display:inline-flex; align-items:center; gap:.4rem;
        color:var(--text-muted); text-decoration:none;
        font-size:.85rem; font-weight:600;
        transition:color .2s; margin-bottom:2rem;
    }
    .btn-back:hover { color:var(--cyan); }

    /* header */
    .ayuda-hero { text-align:center; margin-bottom:3rem; }
    .hero-icon {
        width:56px; height:56px; border-radius:1rem;
        background:rgba(0,195,255,.1); border:1px solid rgba(0,195,255,.2);
        display:flex; align-items:center; justify-content:center;
        color:var(--cyan); margin:0 auto 1.25rem;
    }
    .ayuda-hero h1 {
        font-family:'Syne',sans-serif; font-size:2rem; font-weight:800;
        color:var(--white); letter-spacing:-.5px; margin:0 0 .5rem;
    }
    .ayuda-hero h1 span { color:var(--cyan); }
    .ayuda-hero p { color:var(--text-muted); font-size:.95rem; margin:0; }

    /* secciones */
    .faq-section { margin-bottom:2.5rem; }
    .section-title {
        font-family:'Syne',sans-serif; font-size:.82rem; font-weight:700;
        color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;
        margin-bottom:1rem; display:flex; align-items:center; gap:.5rem;
    }
    .section-title::after { content:''; flex:1; height:1px; background:var(--border); }
    .section-title svg { color:var(--cyan); flex-shrink:0; }

    /* items FAQ */
    .faq-item {
        background:rgba(255,255,255,.03); border:1px solid var(--border);
        border-radius:.9rem; overflow:hidden; margin-bottom:.65rem;
        transition:border-color .2s;
    }
    .faq-item:hover { border-color:rgba(0,195,255,.28); }

    .faq-question {
        width:100%; background:none; border:none; cursor:pointer;
        padding:1rem 1.25rem; text-align:left;
        display:flex; align-items:center; justify-content:space-between; gap:1rem;
        font-family:'Instrument Sans',sans-serif; font-weight:700;
        font-size:.9rem; color:var(--white); transition:color .2s;
    }
    .faq-question:hover { color:var(--cyan); }
    .faq-question svg { flex-shrink:0; color:var(--text-muted); transition:transform .25s, color .2s; }
    .faq-item.open .faq-question svg { transform:rotate(180deg); color:var(--cyan); }
    .faq-item.open .faq-question { color:var(--cyan); }

    .faq-answer {
        max-height:0; overflow:hidden;
        transition:max-height .3s ease, padding .3s;
        padding:0 1.25rem;
        font-size:.88rem; color:var(--text-muted); line-height:1.7;
    }
    .faq-item.open .faq-answer {
        max-height:300px;
        padding:.25rem 1.25rem 1.1rem;
    }
    .faq-answer ol { margin:.5rem 0 0 1.2rem; padding:0; display:flex; flex-direction:column; gap:.25rem; }

    /* contacto */
    .contacto-card {
        background:rgba(0,195,255,.07); border:1px solid rgba(0,195,255,.2);
        border-radius:1.1rem; padding:2rem; text-align:center; margin-top:3rem;
        position:relative; overflow:hidden;
    }
    .contacto-card::before {
        content:''; position:absolute; top:-60px; left:50%; transform:translateX(-50%);
        width:200px; height:200px; background:var(--cyan);
        border-radius:50%; filter:blur(70px); opacity:.06; pointer-events:none;
    }
    .contacto-card h3 {
        font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:800;
        color:var(--white); margin:0 0 .4rem;
    }
    .contacto-card p { color:var(--text-muted); font-size:.88rem; margin:0 0 1.5rem; }
    .contacto-grid { display:flex; justify-content:center; gap:2rem; flex-wrap:wrap; }
    .contacto-item { display:flex; align-items:center; gap:.5rem; font-size:.88rem; color:var(--white); }
    .contacto-item svg { color:var(--cyan); flex-shrink:0; }
    .contacto-item a { color:var(--cyan); text-decoration:none; }
    .contacto-item a:hover { text-decoration:underline; }
    .horario-badge {
        display:inline-flex; align-items:center; gap:.4rem;
        background:rgba(0,195,255,.1); border:1px solid rgba(0,195,255,.2);
        color:var(--cyan); padding:.4rem 1rem; border-radius:100px;
        font-size:.8rem; font-weight:600; margin-top:1.25rem;
    }

    @media(max-width:600px) { .contacto-grid { flex-direction:column; align-items:center; } }
</style>

<div class="ayuda-page">
    <div class="ayuda-wrap">

        @php
            $rol = session('role');
            $backRoute = match($rol) {
                'cliente'    => route('cliente.dashboard'),
                'trabajador' => route('trabajador.dashboard'),
                'admin'      => route('admin.dashboard'),
                'ingeniero'  => route('ingeniero.dashboard'),
                default      => url('/'),
            };
            $backLabel = match($rol) {
                'cliente'    => 'Mi dashboard',
                'trabajador' => 'Mi dashboard',
                'admin'      => 'Panel de administración',
                'ingeniero'  => 'Panel de ingeniería',
                default      => 'Ir al inicio',
            };
        @endphp

        <a href="{{ $backRoute }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            {{ $backLabel }}
        </a>

        <div class="ayuda-hero">
            <div class="hero-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <h1>Centro de <span>Ayuda</span></h1>
            <p>Encuentra respuestas a las preguntas más frecuentes</p>
        </div>

        {{-- CLIENTES --}}
        <div class="faq-section">
            <p class="section-title">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Para clientes
            </p>

            <div class="faq-item">
                <button class="faq-question" onclick="toggle(this)">
                    ¿Cómo contrato un servicio?
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    <ol>
                        <li>Navega al catálogo de servicios</li>
                        <li>Selecciona el servicio que necesitas</li>
                        <li>Revisa los profesionistas disponibles</li>
                        <li>Ingresa la ubicación donde necesitas el servicio</li>
                        <li>Haz clic en <strong style="color:var(--white)">"Contratar"</strong></li>
                    </ol>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggle(this)">
                    ¿Cómo califico a un profesionista?
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    Una vez que el servicio esté marcado como "Completado", encontrarás un botón <strong style="color:var(--white)">"Calificar"</strong> en Mis Contrataciones. Puedes asignar de 1 a 5 estrellas y dejar un comentario opcional.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggle(this)">
                    ¿Cómo descargo mi factura?
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    En "Mis Contrataciones", los servicios completados tendrán un botón <strong style="color:var(--white)">"Descargar Factura"</strong> que generará un PDF con todos los detalles del servicio.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggle(this)">
                    ¿Puedo cancelar una contratación?
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    Actualmente solo los administradores e ingenieros pueden cancelar servicios activos. Contacta al soporte para solicitar la cancelación.
                </div>
            </div>
        </div>

        {{-- PROFESIONISTAS --}}
        <div class="faq-section">
            <p class="section-title">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                Para profesionistas
            </p>

            <div class="faq-item">
                <button class="faq-question" onclick="toggle(this)">
                    ¿Cómo veo mis servicios asignados?
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    En tu dashboard, haz clic en <strong style="color:var(--white)">"Servicios Asignados"</strong> para ver todos los trabajos que tienes pendientes o activos.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggle(this)">
                    ¿Cómo marco un servicio como completado?
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    En "Servicios Asignados", cada trabajo activo tiene un botón <strong style="color:var(--white)">"Completar"</strong>. Una vez que finalices el trabajo, haz clic ahí para actualizar el estado.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggle(this)">
                    ¿Cómo mejoro mi calificación?
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    Tu calificación se actualiza automáticamente con cada evaluación de tus clientes. Completa los servicios con calidad y puntualidad para obtener mejores valoraciones.
                </div>
            </div>
        </div>

        {{-- GENERAL --}}
        <div class="faq-section">
            <p class="section-title">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Preguntas generales
            </p>

            <div class="faq-item">
                <button class="faq-question" onclick="toggle(this)">
                    ¿Qué métodos de pago aceptan?
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    Aceptamos pagos con tarjeta de crédito y débito a través de nuestra plataforma segura (Stripe). Próximamente integraremos más métodos de pago.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggle(this)">
                    ¿Cómo actualizo mi perfil?
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    En tu dashboard, accede a <strong style="color:var(--white)">"Mi Perfil"</strong> en el menú lateral. Ahí puedes actualizar datos personales, teléfono, domicilio y contraseña.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggle(this)">
                    ¿La plataforma cobra comisión?
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    Sí, CityJob cobra una comisión del <strong style="color:var(--white)">10%</strong> sobre el monto total del servicio para mantener y mejorar la plataforma.
                </div>
            </div>
        </div>

        {{-- CONTACTO --}}
        <div class="contacto-card">
            <h3>¿No encontraste lo que buscabas?</h3>
            <p>Nuestro equipo de soporte está aquí para ayudarte</p>
            <div class="contacto-grid">
                <div class="contacto-item">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <a href="mailto:soporte@cityjob.com">soporte@cityjob.com</a>
                </div>
                <div class="contacto-item">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.77 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.68 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    56 3731 4047
                </div>
            </div>
            <div class="horario-badge">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Lunes a Viernes · 9:00 AM – 6:00 PM
            </div>
        </div>

    </div>
</div>

<script>
    function toggle(btn) {
        const item = btn.closest('.faq-item');
        const isOpen = item.classList.contains('open');
        // cerrar todos
        document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
    }
</script>
@endsection