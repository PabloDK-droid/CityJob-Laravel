<?php

namespace App\Http\Controllers;

use App\Models\Contratacion;
use Illuminate\Http\Request;

class ContratacionController extends Controller
{
    // Crear una nueva solicitud de trabajo [cite: 148, 196]
    public function store(Request $request)
    {
        $contratacion = Contratacion::create([
            'id_cliente' => $request->id_cliente,
            'id_profesionista' => $request->id_profesionista,
            'id_servicio' => $request->id_servicio,
            'nombres_emitor' => $request->nombres_emitor,
            'estado_emitor' => true, // Activo al momento de crear [cite: 263]
            'localizacion' => $request->localizacion,
            'fecha_realizacion' => now(), // Fecha actual del sistema [cite: 263]
        ]);

        return response()->json([
            'mensaje' => 'Servicio contratado exitosamente',
            'data' => $contratacion
        ], 201);
    }

    // Consultar el estado de un servicio [cite: 149]
    public function status($id)
    {
        $contratacion = Contratacion::find($id);
        return response()->json(['estado' => $contratacion->estado_emitor]);
    }
}