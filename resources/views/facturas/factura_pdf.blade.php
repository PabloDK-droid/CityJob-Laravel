<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ str_pad($contratacion->id_contratacion, 6, '0', STR_PAD_LEFT) }}</title>
<style>

    /* CONFIGURACION PDF */
    @page{
        size: letter;
        margin: 0;
    }

    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }

    html, body{
        width:216mm;
        height:279mm;
        font-family: Arial, Helvetica, sans-serif;
        font-size:11px;
        color:#1a2a3a;
        background:#ffffff;
    }

    .page{
        position:relative;
        width:100%;
        min-height:279mm;
    }

    /* HEADER */

    .header{
        background:#00152B;
        padding:26px 40px;
    }

    .header-row{
        display:table;
        width:100%;
    }

    .header-left{
        display:table-cell;
        vertical-align:middle;
    }

    .header-right{
        display:table-cell;
        vertical-align:middle;
        text-align:right;
    }

    .brand{
        font-size:24px;
        font-weight:900;
        color:#ffffff;
    }

    .brand em{
        font-style:normal;
        color:#00C3FF;
    }

    .brand-sub{
        font-size:10px;
        color:#8BAAC8;
        margin-top:3px;
    }

    .factura-label{
        font-size:10px;
        color:#8BAAC8;
        text-transform:uppercase;
        letter-spacing:1px;
    }

    .factura-num{
        font-size:22px;
        font-weight:900;
        color:#00C3FF;
        margin-top:2px;
    }

    .factura-fecha{
        font-size:10px;
        color:#8BAAC8;
        margin-top:3px;
    }

    /* STATUS */

    .status-bar{
        background:#002647;
        border-bottom:3px solid #00C3FF;
        padding:10px 40px;
    }

    .status-inner{
        width:100%;
    }

    .status-inner td{
        font-size:10px;
        color:#8BAAC8;
    }

    .status-inner td:last-child{
        text-align:right;
    }

    .status-badge{
        display:inline-block;
        background:rgba(0,195,255,0.15);
        color:#00C3FF;
        border:1px solid rgba(0,195,255,0.35);
        padding:3px 12px;
        border-radius:20px;
        font-size:10px;
        font-weight:700;
        text-transform:uppercase;
    }

    /* BODY */

    .body{
        padding:30px 40px;
    }

    /* DOS COLUMNAS */

    .two-col{
        display:table;
        width:100%;
        margin-bottom:25px;
    }

    .col-left{
        display:table-cell;
        width:50%;
        padding-right:10px;
        vertical-align:top;
    }

    .col-right{
        display:table-cell;
        width:50%;
        padding-left:10px;
        vertical-align:top;
    }

    /* CAJAS INFO */

    .info-box{
        border:1px solid #dde8f0;
        border-radius:5px;
        overflow:hidden;
    }

    .info-box-header{
        background:#f0f6fb;
        padding:9px 14px;
        font-size:9px;
        font-weight:700;
        color:#00152B;
        text-transform:uppercase;
        border-bottom:1px solid #dde8f0;
    }

    .info-box-body{
        padding:14px;
    }

    .info-r{
        display:table;
        width:100%;
        margin-bottom:7px;
    }

    .info-r .lbl{
        display:table-cell;
        width:40%;
        color:#6b8499;
    }

    .info-r .val{
        display:table-cell;
        font-weight:600;
    }

    /* TABLA SERVICIO */

    .section-label{
        font-size:9px;
        font-weight:700;
        color:#8BAAC8;
        text-transform:uppercase;
        margin-bottom:8px;
    }

    .service-table{
        width:100%;
        border-collapse:collapse;
        margin-bottom:25px;
    }

    .service-table thead tr{
        background:#00152B;
    }

    .service-table thead th{
        padding:10px;
        text-align:left;
        font-size:9px;
        color:#8BAAC8;
        text-transform:uppercase;
    }

    .service-table tbody tr{
        border-bottom:1px solid #e8eef4;
    }

    .service-table tbody td{
        padding:12px;
    }

    .service-table tbody td:last-child{
        font-weight:700;
    }

    /* TOTALES */

    .totals-wrap{
        text-align:right;
        margin-bottom:30px;
    }

    .totals-inner{
        display:inline-table;
        border-collapse:collapse;
        min-width:280px;
    }

    .totals-inner td{
        padding:6px 12px;
    }

    .totals-inner .lbl{
        color:#6b8499;
        text-align:left;
    }

    .totals-inner .val{
        text-align:right;
        font-weight:700;
    }

    .totals-inner .divider td{
        border-top:1px solid #dde8f0;
        padding:0;
    }

    .totals-inner .total-row{
        background:#00152B;
    }

    .totals-inner .total-row td{
        padding:12px;
    }

    .totals-inner .total-row .lbl{
        color:#8BAAC8;
        font-size:9px;
        text-transform:uppercase;
    }

    .totals-inner .total-row .val{
        color:#00C3FF;
        font-size:16px;
    }

    /* NOTA LEGAL */

    .legal-note{
        border:1px solid #dde8f0;
        border-radius:5px;
        padding:16px;
        font-size:9.5px;
        color:#8BAAC8;
        line-height:1.7;
        background:#f9fbfd;
        margin-bottom:30px;
    }

    .legal-note strong{
        color:#4a6a80;
    }

    /* FIRMA */

    .firma-row{
        display:table;
        width:100%;
        margin-bottom:40px;
    }

    .firma-col{
        display:table-cell;
        width:33%;
        text-align:center;
        padding:0 10px;
        vertical-align:bottom;
    }

    .firma-line{
        border-top:1px solid #c8d8e4;
        padding-top:8px;
        margin-top:50px;
        font-size:9px;
        color:#8BAAC8;
    }

    /* FOOTER */

    .footer{
        position:absolute;
        bottom:0;
        width:100%;
        background:#00152B;
        padding:18px 40px;
    }

    .footer-row{
        display:table;
        width:100%;
    }

    .footer-left{
        display:table-cell;
        vertical-align:middle;
    }

    .footer-right{
        display:table-cell;
        vertical-align:middle;
        text-align:right;
    }

    .footer-brand{
        font-size:14px;
        font-weight:900;
        color:#ffffff;
    }

    .footer-brand em{
        color:#00C3FF;
        font-style:normal;
    }

    .footer-links{
        font-size:9px;
        color:#8BAAC8;
        margin-top:3px;
    }

    .footer-note{
        font-size:8.5px;
        color:#8BAAC8;
        line-height:1.6;
    }

