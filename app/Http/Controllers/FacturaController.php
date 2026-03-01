<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Contratacion;
use App\Models\HechoContratacion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class FacturaController extends Controller
{
    public function crearSesionStripe($id_contratacion)
    {
        $cliente_id = session('user_id');

        $contratacion = Contratacion::with(['cliente', 'profesionista', 'servicio'])
            ->where('id_contratacion', $id_contratacion)
            ->where('id_cliente', $cliente_id)
            ->where('estado', 'pago_pendiente')
            ->firstOrFail();

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'mxn',
                    'product_data' => [
                        'name' => 'Servicio: ' . $contratacion->servicio->nombre_servicio,
                        'description' => 'Profesionista: ' . $contratacion->profesionista->nombres
                            . ' ' . $contratacion->profesionista->apellido_p,
                    ],
                    'unit_amount' => (int) ($contratacion->monto_acordado * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('cliente.pagoExitoso') . '?session_id={CHECKOUT_SESSION_ID}&contratacion=' . $id_contratacion,
            'cancel_url'  => route('cliente.pagoCancelado') . '?contratacion=' . $id_contratacion,
            'metadata'    => [
                'id_contratacion' => $id_contratacion,
                'id_cliente'      => $cliente_id,
            ],
        ]);

        return redirect($session->url);
    }

    public function pagoExitoso(Request $request)
    {
        $id_contratacion = $request->query('contratacion');
        $session_id      = $request->query('session_id');
        $cliente_id      = session('user_id');

        $contratacion = Contratacion::with(['cliente', 'profesionista', 'servicio'])
            ->where('id_contratacion', $id_contratacion)
            ->where('id_cliente', $cliente_id)
            ->firstOrFail();

        if ($contratacion->estado === 'pago_pendiente') {

            $factura = Factura::create([
                'stripe_id'     => $session_id,
                'nombre_emitor' => $contratacion->cliente->nombres . ' ' . $contratacion->cliente->apellido_p,
                'localizacion'  => $contratacion->localizacion,
                'fecha_emision' => now(),
            ]);

            HechoContratacion::create([
                'id_cliente'               => $contratacion->id_cliente,
                'id_profesionista'         => $contratacion->id_profesionista,
                'id_encargado'             => null,
                'id_administrador'         => null,
                'id_servicio'              => $contratacion->id_servicio,
                'id_contratacion'          => $contratacion->id_contratacion,
                'id_factura'               => $factura->id_factura,
                'monto_total'              => $contratacion->monto_acordado,
                'comision_plataforma'      => $contratacion->monto_acordado * 0.10,
                'duracion_servicio_minutos'=> 0,
                'fecha_registro'           => now(),
            ]);
            $contratacion->estado = 'activo';
            $contratacion->save();
        }

        return view('cliente.pago_exitoso', compact('contratacion'));
    }

    public function pagoCancelado(Request $request)
    {
        $id_contratacion = $request->query('contratacion');
        $cliente_id      = session('user_id');

        $contratacion = Contratacion::with(['servicio'])
            ->where('id_contratacion', $id_contratacion)
            ->where('id_cliente', $cliente_id)
            ->firstOrFail();

        return redirect()->route('cliente.misContrataciones')
            ->with('error', 'El pago no se completó. Tu servicio sigue pendiente de pago. Puedes intentarlo de nuevo cuando quieras.');
    }

    public function descargarPDF($id_contratacion)
    {
        $contratacion = Contratacion::with(['cliente', 'profesionista', 'servicio'])
            ->findOrFail($id_contratacion);

        if ($contratacion->id_cliente != session('user_id')) {
            abort(403, 'No autorizado');
        }

        $pdf = Pdf::loadView('facturas.factura_pdf', compact('contratacion'));
        return $pdf->download('factura_' . $id_contratacion . '.pdf');
    }
}