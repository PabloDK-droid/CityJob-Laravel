<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EncargadosSeeder extends Seeder
{
    public function run(): void
    {
        $encargados = [
            ['nombres' => 'Luis Enrique', 'apellido_p' => 'Ramírez',   'apellido_m' => 'Garza',       'genero' => 'M', 'telefono' => '5534567801', 'correo_electronico' => 'lramirez.ing@cityjob.mx'],
            ['nombres' => 'Andrea',       'apellido_p' => 'Torres',    'apellido_m' => 'Peñaloza',    'genero' => 'F', 'telefono' => '5534567802', 'correo_electronico' => 'atorres.ing@cityjob.mx'],
            ['nombres' => 'Marco Antonio','apellido_p' => 'Saldaña',   'apellido_m' => 'Cruz',        'genero' => 'M', 'telefono' => '5534567803', 'correo_electronico' => 'msaldana.ing@cityjob.mx'],
            ['nombres' => 'Karla',        'apellido_p' => 'Mendívil',  'apellido_m' => 'Rosas',       'genero' => 'F', 'telefono' => '5534567804', 'correo_electronico' => 'kmendivil.ing@cityjob.mx'],
            ['nombres' => 'Rodrigo',      'apellido_p' => 'Espinosa',  'apellido_m' => 'Villafuerte', 'genero' => 'M', 'telefono' => '5534567805', 'correo_electronico' => 'respinosa.ing@cityjob.mx'],
        ];

        foreach ($encargados as $e) {
            DB::table('DimensionEncargados')->insert([
                'nombres'            => $e['nombres'],
                'apellido_p'         => $e['apellido_p'],
                'apellido_m'         => $e['apellido_m'],
                'genero'             => $e['genero'],
                'telefono'           => $e['telefono'],
                'correo_electronico' => $e['correo_electronico'],
                'contrasena'         => Hash::make('paso123'),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }
    }
}