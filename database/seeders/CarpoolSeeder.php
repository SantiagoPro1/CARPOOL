<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Vehiculo;

class CarpoolSeeder extends Seeder
{
    public function run()
    {
        // 1. Insertamos Ubicaciones base (Necesarias para publicar viajes)
        $ubicaciones = [
            ['IdUbicacion' => 1, 'Nombre' => 'TecNM Campus Colima', 'Direccion' => 'Av. Tecnológico', 'Ciudad' => 'Villa de Álvarez'],
            ['IdUbicacion' => 2, 'Nombre' => 'Jardín Libertad (Centro)', 'Direccion' => 'Portal Medellín', 'Ciudad' => 'Colima'],
            ['IdUbicacion' => 3, 'Nombre' => 'Plaza Zentralia', 'Direccion' => '3er Anillo Periférico', 'Ciudad' => 'Colima'],
            ['IdUbicacion' => 4, 'Nombre' => 'Diosa del Agua', 'Direccion' => 'Av. V. Carranza', 'Ciudad' => 'Villa de Álvarez'],
            ['IdUbicacion' => 5, 'Nombre' => 'La Villa (Jardín Principal)', 'Direccion' => 'Jardín Principal', 'Ciudad' => 'Villa de Álvarez'],
        ];

        foreach ($ubicaciones as $ub) {
            DB::table('Ubicaciones')->updateOrInsert(['IdUbicacion' => $ub['IdUbicacion']], $ub);
        }

        // 2. Insertamos a Sergio (Conductor)
        $user1 = Usuario::firstOrCreate(
            ['Correo' => 'sergio@colima.tecnm.mx'],
            [
                'NombreCompleto' => 'Sergio Alejandro',
                'Telefono' => '3121234567',
                'Contrasena' => Hash::make('password123'),
                'Activo' => true,
            ]
        );

        // Agregamos vehículo a Sergio
        Vehiculo::firstOrCreate(
            ['Placas' => 'ABC-123'],
            [
                'IdUsuario' => $user1->IdUsuario,
                'Modelo' => 'Nissan Versa 2020',
                'Color' => 'Gris',
                'Capacidad' => 4,
                'Activo' => true,
            ]
        );

        // 3. Insertamos Pasajeros de Prueba
        Usuario::firstOrCreate(
            ['Correo' => 'ana@colima.tecnm.mx'],
            [
                'NombreCompleto' => 'Ana Martínez',
                'Telefono' => '3129876543',
                'Contrasena' => Hash::make('password123'),
                'Activo' => true,
            ]
        );

        Usuario::firstOrCreate(
            ['Correo' => 'pedro@colima.tecnm.mx'],
            [
                'NombreCompleto' => 'Pedro López',
                'Telefono' => '3120000000',
                'Contrasena' => Hash::make('password123'),
                'Activo' => true,
            ]
        );
    }
}
