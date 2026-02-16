<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contratacion extends Model
{
    protected $table = 'DimensionContrataciones';
    protected $primaryKey = 'id_contratacion';

    protected $fillable = [
        'id_cliente', 'id_profesionista', 'id_servicio', 'nombres_emitor',
        'estado_emitor', 'localizacion', 'fecha_realizacion',
        'monto_acordado','estado', 'estado_trabajador' // AGREGADOs
    ];

    public function cliente(): BelongsTo { 
        return $this->belongsTo(Cliente::class, 'id_cliente'); 
    }
    
    public function profesionista(): BelongsTo { 
        return $this->belongsTo(Profesionista::class, 'id_profesionista'); 
    }
    
    public function servicio(): BelongsTo { 
        return $this->belongsTo(Servicio::class, 'id_servicio'); 
    }
}