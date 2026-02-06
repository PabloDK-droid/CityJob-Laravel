<?php

namespace App\Http\Controllers;

use App\Models\Profesionista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfesionistaController extends Controller
{
    // Listar todos los profesionistas registrados [cite: 147]
    public function index()
    {
        $profesionistas = Profesionista::all();
        return response()->json($profesionistas);
    }

    // Registrar un nuevo trabajador en la plataforma [cite: 146, 215]
    public function store(Request $request)
    {
        $nuevoProfesionista = Profesionista::create([
            'nombres' => $request->nombres,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'genero' => $request->genero,
            'telefono' => $request->telefono,
            'correo_electronico' => $request->correo_electronico,
            'nivel_estudios' => $request->nivel_estudios,
            'especializado' => $request->especializado,
            'calificacion_profesionista' => 0, // Inicia en 0 por defecto [cite: 253]
            'domicilio' => $request->domicilio,
            'cp' => $request->cp,
            'contrasena' => Hash::make($request->contrasena), // Encriptación de seguridad [cite: 162]
        ]);

        return response()->json([
            'mensaje' => 'Profesionista registrado con éxito',
            'data' => $nuevoProfesionista
        ], 201);
    }

    // Ver el perfil detallado de un trabajador [cite: 137, 236]
    public function show($id)
    {
        $profesionista = Profesionista::with('contrataciones')->find($id);

        if (!$profesionista) {
            return response()->json(['error' => 'No se encontró al trabajador'], 404);
        }

        return response()->json($profesionista);
    }
}