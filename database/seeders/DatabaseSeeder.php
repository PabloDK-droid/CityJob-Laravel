<?php

namespace Database\Seeders;

use App\Models\Encargado;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServiciosSeeder::class,
            ClientesSeeder::class,
            ProfesionistasSeeder::class,
            EncargadosSeeder::class,
        ]);
    }
}