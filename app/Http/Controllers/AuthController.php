<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $correo = $request->input('email');
        $password = $request->input('password');

        $user = DB::table('DimensionClientes')->where('correo_electronico', $correo)->first();
        if ($user && Hash::check($password, $user->contrasena)) {
            $this->setSession($user->id_cliente, 'cliente', $user->nombres);
            return redirect('/cliente');
        }

        $user = DB::table('DimensionProfesionistas')->where('correo_electronico', $correo)->first();
        if ($user && Hash::check($password, $user->contrasena)) {
            $this->setSession($user->id_profesionista, 'trabajador', $user->nombres);
            return redirect('/trabajador');
        }

        $user = DB::table('DimensionAdministradores')->where('correo_electronico', $correo)->first();
        if ($user && Hash::check($password, $user->contrasena)) {
            $this->setSession($user->id_administrador, 'admin', $user->nombres);
            return redirect('/admin');
        }

        $user = DB::table('DimensionEncargados')->where('correo_electronico', $correo)->first();
        if ($user && Hash::check($password, $user->contrasena)) {
            $this->setSession($user->id_encargado, 'ingeniero', $user->nombres);
            return redirect('/ingeniero');
        }
        return back()->withErrors(['email' => 'Estas credenciales no coinciden con nuestros registros.']);
    }

    private function setSession($id, $role, $name)
    {
        Session::put('user_id', $id);
        Session::put('role', $role);
        Session::put('user_name', $name);
    }

    public function logout()
    {
        Session::flush();
        return redirect('/')->with('success', 'Sesión cerrada correctamente');
    }
}