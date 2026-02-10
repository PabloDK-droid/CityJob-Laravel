<?php

namespace App\Http\Controllers;

use App\Models\Contratacion;
use App\Models\HechoContratacion;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncargadoController extends Controller
{
    // Ver todas las contrataciones para monitoreo
    public function index()
    {
        $contrataciones = Contratacion::with(['cliente', 'profesionista', 'servicio'])
            ->orderBy('fecha_realizacion', 'desc')
            ->get();
        
        return view('ingeniero.contrataciones', compact('contrataciones'));
    }

    // Ver detalle de una contratación específica
    public function show($id)
    {
        $contratacion = Contratacion::with(['cliente', 'profesionista', 'servicio'])->findOrFail($id);
        
        // Buscar si existe factura asociada
        $hecho = HechoContratacion::where('id_contratacion', $id)->first();
        $factura = null;
        if ($hecho) {
            $factura = Factura::find($hecho->id_factura);
        }
        
        return view('ingeniero.detalle_contratacion', compact('contratacion', 'factura', 'hecho'));
    }

    // Cancelar un servicio
    public function cancelar(Request $request, $id)
    {
        $contratacion = Contratacion::findOrFail($id);
        $contratacion->estado_emitor = false; // Cancelar servicio
        $contratacion->save();

        return redirect()->back()->with('success', 'Servicio cancelado exitosamente');
    }

    // Ver servicios por estado de pago
    public function serviciosPorPago()
    {
        $pagados = HechoContratacion::with(['contratacion.cliente', 'contratacion.profesionista', 'contratacion.servicio'])
            ->whereNotNull('id_factura')
            ->get();

        $pendientes = Contratacion::whereNotIn('id_contratacion', 
            HechoContratacion::pluck('id_contratacion')
        )->where('estado_emitor', true)->get();

        return view('ingeniero.pagos', compact('pagados', 'pendientes'));
    }

    // Ver estadísticas parciales (sin datos sensibles de negocio)
    public function estadisticas()
    {
        $stats = [
            'total_servicios' => Contratacion::count(),
            'servicios_activos' => Contratacion::where('estado_emitor', true)->count(),
            'servicios_completados' => HechoContratacion::count(),
            'servicios_por_tipo' => DB::table('DimensionContrataciones')
                ->join('DimensionServicios', 'DimensionContrataciones.id_servicio', '=', 'DimensionServicios.id_servicio')
                ->select('DimensionServicios.nombre_servicio', DB::raw('count(*) as total'))
                ->groupBy('DimensionServicios.nombre_servicio')
                ->get()
        ];

        return view('ingeniero.estadisticas', compact('stats'));
    }
}