@extends('layouts.app')

@section('content')
<style>
    .pago-exitoso-container {
        max-width: 600px;
        margin: 60px auto;
        padding: 20px;
        text-align: center;
    }

    .success-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.10);
        padding: 50px 40px;
    }

    .check-circle {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #00a86b, #00d68f);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px auto;
        box-shadow: 0 8px 24px rgba(0,168,107,0.3);
    }

    .check-circle svg {
        width: 48px;
        height: 48px;
        color: white;
    }

    .success-title {
        font-size: 28px;
        font-weight: 800;
        color: #04142b;
        margin-bottom: 10px;
    }

    .success-subtitle {
        color: #666;
        font-size: 15px;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .detail-box {
        background: #f8f9ff;
        border-radius: 12px;
        padding: 20px;
        text-align: left;
        margin-bottom: 30px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .detail-row:last-child {
        border-bottom: none;
        font-weight: 700;
        font-size: 16px;
        color: #0066ff;
    }

    .detail-label {
        color: #666;
    }

    .detail-value {
        color: #222;
        font-weight: 600;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-primary-success {
        background: linear-gradient(135deg, #0066ff, #00a8ff);
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-primary-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,102,255,0.3);
    }

    .btn-secondary-success {
        background: #f0f0f0;
        color: #333;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-secondary-success:hover {
        background: #e0e0e0;
        transform: translateY(-2px);
    }
</style>

<div class="pago-exitoso-container">
    <div class="success-card">

        <div class="check-circle">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                 stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <div class="success-title">¡Pago realizado con éxito!</div>
        <div class="success-subtitle">
            Tu servicio ha sido confirmado. El profesionista ya puede comenzar a trabajar.
        </div>

        <div class="detail-box">
            <div class="detail-row">
                <span class="detail-label">Servicio</span>
                <span class="detail-value">{{ $contratacion->servicio->nombre_servicio }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Profesionista</span>
                <span class="detail-value">
                    {{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Teléfono de contacto</span>
                <span class="detail-value">{{ $contratacion->profesionista->telefono }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Ubicación del servicio</span>
                <span class="detail-value">{{ $contratacion->localizacion }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total pagado</span>
                <span class="detail-value">${{ number_format($contratacion->monto_acordado, 2) }} MXN</span>
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('cliente.misContrataciones') }}" class="btn-primary-success">
                Ver mis contrataciones
            </a>
            <a href="{{ route('cliente.descargarFactura', $contratacion->id_contratacion) }}" class="btn-secondary-success">
                Descargar factura PDF
            </a>
        </div>

    </div>
</div>
@endsection