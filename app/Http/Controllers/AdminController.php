<?php

namespace App\Http\Controllers;

use App\Models\Profesionista;
use App\Models\HechoContratacion;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Registrar trabajadores desde el panel administrativo [cite: 215]
    public function registerWorker(Request $request)
    {
        // Lógica similar a ProfesionistaController@store pero con privilegios de admin
    }

    // Obtener métricas generales de la tabla de Hechos (Monto total, comisiones) [cite: 73, 262]
    public function getGlobalStats()
    {
        $stats = [
            'total_recaudado' => HechoContratacion::sum('monto_total'), //
            'comisiones_plataforma' => HechoContratacion::sum('comision_plataforma'), //
            'total_servicios' => HechoContratacion::count()
        ];
        return response()->json($stats);
    }

    // Función para "Descargar Datos" o reportes [cite: 217]
    public function downloadLogs()
    {
        // Aquí iría la lógica para exportar CSV o PDF de las contrataciones
        return response()->json(['mensaje' => 'Generando reporte de sistema...']);
    }
}