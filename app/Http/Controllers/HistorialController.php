<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Contratacion;
use App\Models\HechoContratacion;
use App\Models\Factura;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    // Historial del cliente — sus contrataciones
    public function cliente()
    {
        $cliente_id = session('user_id');

        $contrataciones = Contratacion::with(['profesionista', 'servicio'])
            ->where('id_cliente', $cliente_id)
            ->orderBy('fecha_realizacion', 'desc')
            ->get();

        return view('historial.historial', compact('contrataciones'));
    }

    // Historial del profesionista — trabajos aceptados
    public function profesionista()
    {
        $profesionista_id = session('user_id');

        $contrataciones = Contratacion::with(['cliente', 'servicio'])
            ->where('id_profesionista', $profesionista_id)
            ->where('estado_trabajador', 'aceptado')
            ->orderBy('fecha_realizacion', 'desc')
            ->get();

        return view('historial.historial', compact('contrataciones'));
    }

    // Historial global — admin e ingeniero
    public function global()
    {
        $contrataciones = Contratacion::with(['cliente', 'profesionista', 'servicio'])
            ->orderBy('fecha_realizacion', 'desc')
            ->get();

        return view('historial.historial_global', compact('contrataciones'));
    }

    // Detalle de una contratación — accesible por todos los roles
    public function detalle($id)
    {
        $rol = session('role');
        $user_id = session('user_id');

        $contratacion = Contratacion::with(['cliente', 'profesionista', 'servicio'])
            ->findOrFail($id);

        // Verificar acceso según rol
        if ($rol === 'cliente' && $contratacion->id_cliente != $user_id) abort(403);
        if ($rol === 'trabajador' && $contratacion->id_profesionista != $user_id) abort(403);

        $hecho   = HechoContratacion::where('id_contratacion', $id)->first();
        $factura = $hecho ? Factura::find($hecho->id_factura) : null;
        $historial = Historial::where('id_contratacion', $id)->first();

        return view('historial.detalle', compact('contratacion', 'hecho', 'factura', 'historial'));
    }
}