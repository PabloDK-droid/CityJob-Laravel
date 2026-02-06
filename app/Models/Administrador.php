<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $table = 'DimensionAdministradores';
    protected $primaryKey = 'id_administrador';

    protected $fillable = [
        'nombres', 'apellido_p', 'apellido_m', 'genero', 'telefono', 
        'correo_electronico', 'contrasena'
    ];

    protected $hidden = ['contrasena'];
}