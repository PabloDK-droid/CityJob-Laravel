<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HechoContratacion extends Model
{
    protected $table = 'HechosContrataciones';
    protected $primaryKey = 'id_hecho';
    public $timestamps = false;

    protected $fillable = [
        'id_cliente', 'id_profesionista', 'id_encargado', 'id_administrador',
        'id_servicio', 'id_contratacion', 'id_factura', 'monto_total',
        'comision_plataforma', 'duracion_servicio_minutos', 'fecha_registro'
    ];

    // Relaciones
    public function cliente(): BelongsTo { 
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente'); 
    }
    
    public function profesionista(): BelongsTo { 
        return $this->belongsTo(Profesionista::class, 'id_profesionista', 'id_profesionista'); 
    }
    
    public function servicio(): BelongsTo { 
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio'); 
    }
    
    public function contratacion(): BelongsTo { 
        return $this->belongsTo(Contratacion::class, 'id_contratacion', 'id_contratacion'); 
    }
    
    public function factura(): BelongsTo { 
        return $this->belongsTo(Factura::class, 'id_factura', 'id_factura'); 
    }
}