</style>
</head>
<body>
<div class="page">

    {{-- HEADER --}}
    <div class="header">
        <div class="header-row">
            <div class="header-left">
                <div class="brand">City<em>Job</em></div>
                <div class="brand-sub">Plataforma de Servicios Profesionales</div>
            </div>
            <div class="header-right">
                <div class="factura-label">Factura</div>
                <div class="factura-num">#{{ str_pad($contratacion->id_contratacion, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="factura-fecha">Emitida el {{ now()->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    {{-- STATUS --}}
    <div class="status-bar">
        <table class="status-inner" style="width:100%"><tr>
            <td>Estado del servicio</td>
            <td><span class="status-badge">{{ ucfirst($contratacion->estado) }}</span></td>
        </tr></table>
    </div>

    {{-- BODY --}}
    <div class="body">

        {{-- Datos cliente / profesionista --}}
        <div class="two-col">
            <div class="col-left">
                <div class="info-box">
                    <div class="info-box-header">Datos del cliente</div>
                    <div class="info-box-body">
                        <div class="info-r"><span class="lbl">Nombre</span><span class="val">{{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }}</span></div>
                        <div class="info-r"><span class="lbl">Teléfono</span><span class="val">{{ $contratacion->cliente->telefono }}</span></div>
                        <div class="info-r"><span class="lbl">Email</span><span class="val">{{ $contratacion->cliente->correo_electronico }}</span></div>
                        <div class="info-r"><span class="lbl">Domicilio</span><span class="val">{{ $contratacion->cliente->domicilio }}</span></div>
                    </div>
                </div>
            </div>
            <div class="col-right">
                <div class="info-box">
                    <div class="info-box-header">Datos del profesionista</div>
                    <div class="info-box-body">
                        <div class="info-r"><span class="lbl">Nombre</span><span class="val">{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</span></div>
                        <div class="info-r"><span class="lbl">Teléfono</span><span class="val">{{ $contratacion->profesionista->telefono }}</span></div>
                        <div class="info-r"><span class="lbl">Email</span><span class="val">{{ $contratacion->profesionista->correo_electronico }}</span></div>
                        <div class="info-r"><span class="lbl">Especialidad</span><span class="val">{{ $contratacion->profesionista->especializado }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla servicio --}}
        <p class="section-label">Detalle del servicio</p>
        <table class="service-table">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Ubicación</th>
                    <th>Fecha de realización</th>
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

        {{-- Totales --}}
        <div class="totals-wrap">
            <table class="totals-inner">
                <tr>
                    <td class="lbl">Subtotal</td>
                    <td class="val">${{ number_format($contratacion->monto_acordado, 2) }} MXN</td>
                </tr>
                <tr>
                    <td class="lbl">Comisión plataforma (10%)</td>
                    <td class="val">${{ number_format($contratacion->monto_acordado * 0.10, 2) }} MXN</td>
                </tr>
                <tr class="divider"><td colspan="2"></td></tr>
                <tr class="total-row">
                    <td class="lbl">Total</td>
                    <td class="val">${{ number_format($contratacion->monto_acordado, 2) }} MXN</td>
                </tr>
            </table>
        </div>

        {{-- Nota legal --}}
        <div class="legal-note">
            <strong>Nota importante:</strong> Este documento es una representación impresa de una factura electrónica generada por CityJob. El monto total refleja los servicios prestados por el profesionista contratado a través de la plataforma. La comisión del 10% corresponde al cargo de servicio de CityJob por intermediación y gestión de la contratación. Para cualquier aclaración o disputa, comunícate con nuestro equipo de soporte en <strong>soporte@cityjob.com</strong> o al teléfono <strong>56 3731 4047</strong>, de Lunes a Viernes de 9:00 AM a 6:00 PM.
        </div>

        {{-- Líneas de firma --}}
        <div class="firma-row">
            <div class="firma-col">
                <div class="firma-line">Firma del Cliente</div>
            </div>
            <div class="firma-col">
                <div class="firma-line">Firma del Profesionista</div>
            </div>
            <div class="firma-col">
                <div class="firma-line">Sello CityJob</div>
            </div>
        </div>

    </div>{{-- /body --}}

    {{-- FOOTER --}}
    <div class="footer">
        <div class="footer-row">
            <div class="footer-left">
                <div class="footer-brand">City<em>Job</em></div>
                <div class="footer-links">www.cityjob.com &nbsp;·&nbsp; soporte@cityjob.com &nbsp;·&nbsp; 56 3731 4047</div>
            </div>
            <div class="footer-right">
                <div class="footer-note">
                    Folio: #{{ str_pad($contratacion->id_contratacion, 6, '0', STR_PAD_LEFT) }}<br>
                    Emitida: {{ now()->format('d/m/Y H:i') }}<br>
                    CityJob — Plataforma de Servicios Profesionales
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>