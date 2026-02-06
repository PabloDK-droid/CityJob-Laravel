<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 'DimensionHistorial';
    protected $primaryKey = 'id_historial';

    protected $fillable = ['id_factura', 'id_contratacion', 'fecha_factura', 'monto', 'hora'];

    public function factura() { return $this->belongsTo(Factura::class, 'id_factura'); }
}