<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            'Plomería',
            'Electricidad',
            'Pintura de interiores',
            'Carpintería',
            'Jardinería',
            'Limpieza del hogar',
            'Herrería',
            'Albañilería',
            'Impermeabilización',
            'Instalación de pisos',
            'Cerrajería',
            'Control de plagas',
            'Reparación de electrodomésticos',
            'Reparación de computadoras',
            'Mudanzas',
        ];

        foreach ($servicios as $nombre) {
            // Evita duplicados si ya existen
            $existe = DB::table('DimensionServicios')
                ->where('nombre_servicio', $nombre)
                ->exists();

            if (!$existe) {
                DB::table('DimensionServicios')->insert([
                    'nombre_servicio' => $nombre,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }
    }
}