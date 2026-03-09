<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityJob — @yield('title', 'Plataforma de Servicios')</title>

    <link rel="icon" type="image/png" href="/img/CityJib_2.png">
    <link rel="shortcut icon" href="/img/CityJib_2.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=syne:400,600,700,800|instrument-sans:400,500,600,700" rel="stylesheet"/>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Instrument Sans', system-ui, -apple-system, sans-serif;
            background: #00152B;
            color: #ffffff;
        }
    </style>

    @yield('styles')
</head>
<body>
    @yield('content')

    @yield('scripts')
</body>
</html>