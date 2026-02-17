<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityJob - @yield('title', 'Plataforma de Servicios')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <style>
        :root{
            --accent:#0b5cff; /* main blue tone */
            --muted:#333333;
            --bg:#ffffff;
            --sidebar-width:88px;
        }

        *{box-sizing:border-box;margin:0;padding:0}
        html,body{height:100%;font-family:'Instrument Sans',system-ui,-apple-system,'Segoe UI',Roboto,Helvetica,Arial;background:var(--bg);}

        /* Layout: narrow left sidebar + main area */
        .app-layout{display:flex;min-height:100vh}

        .app-sidebar{width:var(--sidebar-width);background:#fff;display:flex;flex-direction:column;align-items:flex-start;padding:24px 6px;gap:18px}
        .app-sidebar .menu{display:flex;flex-direction:column;gap:18px;margin-top:12px}
        .app-sidebar a{color:var(--muted);text-decoration:none;font-size:15px;padding-left:4px}
        .app-sidebar .brand{font-weight:700;color:var(--accent);margin-bottom:6px}
        .app-sidebar .spacer{flex:1}
        .app-sidebar .logout{font-size:14px;color:var(--muted);text-decoration:none}

        .app-main{flex:1;padding:36px 48px}
        .app-main.client-route{padding:12px 8px}
        .mini-profile{display:flex;align-items:flex-start;gap:18px}
        .profile-box{width:96px;height:96px;border:2px solid rgba(0,0,0,0.12);display:flex;align-items:center;justify-content:center;border-radius:6px}
        .welcome-title{font-size:44px;font-weight:700;color:#111}
        .hero-desc{margin-top:18px;color:rgba(0,0,0,0.6);max-width:900px}

        @media (max-width:900px){
            .app-sidebar{display:none}
            .app-main{padding:20px}
            .welcome-title{font-size:28px}
        }
    </style>
</head>
<body>
    <div class="app-layout">
        @unless(Request::is('cliente*'))
            <aside class="app-sidebar">
                @auth
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
                    <a href="#" class="logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar sesión</a>
                @endauth
            </aside>
        @endunless

        <main class="app-main @if(Request::is('cliente*')) client-route @endif">
            @yield('content')
        </main>
    </div>
</body>
</html>