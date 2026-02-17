@extends('layouts.app')

@section('content')
<style>
    .ayuda-container { max-width: 900px; margin: 0 auto; padding: 40px 20px; }
    .ayuda-header { text-align: center; margin-bottom: 40px; }
    .ayuda-header h1 { font-size: 36px; font-weight: 700; color: #04142b; }
    .ayuda-header p { color: #666; font-size: 16px; }
    
    .faq-section { margin-bottom: 30px; }
    .faq-section h2 { color: #0066ff; font-size: 24px; margin-bottom: 20px; }
    
    .faq-item { background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; margin-bottom: 15px; }
    .faq-question { font-weight: 700; color: #333; font-size: 16px; margin-bottom: 10px; }
    .faq-answer { color: #666; line-height: 1.6; }
    
    .contacto-box { background: linear-gradient(135deg, #0066ff, #00a8ff); color: white; padding: 30px; border-radius: 12px; text-align: center; margin-top: 40px; }
    .contacto-box h3 { margin-top: 0; }
    .contacto-box a { color: white; text-decoration: underline; }
</style>

<div class="ayuda-container">
    <div class="ayuda-header">
        <h1>Centro de Ayuda</h1>
        <p>Encuentra respuestas a las preguntas más frecuentes</p>
    </div>

    <!-- FAQ para Clientes -->
    <div class="faq-section">
        <h2>Para Clientes</h2>
        
        <div class="faq-item">
            <div class="faq-question">¿Cómo contrato un servicio?</div>
            <div class="faq-answer">
                1. Navega al catálogo de servicios<br>
                2. Selecciona el servicio que necesitas<br>
                3. Revisa los profesionistas disponibles<br>
                4. Ingresa la ubicación donde necesitas el servicio<br>
                5. Click en "Contratar"
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">¿Cómo califico a un profesionista?</div>
            <div class="faq-answer">
                Una vez que el servicio esté marcado como "Completado", encontrarás un botón "Calificar" en "Mis Contrataciones". Puedes asignar de 1 a 5 estrellas y dejar un comentario opcional.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">¿Cómo descargo mi factura?</div>
            <div class="faq-answer">
                En "Mis Contrataciones", los servicios completados tendrán un botón "Descargar Factura" que generará un PDF con todos los detalles del servicio.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">¿Puedo cancelar una contratación?</div>
            <div class="faq-answer">
                Actualmente, solo los administradores e ingenieros pueden cancelar servicios. Contacta al soporte para solicitar la cancelación de un servicio.
            </div>
        </div>
    </div>

    <!-- FAQ para Trabajadores -->
    <div class="faq-section">
        <h2>Para Profesionistas</h2>
        
        <div class="faq-item">
            <div class="faq-question">¿Cómo veo mis servicios asignados?</div>
            <div class="faq-answer">
                En tu dashboard de trabajador, haz click en "Servicios Asignados" para ver todos los trabajos que te han sido asignados.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">¿Cómo marco un servicio como completado?</div>
            <div class="faq-answer">
                En la lista de "Servicios Asignados", cada trabajo activo tiene un botón "✓ Marcar Completado". Una vez que finalices el trabajo, haz click ahí para actualizar el estado.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">¿Cómo mejoro mi calificación?</div>
            <div class="faq-answer">
                Tu calificación se actualiza automáticamente con cada evaluación que recibas de los clientes. Completa los servicios con calidad y profesionalismo para obtener mejores calificaciones.
            </div>
        </div>
    </div>

    <!-- FAQ General -->
    <div class="faq-section">
        <h2>Preguntas Generales</h2>
        
        <div class="faq-item">
            <div class="faq-question">¿Qué métodos de pago aceptan?</div>
            <div class="faq-answer">
                Actualmente aceptamos pagos con tarjeta de crédito/débito a través de nuestra plataforma segura. Próximamente integraremos más métodos de pago.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">¿Cómo actualizo mi perfil?</div>
            <div class="faq-answer">
                En tu dashboard, encontrarás la opción "Editar Perfil" donde puedes actualizar tus datos personales, teléfono, domicilio y contraseña.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">¿La plataforma cobra comisión?</div>
            <div class="faq-answer">
                Sí, CityJob cobra una comisión del 10% sobre el monto total del servicio para mantener y mejorar la plataforma.
            </div>
        </div>
    </div>

    <!-- Contacto -->
    <div class="contacto-box">
        <h3>¿No encontraste lo que buscabas?</h3>
        <p>Nuestro equipo de soporte está aquí para ayudarte</p>
        <p><strong>Email:</strong> <a href="mailto:soporte@cityjob.com">soporte@cityjob.com</a></p>
        <p><strong>Teléfono:</strong> 56 3731 4047</p>
        <p><strong>Horario:</strong> Lunes a Viernes, 9:00 AM - 6:00 PM</p>
    </div>
</div>
@endsection