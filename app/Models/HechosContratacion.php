<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HechoContratacion extends Model
{
    protected $table = 'HechosContrataciones';
    protected $primaryKey = 'id_hecho';

    protected $fillable = [
        'id_cliente', 'id_profesionista', 'id_encargado', 'id_administrador',
        'id_servicio', 'id_contratacion', 'id_factura', 'monto_total',
        'comision_plataforma', 'duracion_servicio_minutos', 'fecha_registro'
    ];

    // Relaciones para navegar a través del esquema de estrella [cite: 249]
    public function cliente(): BelongsTo { return $this->belongsTo(Cliente::class, 'id_cliente'); }
    public function profesionista(): BelongsTo { return $this->belongsTo(Profesionista::class, 'id_profesionista'); }
    public function servicio(): BelongsTo { return $this->belongsTo(Servicio::class, 'id_servicio'); }
}