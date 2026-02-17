<?php

namespace App\Http\Controllers;

use App\Models\Profesionista;
use App\Models\Cliente;
use App\Models\Administrador;
use App\Models\Encargado;
use App\Models\Servicio;
use App\Models\Contratacion;
use App\Models\HechoContratacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Dashboard principal del admin
    public function dashboard()
    {
        $stats = [
            'total_clientes' => Cliente::count(),
            'total_profesionistas' => Profesionista::count(),
            'total_servicios' => Servicio::count(),
            'total_contrataciones' => Contratacion::count(),
            'total_recaudado' => HechoContratacion::sum('monto_total'),
            'comisiones_plataforma' => HechoContratacion::sum('comision_plataforma'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // === GESTIÓN DE USUARIOS ===
    
    // Listar todos los usuarios
    public function usuarios()
    {
        $clientes = Cliente::all();
        $profesionistas = Profesionista::all();
        $administradores = Administrador::all();
        $encargados = Encargado::all();

        return view('admin.usuarios', compact('clientes', 'profesionistas', 'administradores', 'encargados'));
    }

    // Cambiar rol de usuario
    public function cambiarRol(Request $request)
    {
        $usuario_id = $request->usuario_id;
        $rol_actual = $request->rol_actual;
        $rol_nuevo = $request->rol_nuevo;

        // Obtener datos del usuario según su rol actual
        $usuario = null;
        $tabla_actual = '';
        
        switch($rol_actual) {
            case 'cliente':
                $usuario = Cliente::find($usuario_id);
                $tabla_actual = 'DimensionClientes';
                break;
            case 'trabajador':
                $usuario = Profesionista::find($usuario_id);
                $tabla_actual = 'DimensionProfesionistas';
                break;
            case 'admin':
                $usuario = Administrador::find($usuario_id);
                $tabla_actual = 'DimensionAdministradores';
                break;
            case 'ingeniero':
                $usuario = Encargado::find($usuario_id);
                $tabla_actual = 'DimensionEncargados';
                break;
        }

        if (!$usuario) {
            return back()->withErrors(['error' => 'Usuario no encontrado']);
        }

        // Crear usuario en la nueva tabla según el rol nuevo
        $data_base = [
            'nombres' => $usuario->nombres,
            'apellido_p' => $usuario->apellido_p,
            'apellido_m' => $usuario->apellido_m,
            'genero' => $usuario->genero,
            'telefono' => $usuario->telefono,
            'correo_electronico' => $usuario->correo_electronico,
            'contrasena' => $usuario->contrasena,
        ];

        switch($rol_nuevo) {
            case 'cliente':
                Cliente::create(array_merge($data_base, [
                    'cp' => $usuario->cp ?? 0,
                    'domicilio' => $usuario->domicilio ?? 'Sin domicilio',
                    'referencias' => $usuario->referencias ?? ''
                ]));
                break;
            case 'trabajador':
                Profesionista::create(array_merge($data_base, [
                    'nivel_estudios' => $usuario->nivel_estudios ?? 'No especificado',
                    'especializado' => $usuario->especializado ?? 'General',
                    'calificacion_profesionista' => 0,
                    'domicilio' => $usuario->domicilio ?? 'Sin domicilio',
                    'cp' => $usuario->cp ?? 0
                ]));
                break;
            case 'admin':
                Administrador::create($data_base);
                break;
            case 'ingeniero':
                Encargado::create($data_base);
                break;
        }

        // Eliminar de la tabla anterior
        $usuario->delete();

        return redirect()->route('admin.usuarios')->with('success', 'Rol cambiado exitosamente');
    }

    // Eliminar usuario
    public function eliminarUsuario(Request $request)
    {
        $usuario_id = $request->usuario_id;
        $rol = $request->rol;

        switch($rol) {
            case 'cliente':
                Cliente::find($usuario_id)->delete();
                break;
            case 'trabajador':
                Profesionista::find($usuario_id)->delete();
                break;
            case 'admin':
                Administrador::find($usuario_id)->delete();
                break;
            case 'ingeniero':
                Encargado::find($usuario_id)->delete();
                break;
        }

        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado exitosamente');
    }

    // === GESTIÓN DE SERVICIOS ===

    // Listar todos los servicios
    public function servicios()
    {
        $servicios = Servicio::withCount('contrataciones')->get();
        return view('admin.servicios', compact('servicios'));
    }

    // Crear nuevo servicio
    public function crearServicio(Request $request)
    {
        $request->validate([
            'nombre_servicio' => 'required|string|max:30',
            'precio_base' => 'required|numeric|min:0'
        ]);
        Servicio::create([
            'nombre_servicio' => $request->nombre_servicio,
            'precio_base' => $request->precio_base
        ]);
        return redirect()->route('admin.servicios')->with('success', 'Servicio creado exitosamente');
    }

    // Actualizar servicio CON PRECIO
    public function actualizarServicio(Request $request, $id)
    {
        $request->validate([
            'nombre_servicio' => 'required|string|max:30',
            'precio_base' => 'required|numeric|min:0'
        ]);
        $servicio = Servicio::findOrFail($id);
        $servicio->update([
            'nombre_servicio' => $request->nombre_servicio,
            'precio_base' => $request->precio_base
        ]);
        return redirect()->route('admin.servicios')->with('success', 'Servicio actualizado exitosamente');
    }

    // Eliminar servicio
    public function eliminarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return redirect()->route('admin.servicios')->with('success', 'Servicio eliminado exitosamente');
    }

    // === CONTRATACIONES Y REPORTES ===

    // Ver todas las contrataciones
    public function contrataciones()
    {
        $contrataciones = Contratacion::with(['cliente', 'profesionista', 'servicio'])
            ->orderBy('fecha_realizacion', 'desc')
            ->get();

        return view('admin.contrataciones', compact('contrataciones'));
    }

    // Obtener métricas generales de la tabla de Hechos
    public function getGlobalStats()
    {
        $stats = [
            'total_recaudado' => HechoContratacion::sum('monto_total'),
            'comisiones_plataforma' => HechoContratacion::sum('comision_plataforma'),
            'total_servicios' => HechoContratacion::count()
        ];
        return response()->json($stats);
    }

    // Función para "Descargar Datos" o reportes
// Descargar reportes en CSV
public function downloadLogs()
{
    $contrataciones = Contratacion::with(['cliente', 'profesionista', 'servicio'])
        ->orderBy('fecha_realizacion', 'desc')
        ->get();

    $filename = 'reporte_contrataciones_' . now()->format('Y-m-d_His') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function() use ($contrataciones) {
        $file = fopen('php://output', 'w');
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Encabezados
        fputcsv($file, [
            'ID',
            'Cliente',
            'Profesionista',
            'Servicio',
            'Monto',
            'Estado',
            'Ubicación',
            'Fecha'
        ]);
        
        // Datos
        foreach ($contrataciones as $c) {
            fputcsv($file, [
                $c->id_contratacion,
                $c->cliente->nombres . ' ' . $c->cliente->apellido_p,
                $c->profesionista->nombres . ' ' . $c->profesionista->apellido_p,
                $c->servicio->nombre_servicio,
                '$' . number_format($c->monto_acordado, 2),
                ucfirst($c->estado),
                $c->localizacion,
                $c->fecha_realizacion
            ]);
        }
        
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

    // Registrar trabajadores desde el panel administrativo
    public function registerWorker(Request $request)
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

        return redirect()->route('admin.usuarios')->with('success', 'Trabajador registrado exitosamente');
    }
}