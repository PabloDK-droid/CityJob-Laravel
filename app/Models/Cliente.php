<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'DimensionClientes';
    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'nombres', 'apellido_p', 'apellido_m', 'genero', 'telefono', 
        'telefono_fijo',
        'correo_electronico', 'cp', 'domicilio', 'referencias', 'contrasena'
    ];

    protected $hidden = ['contrasena'];

    public function contrataciones(): HasMany
    {
        return $this->hasMany(Contratacion::class, 'id_cliente');
    }
}