<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'CityJob') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        
        <style>
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
                background: linear-gradient(135deg, #0066ff 0%, #00a8ff 100%);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                color: #333;
            }
            
            /* Header */
            header {
                padding: 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: rgba(255, 255, 255, 0.95);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }
            
            .logo-text {
                font-size: 1.5rem;
                font-weight: 700;
                background: linear-gradient(135deg, #0066ff 0%, #00a8ff 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            .nav-buttons {
                display: flex;
                gap: 1rem;
            }
            
            .btn {
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem;
                font-weight: 600;
                font-size: 0.875rem;
                text-decoration: none;
                transition: all 0.3s ease;
                border: 2px solid transparent;
                cursor: pointer;
            }
            
            .btn-login {
                background: white;
                color: #0066ff;
                border-color: #0066ff;
            }
            
            .btn-login:hover {
                background: #f0f4ff;
                transform: translateY(-2px);
            }
            
            .btn-register {
                background: linear-gradient(135deg, #0066ff 0%, #00a8ff 100%);
                color: white;
                border-color: transparent;
            }
            
            .btn-register:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 16px rgba(0, 102, 255, 0.3);
            }
            
            /* Main Content */
            main {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 3rem 2rem;
            }
            
            .container {
                max-width: 1200px;
                width: 100%;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
                align-items: center;
            }
            
            @media (max-width: 768px) {
                .container {
                    grid-template-columns: 1fr;
                    gap: 2rem;
                }
            }
            
            /* Logo Box */
            .logo-box {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                border: 2px solid rgba(255, 255, 255, 0.3);
                border-radius: 1.5rem;
                padding: 3rem;
                height: 350px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                color: rgba(255, 255, 255, 0.8);
                transition: all 0.3s ease;
            }
            
            .logo-box:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-4px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            }
            
            /* Content Section */
            .content {
                color: white;
                z-index: 10;
            }
            
            h1 {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
                line-height: 1.2;
            }
            
            .description {
                font-size: 1.125rem;
                margin-bottom: 2rem;
                opacity: 0.95;
                line-height: 1.6;
            }
            
            /* Features List */
            .features {
                list-style: none;
                margin: 2rem 0;
            }
            
            .features li {
                padding: 0.75rem 0;
                font-size: 1rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }
            
            .features li::before {
                content: "✓";
                color: #00ff88;
                font-weight: bold;
                font-size: 1.25rem;
            }
            
            /* Buttons Container */
            .button-group {
                display: flex;
                gap: 1rem;
                margin-top: 2.5rem;
                flex-wrap: wrap;
            }
            
            .btn-cta {
                padding: 1rem 2rem;
                border-radius: 0.75rem;
                font-weight: 600;
                font-size: 1rem;
                text-decoration: none;
                transition: all 0.3s ease;
                border: 2px solid white;
                cursor: pointer;
            }
            
            .btn-primary {
                background: white;
                color: #0066ff;
                border-color: white;
            }
            
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }
            
            .btn-secondary {
                background: transparent;
                color: white;
                border-color: white;
            }
            
            .btn-secondary:hover {
                background: rgba(255, 255, 255, 0.1);
                transform: translateY(-2px);
            }
            
            /* Footer */
            footer {
                background: rgba(255, 255, 255, 0.1);
                color: rgba(255, 255, 255, 0.9);
                text-align: center;
                padding: 2rem;
                border-top: 1px solid rgba(255, 255, 255, 0.2);
                font-size: 0.875rem;
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <header>
            <div class="logo-text">CityJob</div>
            <nav class="nav-buttons">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-login">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-register">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <!-- Main Content -->
        <main>
            <div class="container">
                <!-- Logo Section -->
                <div class="logo-box">
                    Aquí va tu logo
                </div>
                
                <!-- Content Section -->
                <div class="content">
                    <h1>Bienvenido a CityJob</h1>
                    <p class="description">
                        Conecta con las mejores oportunidades laborales y desarrolla tu carrera profesional con nosotros.
                    </p>
                    
                    <ul class="features">
                        <li>Encuentra las mejores oportunidades laborales</li>
                        <li>Conecta con profesionales calificados</li>
                        <li>Crece en tu carrera profesional</li>
                    </ul>
                    
                    <div class="button-group">
                        <a href="{{ route('register.form') }}" class="btn-cta btn-primary">Registrarse Ahora</a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer>
            <p>&copy; 2026 CityJob. Todos los derechos reservados.</p>
        </footer>
    </body>
</html>
                               