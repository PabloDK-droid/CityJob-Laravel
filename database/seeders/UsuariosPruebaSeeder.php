<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosPruebaSeeder extends Seeder
{
    public function run()
    {
        // 1. Cliente: Basado en el equipo de "Integradora"
        DB::table('DimensionClientes')->insert([
            'nombres' => 'Jesus',
            'apellido_p' => 'Flores',
            'apellido_m' => 'Ambrosio',
            'genero' => 'M',
            'telefono' => '5512345678',
            'correo_electronico' => 'cliente@cityjob.com',
            'cp' => 55000,
            'domicilio' => 'Tecámac, Edo. Méx',
            'contrasena' => Hash::make('paso123'), // Cifrado Bcrypt obligatorio
        ]);

        // 2. Profesionista: Usando datos de especialización del proyecto
        DB::table('DimensionProfesionistas')->insert([
            'nombres' => 'Angie Carolina',
            'apellido_p' => 'Martinez',
            'apellido_m' => 'Cruz',
            'genero' => 'F',
            'telefono' => '5587654321',
            'correo_electronico' => 'worker@cityjob.com',
            'nivel_estudios' => 'Ingeniería',
            'especializado' => 'Desarrollo de Software',
            'calificacion_profesionista' => 5.0,
            'domicilio' => 'UTTEC Edificio C',
            'cp' => 55760,
            'contrasena' => Hash::make('paso123'),
        ]);

        // 3. Administrador
        DB::table('DimensionAdministradores')->insert([
            'nombres' => 'Pablo',
            'apellido_p' => 'Sánchez',
            'apellido_m' => 'Bustamante',
            'genero' => 'M',
            'telefono' => '5599887766',
            'correo_electronico' => 'admin@cityjob.com',
            'contrasena' => Hash::make('paso123'),
        ]);

        // 4. Encargado (Ingeniero)
        DB::table('DimensionEncargados')->insert([
            'nombres' => 'Jose Carlos',
            'apellido_p' => 'Gachuz',
            'apellido_m' => 'Allende',
            'genero' => 'M',
            'telefono' => '5511223344',
            'correo_electronico' => 'ing@cityjob.com',
            'contrasena' => Hash::make('paso123'),
        ]);
    }
}