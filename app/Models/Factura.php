<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'DimensionFacturas';
    protected $primaryKey = 'id_factura';
    public $timestamps = false;

    protected $fillable = ['stripe_id', 'nombre_emitor', 'localizacion', 'fecha_emision'];
}