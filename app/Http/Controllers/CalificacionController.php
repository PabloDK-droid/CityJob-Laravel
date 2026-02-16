<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Profesionista;
use App\Models\Contratacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalificacionController extends Controller
{
    // Mostrar formulario para calificar un servicio
    public function create($id_contratacion)
    {
        $cliente_id = session('user_id');
        
        // Verificar que la contratación pertenece al cliente
        $contratacion = Contratacion::with(['profesionista', 'servicio'])
            ->where('id_contratacion', $id_contratacion)
            ->where('id_cliente', $cliente_id)
            ->firstOrFail();
        
        // Verificar si ya calificó este servicio
        $yaCalificado = Calificacion::where('id_cliente', $cliente_id)
            ->where('id_profesionista', $contratacion->id_profesionista)
            ->whereRaw('id_profesionista IN (SELECT id_profesionista FROM "DimensionContrataciones" WHERE id_contratacion = ?)', [$id_contratacion])
            ->exists();
        
        if ($yaCalificado) {
            return redirect()->route('cliente.misContrataciones')
                ->with('error', 'Ya calificaste este servicio anteriormente');
        }
        
        return view('cliente.calificar_servicio', compact('contratacion'));
    }

    // Registrar una nueva calificación
    public function store(Request $request)
    {
        $request->validate([
            'id_contratacion' => 'required|exists:DimensionContrataciones,id_contratacion',
            'id_profesionista' => 'required|exists:DimensionProfesionistas,id_profesionista',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        $cliente_id = session('user_id');
        
        // Crear la calificación
        $calificacion = Calificacion::create([
            'id_cliente' => $cliente_id,
            'id_profesionista' => $request->id_profesionista,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
            'total_calif' => 1, // Este campo se usa para contar calificaciones
            'created_at' => now()
        ]);

        // Actualizar el promedio de calificaciones del profesionista
        $this->actualizarPromedioCalificacion($request->id_profesionista);

        return redirect()->route('cliente.misContrataciones')
            ->with('success', '¡Calificación registrada exitosamente!');
    }

    // Método privado para actualizar el promedio
    private function actualizarPromedioCalificacion($id_profesionista)
    {
        $promedio = Calificacion::where('id_profesionista', $id_profesionista)
            ->avg('calificacion');
        
        $totalCalificaciones = Calificacion::where('id_profesionista', $id_profesionista)
            ->count();
        
        Profesionista::where('id_profesionista', $id_profesionista)
            ->update([
                'calificacion_profesionista' => round($promedio, 2),
            ]);
    }

    // Ver calificaciones de un profesionista
    public function verCalificaciones($id_profesionista)
    {
        $profesionista = Profesionista::findOrFail($id_profesionista);
        
        $calificaciones = Calificacion::with('cliente')
            ->where('id_profesionista', $id_profesionista)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('profesionista.calificaciones', compact('profesionista', 'calificaciones'));
    }
}