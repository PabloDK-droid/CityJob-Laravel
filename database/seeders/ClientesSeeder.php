<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientesSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            ['nombres' => 'María Fernanda', 'apellido_p' => 'Ramírez', 'apellido_m' => 'Torres', 'genero' => 'F', 'telefono' => '5512345601', 'telefono_fijo' => '5556781201', 'correo_electronico' => 'mramirez@gmail.com', 'cp' => 6600, 'domicilio' => 'Av. Insurgentes Sur 1234, Col. Del Valle, CDMX', 'referencias' => 'Frente al parque'],
            ['nombres' => 'Carlos Alberto', 'apellido_p' => 'López', 'apellido_m' => 'Hernández', 'genero' => 'M', 'telefono' => '5512345602', 'telefono_fijo' => null, 'correo_electronico' => 'calopez@gmail.com', 'cp' => 3100, 'domicilio' => 'Calle Morelos 456, Col. Narvarte, CDMX', 'referencias' => 'Casa azul con reja negra'],
            ['nombres' => 'Ana Luisa', 'apellido_p' => 'Martínez', 'apellido_m' => 'García', 'genero' => 'F', 'telefono' => '5512345603', 'telefono_fijo' => '5556781203', 'correo_electronico' => 'almartinez@hotmail.com', 'cp' => 11000, 'domicilio' => 'Periférico Norte 789, Col. Polanco, CDMX', 'referencias' => 'Edificio gris, piso 3'],
            ['nombres' => 'Roberto', 'apellido_p' => 'González', 'apellido_m' => 'Pérez', 'genero' => 'M', 'telefono' => '5512345604', 'telefono_fijo' => null, 'correo_electronico' => 'rgonzalez@yahoo.com', 'cp' => 9000, 'domicilio' => 'Calz. de Tlalpan 321, Col. Portales, CDMX', 'referencias' => 'Junto a la farmacia'],
            ['nombres' => 'Sofía', 'apellido_p' => 'Sánchez', 'apellido_m' => 'Flores', 'genero' => 'F', 'telefono' => '5512345605', 'telefono_fijo' => '5556781205', 'correo_electronico' => 'ssanchez@gmail.com', 'cp' => 6700, 'domicilio' => 'Av. Coyoacán 654, Col. Del Valle Sur, CDMX', 'referencias' => null],
            ['nombres' => 'Jorge Luis', 'apellido_p' => 'Morales', 'apellido_m' => 'Castro', 'genero' => 'M', 'telefono' => '5512345606', 'telefono_fijo' => null, 'correo_electronico' => 'jlmorales@gmail.com', 'cp' => 7700, 'domicilio' => 'Calle Tepeyac 112, Col. Lindavista, CDMX', 'referencias' => 'Casa blanca portón verde'],
            ['nombres' => 'Valentina', 'apellido_p' => 'Reyes', 'apellido_m' => 'Jiménez', 'genero' => 'F', 'telefono' => '5512345607', 'telefono_fijo' => '5556781207', 'correo_electronico' => 'vreyes@outlook.com', 'cp' => 4700, 'domicilio' => 'Av. Universidad 900, Col. Copilco, CDMX', 'referencias' => 'Cerca del metro'],
            ['nombres' => 'Miguel Ángel', 'apellido_p' => 'Vargas', 'apellido_m' => 'Mendoza', 'genero' => 'M', 'telefono' => '5512345608', 'telefono_fijo' => null, 'correo_electronico' => 'mavargas@gmail.com', 'cp' => 8500, 'domicilio' => 'Calle Oriente 143 No. 55, Col. Moctezuma, CDMX', 'referencias' => 'Detrás del OXXO'],
            ['nombres' => 'Daniela', 'apellido_p' => 'Cruz', 'apellido_m' => 'Aguilar', 'genero' => 'F', 'telefono' => '5512345609', 'telefono_fijo' => '5556781209', 'correo_electronico' => 'dcruz@gmail.com', 'cp' => 13000, 'domicilio' => 'Av. Tláhuac 2200, Col. Los Ángeles, CDMX', 'referencias' => null],
            ['nombres' => 'Alejandro', 'apellido_p' => 'Gutiérrez', 'apellido_m' => 'Ruiz', 'genero' => 'M', 'telefono' => '5512345610', 'telefono_fijo' => null, 'correo_electronico' => 'agutierrez@hotmail.com', 'cp' => 2000, 'domicilio' => 'Calz. México-Tacuba 80, Col. Popotla, CDMX', 'referencias' => 'Planta baja'],
            ['nombres' => 'Lucía', 'apellido_p' => 'Ortiz', 'apellido_m' => 'Romero', 'genero' => 'F', 'telefono' => '5512345611', 'telefono_fijo' => '5556781211', 'correo_electronico' => 'lortiz@gmail.com', 'cp' => 5600, 'domicilio' => 'Av. Observatorio 330, Col. Observatorio, CDMX', 'referencias' => 'Edificio amarillo'],
            ['nombres' => 'Fernando', 'apellido_p' => 'Herrera', 'apellido_m' => 'Díaz', 'genero' => 'M', 'telefono' => '5512345612', 'telefono_fijo' => null, 'correo_electronico' => 'fherrera@yahoo.com', 'cp' => 15500, 'domicilio' => 'Calle Juan Aldama 77, Col. Jardín Balbuena, CDMX', 'referencias' => 'Casa con jardín'],
            ['nombres' => 'Paola', 'apellido_p' => 'Navarro', 'apellido_m' => 'Vega', 'genero' => 'F', 'telefono' => '5512345613', 'telefono_fijo' => '5556781213', 'correo_electronico' => 'pnavarro@gmail.com', 'cp' => 4360, 'domicilio' => 'Av. División del Norte 1500, Col. Parque San Andrés, CDMX', 'referencias' => null],
            ['nombres' => 'Ricardo', 'apellido_p' => 'Medina', 'apellido_m' => 'Contreras', 'genero' => 'M', 'telefono' => '5512345614', 'telefono_fijo' => null, 'correo_electronico' => 'rmedina@gmail.com', 'cp' => 16000, 'domicilio' => 'Calle Juárez 45, Col. San Ángel, CDMX', 'referencias' => 'Frente a la iglesia'],
            ['nombres' => 'Isabella', 'apellido_p' => 'Ríos', 'apellido_m' => 'Fuentes', 'genero' => 'F', 'telefono' => '5512345615', 'telefono_fijo' => '5556781215', 'correo_electronico' => 'irios@outlook.com', 'cp' => 11400, 'domicilio' => 'Av. Masaryk 123, Col. Polanco V Sección, CDMX', 'referencias' => 'Torre ejecutiva piso 2'],
            ['nombres' => 'Héctor Manuel', 'apellido_p' => 'Espinoza', 'apellido_m' => 'Luna', 'genero' => 'M', 'telefono' => '5512345616', 'telefono_fijo' => null, 'correo_electronico' => 'hespinoza@gmail.com', 'cp' => 7800, 'domicilio' => 'Calle Ferrocarril de Cuernavaca 68, Col. Lomas, CDMX', 'referencias' => null],
            ['nombres' => 'Camila', 'apellido_p' => 'Serrano', 'apellido_m' => 'Peña', 'genero' => 'F', 'telefono' => '5512345617', 'telefono_fijo' => '5556781217', 'correo_electronico' => 'cserrano@gmail.com', 'cp' => 9830, 'domicilio' => 'Av. Ermita Iztapalapa 890, Col. Miravalle, CDMX', 'referencias' => 'Junto a la secundaria'],
            ['nombres' => 'Eduardo', 'apellido_p' => 'Delgado', 'apellido_m' => 'Ramos', 'genero' => 'M', 'telefono' => '5512345618', 'telefono_fijo' => null, 'correo_electronico' => 'edelgado@hotmail.com', 'cp' => 12000, 'domicilio' => 'Calle Xochimilco 200, Col. Los Reyes, CDMX', 'referencias' => 'Casa naranja'],
            ['nombres' => 'Natalia', 'apellido_p' => 'Campos', 'apellido_m' => 'Silva', 'genero' => 'F', 'telefono' => '5512345619', 'telefono_fijo' => '5556781219', 'correo_electronico' => 'ncampos@gmail.com', 'cp' => 6400, 'domicilio' => 'Av. Revolución 555, Col. Mixcoac, CDMX', 'referencias' => null],
            ['nombres' => 'Arturo', 'apellido_p' => 'Rojas', 'apellido_m' => 'Blanco', 'genero' => 'M', 'telefono' => '5512345620', 'telefono_fijo' => null, 'correo_electronico' => 'arojas@gmail.com', 'cp' => 4310, 'domicilio' => 'Calle Francisco Sosa 33, Col. Villa Coyoacán, CDMX', 'referencias' => 'Casa colonial con patio'],
        ];

        foreach ($clientes as $cliente) {
            DB::table('DimensionClientes')->insert([
                'nombres'            => $cliente['nombres'],
                'apellido_p'         => $cliente['apellido_p'],
                'apellido_m'         => $cliente['apellido_m'],
                'genero'             => $cliente['genero'],
                'telefono'           => $cliente['telefono'],
                'telefono_fijo'      => $cliente['telefono_fijo'],
                'correo_electronico' => $cliente['correo_electronico'],
                'cp'                 => $cliente['cp'],
                'domicilio'          => $cliente['domicilio'],
                'referencias'        => $cliente['referencias'],
                'contrasena'         => Hash::make('paso123'),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }
    }
}