<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - CityJob</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, #0066ff 0%, #00a8ff 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .header .back-btn {
            color: #fff;
            text-decoration: none;
            font-size: 24px;
            font-weight: 600;
            background: linear-gradient(135deg, #0066ff 0%, #00a8ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: transform 0.3s ease;
        }

        .header .back-btn:hover {
            transform: translateX(-5px);
        }

        .header .logo {
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #0066ff 0%, #00a8ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            box-shadow: 0 0.2px 60px rgba(0, 0, 0, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 550px;
            margin-top: 80px;
            margin-bottom: 40px;
        }

        .register-container h2 {
            color: #333;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .register-container p {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 0.75rem;
            font-family: 'Instrument Sans', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            background: #fff;
            border-color: #0066ff;
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            transition: transform 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .password-toggle:hover {
            transform: translateY(-50%) scale(1.1);
            color: #0066ff;
        }

        .conditional-fields {
            display: none;
            padding: 15px;
            background: rgba(0, 102, 255, 0.05);
            border-radius: 0.75rem;
            margin: 20px 0;
            border-left: 4px solid #0066ff;
        }

        .conditional-fields.active {
            display: block;
        }

        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 0.75rem;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert-success {
            background: rgba(0, 255, 136, 0.1);
            color: #00ff88;
            border: 1px solid rgba(0, 255, 136, 0.2);
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 0.75rem;
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-submit {
            background: linear-gradient(135deg, #0066ff 0%, #00a8ff 100%);
            color: #fff;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.3);
        }

        .btn-cancel {
            background: transparent;
            color: #0066ff;
            border: 2px solid #0066ff;
        }

        .btn-cancel:hover {
            background: rgba(0, 102, 255, 0.05);
            transform: translateY(-2px);
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .form-footer a {
            color: #0066ff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: #00a8ff;
        }

        @media (max-width: 768px) {
            .register-container {
                padding: 30px 20px;
                margin-top: 100px;
            }

            .register-container h2 {
                font-size: 24px;
            }

            .header {
                padding: 12px 20px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="{{ url('/') }}" class="back-btn">← Volver</a>
        <div class="logo">CityJob</div>
    </div>

    <div class="register-container">
        <h2>Crear Cuenta</h2>
        <p>Únete a CityJob y comienza hoy</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="form-group">
                <label for="rol">Tipo de Usuario</label>
                <select id="rol" name="rol" onchange="toggleFormFields()" required>
                    <option value="">Selecciona tu rol...</option>
                    <option value="cliente">Quiero contratar servicios</option>
                    <option value="trabajador">Quiero ofrecer mis servicios</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nombres">Nombre(s)</label>
                    <input id="nombres" type="text" name="nombres" required autofocus placeholder="Tu nombre">
                </div>
                <div class="form-group">
                    <label for="apellido_p">Apellido Paterno</label>
                    <input id="apellido_p" type="text" name="apellido_p" required placeholder="Tu apellido">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="apellido_m">Apellido Materno</label>
                    <input id="apellido_m" type="text" name="apellido_m" placeholder="Tu apellido materno">
                </div>
                <div class="form-group">
                    <label for="genero">Género</label>
                    <select id="genero" name="genero" required>
                        <option value="">Selecciona...</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input id="telefono" type="tel" name="telefono" required placeholder="10 dígitos">
                </div>
                <div class="form-group">
                    <label for="telefono_fijo">Teléfono Fijo (opcional)</label>
                    <input id="telefono_fijo" type="tel" name="telefono_fijo" placeholder="10 dígitos">
                </div>
            </div>

            <div class="form-group">
                <label for="correo_electronico">Correo Electrónico</label>
                <input id="correo_electronico" type="email" name="correo_electronico" required placeholder="tu@correo.com">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="cp">Código Postal</label>
                    <input id="cp" type="number" name="cp" required placeholder="Tu código postal">
                </div>
                <div class="form-group">
                    <label for="domicilio">Domicilio</label>
                    <input id="domicilio" type="text" name="domicilio" required placeholder="Calle y número">
                </div>
            </div>

            <!-- Campos específicos para CLIENTE -->
            <div id="campos_cliente" class="conditional-fields">
                <div class="form-group">
                    <label for="referencias">Referencias de Ubicación</label>
                    <textarea id="referencias" name="referencias" rows="3" placeholder="Ej: Cerca de la estación, entre dos avenidas..."></textarea>
                </div>
            </div>

            <!-- Campos específicos para TRABAJADOR -->
            <div id="campos_trabajador" class="conditional-fields">
                <div class="form-group">
                    <label for="nivel_estudios">Nivel de Estudios</label>
                    <input id="nivel_estudios" type="text" name="nivel_estudios" placeholder="Ej: Licenciatura, Técnico...">
                </div>
                <div class="form-group">
                    <label for="especializado">Especialidad</label>
                    <input id="especializado" type="text" name="especializado" placeholder="Ej: Plomería, Electricidad...">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <div class="password-wrapper">
                        <input id="contrasena" type="password" name="contrasena" required minlength="6" placeholder="Mínimo 6 caracteres">
                        <button type="button" class="password-toggle" onclick="togglePassword('contrasena')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contrasena_confirmacion">Confirmar Contraseña</label>
                    <div class="password-wrapper">
                        <input id="contrasena_confirmacion" type="password" name="contrasena_confirmacion" required minlength="6" placeholder="Repite tu contraseña">
                        <button type="button" class="password-toggle" onclick="togglePassword('contrasena_confirmacion')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-submit">Registrarse</button>
                <a href="{{ url('/') }}" class="btn btn-cancel">Cancelar</a>
            </div>

            <div class="form-footer">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        function toggleFormFields() {
            const rol = document.getElementById('rol').value;
            const camposCliente = document.getElementById('campos_cliente');
            const camposTrabajador = document.getElementById('campos_trabajador');
            const nivelEstudios = document.getElementById('nivel_estudios');
            const especializado = document.getElementById('especializado');

            if (rol === 'cliente') {
                camposCliente.classList.add('active');
                camposTrabajador.classList.remove('active');
                nivelEstudios.removeAttribute('required');
                especializado.removeAttribute('required');
            } else if (rol === 'trabajador') {
                camposCliente.classList.remove('active');
                camposTrabajador.classList.add('active');
                nivelEstudios.setAttribute('required', 'required');
                especializado.setAttribute('required', 'required');
            } else {
                camposCliente.classList.remove('active');
                camposTrabajador.classList.remove('active');
            }
        }
    </script>
</body>
</html>