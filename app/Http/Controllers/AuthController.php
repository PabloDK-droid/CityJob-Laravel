<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required',
            'tipo' => 'required'
        ]);

        switch ($request->tipo) {
            case 'cliente':
                $usuario = DB::table('DimensionClientes')
                    ->where('correo_electronico', $request->correo)
                    ->first();
                $idCampo = 'id_cliente';
                break;

            case 'profesionista':
                $usuario = DB::table('DimensionProfesionistas')
                    ->where('correo_electronico', $request->correo)
                    ->first();
                $idCampo = 'id_profesionista';
                break;

            case 'administrador':
                $usuario = DB::table('DimensionAdministradores')
                    ->where('correo_electronico', $request->correo)
                    ->first();
                $idCampo = 'id_administrador';
                break;

            case 'encargado':
                $usuario = DB::table('DimensionEncargados')
                    ->where('correo_electronico', $request->correo)
                    ->first();
                $idCampo = 'id_encargado';
                break;

            default:
                return response()->json(['error' => 'Tipo de usuario inválido'], 400);
        }

        if (!$usuario || !Hash::check($request->password, $usuario->contrasena)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        $token = Str::random(60);

        DB::table('tokens')->insert([
            'usuario_id' => $usuario->$idCampo,
            'tipo_usuario' => $request->tipo,
            'token' => hash('sha256', $token),
            'created_at' => now()
        ]);

        return response()->json([
            'token' => $token,
            'usuario_id' => $usuario->$idCampo,
            'tipo_usuario' => $request->tipo
        ]);
    }
}
