<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CityJob — Iniciar Sesión</title>

    <link rel="icon" type="image/png" href="/img/CityJib_2.png">
    <link rel="shortcut icon" href="/img/CityJib_2.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=syne:400,600,700,800|instrument-sans:400,500,600" rel="stylesheet"/>

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

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* noise */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: .5;
        }

        /* blobs */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            opacity: .25;
            z-index: 0;
        }
        .blob-1 { width:500px; height:500px; background:var(--cyan);  top:-150px; right:-150px; }
        .blob-2 { width:350px; height:350px; background:#0055aa;       bottom:-100px; left:-100px; }

        /* dot grid */
        .dot-grid {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle at 2px 2px, rgba(0,195,255,.06) 1.5px, transparent 0);
            background-size: 36px 36px;
            pointer-events: none;
            z-index: 0;
        }

        /* ─── HEADER ─── */
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
            height: 36px;
            width: 36px;
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
        .logo-link span em { font-style: normal; color: var(--cyan); }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: .88rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: .4rem;
            transition: color .2s;
        }
        .back-link:hover { color: var(--cyan); }

        /* ─── MAIN ─── */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
            position: relative;
            z-index: 10;
        }

        .login-card {
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

        .login-card::before {
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
            from { opacity:0; transform: translateY(24px); }
            to   { opacity:1; transform: translateY(0); }
        }

        /* logo top */
        .card-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .5rem;
            margin-bottom: 2rem;
        }
        .card-logo img {
            width: 56px;
            height: 56px;
            object-fit: contain;
            filter: drop-shadow(0 0 12px rgba(0,195,255,.5));
        }
        .card-logo h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -1px;
        }
        .card-logo p {
            color: var(--text-muted);
            font-size: .88rem;
        }

        /* errors */
        .alert-error {
            background: rgba(220,53,69,.12);
            border: 1px solid rgba(220,53,69,.3);
            color: #ff6b7a;
            border-radius: .65rem;
            padding: .75rem 1rem;
            font-size: .88rem;
            margin-bottom: 1.25rem;
        }

        /* form */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: .45rem;
            margin-bottom: 1.25rem;
        }

        label {
            font-weight: 600;
            font-size: .85rem;
            color: #a8c5e0;
            letter-spacing: .3px;
        }

        .input-wrap {
            position: relative;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
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
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: var(--cyan);
            background: rgba(0,195,255,.06);
            box-shadow: 0 0 0 3px rgba(0,195,255,.12);
        }
        input::placeholder { color: rgba(139,170,200,.45); }

        input.is-invalid {
            border-color: rgba(220,53,69,.6);
        }
        .field-error {
            color: #ff6b7a;
            font-size: .8rem;
            margin-top: .2rem;
        }

        /* password toggle */
        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color .2s;
        }
        .pw-toggle:hover { color: var(--cyan); }

        input[type="password"],
        input[type="text"] { padding-right: 2.75rem; }

        /* remember row */
        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: .5rem;
            cursor: pointer;
            font-size: .88rem;
            color: var(--text-muted);
            user-select: none;
        }
        .check-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--cyan);
            cursor: pointer;
        }

        .forgot-link {
            font-size: .85rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color .2s;
        }
        .forgot-link:hover { color: var(--cyan); }

        /* submit */
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
        .btn-submit:active { transform: translateY(0); }

        /* divider */
        .divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.5rem 0;
            color: rgba(139,170,200,.35);
            font-size: .8rem;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* register link */
        .register-row {
            text-align: center;
            font-size: .88rem;
            color: var(--text-muted);
            margin-bottom: .75rem;
        }

        .btn-register {
            display: block;
            width: 100%;
            padding: .82rem;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: .75rem;
            color: var(--white);
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .95rem;
            text-align: center;
            text-decoration: none;
            transition: all .25s ease;
            letter-spacing: .3px;
        }
        .btn-register:hover {
            border-color: var(--cyan);
            color: var(--cyan);
            background: rgba(0,195,255,.06);
        }

        /* footer */
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
            .login-card { padding: 2rem 1.5rem; border-radius: 1rem; }
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
        <a href="{{ url('/') }}" class="back-link">
            ← Regresar
        </a>
    </header>

    <main>
        <div class="login-card">

            <div class="card-logo">
                <img src="/img/CityJib_2.png" alt="CityJob">
                <h1>Bienvenido de vuelta</h1>
                <p>Inicia sesión para continuar</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('mensaje'))
                <div class="alert-error">
                    {{ session('mensaje') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
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

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-wrap">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        >
                        <button type="button" class="pw-toggle" onclick="togglePw()">
                            <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <label class="check-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Recuérdame
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">Iniciar sesión</button>
            </form>

            <div class="divider">o</div>

            <div class="register-row">¿No tienes cuenta?</div>
            @if (Route::has('register.form'))
                <a href="{{ route('register.form') }}" class="btn-register">Crea una cuenta</a>
            @endif

        </div>
    </main>

    <footer>&copy; 2026 CityJob. Todos los derechos reservados.</footer>

    <script>
        function togglePw() {
            const field = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            if (field.type === 'password') {
                field.type = 'text';
                icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>`;
            } else {
                field.type = 'password';
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>`;
            }
        }
    </script>
</body>
</html>