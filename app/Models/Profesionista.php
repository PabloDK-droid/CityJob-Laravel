<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profesionista extends Model
{
    protected $table = 'DimensionProfesionistas';
    protected $primaryKey = 'id_profesionista';

    protected $fillable = [
        'nombres', 'apellido_p', 'apellido_m', 'genero', 'telefono', 
        'correo_electronico', 'nivel_estudios', 'especializado', 
        'calificacion_profesionista', 'domicilio', 'cp', 'contrasena'
    ];

    protected $hidden = ['contrasena'];

    public function contrataciones(): HasMany
    {
        return $this->hasMany(Contratacion::class, 'id_profesionista');
    }
}