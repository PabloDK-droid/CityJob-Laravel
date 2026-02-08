<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $rol = $request->input('rol');
        $password = Hash::make($request->input('contrasena'));

        if ($rol === 'cliente') {
            DB::table('DimensionClientes')->insert([
                'nombres' => $request->nombres,
                'apellido_p' => $request->apellido_p,
                'apellido_m' => $request->apellido_m,
                'genero' => $request->genero,
                'telefono' => $request->telefono,
                'correo_electronico' => $request->correo_electronico,
                'cp' => $request->cp,
                'domicilio' => $request->domicilio,
                'referencias' => $request->referencias,
                'contrasena' => $password
            ]);
            return redirect('/')->with('success', 'Cliente registrado');
        }

        if ($rol === 'trabajador') {
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
            return redirect('/')->with('success', 'Profesionista registrado');
        }

        return back()->withErrors('Rol no válido');
    }
}