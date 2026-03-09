<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CityJob — Crear Cuenta</title>

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
            filter: blur(110px);
            pointer-events: none;
            opacity: .2;
            z-index: 0;
        }
        .blob-1 { width:500px; height:500px; background:var(--cyan);  top:-160px; right:-160px; }
        .blob-2 { width:380px; height:380px; background:#0055aa;       bottom:-120px; left:-100px; }

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
            align-items: flex-start;
            justify-content: center;
            padding: 2.5rem 1.5rem 3rem;
            position: relative;
            z-index: 10;
        }

        .register-card {
            width: 100%;
            max-width: 580px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 2.5rem 2.5rem;
            backdrop-filter: blur(16px);
            position: relative;
            overflow: hidden;
            animation: slideUp .55s ease both;
        }

        .register-card::before {
            content: '';
            position: absolute;
            top: -60px; left: 50%;
            transform: translateX(-50%);
            width: 260px; height: 260px;
            background: var(--cyan);
            border-radius: 50%;
            filter: blur(90px);
            opacity: .07;
            pointer-events: none;
        }

        @keyframes slideUp {
            from { opacity:0; transform:translateY(24px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        .card-header img {
            width: 44px; height: 44px;
            object-fit: contain;
            filter: drop-shadow(0 0 10px rgba(0,195,255,.5));
        }
        .card-header div h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -.5px;
        }
        .card-header div p {
            color: var(--text-muted);
            font-size: .85rem;
            margin-top: .15rem;
        }

        /* alerts */
        .alert {
            padding: .75rem 1rem;
            border-radius: .65rem;
            font-size: .88rem;
            margin-bottom: 1.25rem;
        }
        .alert-error {
            background: rgba(220,53,69,.12);
            border: 1px solid rgba(220,53,69,.3);
            color: #ff6b7a;
        }
        .alert-error ul { padding-left: 1.25rem; }
        .alert-success {
            background: rgba(0,195,255,.1);
            border: 1px solid rgba(0,195,255,.25);
            color: var(--cyan);
        }

        /* role tabs */
        .role-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
            margin-bottom: 1.75rem;
        }

        .role-tab {
            padding: .9rem 1rem;
            border-radius: .75rem;
            border: 1px solid var(--border);
            background: rgba(255,255,255,.03);
            cursor: pointer;
            transition: all .2s;
            text-align: center;
            position: relative;
        }
        .role-tab input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0; height: 0;
        }
        .role-tab .tab-icon { font-size: 1.5rem; display: block; margin-bottom: .3rem; }
        .role-tab .tab-label {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .9rem;
            display: block;
        }
        .role-tab .tab-sub {
            font-size: .75rem;
            color: var(--text-muted);
            display: block;
            margin-top: .2rem;
        }

        .role-tab:hover {
            border-color: rgba(0,195,255,.35);
            background: rgba(0,195,255,.05);
        }
        .role-tab.selected {
            border-color: var(--cyan);
            background: rgba(0,195,255,.1);
            box-shadow: 0 0 0 1px rgba(0,195,255,.2);
        }
        .role-tab.selected .tab-label { color: var(--cyan); }

        /* section label */
        .section-sep {
            font-size: .72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(139,170,200,.5);
            margin: 1.5rem 0 1rem;
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .section-sep::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* form grid */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .form-group { display: flex; flex-direction: column; gap: .4rem; margin-bottom: 1rem; }
        .form-group:last-child { margin-bottom: 0; }

        label {
            font-weight: 600;
            font-size: .82rem;
            color: #a8c5e0;
            letter-spacing: .3px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: .72rem 1rem;
            background: rgba(255,255,255,.06);
            border: 1px solid var(--border);
            border-radius: .65rem;
            color: var(--white);
            font-family: 'Instrument Sans', sans-serif;
            font-size: .92rem;
            transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--cyan);
            background: rgba(0,195,255,.06);
            box-shadow: 0 0 0 3px rgba(0,195,255,.12);
        }
        input::placeholder, textarea::placeholder { color: rgba(139,170,200,.4); }
        select option { background: var(--navy-mid); color: var(--white); }
        textarea { resize: vertical; min-height: 72px; }

        /* password wrap */
        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 2.75rem; }
        .pw-toggle {
            position: absolute;
            right: 10px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color .2s;
        }
        .pw-toggle:hover { color: var(--cyan); }

        /* conditional */
        .conditional { display: none; }
        .conditional.active { display: block; }

        .cond-box {
            background: rgba(0,195,255,.05);
            border: 1px solid rgba(0,195,255,.15);
            border-left: 3px solid var(--cyan);
            border-radius: .75rem;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        /* submit */
        .btn-submit {
            width: 100%;
            padding: .9rem;
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
            margin-top: 1.75rem;
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
            margin-top: 1.25rem;
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

        @media (max-width: 560px) {
            .form-row { grid-template-columns: 1fr; }
            .register-card { padding: 1.75rem 1.25rem; }
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
        <a href="{{ url('/') }}" class="back-link">← Regresar</a>
    </header>

    <main>
        <div class="register-card">

            <div class="card-header">
                <img src="/img/CityJib_2.png" alt="CityJob">
                <div>
                    <h1>Crear cuenta</h1>
                    <p>Únete a CityJob y comienza hoy</p>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                {{-- ROLE TABS --}}
                <p class="section-sep">Tipo de cuenta</p>
                <div class="role-tabs">
                    <label class="role-tab {{ old('rol') === 'cliente' ? 'selected' : '' }}" id="tab-cliente">
                        <input type="radio" name="rol" value="cliente"
                               {{ old('rol') === 'cliente' ? 'checked' : '' }}
                               onchange="handleRole(this)">
                        <span class="tab-icon">🏠</span>
                        <span class="tab-label">Cliente</span>
                        <span class="tab-sub">Quiero contratar servicios</span>
                    </label>
                    <label class="role-tab {{ old('rol') === 'trabajador' ? 'selected' : '' }}" id="tab-trabajador">
                        <input type="radio" name="rol" value="trabajador"
                               {{ old('rol') === 'trabajador' ? 'checked' : '' }}
                               onchange="handleRole(this)">
                        <span class="tab-icon">🔧</span>
                        <span class="tab-label">Profesionista</span>
                        <span class="tab-sub">Quiero ofrecer mis servicios</span>
                    </label>
                </div>

                {{-- DATOS PERSONALES --}}
                <p class="section-sep">Datos personales</p>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre(s)</label>
                        <input type="text" name="nombres" value="{{ old('nombres') }}" required placeholder="Tu nombre" autofocus>
                    </div>
                    <div class="form-group">
                        <label>Apellido Paterno</label>
                        <input type="text" name="apellido_p" value="{{ old('apellido_p') }}" required placeholder="Apellido">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Apellido Materno <span style="color:var(--text-muted);font-weight:400;">(opcional)</span></label>
                        <input type="text" name="apellido_m" value="{{ old('apellido_m') }}" placeholder="Apellido materno">
                    </div>
                    <div class="form-group">
                        <label>Género</label>
                        <select name="genero" required>
                            <option value="">Selecciona...</option>
                            <option value="M" {{ old('genero') === 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('genero') === 'F' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>
                </div>

                {{-- CONTACTO --}}
                <p class="section-sep">Contacto</p>

                <div class="form-row">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="tel" name="telefono" value="{{ old('telefono') }}" required placeholder="10 dígitos">
                    </div>
                    <div class="form-group">
                        <label>Teléfono Fijo <span style="color:var(--text-muted);font-weight:400;">(opcional)</span></label>
                        <input type="tel" name="telefono_fijo" value="{{ old('telefono_fijo') }}" placeholder="10 dígitos">
                    </div>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="correo_electronico" value="{{ old('correo_electronico') }}" required placeholder="tu@correo.com">
                </div>

                {{-- DOMICILIO --}}
                <p class="section-sep">Domicilio</p>

                <div class="form-row">
                    <div class="form-group">
                        <label>Código Postal</label>
                        <input type="number" name="cp" value="{{ old('cp') }}" required placeholder="CP">
                    </div>
                    <div class="form-group">
                        <label>Domicilio</label>
                        <input type="text" name="domicilio" value="{{ old('domicilio') }}" required placeholder="Calle y número">
                    </div>
                </div>

                {{-- CLIENTE --}}
                <div id="campos_cliente" class="conditional {{ old('rol') === 'cliente' ? 'active' : '' }}">
                    <div class="cond-box">
                        <div class="form-group" style="margin-bottom:0">
                            <label>Referencias de Ubicación</label>
                            <textarea name="referencias" placeholder="Ej: Cerca de la estación, entre dos avenidas...">{{ old('referencias') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- TRABAJADOR --}}
                <div id="campos_trabajador" class="conditional {{ old('rol') === 'trabajador' ? 'active' : '' }}">
                    <div class="cond-box">
                        <p class="section-sep" style="margin-top:0">Datos profesionales</p>
                        <div class="form-row">
                            <div class="form-group" style="margin-bottom:0">
                                <label>Nivel de Estudios</label>
                                <input type="text" name="nivel_estudios" value="{{ old('nivel_estudios') }}" id="nivel_estudios" placeholder="Ej: Licenciatura, Técnico...">
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label>Especialidad</label>
                                <input type="text" name="especializado" value="{{ old('especializado') }}" id="especializado" placeholder="Ej: Plomería, Electricidad...">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CONTRASEÑA --}}
                <p class="section-sep">Seguridad</p>

                <div class="form-row">
                    <div class="form-group">
                        <label>Contraseña</label>
                        <div class="pw-wrap">
                            <input type="password" name="contrasena" id="pw1" required minlength="6" placeholder="Mínimo 6 caracteres">
                            <button type="button" class="pw-toggle" onclick="togglePw('pw1', this)">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirmar Contraseña</label>
                        <div class="pw-wrap">
                            <input type="password" name="contrasena_confirmacion" id="pw2" required minlength="6" placeholder="Repite tu contraseña">
                            <button type="button" class="pw-toggle" onclick="togglePw('pw2', this)">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Crear mi cuenta</button>

                <div class="login-row">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
                </div>

            </form>
        </div>
    </main>

    <footer>&copy; 2026 CityJob. Todos los derechos reservados.</footer>

    <script>
        function handleRole(radio) {
            document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('selected'));
            radio.closest('.role-tab').classList.add('selected');

            const isWorker = radio.value === 'trabajador';
            document.getElementById('campos_cliente').classList.toggle('active', radio.value === 'cliente');
            document.getElementById('campos_trabajador').classList.toggle('active', isWorker);

            const niv = document.getElementById('nivel_estudios');
            const esp = document.getElementById('especializado');
            if (isWorker) {
                niv.setAttribute('required', '');
                esp.setAttribute('required', '');
            } else {
                niv.removeAttribute('required');
                esp.removeAttribute('required');
            }
        }

        function togglePw(id, btn) {
            const field = document.getElementById(id);
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>