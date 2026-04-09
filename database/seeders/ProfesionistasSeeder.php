<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfesionistasSeeder extends Seeder
{
    public function run(): void
    {
        $profesionistas = [
            ['nombres' => 'Juan Carlos', 'apellido_p' => 'Mendoza', 'apellido_m' => 'Ríos', 'genero' => 'M', 'telefono' => '5523456701', 'correo_electronico' => 'jcmendoza@gmail.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Plomería', 'calificacion' => 4.8, 'domicilio' => 'Calle Moctezuma 12, Col. Tepito, CDMX', 'cp' => 6900],
            ['nombres' => 'Pedro Antonio', 'apellido_p' => 'Fuentes', 'apellido_m' => 'Castillo', 'genero' => 'M', 'telefono' => '5523456702', 'correo_electronico' => 'pafuentes@gmail.com', 'nivel_estudios' => 'Bachillerato', 'especializado' => 'Electricidad', 'calificacion' => 4.5, 'domicilio' => 'Av. Politécnico 340, Col. Zacatenco, CDMX', 'cp' => 7360],
            ['nombres' => 'Laura Elena', 'apellido_p' => 'Vásquez', 'apellido_m' => 'Mora', 'genero' => 'F', 'telefono' => '5523456703', 'correo_electronico' => 'levasquez@hotmail.com', 'nivel_estudios' => 'Licenciatura', 'especializado' => 'Diseño de interiores', 'calificacion' => 4.9, 'domicilio' => 'Av. Sonora 78, Col. Hipódromo, CDMX', 'cp' => 6100],
            ['nombres' => 'Raúl', 'apellido_p' => 'Cisneros', 'apellido_m' => 'Ponce', 'genero' => 'M', 'telefono' => '5523456704', 'correo_electronico' => 'rcisneros@gmail.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Pintura de interiores', 'calificacion' => 4.3, 'domicilio' => 'Calle Nogal 22, Col. Santa María la Ribera, CDMX', 'cp' => 6400],
            ['nombres' => 'Gloria Inés', 'apellido_p' => 'Paredes', 'apellido_m' => 'Lozano', 'genero' => 'F', 'telefono' => '5523456705', 'correo_electronico' => 'giparedes@gmail.com', 'nivel_estudios' => 'Licenciatura', 'especializado' => 'Limpieza del hogar', 'calificacion' => 4.7, 'domicilio' => 'Calle Camelia 9, Col. Guerrero, CDMX', 'cp' => 6300],
            ['nombres' => 'Ernesto', 'apellido_p' => 'Villanueva', 'apellido_m' => 'Ibarra', 'genero' => 'M', 'telefono' => '5523456706', 'correo_electronico' => 'evillanueva@yahoo.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Carpintería', 'calificacion' => 4.6, 'domicilio' => 'Av. Aquiles Serdán 500, Col. Vallejo, CDMX', 'cp' => 7870],
            ['nombres' => 'Marisol', 'apellido_p' => 'Ángeles', 'apellido_m' => 'Trejo', 'genero' => 'F', 'telefono' => '5523456707', 'correo_electronico' => 'mangeles@gmail.com', 'nivel_estudios' => 'Bachillerato', 'especializado' => 'Jardinería', 'calificacion' => 4.4, 'domicilio' => 'Calle Puebla 115, Col. Roma Norte, CDMX', 'cp' => 6700],
            ['nombres' => 'Benjamín', 'apellido_p' => 'Orozco', 'apellido_m' => 'Salinas', 'genero' => 'M', 'telefono' => '5523456708', 'correo_electronico' => 'borozco@gmail.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Herrería', 'calificacion' => 4.2, 'domicilio' => 'Calle Ferrocarril 88, Col. Doctores, CDMX', 'cp' => 6720],
            ['nombres' => 'Adriana', 'apellido_p' => 'Bustamante', 'apellido_m' => 'Nava', 'genero' => 'F', 'telefono' => '5523456709', 'correo_electronico' => 'abustamante@outlook.com', 'nivel_estudios' => 'Licenciatura', 'especializado' => 'Fotografía', 'calificacion' => 4.8, 'domicilio' => 'Av. Michoacán 300, Col. Condesa, CDMX', 'cp' => 6140],
            ['nombres' => 'Sergio', 'apellido_p' => 'Tapia', 'apellido_m' => 'Montes', 'genero' => 'M', 'telefono' => '5523456710', 'correo_electronico' => 'stapia@gmail.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Reparación de electrodomésticos', 'calificacion' => 4.5, 'domicilio' => 'Calle Oriente 59 No. 3012, Col. Jardín Balbuena, CDMX', 'cp' => 15900],
            ['nombres' => 'Patricia', 'apellido_p' => 'Guzmán', 'apellido_m' => 'Acosta', 'genero' => 'F', 'telefono' => '5523456711', 'correo_electronico' => 'pguzman@gmail.com', 'nivel_estudios' => 'Licenciatura', 'especializado' => 'Clases particulares', 'calificacion' => 4.9, 'domicilio' => 'Av. Copilco 120, Col. Copilco Universidad, CDMX', 'cp' => 4360],
            ['nombres' => 'Óscar', 'apellido_p' => 'Becerra', 'apellido_m' => 'Zamora', 'genero' => 'M', 'telefono' => '5523456712', 'correo_electronico' => 'obecerra@hotmail.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Albañilería', 'calificacion' => 4.1, 'domicilio' => 'Calle Amado Nervo 34, Col. Peralvillo, CDMX', 'cp' => 6200],
            ['nombres' => 'Claudia', 'apellido_p' => 'Mena', 'apellido_m' => 'Quiroz', 'genero' => 'F', 'telefono' => '5523456713', 'correo_electronico' => 'cmena@gmail.com', 'nivel_estudios' => 'Licenciatura', 'especializado' => 'Cuidado de adultos mayores', 'calificacion' => 4.7, 'domicilio' => 'Calle Río Elba 67, Col. Cuauhtémoc, CDMX', 'cp' => 6500],
            ['nombres' => 'Ignacio', 'apellido_p' => 'Soto', 'apellido_m' => 'Palacios', 'genero' => 'M', 'telefono' => '5523456714', 'correo_electronico' => 'isoto@gmail.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Impermeabilización', 'calificacion' => 4.3, 'domicilio' => 'Av. Xola 890, Col. Narvarte Poniente, CDMX', 'cp' => 3020],
            ['nombres' => 'Verónica', 'apellido_p' => 'Alvarado', 'apellido_m' => 'Bravo', 'genero' => 'F', 'telefono' => '5523456715', 'correo_electronico' => 'valvarado@gmail.com', 'nivel_estudios' => 'Bachillerato', 'especializado' => 'Costura y sastrería', 'calificacion' => 4.6, 'domicilio' => 'Calle Mesones 22, Col. Centro Histórico, CDMX', 'cp' => 6060],
            ['nombres' => 'Manuel', 'apellido_p' => 'Pedraza', 'apellido_m' => 'Esquivel', 'genero' => 'M', 'telefono' => '5523456716', 'correo_electronico' => 'mpedraza@yahoo.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Instalación de pisos', 'calificacion' => 4.4, 'domicilio' => 'Calle Toltecas 77, Col. San Álvaro, CDMX', 'cp' => 2090],
            ['nombres' => 'Ximena', 'apellido_p' => 'Coronel', 'apellido_m' => 'Valdés', 'genero' => 'F', 'telefono' => '5523456717', 'correo_electronico' => 'xcoronel@gmail.com', 'nivel_estudios' => 'Licenciatura', 'especializado' => 'Nutrición y dieta', 'calificacion' => 4.8, 'domicilio' => 'Av. Insurgentes Norte 1200, Col. Tlatelolco, CDMX', 'cp' => 6900],
            ['nombres' => 'Armando', 'apellido_p' => 'Palma', 'apellido_m' => 'Espino', 'genero' => 'M', 'telefono' => '5523456718', 'correo_electronico' => 'apalma@gmail.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Cerrajería', 'calificacion' => 4.5, 'domicilio' => 'Calle Victoria 14, Col. Centro, CDMX', 'cp' => 6050],
            ['nombres' => 'Rebeca', 'apellido_p' => 'Duarte', 'apellido_m' => 'Magaña', 'genero' => 'F', 'telefono' => '5523456719', 'correo_electronico' => 'rduarte@outlook.com', 'nivel_estudios' => 'Licenciatura', 'especializado' => 'Psicología', 'calificacion' => 4.9, 'domicilio' => 'Calle Orizaba 88, Col. Roma Sur, CDMX', 'cp' => 6760],
            ['nombres' => 'Tomás', 'apellido_p' => 'Ávila', 'apellido_m' => 'Serrato', 'genero' => 'M', 'telefono' => '5523456720', 'correo_electronico' => 'tavila@gmail.com', 'nivel_estudios' => 'Bachillerato', 'especializado' => 'Mudanzas', 'calificacion' => 4.2, 'domicilio' => 'Av. Canal de San Juan 430, Col. Puebla, CDMX', 'cp' => 8260],
            ['nombres' => 'Norma', 'apellido_p' => 'Leal', 'apellido_m' => 'Sandoval', 'genero' => 'F', 'telefono' => '5523456721', 'correo_electronico' => 'nleal@gmail.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Estética y belleza', 'calificacion' => 4.7, 'domicilio' => 'Calle Magnolia 5, Col. Santa María la Ribera, CDMX', 'cp' => 6400],
            ['nombres' => 'Francisco', 'apellido_p' => 'Montoya', 'apellido_m' => 'Quiroga', 'genero' => 'M', 'telefono' => '5523456722', 'correo_electronico' => 'fmontoya@gmail.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Reparación de computadoras', 'calificacion' => 4.6, 'domicilio' => 'Av. Texcoco 660, Col. Pantitlán, CDMX', 'cp' => 8100],
            ['nombres' => 'Silvia', 'apellido_p' => 'Cabrera', 'apellido_m' => 'Lara', 'genero' => 'F', 'telefono' => '5523456723', 'correo_electronico' => 'scabrera@hotmail.com', 'nivel_estudios' => 'Licenciatura', 'especializado' => 'Contabilidad', 'calificacion' => 4.8, 'domicilio' => 'Av. Cuauhtémoc 800, Col. Narvarte, CDMX', 'cp' => 3020],
            ['nombres' => 'Gerardo', 'apellido_p' => 'Peña', 'apellido_m' => 'Hurtado', 'genero' => 'M', 'telefono' => '5523456724', 'correo_electronico' => 'gpena@gmail.com', 'nivel_estudios' => 'Técnico', 'especializado' => 'Control de plagas', 'calificacion' => 4.4, 'domicilio' => 'Calle Mármol 33, Col. Escandón, CDMX', 'cp' => 11800],
            ['nombres' => 'Diana', 'apellido_p' => 'Rangel', 'apellido_m' => 'Solano', 'genero' => 'F', 'telefono' => '5523456725', 'correo_electronico' => 'drangel@gmail.com', 'nivel_estudios' => 'Licenciatura', 'especializado' => 'Paseadora de mascotas', 'calificacion' => 4.9, 'domicilio' => 'Calle Tamaulipas 45, Col. Condesa, CDMX', 'cp' => 6140],
        ];

        foreach ($profesionistas as $p) {
            DB::table('DimensionProfesionistas')->insert([
                'nombres'                   => $p['nombres'],
                'apellido_p'                => $p['apellido_p'],
                'apellido_m'                => $p['apellido_m'],
                'genero'                    => $p['genero'],
                'telefono'                  => $p['telefono'],
                'correo_electronico'        => $p['correo_electronico'],
                'nivel_estudios'            => $p['nivel_estudios'],
                'especializado'             => $p['especializado'],
                'calificacion_profesionista'=> $p['calificacion'],
                'domicilio'                 => $p['domicilio'],
                'cp'                        => $p['cp'],
                'contrasena'                => Hash::make('paso123'),
                'created_at'                => now(),
                'updated_at'                => now(),
            ]);
        }
    }
}