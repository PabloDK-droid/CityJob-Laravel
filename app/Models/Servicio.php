<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    protected $table = 'DimensionServicios';
    protected $primaryKey = 'id_servicio';

    protected $fillable = ['nombre_servicio'];

    public function contrataciones(): HasMany
    {
        return $this->hasMany(Contratacion::class, 'id_servicio');
    }
}
