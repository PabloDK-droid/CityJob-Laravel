<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $contratacion->id_contratacion }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #0066ff; margin: 0; }
        .info-box { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; }
        .info-box h3 { margin-top: 0; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        table th { background: #f8f9fa; font-weight: bold; }
        .total { text-align: right; font-size: 16px; font-weight: bold; margin-top: 20px; }
        .footer { margin-top: 40px; text-align: center; color: #666; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CITYJOB</h1>
        <p>Plataforma de Servicios Profesionales</p>
    </div>

    <div class="info-box">
        <h3>Información de Factura</h3>
        <p><strong>Folio:</strong> #{{ str_pad($contratacion->id_contratacion, 6, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Fecha de emisión:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($contratacion->estado) }}</p>
    </div>

    <div class="info-box">
        <h3>Datos del Cliente</h3>
        <p><strong>Nombre:</strong> {{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }}</p>
        <p><strong>Teléfono:</strong> {{ $contratacion->cliente->telefono }}</p>
        <p><strong>Email:</strong> {{ $contratacion->cliente->correo_electronico }}</p>
        <p><strong>Domicilio:</strong> {{ $contratacion->cliente->domicilio }}</p>
    </div>

    <div class="info-box">
        <h3>Datos del Profesionista</h3>
        <p><strong>Nombre:</strong> {{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</p>
        <p><strong>Teléfono:</strong> {{ $contratacion->profesionista->telefono }}</p>
        <p><strong>Email:</strong> {{ $contratacion->profesionista->correo_electronico }}</p>
        <p><strong>Especialidad:</strong> {{ $contratacion->profesionista->especializado }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Ubicación</th>
                <th>Fecha</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $contratacion->servicio->nombre_servicio }}</td>
                <td>{{ $contratacion->localizacion }}</td>
                <td>{{ \Carbon\Carbon::parse($contratacion->fecha_realizacion)->format('d/m/Y H:i') }}</td>
                <td>${{ number_format($contratacion->monto_acordado, 2) }} MXN</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        <p>TOTAL: ${{ number_format($contratacion->monto_acordado, 2) }} MXN</p>
    </div>

    <div class="footer">
        <p>CityJob - Plataforma de Servicios Profesionales</p>
        <p>www.cityjob.com | contacto@cityjob.com</p>
        <p>Este documento es una representación impresa de una factura electrónica</p>
    </div>
</body>
</html>