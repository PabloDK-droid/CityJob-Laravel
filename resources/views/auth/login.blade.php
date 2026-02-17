<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'CityJob') }} - Iniciar Sesión</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        
        <style>
            :root{--blue-1:#0066ff;--blue-2:#00a8ff}
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            html, body {
                font-family: 'Instrument Sans', sans-serif;
                height: 100%;
            }
            
            body {
                background: linear-gradient(135deg, var(--blue-1) 0%, var(--blue-2) 100%);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem;
            }
            
            /* Header */
            header {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                padding: 1.5rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .back-link {
                color: white;
                text-decoration: none;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.3s ease;
            }
            
            .back-link:hover {
                transform: translateX(-4px);
            }
            
            .logo-text {
                font-size: 1.5rem;
                font-weight: 700;
                color: white;
            }
            
            /* Login Container */
            .login-container {
                background: white;
                border-radius: 1rem;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
                width: 100%;
                max-width: 450px;
                padding: 3rem;
                z-index: 10;
            }
            
            .login-header {
                text-align: center;
                margin-bottom: 2rem;
            }
            
            .login-header h1 {
                font-size: 2rem;
                color: #333;
                margin-bottom: 0.5rem;
            }
            
            .login-header p {
                color: #666;
                font-size: 0.95rem;
            }
            
            /* Form */
            form {
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
            }
            
            .form-group {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }
            
            label {
                font-weight: 600;
                color: #333;
                font-size: 0.95rem;
            }
            
            input[type="email"],
            input[type="password"] {
                padding: 0.75rem 1rem;
                border: 2px solid #e0e0e0;
                border-radius: 0.5rem;
                font-size: 1rem;
                font-family: 'Instrument Sans', sans-serif;
                transition: all 0.3s ease;
            }
            
            input[type="email"]:focus,
            input[type="password"]:focus {
                outline: none;
                border-color: var(--blue-1);
                box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
            }
            
            input[type="email"].is-invalid,
            input[type="password"].is-invalid {
                border-color: #dc3545;
            }
            
            .invalid-feedback {
                color: #dc3545;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }
            
            .form-check {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin: 0.5rem 0;
            }
            
            .form-check input[type="checkbox"] {
                width: 18px;
                height: 18px;
                accent-color: var(--blue-1);
                cursor: pointer;
            }
            
            .form-check label {
                margin: 0;
                cursor: pointer;
                font-weight: 500;
            }
            
            /* Buttons */
            .btn {
                padding: 0.85rem 1.5rem;
                border: none;
                border-radius: 0.5rem;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: all 0.3s ease;
                font-family: 'Instrument Sans', sans-serif;
                text-decoration: none;
                display: inline-block;
                text-align: center;
            }
            
            .btn-primary {
                background: linear-gradient(135deg, var(--blue-1) 0%, var(--blue-2) 100%);
                color: white;
                width: 100%;
            }
            
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0, 102, 255, 0.3);
            }
            
            .btn-link {
                background: none;
                color: #0066ff;
                padding: 0;
                text-decoration: underline;
                text-underline-offset: 4px;
                font-weight: 500;
                font-size: 0.9rem;
            }
            
            .btn-link:hover {
                color: var(--blue-2);
            }
            
            /* Links Section */
            .login-links {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid #e0e0e0;
            }
            
            .register-link {
                font-size: 0.95rem;
                color: #666;
            }
            
            .register-link a {
                color: var(--blue-1);
                text-decoration: none;
                font-weight: 600;
                transition: color 0.3s ease;
            }
            
            .register-link a:hover {
                color: var(--blue-2);
            }

            /* Password Toggle */
            .password-wrapper {
                position: relative;
            }

            .password-toggle {
                position: absolute;
                right: 12px;
                top: 32px;
                background: none;
                border: none;
                cursor: pointer;
                padding: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #666;
                transition: transform 0.3s ease;
            }

            .password-toggle:hover {
                transform: scale(1.1);
                color: #0066ff;
            }
            
            /* Footer */
            footer {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                background: rgba(255, 255, 255, 0.1);
                color: rgba(255, 255, 255, 0.9);
                text-align: center;
                padding: 1.5rem;
                font-size: 0.875rem;
                border-top: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            @media (max-width: 600px) {
                .login-container {
                    padding: 2rem 1.5rem;
                    margin-bottom: 80px;
                }
                
                .login-header h1 {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <header>
            <a href="{{ url('/') }}" class="back-link">
                <span>←</span> Regresar
            </a>
            <div class="logo-text">CityJob</div>
        </header>

        <!-- Login Form -->
        <div class="login-container">
            <div class="login-header">
                <h1>Iniciar sesión</h1>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Correo</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="tu@correo.com"
                        required 
                        autocomplete="email" 
                        autofocus
                        class="@error('email') is-invalid @enderror"
                    >
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="password-wrapper">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            placeholder="••••••••"
                            required 
                            autocomplete="current-password"
                            class="@error('password') is-invalid @enderror"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-check">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label for="remember">Recuérdame</label>
                </div>

                <button type="submit" class="btn btn-primary">Iniciar sesión</button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                <div class="login-links">
                    <div class="register-link">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Regístrate aquí</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <footer>
            <p>&copy; 2026 CityJob. Todos los derechos reservados.</p>
        </footer>

        <script>
            function togglePassword(fieldId) {
                const field = document.getElementById(fieldId);
                field.type = field.type === 'password' ? 'text' : 'password';
            }
        </script>
    </body>
</html>