<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'DimensionClientes'; // Tabla personalizada
    protected $primaryKey = 'id_cliente';    // PK personalizada

    protected $fillable = [
        'nombres', 'apellido_p', 'apellido_m', 'genero', 'telefono', 
        'correo_electronico', 'cp', 'domicilio', 'contrasena'
    ];

    protected $hidden = ['contrasena']; // Seguridad para la contraseña

    public function contrataciones(): HasMany
    {
        return $this->hasMany(Contratacion::class, 'id_cliente');
    }
}