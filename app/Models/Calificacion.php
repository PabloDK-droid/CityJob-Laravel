<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'DimensionCalificaciones';
    protected $primaryKey = 'id_calificaciones';
    public $timestamps = false; // Porque solo tenemos created_at

    protected $fillable = [
        'id_cliente', 
        'id_profesionista', 
        'calificacion', 
        'comentario', // AGREGADO
        'total_calif',
        'created_at'
    ];

    public function cliente() { 
        return $this->belongsTo(Cliente::class, 'id_cliente'); 
    }
    
    public function profesionista() { 
        return $this->belongsTo(Profesionista::class, 'id_profesionista'); 
    }
}