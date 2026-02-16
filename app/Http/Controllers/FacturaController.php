<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Contratacion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaController extends Controller
{
    // Generar factura tras completar servicio
    public function store(Request $request)
    {
        $factura = Factura::create([
            'stripe_id' => $request->stripe_id ?? 'N/A',
            'nombre_emitor' => $request->nombre_emitor,
            'localizacion' => $request->localizacion,
            'fecha_emision' => now(),
        ]);

        return response()->json(['mensaje' => 'Factura generada', 'data' => $factura], 201);
    }

    // Descargar factura en PDF
    public function descargarPDF($id_contratacion)
    {
        $contratacion = Contratacion::with(['cliente', 'profesionista', 'servicio'])
            ->findOrFail($id_contratacion);

        // Verificar que el cliente sea el dueño
        if ($contratacion->id_cliente != session('user_id')) {
            abort(403, 'No autorizado');
        }

        $pdf = Pdf::loadView('facturas.factura_pdf', compact('contratacion'));
        
        return $pdf->download('factura_' . $id_contratacion . '.pdf');
    }
}