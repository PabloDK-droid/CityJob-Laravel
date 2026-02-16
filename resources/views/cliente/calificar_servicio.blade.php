@extends('layouts.app')

@section('content')
<style>
    .rating-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 40px 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .rating-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .rating-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #04142b;
        margin-bottom: 10px;
    }
    .service-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }
    .service-info p {
        margin: 8px 0;
        font-size: 15px;
    }
    .service-info strong {
        color: #0066ff;
    }
    
    /* Sistema de estrellas */
    .star-rating {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin: 30px 0;
        font-size: 40px;
    }
    .star {
        cursor: pointer;
        color: #ddd;
        transition: all 0.2s;
    }
    .star:hover,
    .star.active {
        color: #ffc107;
        transform: scale(1.1);
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        resize: vertical;
    }
    .form-group textarea:focus {
        outline: none;
        border-color: #0066ff;
        box-shadow: 0 0 0 3px rgba(0,102,255,0.1);
    }
    
    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, #0066ff, #00a8ff);
        color: white;
        padding: 14px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,102,255,0.3);
    }
    .btn-submit:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    
    .btn-back {
        display: inline-block;
        margin-bottom: 20px;
        color: #0066ff;
        text-decoration: none;
        font-weight: 600;
    }
    
    #rating-text {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        color: #0066ff;
        margin-top: 10px;
        min-height: 25px;
    }
</style>

<div class="rating-container">
    <a href="{{ route('cliente.misContrataciones') }}" class="btn-back">← Volver a mis contrataciones</a>
    
    <div class="rating-header">
        <h1>Calificar Servicio</h1>
        <p>Comparte tu experiencia con este profesionista</p>
    </div>

    <div class="service-info">
        <p><strong>Servicio:</strong> {{ $contratacion->servicio->nombre_servicio }}</p>
        <p><strong>Profesionista:</strong> {{ $contratacion->profesionista->nombres }} {{ $contratacion->profesionista->apellido_p }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($contratacion->fecha_realizacion)->format('d/m/Y H:i') }}</p>
        <p><strong>Ubicación:</strong> {{ $contratacion->localizacion }}</p>
    </div>

    <form action="{{ route('cliente.guardarCalificacion') }}" method="POST" id="rating-form">
        @csrf
        
        <input type="hidden" name="id_contratacion" value="{{ $contratacion->id_contratacion }}">
        <input type="hidden" name="id_profesionista" value="{{ $contratacion->id_profesionista }}">
        <input type="hidden" name="calificacion" id="calificacion-input" value="0">

        <div class="form-group">
            <label>¿Cómo calificarías este servicio?</label>
            <div class="star-rating">
                <span class="star" data-rating="1">★</span>
                <span class="star" data-rating="2">★</span>
                <span class="star" data-rating="3">★</span>
                <span class="star" data-rating="4">★</span>
                <span class="star" data-rating="5">★</span>
            </div>
            <div id="rating-text"></div>
            @error('calificacion')
                <span style="color: red; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Comentario (opcional)</label>
            <textarea name="comentario" rows="4" placeholder="Cuéntanos sobre tu experiencia con este profesionista...">{{ old('comentario') }}</textarea>
            @error('comentario')
                <span style="color: red; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-submit" id="submit-btn" disabled>
            Enviar Calificación
        </button>
    </form>
</div>

<script>
    const stars = document.querySelectorAll('.star');
    const calificacionInput = document.getElementById('calificacion-input');
    const ratingText = document.getElementById('rating-text');
    const submitBtn = document.getElementById('submit-btn');
    
    const textos = {
        1: 'Muy malo',
        2: 'Malo',
        3: 'Regular',
        4: 'Bueno',
        5: 'Excelente'
    };
    
    let selectedRating = 0;
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            calificacionInput.value = selectedRating;
            ratingText.textContent = textos[selectedRating];
            submitBtn.disabled = false;
            
            // Actualizar estrellas visuales
            stars.forEach(s => {
                if (parseInt(s.dataset.rating) <= selectedRating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
        
        star.addEventListener('mouseover', function() {
            const hoverRating = parseInt(this.dataset.rating);
            stars.forEach(s => {
                if (parseInt(s.dataset.rating) <= hoverRating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
    });
    
    document.querySelector('.star-rating').addEventListener('mouseleave', function() {
        stars.forEach(s => {
            if (parseInt(s.dataset.rating) <= selectedRating) {
                s.classList.add('active');
            } else {
                s.classList.remove('active');
            }
        });
    });
</script>
@endsection