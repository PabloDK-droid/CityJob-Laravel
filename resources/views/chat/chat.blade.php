@extends('layouts.app')

@section('content')
<style>
    .chat-container {
        max-width: 700px;
        margin: 30px auto;
        display: flex;
        flex-direction: column;
        height: 80vh;
    }

    .chat-header {
        background: linear-gradient(135deg, #0066ff, #00a8ff);
        color: white;
        padding: 16px 20px;
        border-radius: 12px 12px 0 0;
    }

    .chat-header h2 { margin: 0; font-size: 18px; font-weight: 700; }
    .chat-header p  { margin: 4px 0 0 0; font-size: 13px; opacity: 0.85; }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f4f6fb;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .msg-bubble {
        max-width: 70%;
        padding: 10px 14px;
        border-radius: 14px;
        font-size: 14px;
        line-height: 1.5;
        word-break: break-word;
    }

    .msg-bubble.mio {
        align-self: flex-end;
        background: #0066ff;
        color: white;
        border-bottom-right-radius: 4px;
    }

    .msg-bubble.otro {
        align-self: flex-start;
        background: white;
        color: #222;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }

    .msg-time {
        font-size: 10px;
        opacity: 0.6;
        margin-top: 4px;
        text-align: right;
    }

    .msg-bubble.otro .msg-time { text-align: left; }

    .chat-form {
        display: flex;
        gap: 10px;
        padding: 14px 16px;
        background: white;
        border-radius: 0 0 12px 12px;
        border-top: 1px solid #eee;
    }

    .chat-form input {
        flex: 1;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s;
    }

    .chat-form input:focus { border-color: #0066ff; }

    .chat-form button {
        background: linear-gradient(135deg, #0066ff, #00a8ff);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }

    .chat-form button:hover { transform: translateY(-1px); }

    .back-link {
        display: inline-block;
        margin-bottom: 12px;
        color: #0066ff;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .status-tag {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        background: rgba(255,255,255,0.2);
        margin-left: 8px;
    }
</style>

@php
    $rol    = session('role');
    $userId = session('user_id');
@endphp

@if($rol === 'cliente')
    <a href="{{ route('cliente.misContrataciones') }}" class="back-link">← Volver a mis contrataciones</a>
@else
    <a href="{{ route('trabajador.serviciosAsignados') }}" class="back-link">← Volver a servicios asignados</a>
@endif

<div class="chat-container">

    <div class="chat-header">
        <h2>
            {{ $contratacion->servicio->nombre_servicio }}
            <span class="status-tag">{{ ucfirst($contratacion->estado) }}</span>
        </h2>
        <p>
            @if($rol === 'cliente')
                Hablando con: {{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}
            @else
                Hablando con: {{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }}
            @endif
        </p>
    </div>

    <div class="chat-messages" id="chat-messages">
        @foreach($mensajes as $msg)
            @php $esMio = ($msg->remitente_tipo === $rol); @endphp
            <div class="msg-bubble {{ $esMio ? 'mio' : 'otro' }}">
                {{ $msg->mensaje }}
                <div class="msg-time">{{ \Carbon\Carbon::parse($msg->created_at)->format('d/m H:i') }}</div>
            </div>
        @endforeach
    </div>

    <div class="chat-form">
        <input type="text" id="msg-input" placeholder="Escribe un mensaje..." autocomplete="off" maxlength="1000">
        <button onclick="enviarMensaje()">Enviar</button>
    </div>

</div>

<script>
    const rol             = "{{ $rol }}";
    const idContratacion  = {{ $contratacion->id_contratacion }};
    const storeUrl        = "{{ $rol === 'cliente' ? route('cliente.chat.store', $contratacion->id_contratacion) : route('trabajador.chat.store', $contratacion->id_contratacion) }}";
    const pollingUrl      = "{{ $rol === 'cliente' ? route('cliente.chat.polling', $contratacion->id_contratacion) : route('trabajador.chat.polling', $contratacion->id_contratacion) }}";
    const csrfToken       = "{{ csrf_token() }}";
    let ultimoId = {{ $mensajes->count() > 0 ? $mensajes->last()->id_mensaje : 0 }};
    const messagesDiv = document.getElementById('chat-messages');
    function scrollAbajo() {
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    scrollAbajo();

    function agregarBurbuja(msg) {
        const esMio = msg.remitente_tipo === rol;
        const div   = document.createElement('div');
        div.className = 'msg-bubble ' + (esMio ? 'mio' : 'otro');

        const fecha = new Date(msg.created_at);
        const hora  = fecha.toLocaleDateString('es-MX', {day:'2-digit', month:'2-digit'})
                    + ' ' + fecha.toLocaleTimeString('es-MX', {hour:'2-digit', minute:'2-digit'});

        div.innerHTML = msg.mensaje + '<div class="msg-time">' + hora + '</div>';
        messagesDiv.appendChild(div);
        scrollAbajo();
    }

    // Respuesta cada 5 segundos
    setInterval(() => {
        fetch(pollingUrl + '?desde=' + ultimoId)
            .then(r => r.json())
            .then(data => {
                data.forEach(msg => {
                    agregarBurbuja(msg);
                    ultimoId = msg.id_mensaje;
                });
            })
            .catch(() => {});
    }, 5000);

    function enviarMensaje() {
        const input   = document.getElementById('msg-input');
        const mensaje = input.value.trim();
        if (!mensaje) return;

        fetch(storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ mensaje })
        })
        .then(r => r.json())
        .then(() => { input.value = ''; })
        .catch(() => {});
    }
    document.getElementById('msg-input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') enviarMensaje();
    });
</script>
@endsection