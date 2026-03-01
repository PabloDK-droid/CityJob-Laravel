<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Contratacion;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    // Vista del chat — compartida para cliente y trabajador
    public function chat($id_contratacion)
    {
        $rol       = session('role');
        $user_id   = session('user_id');

        $contratacion = Contratacion::with(['cliente', 'profesionista', 'servicio'])
            ->findOrFail($id_contratacion);

        // Verificar que el usuario pertenece a esta contratación
        if ($rol === 'cliente' && $contratacion->id_cliente != $user_id) {
            abort(403);
        }
        if ($rol === 'trabajador' && $contratacion->id_profesionista != $user_id) {
            abort(403);
        }

        $mensajes = Mensaje::where('id_contratacion', $id_contratacion)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.chat', compact('contratacion', 'mensajes'));
    }

    // Enviar mensaje
    public function store(Request $request, $id_contratacion)
    {
        $request->validate(['mensaje' => 'required|string|max:1000']);

        $rol     = session('role');
        $user_id = session('user_id');

        $contratacion = Contratacion::findOrFail($id_contratacion);

        if ($rol === 'cliente' && $contratacion->id_cliente != $user_id) abort(403);
        if ($rol === 'trabajador' && $contratacion->id_profesionista != $user_id) abort(403);

        Mensaje::create([
            'id_contratacion' => $id_contratacion,
            'remitente_tipo'  => $rol,
            'remitente_id'    => $user_id,
            'mensaje'         => $request->mensaje,
            'created_at'      => now(),
        ]);

        return response()->json(['ok' => true]);
    }

    // Polling — devuelve mensajes nuevos desde un id dado
    public function polling($id_contratacion, Request $request)
    {
        $rol     = session('role');
        $user_id = session('user_id');

        $contratacion = Contratacion::findOrFail($id_contratacion);

        if ($rol === 'cliente' && $contratacion->id_cliente != $user_id) abort(403);
        if ($rol === 'trabajador' && $contratacion->id_profesionista != $user_id) abort(403);

        $desde = $request->query('desde', 0);

        $mensajes = Mensaje::where('id_contratacion', $id_contratacion)
            ->where('id_mensaje', '>', $desde)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($m) {
                return [
                    'id_mensaje'      => $m->id_mensaje,
                    'remitente_tipo'  => $m->remitente_tipo,
                    'mensaje'         => $m->mensaje,
                    'created_at'      => $m->created_at,
                ];
            });

        return response()->json($mensajes);
    }
}