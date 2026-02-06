<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    // Listar todos los servicios disponibles (Plomería, Carpintería, etc.) [cite: 147]
    public function index()
    {
        return response()->json(Servicio::all());
    }

    // Agregar un nuevo tipo de servicio al catálogo [cite: 146]
    public function store(Request $request)
    {
        $servicio = Servicio::create([
            'nombre_servicio' => $request->nombre_servicio
        ]);
        return response()->json($servicio, 201);
    }
}