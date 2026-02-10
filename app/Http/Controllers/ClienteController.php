<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Profesionista;
use App\Models\Contratacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    // Mostrar dashboard principal del cliente
    public function dashboard()
    {
        $cliente_id = session('user_id');
        $cliente = Cliente::findOrFail($cliente_id);
        
        return view('cliente.dashboard', compact('cliente'));
    }

    // Mostrar catálogo de servicios
    public function catalogoServicios()
    {
        $servicios = Servicio::withCount('contrataciones')->get();
        return view('cliente.catalogo', compact('servicios'));
    }

    // Mostrar profesionistas por servicio
    public function profesionistasServicio($id_servicio)
    {
        $servicio = Servicio::findOrFail($id_servicio);
        $profesionistas = Profesionista::where('especializado', $servicio->nombre_servicio)
            ->orWhere('especializado', 'LIKE', '%' . $servicio->nombre_servicio . '%')
            ->get();
        
        return view('cliente.profesionistas', compact('servicio', 'profesionistas'));
    }

    // Crear contratación
    public function contratar(Request $request)
    {
        $cliente_id = session('user_id');
        $cliente = Cliente::findOrFail($cliente_id);

        $contratacion = Contratacion::create([
            'id_cliente' => $cliente_id,
            'id_profesionista' => $request->id_profesionista,
            'id_servicio' => $request->id_servicio,
            'nombres_emitor' => $cliente->nombres . ' ' . $cliente->apellido_p,
            'estado_emitor' => true,
            'localizacion' => $request->localizacion,
            'fecha_realizacion' => now(),
        ]);

        return redirect()->route('cliente.misContrataciones')->with('success', 'Servicio contratado exitosamente');
    }

    // Ver mis contrataciones
    public function misContrataciones()
    {
        $cliente_id = session('user_id');
        $contrataciones = Contratacion::with(['profesionista', 'servicio'])
            ->where('id_cliente', $cliente_id)
            ->orderBy('fecha_realizacion', 'desc')
            ->get();
        
        return view('cliente.mis_contrataciones', compact('contrataciones'));
    }

    // Mostrar formulario de edición de perfil
    public function editarPerfil()
    {
        $cliente_id = session('user_id');
        $cliente = Cliente::findOrFail($cliente_id);
        
        return view('cliente.editar_perfil', compact('cliente'));
    }

    // Actualizar perfil del cliente
    public function actualizarPerfil(Request $request)
    {
        $cliente_id = session('user_id');
        $cliente = Cliente::findOrFail($cliente_id);

        $data = $request->only([
            'nombres', 'apellido_p', 'apellido_m', 'genero', 
            'telefono', 'telefono_fijo', 'cp', 'domicilio', 'referencias'
        ]);

        // Actualizar contraseña si se proporciona
        if ($request->filled('contrasena')) {
            $data['contrasena'] = Hash::make($request->contrasena);
        }

        $cliente->update($data);

        return redirect()->route('cliente.dashboard')->with('success', 'Perfil actualizado exitosamente');
    }

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
            'contrasena' => Hash::make($request->contrasena)
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