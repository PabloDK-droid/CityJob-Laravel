@extends('layouts.app')
@section('title', 'Chat')

@section('content')
<style>
    :root {
        --cyan:#00C3FF; --cyan-dim:#0094cc; --navy:#00152B;
        --navy-mid:#002647; --text-muted:#8BAAC8; --border:rgba(0,195,255,0.15); --white:#FFFFFF;
    }

    body, .cj-chat-page {
        background:var(--navy);
        font-family:'Instrument Sans',sans-serif;
        min-height:100vh;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:flex-start;
        padding:2rem 1rem;
    }

    .chat-wrap {
        width:100%;
        max-width:720px;
        display:flex;
        flex-direction:column;
        height:calc(100vh - 4rem);
        min-height:500px;
    }

    /* back link */
    .btn-back {
        display:inline-flex; align-items:center; gap:.4rem;
        color:var(--text-muted); text-decoration:none;
        font-size:.85rem; font-weight:600;
        transition:color .2s; margin-bottom:1rem; align-self:flex-start;
    }
    .btn-back:hover { color:var(--cyan); }

    /* header */
    .chat-header {
        background:rgba(0,195,255,.07);
        border:1px solid var(--border);
        border-bottom:none;
        border-radius:1.1rem 1.1rem 0 0;
        padding:1.1rem 1.4rem;
        display:flex; align-items:center; justify-content:space-between; gap:1rem;
    }
    .chat-header-info h2 {
        font-family:'Syne',sans-serif; font-weight:800; font-size:1.05rem;
        color:var(--white); margin:0 0 .2rem 0; letter-spacing:-.3px;
        display:flex; align-items:center; gap:.6rem;
    }
    .chat-header-info p {
        margin:0; font-size:.82rem; color:var(--text-muted);
    }
    .status-tag {
        display:inline-block; padding:.2rem .6rem;
        border-radius:100px; font-size:.68rem; font-weight:700;
        background:rgba(0,195,255,.15); color:var(--cyan);
        border:1px solid rgba(0,195,255,.25); letter-spacing:.3px;
    }

    /* avatar placeholder */
    .chat-avatar {
        width:40px; height:40px; border-radius:50%;
        background:rgba(0,195,255,.12); border:1px solid rgba(0,195,255,.2);
        display:flex; align-items:center; justify-content:center;
        color:var(--cyan); flex-shrink:0;
    }

    /* messages */
    .chat-messages {
        flex:1; overflow-y:auto;
        padding:1.25rem;
        background:rgba(0,10,22,.55);
        border:1px solid var(--border);
        display:flex; flex-direction:column; gap:.65rem;
        scroll-behavior:smooth;
    }
    .chat-messages::-webkit-scrollbar { width:4px; }
    .chat-messages::-webkit-scrollbar-track { background:transparent; }
    .chat-messages::-webkit-scrollbar-thumb { background:rgba(0,195,255,.2); border-radius:2px; }

    /* burbujas */
    .msg-bubble {
        max-width:68%; padding:.7rem 1rem;
        border-radius:1rem; font-size:.88rem;
        line-height:1.55; word-break:break-word;
        position:relative;
    }
    .msg-bubble.mio {
        align-self:flex-end;
        background:linear-gradient(135deg, #0094cc, #00C3FF);
        color:var(--navy);
        border-bottom-right-radius:.3rem;
        box-shadow:0 4px 14px rgba(0,195,255,.18);
    }
    .msg-bubble.otro {
        align-self:flex-start;
        background:rgba(255,255,255,.06);
        color:var(--white);
        border:1px solid var(--border);
        border-bottom-left-radius:.3rem;
    }
    .msg-time {
        font-size:.68rem; margin-top:.3rem; opacity:.65;
        text-align:right;
    }
    .msg-bubble.mio .msg-time { color:rgba(0,21,43,.65); }
    .msg-bubble.otro .msg-time { text-align:left; color:var(--text-muted); }

    /* empty */
    .chat-empty {
        flex:1; display:flex; flex-direction:column;
        align-items:center; justify-content:center;
        color:var(--text-muted); gap:.5rem; opacity:.5;
    }

    /* input */
    .chat-form {
        display:flex; gap:.75rem;
        padding:1rem 1.1rem;
        background:rgba(0,21,43,.9);
        border:1px solid var(--border);
        border-top:none;
        border-radius:0 0 1.1rem 1.1rem;
        align-items:center;
    }
    .chat-form input {
        flex:1; padding:.7rem 1rem;
        background:rgba(255,255,255,.06);
        border:1px solid var(--border);
        border-radius:.65rem;
        color:var(--white); font-family:'Instrument Sans',sans-serif;
        font-size:.9rem; outline:none;
        transition:border-color .2s, box-shadow .2s;
    }
    .chat-form input:focus { border-color:var(--cyan); box-shadow:0 0 0 3px rgba(0,195,255,.1); }
    .chat-form input::placeholder { color:rgba(139,170,200,.35); }

    .btn-send {
        padding:.7rem 1.3rem;
        background:var(--cyan);
        color:var(--navy);
        border:none; border-radius:.65rem;
        font-family:'Syne',sans-serif; font-weight:700; font-size:.9rem;
        cursor:pointer; transition:all .2s;
        display:flex; align-items:center; gap:.4rem; flex-shrink:0;
    }
    .btn-send:hover { background:var(--cyan-dim); transform:translateY(-1px); box-shadow:0 4px 14px rgba(0,195,255,.25); }
    .btn-send:active { transform:translateY(0); }

    @media(max-width:600px) {
        .chat-wrap { height:calc(100vh - 2rem); }
        body, .cj-chat-page { padding:1rem .5rem; }
        .msg-bubble { max-width:82%; }
    }
</style>

@php
    $rol    = session('role');
    $userId = session('user_id');
@endphp

<div class="cj-chat-page">
    <div class="chat-wrap">

        {{-- back --}}
        @if($rol === 'cliente')
            <a href="{{ route('cliente.misContrataciones') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Volver a mis contrataciones
            </a>
        @else
            <a href="{{ route('trabajador.serviciosAsignados') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Volver a servicios asignados
            </a>
        @endif

        {{-- header --}}
        <div class="chat-header">
            <div class="chat-header-info">
                <h2>
                    {{ $contratacion->servicio->nombre_servicio }}
                    <span class="status-tag">{{ ucfirst($contratacion->estado) }}</span>
                </h2>
                <p>
                    @if($rol === 'cliente')
                        Hablando con: <strong style="color:var(--white)">{{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</strong>
                    @else
                        Hablando con: <strong style="color:var(--white)">{{ $contratacion->cliente->nombres }} {{ $contratacion->cliente->apellido_p }}</strong>
                    @endif
                </p>
            </div>
            <div class="chat-avatar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
        </div>

        {{-- messages --}}
        <div class="chat-messages" id="chat-messages">
            @forelse($mensajes as $msg)
                @php $esMio = ($msg->remitente_tipo === $rol); @endphp
                <div class="msg-bubble {{ $esMio ? 'mio' : 'otro' }}">
                    {{ $msg->mensaje }}
                    <div class="msg-time">{{ \Carbon\Carbon::parse($msg->created_at)->format('d/m H:i') }}</div>
                </div>
            @empty
                <div class="chat-empty">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <span>Aún no hay mensajes. ¡Sé el primero!</span>
                </div>
            @endforelse
        </div>

        {{-- form --}}
        <div class="chat-form">
            <input type="text" id="msg-input" placeholder="Escribe un mensaje..." autocomplete="off" maxlength="1000">
            <button class="btn-send" onclick="enviarMensaje()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Enviar
            </button>
        </div>

    </div>
</div>

<script>
    const rol            = "{{ $rol }}";
    const storeUrl       = "{{ $rol === 'cliente' ? route('cliente.chat.store', $contratacion->id_contratacion) : route('trabajador.chat.store', $contratacion->id_contratacion) }}";
    const pollingUrl     = "{{ $rol === 'cliente' ? route('cliente.chat.polling', $contratacion->id_contratacion) : route('trabajador.chat.polling', $contratacion->id_contratacion) }}";
    const csrfToken      = "{{ csrf_token() }}";
    let ultimoId = {{ $mensajes->count() > 0 ? $mensajes->last()->id_mensaje : 0 }};
    const messagesDiv = document.getElementById('chat-messages');

    function scrollAbajo() {
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
    scrollAbajo();

    function agregarBurbuja(msg) {
        // quitar empty state si existe
        const empty = messagesDiv.querySelector('.chat-empty');
        if (empty) empty.remove();

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

    // polling cada 5 segundos
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
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
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