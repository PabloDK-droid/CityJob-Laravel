<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    // Generar una factura tras el pago exitoso en Stripe
    public function store(Request $request)
    {
        $factura = Factura::create([
            'stripe_id' => $request->stripe_id, // Identificador de la pasarela de pagos [cite: 259]
            'nombre_emitor' => $request->nombre_emitor,
            'localizacion' => $request->localizacion,
            'fecha_emision' => now(),
        ]);

        return response()->json(['mensaje' => 'Factura generada', 'data' => $factura], 201);
    }
}