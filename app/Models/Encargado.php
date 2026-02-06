<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
    protected $table = 'DimensionEncargados';
    protected $primaryKey = 'id_encargado';

    protected $fillable = [
        'nombres', 'apellido_p', 'apellido_m', 'genero', 'telefono', 
        'correo_electronico', 'contrasena'
    ];

    protected $hidden = ['contrasena'];
}