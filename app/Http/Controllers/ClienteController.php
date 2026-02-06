<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    // Obtener perfil del cliente [cite: 145]
    public function show($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) return response()->json(['error' => 'Cliente no encontrado'], 404);
        return response()->json($cliente);
    }

    // Registrar un nuevo cliente [cite: 232]
    public function store(Request $request)
    {
        $cliente = Cliente::create([
            'nombres' => $request->nombres,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'genero' => $request->genero,
            'telefono' => $request->telefono,
            'correo_electronico' => $request->correo_electronico,
            'cp' => $request->cp,
            'domicilio' => $request->domicilio,
            'referencias' => $request->referencias,
            'contrasena' => Hash::make($request->contrasena) // Hash de seguridad para la contraseña
        ]);

        return response()->json(['mensaje' => 'Registro exitoso', 'data' => $cliente], 201);
    }

    // Actualizar datos del cliente [cite: 145, 239]
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        $cliente->update($request->all());
        return response()->json(['mensaje' => 'Datos actualizados', 'data' => $cliente]);
    }
}