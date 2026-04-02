<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rol'                  => 'required|in:cliente,trabajador',
            'nombres'              => 'required|string|max:30',
            'apellido_p'           => 'required|string|max:30',
            'apellido_m'           => 'nullable|string|max:30',
            'genero'               => 'required|in:M,F',
            'telefono'             => 'required|regex:/^[0-9]+$/|digits_between:10,12',
            'telefono_fijo'        => 'nullable|regex:/^[0-9]+$/|digits_between:10,12',
            'correo_electronico'   => 'required|email|unique:DimensionClientes,correo_electronico|unique:DimensionProfesionistas,correo_electronico',
            'cp'                   => 'required|integer|digits:5',
            'domicilio'            => 'required|string|max:80',
            'contrasena'           => 'required|string|min:6|confirmed',
            'acepta_terminos'      => 'accepted',
        ], [
            'rol.required'                => 'Debes seleccionar un tipo de cuenta.',
            'nombres.required'            => 'El nombre es obligatorio.',
            'nombres.max'                 => 'El nombre no puede superar 30 caracteres.',
            'apellido_p.required'         => 'El apellido paterno es obligatorio.',
            'genero.required'             => 'El género es obligatorio.',
            'telefono.required'           => 'El teléfono es obligatorio.',
            'telefono.regex'              => 'El teléfono solo puede contener números.',
            'telefono.digits_between'     => 'El teléfono debe tener entre 10 y 12 dígitos.',
            'telefono_fijo.regex'         => 'El teléfono fijo solo puede contener números.',
            'telefono_fijo.digits_between'=> 'El teléfono fijo debe tener entre 10 y 12 dígitos.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email'    => 'Ingresa un correo electrónico válido.',
            'correo_electronico.unique'   => 'Este correo ya está registrado en la plataforma.',
            'cp.required'                 => 'El código postal es obligatorio.',
            'cp.digits'                   => 'El código postal debe tener exactamente 5 dígitos.',
            'domicilio.required'          => 'El domicilio es obligatorio.',
            'contrasena.required'         => 'La contraseña es obligatoria.',
            'contrasena.min'              => 'La contraseña debe tener al menos 6 caracteres.',
            'contrasena.confirmed'        => 'Las contraseñas no coinciden.',
            'acepta_terminos.accepted'    => 'Debes aceptar los Términos y Condiciones y el Aviso de Privacidad.',
        ]);

        $rol      = $request->input('rol');
        $password = Hash::make($request->input('contrasena'));

        if ($rol === 'cliente') {
            DB::table('DimensionClientes')->insert([
                'nombres'            => $request->nombres,
                'apellido_p'         => $request->apellido_p,
                'apellido_m'         => $request->apellido_m,
                'genero'             => $request->genero,
                'telefono'           => $request->telefono,
                'telefono_fijo'      => $request->telefono_fijo,
                'correo_electronico' => $request->correo_electronico,
                'cp'                 => $request->cp,
                'domicilio'          => $request->domicilio,
                'referencias'        => $request->referencias,
                'contrasena'         => $password,
            ]);
            return redirect('/')->with('success', 'Cliente registrado exitosamente');
        }

        if ($rol === 'trabajador') {
            $request->validate([
                'nivel_estudios' => 'required|string|max:30',
                'especializado'  => 'required|string|max:40',
            ], [
                'nivel_estudios.required' => 'El nivel de estudios es obligatorio para profesionistas.',
                'especializado.required'  => 'La especialidad es obligatoria para profesionistas.',
            ]);

            DB::table('DimensionProfesionistas')->insert([
                'nombres'                    => $request->nombres,
                'apellido_p'                 => $request->apellido_p,
                'apellido_m'                 => $request->apellido_m,
                'genero'                     => $request->genero,
                'telefono'                   => $request->telefono,
                'correo_electronico'         => $request->correo_electronico,
                'nivel_estudios'             => $request->nivel_estudios,
                'especializado'              => $request->especializado,
                'calificacion_profesionista' => 0,
                'domicilio'                  => $request->domicilio,
                'cp'                         => $request->cp,
                'contrasena'                 => $password,
            ]);
            return redirect('/')->with('success', 'Profesionista registrado exitosamente');
        }

        return back()->withErrors(['rol' => 'Rol no válido']);
    }
}