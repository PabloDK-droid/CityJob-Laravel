<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'rol' => 'required|in:cliente,trabajador',
            'nombres' => 'required|string|max:30',
            'apellido_p' => 'required|string|max:30',
            'apellido_m' => 'nullable|string|max:30',
            'genero' => 'required|in:M,F',
            'telefono' => 'required|string|max:12',
            'telefono_fijo' => 'nullable|string|max:12',
            'correo_electronico' => 'required|email|unique:DimensionClientes,correo_electronico|unique:DimensionProfesionistas,correo_electronico',
            'cp' => 'required|integer',
            'domicilio' => 'required|string|max:80',
            'contrasena' => 'required|string|min:6',
        ]);

        $rol = $request->input('rol');
        $password = Hash::make($request->input('contrasena'));

        if ($rol === 'cliente') {
            DB::table('DimensionClientes')->insert([
                'nombres' => $request->nombres,
                'apellido_p' => $request->apellido_p,
                'apellido_m' => $request->apellido_m,
                'genero' => $request->genero,
                'telefono' => $request->telefono,
                'telefono_fijo' => $request->telefono_fijo,
                'correo_electronico' => $request->correo_electronico,
                'cp' => $request->cp,
                'domicilio' => $request->domicilio,
                'referencias' => $request->referencias,
                'contrasena' => $password
            ]);
            return redirect('/')->with('success', 'Cliente registrado exitosamente');
        }

        if ($rol === 'trabajador') {
            $request->validate([
                'nivel_estudios' => 'required|string|max:30',
                'especializado' => 'required|string|max:40',
            ]);

            DB::table('DimensionProfesionistas')->insert([
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
                'contrasena' => $password
            ]);
            return redirect('/')->with('success', 'Profesionista registrado exitosamente');
        }

        return back()->withErrors('Rol no válido');
    }
}