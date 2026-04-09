<?php

namespace App\Http\Controllers;

use App\Models\Profesionista;
use App\Models\Contratacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfesionistaController extends Controller
{
    public function dashboard()
    {
        $profesionista_id = session('user_id');
        $profesionista = Profesionista::findOrFail($profesionista_id);
        return view('trabajador.dashboard', compact('profesionista'));
    }

    public function serviciosAsignados()
    {
        $profesionista_id = session('user_id');
        $contrataciones = Contratacion::with(['cliente', 'servicio'])
            ->where('id_profesionista', $profesionista_id)
            ->where('estado_emitor', true)
            ->where('estado_trabajador', 'aceptado')
            ->whereIn('estado', ['activo', 'completado', 'pago_pendiente'])  
            ->orderBy('fecha_realizacion', 'desc')
            ->get();
        return view('trabajador.servicios_asignados', compact('contrataciones'));
    }

    public function detalleServicio($id)
    {
        $profesionista_id = session('user_id');
        $contratacion = Contratacion::with(['cliente', 'servicio'])
            ->where('id_profesionista', $profesionista_id)
            ->where('id_contratacion', $id)
            ->firstOrFail();
        return view('trabajador.detalle_servicio', compact('contratacion'));
    }

    public function editarPerfil()
    {
        $profesionista_id = session('user_id');
        $profesionista = Profesionista::findOrFail($profesionista_id);
        return view('trabajador.editar_perfil', compact('profesionista'));
    }

    public function actualizarPerfil(Request $request)
    {
        $profesionista_id = session('user_id');
        $profesionista = Profesionista::findOrFail($profesionista_id);

        $data = $request->only([
            'nombres', 'apellido_p', 'apellido_m', 'genero',
            'telefono', 'nivel_estudios', 'especializado',
            'domicilio', 'cp'
        ]);

        if ($request->filled('contrasena')) {
            $data['contrasena'] = Hash::make($request->contrasena);
        }

        $profesionista->update($data);
        return redirect()->route('trabajador.dashboard')->with('success', 'Perfil actualizado exitosamente');
    }

    public function index()
    {
        $profesionistas = Profesionista::all();
        return response()->json($profesionistas);
    }

    public function store(Request $request)
    {
        $nuevoProfesionista = Profesionista::create([
            'nombres'                   => $request->nombres,
            'apellido_p'                => $request->apellido_p,
            'apellido_m'                => $request->apellido_m,
            'genero'                    => $request->genero,
            'telefono'                  => $request->telefono,
            'correo_electronico'        => $request->correo_electronico,
            'nivel_estudios'            => $request->nivel_estudios,
            'especializado'             => $request->especializado,
            'calificacion_profesionista'=> 0,
            'domicilio'                 => $request->domicilio,
            'cp'                        => $request->cp,
            'contrasena'                => Hash::make($request->contrasena),
        ]);

        return response()->json(['mensaje' => 'Profesionista registrado con éxito', 'data' => $nuevoProfesionista], 201);
    }

    public function show($id)
    {
        $profesionista = Profesionista::with('contrataciones')->find($id);
        if (!$profesionista) {
            return response()->json(['error' => 'No se encontró al trabajador'], 404);
        }
        return response()->json($profesionista);
    }

    public function completarServicio($id)
    {
        $profesionista_id = session('user_id');

        $contratacion = Contratacion::with(['servicio'])
            ->where('id_contratacion', $id)
            ->where('id_profesionista', $profesionista_id)
            ->firstOrFail();

        $contratacion->estado = 'completado';
        $contratacion->save();

        $hecho = \App\Models\HechoContratacion::where('id_contratacion', $id)->first();

        if ($hecho) {
            \App\Models\Historial::create([
                'id_factura'      => $hecho->id_factura,
                'id_contratacion' => $id,
                'fecha_factura'   => now(),
                'monto'           => $hecho->monto_total,
                'hora'            => now()->format('H:i:s'),
            ]);
        }

        return redirect()->route('trabajador.serviciosAsignados')
            ->with('success', 'Servicio marcado como completado.');
    }

    public function peticionesPendientes()
    {
        $profesionista_id = session('user_id');
        $peticiones = Contratacion::with(['cliente', 'servicio'])
            ->where('id_profesionista', $profesionista_id)
            ->where('estado_emitor', true)
            ->where('estado_trabajador', 'pendiente')
            ->orderBy('fecha_realizacion', 'desc')
            ->get();
        return view('trabajador.peticiones_pendientes', compact('peticiones'));
    }

    public function aceptarTrabajo(Request $request, $id)
    {
        $profesionista_id = session('user_id');

        $request->validate([
            'monto_propuesto' => 'required|numeric|min:1',
        ], [
            'monto_propuesto.required' => 'Debes ingresar el monto del servicio.',
            'monto_propuesto.numeric'  => 'El monto debe ser un número válido.',
            'monto_propuesto.min'      => 'El monto debe ser mayor a 0.',
        ]);

        $contratacion = Contratacion::where('id_contratacion', $id)
            ->where('id_profesionista', $profesionista_id)
            ->where('estado_trabajador', 'pendiente')
            ->firstOrFail();

        $contratacion->estado_trabajador = 'aceptado';
        $contratacion->estado            = 'pago_pendiente';
        $contratacion->monto_acordado    = $request->monto_propuesto;
        $contratacion->save();

        return redirect()->route('trabajador.peticionesPendientes')
            ->with('success', 'Trabajo aceptado. Se notificó al cliente con el monto propuesto.');
    }

    public function rechazarTrabajo($id)
    {
        $profesionista_id = session('user_id');

        $contratacion = Contratacion::where('id_contratacion', $id)
            ->where('id_profesionista', $profesionista_id)
            ->where('estado_trabajador', 'pendiente')
            ->firstOrFail();

        $contratacion->estado_trabajador = 'rechazado';
        $contratacion->estado = 'cancelado';
        $contratacion->save();

        return redirect()->route('trabajador.peticionesPendientes')
            ->with('success', 'Trabajo rechazado correctamente.');
    }
}