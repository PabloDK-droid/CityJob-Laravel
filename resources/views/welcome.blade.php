<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CityJob — Servicios Profesionales</title>

    <link rel="icon" type="image/png" href="/img/CityJib_2.png">
    <link rel="shortcut icon" href="/img/CityJib_2.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=syne:400,600,700,800|instrument-sans:400,500,600" rel="stylesheet"/>

    <style>
        :root {
            --cyan:        #00C3FF;
            --cyan-dim:    #0094cc;
            --navy:        #00152B;
            --navy-mid:    #002647;
            --navy-light:  #003B73;
            --text-muted:  #8BAAC8;
            --white:       #FFFFFF;
            --card-bg:     rgba(255,255,255,0.04);
            --border:      rgba(0,195,255,0.15);
        }

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            overflow-x: hidden;
        }

        /* ─── NOISE OVERLAY ─── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: .5;
        }

        /* ─── HEADER ─── */
        header {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 999;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0,21,43,0.82);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
        }

        .logo-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
        }

        .logo-link img {
            height: 42px;
            width: 42px;
            object-fit: contain;
            border-radius: 10px;
            filter: drop-shadow(0 0 8px rgba(0,195,255,.5));
        }

        .logo-link span {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -1px;
        }

        .logo-link span em {
            font-style: normal;
            color: var(--cyan);
        }

        nav { display: flex; gap: .75rem; align-items: center; }

        .btn {
            padding: .55rem 1.4rem;
            border-radius: .5rem;
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 600;
            font-size: .9rem;
            text-decoration: none;
            transition: all .25s ease;
            cursor: pointer;
            border: none;
            display: inline-block;
        }

        .btn-ghost {
            color: var(--text-muted);
            background: transparent;
            border: 1px solid var(--border);
        }
        .btn-ghost:hover {
            color: var(--cyan);
            border-color: var(--cyan);
            background: rgba(0,195,255,.06);
        }

        .btn-cyan {
            background: var(--cyan);
            color: var(--navy);
            box-shadow: 0 4px 20px rgba(0,195,255,.35);
        }
        .btn-cyan:hover {
            background: var(--cyan-dim);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(0,195,255,.45);
        }

        /* ─── HERO ─── */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 10rem 5% 7rem;
            position: relative;
            overflow: hidden;
        }

        /* grid dot pattern */
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 2px 2px, rgba(0,195,255,.07) 1.5px, transparent 0);
            background-size: 36px 36px;
            pointer-events: none;
        }

        /* glow blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            opacity: .35;
        }
        .blob-1 { width:520px; height:520px; background:var(--cyan);    top:-180px; right:-100px; }
        .blob-2 { width:380px; height:380px; background:#0055aa;         bottom:-120px; left:-80px; }

        .hero-inner {
            position: relative;
            z-index: 10;
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            gap: 4rem;
            align-items: center;
            width: 100%;
        }

        /* badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(0,195,255,.1);
            border: 1px solid rgba(0,195,255,.25);
            color: var(--cyan);
            font-size: .8rem;
            font-weight: 600;
            padding: .35rem .9rem;
            border-radius: 100px;
            margin-bottom: 1.5rem;
            letter-spacing: .5px;
            text-transform: uppercase;
        }
        .badge-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--cyan);
            box-shadow: 0 0 6px var(--cyan);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:.5; transform:scale(.75); }
        }

        .hero-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.4rem, 4.5vw, 3.8rem);
            font-weight: 800;
            line-height: 1.18;
            margin-bottom: 1.75rem;
            letter-spacing: -1.5px;
        }
        .hero-title .accent { color: var(--cyan); }

        .hero-desc {
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.8;
            max-width: 500px;
            margin-bottom: 3rem;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-large {
            padding: .85rem 2rem;
            font-size: 1rem;
            border-radius: .65rem;
        }

        /* stats row */
        .hero-stats {
            display: flex;
            gap: 2.5rem;
            margin-top: 3.5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
        }
        .stat-item { display:flex; flex-direction:column; gap:.25rem; }
        .stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--cyan);
            letter-spacing: -1px;
        }
        .stat-label { font-size: .8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }

        /* logo illustration side */
        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .logo-ring {
            position: relative;
            width: 360px;
            height: 360px;
        }

        .logo-ring::before {
            content: '';
            position: absolute;
            inset: -20px;
            border-radius: 50%;
            border: 1px dashed rgba(0,195,255,.2);
            animation: spin 20s linear infinite;
        }
        .logo-ring::after {
            content: '';
            position: absolute;
            inset: -50px;
            border-radius: 50%;
            border: 1px dashed rgba(0,195,255,.1);
            animation: spin 35s linear infinite reverse;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .logo-ring img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 24px;
            filter: drop-shadow(0 0 40px rgba(0,195,255,.4));
            animation: float 7s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-18px); }
        }

        /* orbit dots */
        .orbit-dot {
            position: absolute;
            width: 10px; height: 10px;
            background: var(--cyan);
            border-radius: 50%;
            box-shadow: 0 0 12px var(--cyan);
            z-index: 3;
        }
        .orbit-dot:nth-child(2) { top: -10px; left: 50%; }
        .orbit-dot:nth-child(3) { bottom: -10px; right: 20%; }
        .orbit-dot:nth-child(4) { top: 40%; left: -10px; }

        /* ─── HOW IT WORKS ─── */
        .how {
            padding: 6rem 5%;
            position: relative;
        }

        .section-label {
            text-align: center;
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--cyan);
            margin-bottom: .75rem;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800;
            text-align: center;
            margin-bottom: .75rem;
            letter-spacing: -1px;
        }

        .section-sub {
            text-align: center;
            color: var(--text-muted);
            font-size: .95rem;
            margin-bottom: 3.5rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .steps-grid {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            position: relative;
        }

        /* connector line */
        .steps-grid::before {
            content: '';
            position: absolute;
            top: 52px;
            left: calc(16.6% + 1rem);
            right: calc(16.6% + 1rem);
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--cyan), transparent);
            opacity: .4;
            pointer-events: none;
        }

        .step-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 1.25rem;
            padding: 2rem 1.75rem;
            transition: transform .3s, border-color .3s, box-shadow .3s;
            position: relative;
            overflow: hidden;
        }
        .step-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 0%, rgba(0,195,255,.06), transparent 65%);
        }
        .step-card:hover {
            transform: translateY(-6px);
            border-color: rgba(0,195,255,.45);
            box-shadow: 0 20px 40px rgba(0,0,0,.3), 0 0 0 1px rgba(0,195,255,.15);
        }

        .step-num {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: rgba(0,195,255,.12);
            border: 1px solid rgba(0,195,255,.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--cyan);
            margin-bottom: 1.25rem;
        }

        .step-card h3 {
            font-family: 'Syne', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: .6rem;
        }

        .step-card p {
            color: var(--text-muted);
            font-size: .9rem;
            line-height: 1.6;
        }

        /* ─── CTA BANNER ─── */
        .cta-section {
            padding: 5rem 5%;
        }

        .cta-card {
            max-width: 900px;
            margin: 0 auto;
            background: linear-gradient(135deg, var(--navy-mid), var(--navy-light));
            border: 1px solid rgba(0,195,255,.2);
            border-radius: 2rem;
            padding: 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-card::before {
            content: '';
            position: absolute;
            top: -60px; left: 50%;
            transform: translateX(-50%);
            width: 300px; height: 300px;
            background: var(--cyan);
            border-radius: 50%;
            filter: blur(100px);
            opacity: .12;
            pointer-events: none;
        }

        .cta-card h2 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            font-weight: 800;
            margin-bottom: .75rem;
            letter-spacing: -1px;
        }
        .cta-card p {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 2rem;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ─── FOOTER ─── */
        footer {
            border-top: 1px solid var(--border);
            padding: 2rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text-muted);
            font-size: .82rem;
        }
        footer a { color: var(--text-muted); text-decoration: none; }
        footer a:hover { color: var(--cyan); }

        /* ─── ENTER ANIMATION ─── */
        .fade-up {
            opacity: 0;
            transform: translateY(28px);
            animation: fadeUp .7s ease forwards;
        }
        .fade-up:nth-child(1) { animation-delay: .1s; }
        .fade-up:nth-child(2) { animation-delay: .25s; }
        .fade-up:nth-child(3) { animation-delay: .4s; }
        .fade-up:nth-child(4) { animation-delay: .55s; }
        @keyframes fadeUp {
            to { opacity:1; transform:translateY(0); }
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 900px) {
            .hero-inner { grid-template-columns: 1fr; text-align: center; gap: 2.5rem; }
            .hero-desc { margin: 0 auto 2rem; }
            .hero-cta { justify-content: center; }
            .hero-stats { justify-content: center; }
            .logo-ring { width: 260px; height: 260px; }
            .steps-grid { grid-template-columns: 1fr; }
            .steps-grid::before { display: none; }
            footer { flex-direction: column; gap: .75rem; text-align: center; }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header>
        <a href="#" class="logo-link">
            <img src="/img/CityJib_2.png" alt="CityJob">
            <span>City<em>Job</em></span>
        </a>
        <nav>
            <a href="{{ route('login') }}" class="btn btn-ghost">Iniciar sesión</a>
            <a href="{{ route('register.form') }}" class="btn btn-cyan">Regístrate gratis</a>
        </nav>
    </header>

    <!-- HERO -->
    <section class="hero">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>

        <div class="hero-inner">
            <div class="hero-content">
                <div class="badge fade-up">
                    <span class="badge-dot"></span>
                    Plataforma activa en tu ciudad
                </div>

                <h1 class="hero-title fade-up">
                    Encuentra al experto<br>ideal para tu
                    <span class="accent"> próximo proyecto</span>
                </h1>

                <p class="hero-desc fade-up">
                    Conecta con profesionales calificados cerca de ti. Plomería, electricidad, carpintería, tecnología y más — todo gestionado en un solo lugar con pagos seguros.
                </p>

                <div class="hero-cta fade-up">
                    <a href="{{ route('register.form') }}" class="btn btn-cyan btn-large">Comenzar ahora</a>
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-large">Ya tengo cuenta</a>
                </div>

                <div class="hero-stats fade-up">
                    <div class="stat-item">
                        <span class="stat-num">100%</span>
                        <span class="stat-label">Pagos seguros</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">4</span>
                        <span class="stat-label">Roles de usuario</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">10%</span>
                        <span class="stat-label">Comisión plataforma</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="logo-ring">
                    <span class="orbit-dot"></span>
                    <span class="orbit-dot"></span>
                    <span class="orbit-dot"></span>
                    <img src="/img/CityJib_2.png" alt="CityJob Logo">
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how">
        <p class="section-label">¿Cómo funciona?</p>
        <h2 class="section-title">Tres pasos, resultado garantizado</h2>
        <p class="section-sub">Sin complicaciones. Desde la búsqueda hasta el pago, todo dentro de CityJob.</p>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">01</div>
                <h3>Busca el servicio</h3>
                <p>Explora el catálogo, filtra por precio y calificación. Encuentra exactamente lo que necesitas en segundos.</p>
            </div>
            <div class="step-card">
                <div class="step-num">02</div>
                <h3>Conecta y acuerda</h3>
                <p>Habla directamente con el profesionista por el chat integrado, confirma detalles y espera su aceptación.</p>
            </div>
            <div class="step-card">
                <div class="step-num">03</div>
                <h3>Paga y califica</h3>
                <p>Realiza el pago seguro con tarjeta, recibe tu factura PDF y evalúa al profesionista al finalizar.</p>
            </div>
        </div>
    </section>

    <!-- CTA FINAL -->
    <section class="cta-section">
        <div class="cta-card">
            <h2>¿Listo para empezar?</h2>
            <p>Únete a CityJob hoy mismo. El registro es gratuito y toma menos de 2 minutos.</p>
            <a href="{{ route('register.form') }}" class="btn btn-cyan btn-large">Crear mi cuenta gratis</a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <span>&copy; 2026 CityJob. Todos los derechos reservados.</span>
        <div style="display:flex;gap:1.5rem;">
            <a href="{{ route('ayuda') }}">Centro de ayuda</a>
            <a href="{{ route('login') }}">Iniciar sesión</a>
        </div>
    </footer>

</body>
</html>