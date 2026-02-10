<?php

namespace App\Http\Controllers;

use App\Models\Profesionista;
use App\Models\Contratacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfesionistaController extends Controller
{
    // Dashboard del trabajador
    public function dashboard()
    {
        $profesionista_id = session('user_id');
        $profesionista = Profesionista::findOrFail($profesionista_id);
        
        return view('trabajador.dashboard', compact('profesionista'));
    }

    // Ver servicios asignados (contrataciones donde el trabajador está involucrado)
    public function serviciosAsignados()
    {
        $profesionista_id = session('user_id');
        $contrataciones = Contratacion::with(['cliente', 'servicio'])
            ->where('id_profesionista', $profesionista_id)
            ->where('estado_emitor', true)
            ->orderBy('fecha_realizacion', 'desc')
            ->get();
        
        return view('trabajador.servicios_asignados', compact('contrataciones'));
    }

    // Ver detalle de un servicio asignado
    public function detalleServicio($id)
    {
        $profesionista_id = session('user_id');
        $contratacion = Contratacion::with(['cliente', 'servicio'])
            ->where('id_profesionista', $profesionista_id)
            ->where('id_contratacion', $id)
            ->firstOrFail();
        
        return view('trabajador.detalle_servicio', compact('contratacion'));
    }

    // Mostrar formulario de edición de perfil
    public function editarPerfil()
    {
        $profesionista_id = session('user_id');
        $profesionista = Profesionista::findOrFail($profesionista_id);
        
        return view('trabajador.editar_perfil', compact('profesionista'));
    }

    // Actualizar perfil del trabajador
    public function actualizarPerfil(Request $request)
    {
        $profesionista_id = session('user_id');
        $profesionista = Profesionista::findOrFail($profesionista_id);

        $data = $request->only([
            'nombres', 'apellido_p', 'apellido_m', 'genero', 
            'telefono', 'nivel_estudios', 'especializado', 
            'domicilio', 'cp'
        ]);

        // Actualizar contraseña si se proporciona
        if ($request->filled('contrasena')) {
            $data['contrasena'] = Hash::make($request->contrasena);
        }

        $profesionista->update($data);

        return redirect()->route('trabajador.dashboard')->with('success', 'Perfil actualizado exitosamente');
    }

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
            'calificacion_profesionista' => 0,
            'domicilio' => $request->domicilio,
            'cp' => $request->cp,
            'contrasena' => Hash::make($request->contrasena),
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