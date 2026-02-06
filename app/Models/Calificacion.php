<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'DimensionCalificaciones';
    protected $primaryKey = 'id_calificaciones';

    protected $fillable = ['id_cliente', 'id_profesionista', 'calificacion', 'total_calif'];

    public function cliente() { return $this->belongsTo(Cliente::class, 'id_cliente'); }
    public function profesionista() { return $this->belongsTo(Profesionista::class, 'id_profesionista'); }
}