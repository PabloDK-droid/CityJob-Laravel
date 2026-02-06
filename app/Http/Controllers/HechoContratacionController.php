<?php

namespace App\Http\Controllers;

use App\Models\HechoContratacion;
use Illuminate\Http\Request;

class HechoContratacionController extends Controller
{
    // Consolidar el registro final de la contratación para analítica
    public function logFact(Request $request)
    {
        $hecho = HechoContratacion::create([
            'id_cliente' => $request->id_cliente,
            'id_profesionista' => $request->id_profesionista,
            'id_encargado' => $request->id_encargado,
            'id_administrador' => $request->id_administrador,
            'id_servicio' => $request->id_servicio,
            'id_contratacion' => $request->id_contratacion,
            'id_factura' => $request->id_factura,
            'monto_total' => $request->monto_total,
            'comision_plataforma' => $request->monto_total * 0.10, // Ejemplo: 10% de comisión
            'duracion_servicio_minutos' => $request->duracion_servicio_minutos,
            'fecha_registro' => now(),
        ]);

        return response()->json(['mensaje' => 'Historial analítico registrado', 'data' => $hecho]);
    }
}