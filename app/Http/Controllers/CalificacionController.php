<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Profesionista;
use App\Models\Contratacion;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function create($id_contratacion)
    {
        $cliente_id = session('user_id');

        $contratacion = Contratacion::with(['profesionista', 'servicio'])
            ->where('id_contratacion', $id_contratacion)
            ->where('id_cliente', $cliente_id)
            ->firstOrFail();

        $yaCalificado = Calificacion::where('id_cliente', $cliente_id)
            ->where('id_profesionista', $contratacion->id_profesionista)
            ->where('tipo', 'cliente_a_profesionista')
            ->whereExists(function($q) use ($id_contratacion) {
                $q->selectRaw('1')
                  ->from('DimensionContrataciones')
                  ->whereRaw('"DimensionContrataciones".id_contratacion = ?', [$id_contratacion]);
            })
            ->exists();

        if ($yaCalificado) {
            return redirect()->route('cliente.misContrataciones')
                ->with('error', 'Ya calificaste este servicio.');
        }

        return view('cliente.calificar_servicio', compact('contratacion'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_contratacion' => 'required|exists:DimensionContrataciones,id_contratacion',
            'id_profesionista' => 'required|exists:DimensionProfesionistas,id_profesionista',
            'calificacion'    => 'required|integer|min:1|max:5',
            'comentario'      => 'nullable|string|max:500'
        ]);

        $cliente_id = session('user_id');

        Calificacion::create([
            'id_cliente'      => $cliente_id,
            'id_profesionista'=> $request->id_profesionista,
            'calificacion'    => $request->calificacion,
            'comentario'      => $request->comentario,
            'total_calif'     => 1,
            'tipo'            => 'cliente_a_profesionista',
            'created_at'      => now()
        ]);

        $this->actualizarPromedioProfesionista($request->id_profesionista);

        return redirect()->route('cliente.misContrataciones')
            ->with('success', '¡Calificación registrada!');
    }

    private function actualizarPromedioProfesionista($id_profesionista)
    {
        $promedio = Calificacion::where('id_profesionista', $id_profesionista)
            ->where('tipo', 'cliente_a_profesionista')
            ->avg('calificacion');

        Profesionista::where('id_profesionista', $id_profesionista)
            ->update(['calificacion_profesionista' => round($promedio, 2)]);
    }

    public function createClienteRating($id_contratacion)
    {
        $profesionista_id = session('user_id');

        $contratacion = Contratacion::with(['cliente', 'servicio'])
            ->where('id_contratacion', $id_contratacion)
            ->where('id_profesionista', $profesionista_id)
            ->where('estado', 'completado')
            ->firstOrFail();

        $yaCalificado = Calificacion::where('id_profesionista', $profesionista_id)
            ->where('id_cliente', $contratacion->id_cliente)
            ->where('tipo', 'profesionista_a_cliente')
            ->exists();

        if ($yaCalificado) {
            return redirect()->route('trabajador.misCalificaciones')
                ->with('error', 'Ya calificaste a este cliente.');
        }

        return view('trabajador.calificar_cliente', compact('contratacion'));
    }

    public function storeClienteRating(Request $request)
    {
        $request->validate([
            'id_contratacion' => 'required|exists:DimensionContrataciones,id_contratacion',
            'id_cliente'      => 'required|exists:DimensionClientes,id_cliente',
            'calificacion'    => 'required|integer|min:1|max:5',
            'comentario'      => 'nullable|string|max:500'
        ]);

        $profesionista_id = session('user_id');

        $yaCalificado = Calificacion::where('id_profesionista', $profesionista_id)
            ->where('id_cliente', $request->id_cliente)
            ->where('tipo', 'profesionista_a_cliente')
            ->exists();

        if ($yaCalificado) {
            return redirect()->route('trabajador.misCalificaciones')
                ->with('error', 'Ya calificaste a este cliente.');
        }

        Calificacion::create([
            'id_cliente'      => $request->id_cliente,
            'id_profesionista'=> $profesionista_id,
            'calificacion'    => $request->calificacion,
            'comentario'      => $request->comentario,
            'total_calif'     => 1,
            'tipo'            => 'profesionista_a_cliente',
            'created_at'      => now()
        ]);

        return redirect()->route('trabajador.misCalificaciones')
            ->with('success', '¡Calificación registrada!');
    }

    public function misCalificaciones()
    {
        $profesionista_id = session('user_id');

        $calificaciones = Calificacion::with('cliente')
            ->where('id_profesionista', $profesionista_id)
            ->where('tipo', 'profesionista_a_cliente')
            ->orderBy('created_at', 'desc')
            ->get();

        $pendientes = Contratacion::with(['cliente', 'servicio'])
            ->where('id_profesionista', $profesionista_id)
            ->where('estado', 'completado')
            ->whereNotIn('id_cliente',
                Calificacion::where('id_profesionista', $profesionista_id)
                    ->where('tipo', 'profesionista_a_cliente')
                    ->pluck('id_cliente')
            )
            ->get();

        return view('trabajador.mis_calificaciones', compact('calificaciones', 'pendientes'));
    }

    public function verCalificaciones($id_profesionista)
    {
        $profesionista = Profesionista::findOrFail($id_profesionista);

        $calificaciones = Calificacion::with('cliente')
            ->where('id_profesionista', $id_profesionista)
            ->where('tipo', 'cliente_a_profesionista')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profesionista.calificaciones', compact('profesionista', 'calificaciones'));
    }
}