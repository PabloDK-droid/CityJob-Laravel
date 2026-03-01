<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'DimensionMensajes';
    protected $primaryKey = 'id_mensaje';
    public $timestamps = false;

    protected $fillable = [
        'id_contratacion',
        'remitente_tipo',
        'remitente_id',
        'mensaje',
        'created_at'
    ];

    public function contratacion()
    {
        return $this->belongsTo(Contratacion::class, 'id_contratacion');
    }
}