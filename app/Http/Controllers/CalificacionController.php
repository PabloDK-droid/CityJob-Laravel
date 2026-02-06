<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Profesionista;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    // Registrar una nueva calificación para un trabajador
    public function store(Request $request)
    {
        $calificacion = Calificacion::create([
            'id_cliente' => $request->id_cliente,
            'id_profesionista' => $request->id_profesionista,
            'calificacion' => $request->calificacion,
            'total_calif' => $request->total_calif,
        ]);

        // Opcional: Aquí podrías actualizar el promedio en la tabla DimensionProfesionistas
        return response()->json(['mensaje' => 'Calificación registrada', 'data' => $calificacion]);
    }
}