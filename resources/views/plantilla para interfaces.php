<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CityJob :3</title>
    
    <link rel="icon" type="image/jpeg" href="/img/LogoCJ2.jpeg">
    <link rel="shortcut icon" href="/img/LogoCJ2.jpeg">
       
    <style>
        :root {
            --primary-cyan: #00C3FF;
            --primary-cyan-hover: #00A6D9;
            --navy-dark: #00152B;
            --navy-light: #003B73;
            --text-light: #F7FAFC;
            --white: #FFFFFF;
            --gray-light: #EDF2F7;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            color: var(--text-dark);
            background-color: var(--white);
            line-height: 1.6;
        }
        
        header {
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .logo-img {
            height: 40px;
            width: auto;
            border-radius: 8px;
        }

        .logo-text {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--navy-light);
            letter-spacing: -0.5px;
        }
        
        .logo-text span {
            color: var(--primary-cyan);
        }
        
        .nav-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .btn {
            padding: 0.6rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
        }
        
        .btn-ghost {
            color: var(--navy-light);
            background: transparent;
        }
        
        .btn-ghost:hover {
            color: var(--primary-cyan);
        }
        
        .btn-primary {
            background: var(--primary-cyan);
            color: var(--navy-dark);
            box-shadow: 0 4px 15px rgba(0, 195, 255, 0.3);
        }
        
        .btn-primary:hover {
            background: var(--primary-cyan-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 195, 255, 0.4);
        }

        .hero {
            background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-light) 100%);
            min-height: 70vh;
            display: flex;
            align-items: center;
            padding: 2rem 5%;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .hero-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 3rem;
            align-items: center;
            position: relative;
            z-index: 10;
        }

        .hero-content {
            color: var(--text-light);
        }
        
        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.25rem;
        }

        .hero-content h1 span {
            color: var(--primary-cyan);
        }
        
        .description {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #CBD5E0;
            max-width: 90%;
        }

        .hero-image-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-logo {
            width: 100%;
            max-width: 380px;
            border-radius: 20px;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.3));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .features-section {
            padding: 4rem 5%;
            background: var(--gray-light);
        }

        .features-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 3rem auto;
        }
        
        .features-header h2 {
            font-size: 2rem;
            color: var(--navy-light);
            margin-bottom: 0.75rem;
        }
        
        .features-grid {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .feature-card {
            background: var(--white);
            padding: 2rem 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            text-align: center;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(0, 195, 255, 0.1);
            color: var(--primary-cyan);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 1.25rem auto;
        }

        .feature-card h3 {
            color: var(--navy-light);
            margin-bottom: 0.75rem;
            font-size: 1.2rem;
        }

        .feature-card p {
            color: #718096;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        @media (max-width: 968px) {
            .hero-container {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 1.5rem;
            }
            .hero-content h1 {
                font-size: 2.2rem;
            }
            .description {
                margin: 0 auto 1.5rem auto;
            }
            .features-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <a href="#" class="logo-container" onclick="return false;">
            <img src="img/LogoCJ2.jpeg" alt="CityJob Logo" class="logo-img">
            <div class="logo-text">City<span>Job</span></div>
        </a>
        <nav class="nav-buttons">
            <a href="auth/login" class="btn btn-ghost">Iniciar Sesión</a>
            <a href="auth/register" class="btn btn-primary">Regístrate gratis</a>
        </nav>
    </header>

    <main class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Encuentra al experto ideal para tu <span>próximo proyecto</span></h1>
                <p class="description">
                    Conecta rápidamente con profesionales calificados en tu ciudad. Desde reparaciones del hogar hasta desarrollo tecnológico, todo en un solo lugar.
                </p>
            </div>

            <div class="hero-image-container">
                <img src="img/LogoCJ2.jpeg" alt="CityJob Logo" class="main-logo">
            </div>
        </div>
    </main>

    <section class="features-section">
        <div class="features-header">
            <h2>¿Cómo funciona CityJob?</h2>
            <p>Tres pasos simples para conectar con el profesional que necesitas</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">1</div>
                <h3>Busca el servicio</h3>
                <p>Explora entre cientos de profesionales calificados listos para ayudarte con tu necesidad específica.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">2</div>
                <h3>Compara y elige</h3>
                <p>Revisa perfiles, calificaciones y portafolios para tomar la mejor decisión con total transparencia.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">3</div>
                <h3>Trabajo completado</h3>
                <p>Conecta de manera segura, recibe el servicio y califica la experiencia para ayudar a la comunidad.</p>
            </div>
        </div>
    </section>
</body>
</html>
