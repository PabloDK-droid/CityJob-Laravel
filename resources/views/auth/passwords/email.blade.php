<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CityJob — Recuperar Contraseña</title>

    <link rel="icon" type="image/png" href="/img/CityJib_2.png">
    <link rel="shortcut icon" href="/img/CityJib_2.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=syne:400,600,700,800|instrument-sans:400,500,600" rel="stylesheet"/>

    <style>
        :root {
            --cyan:       #00C3FF;
            --cyan-dim:   #0094cc;
            --navy:       #00152B;
            --text-muted: #8BAAC8;
            --border:     rgba(0,195,255,0.15);
            --white:      #FFFFFF;
        }

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: .5;
        }

        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            opacity: .22;
            z-index: 0;
        }
        .blob-1 { width:460px; height:460px; background:var(--cyan); top:-140px; right:-140px; }
        .blob-2 { width:340px; height:340px; background:#0055aa;      bottom:-100px; left:-90px; }

        .dot-grid {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle at 2px 2px, rgba(0,195,255,.06) 1.5px, transparent 0);
            background-size: 36px 36px;
            pointer-events: none;
            z-index: 0;
        }

        header {
            position: relative;
            z-index: 10;
            padding: 1.25rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            background: rgba(0,21,43,0.6);
            backdrop-filter: blur(12px);
        }

        .logo-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            text-decoration: none;
        }
        .logo-link img {
            height: 36px; width: 36px;
            object-fit: contain;
            border-radius: 8px;
            filter: drop-shadow(0 0 6px rgba(0,195,255,.5));
        }
        .logo-link span {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -1px;
        }
        .logo-link span em { font-style:normal; color:var(--cyan); }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: .88rem;
            font-weight: 600;
            transition: color .2s;
        }
        .back-link:hover { color: var(--cyan); }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
            position: relative;
            z-index: 10;
        }

        .card {
            width: 100%;
            max-width: 440px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 2.75rem 2.5rem;
            backdrop-filter: blur(16px);
            position: relative;
            overflow: hidden;
            animation: slideUp .55s ease both;
        }

        .card::before {
            content: '';
            position: absolute;
            top: -60px; left: 50%;
            transform: translateX(-50%);
            width: 220px; height: 220px;
            background: var(--cyan);
            border-radius: 50%;
            filter: blur(80px);
            opacity: .08;
            pointer-events: none;
        }

        @keyframes slideUp {
            from { opacity:0; transform:translateY(24px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .card-icon {
            width: 64px; height: 64px;
            background: rgba(0,195,255,.1);
            border: 1px solid rgba(0,195,255,.25);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .card-icon svg { color: var(--cyan); }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            text-align: center;
            letter-spacing: -.5px;
            margin-bottom: .5rem;
        }
        .card-sub {
            text-align: center;
            color: var(--text-muted);
            font-size: .88rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .alert-success {
            background: rgba(0,195,255,.1);
            border: 1px solid rgba(0,195,255,.25);
            color: var(--cyan);
            padding: .75rem 1rem;
            border-radius: .65rem;
            font-size: .88rem;
            margin-bottom: 1.25rem;
            text-align: center;
        }

        .alert-error {
            background: rgba(220,53,69,.12);
            border: 1px solid rgba(220,53,69,.3);
            color: #ff6b7a;
            padding: .75rem 1rem;
            border-radius: .65rem;
            font-size: .88rem;
            margin-bottom: 1.25rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: .45rem;
            margin-bottom: 1.5rem;
        }

        label {
            font-weight: 600;
            font-size: .85rem;
            color: #a8c5e0;
            letter-spacing: .3px;
        }

        input[type="email"] {
            width: 100%;
            padding: .75rem 1rem;
            background: rgba(255,255,255,.06);
            border: 1px solid var(--border);
            border-radius: .65rem;
            color: var(--white);
            font-family: 'Instrument Sans', sans-serif;
            font-size: .95rem;
            transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none;
        }
        input[type="email"]:focus {
            border-color: var(--cyan);
            background: rgba(0,195,255,.06);
            box-shadow: 0 0 0 3px rgba(0,195,255,.12);
        }
        input::placeholder { color: rgba(139,170,200,.4); }
        input.is-invalid   { border-color: rgba(220,53,69,.6); }

        .field-error {
            color: #ff6b7a;
            font-size: .8rem;
        }

        .btn-submit {
            width: 100%;
            padding: .85rem;
            background: var(--cyan);
            color: var(--navy);
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            border-radius: .75rem;
            cursor: pointer;
            transition: all .25s ease;
            box-shadow: 0 4px 20px rgba(0,195,255,.3);
            letter-spacing: .3px;
        }
        .btn-submit:hover {
            background: var(--cyan-dim);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(0,195,255,.4);
        }

        .login-row {
            text-align: center;
            font-size: .88rem;
            color: var(--text-muted);
            margin-top: 1.5rem;
        }
        .login-row a {
            color: var(--cyan);
            text-decoration: none;
            font-weight: 600;
        }
        .login-row a:hover { opacity: .8; }

        footer {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 1.25rem;
            color: rgba(139,170,200,.4);
            font-size: .78rem;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 480px) {
            .card { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="dot-grid"></div>

    <header>
        <a href="{{ url('/') }}" class="logo-link">
            <img src="/img/CityJib_2.png" alt="CityJob">
            <span>City<em>Job</em></span>
        </a>
        <a href="{{ route('login') }}" class="back-link">← Iniciar sesión</a>
    </header>

    <main>
        <div class="card">

            <div class="card-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
            </div>

            <h1 class="card-title">¿Olvidaste tu contraseña?</h1>
            <p class="card-sub">Ingresa tu correo y te enviaremos un enlace para restablecerla.</p>

            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="tu@correo.com"
                        required
                        autocomplete="email"
                        autofocus
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    >
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Enviar enlace de recuperación</button>
            </form>

            <div class="login-row">
                <a href="{{ route('login') }}">← Volver a iniciar sesión</a>
            </div>

        </div>
    </main>

    <footer>&copy; 2026 CityJob. Todos los derechos reservados.</footer>
</body>
</html>