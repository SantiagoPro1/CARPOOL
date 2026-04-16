<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Base statuses for Trips (EstadosViaje)
        $estadosViaje = [
            ['IdEstado' => 1, 'NombreEstado' => 'Publicado'],
            ['IdEstado' => 2, 'NombreEstado' => 'En curso'],
            ['IdEstado' => 3, 'NombreEstado' => 'Finalizado'],
            ['IdEstado' => 4, 'NombreEstado' => 'Cancelado'],
        ];

        foreach ($estadosViaje as $estado) {
            DB::table('estadosviaje')->updateOrInsert(['IdEstado' => $estado['IdEstado']], $estado);
        }

        // Base statuses for Requests (EstadosSolicitud)
        $estadosSolicitud = [
            ['IdEstado' => 1, 'NombreEstado' => 'Pendiente'],
            ['IdEstado' => 2, 'NombreEstado' => 'Aceptada'],
            ['IdEstado' => 3, 'NombreEstado' => 'Rechazada'],
            ['IdEstado' => 4, 'NombreEstado' => 'Cancelada'],
        ];

        foreach ($estadosSolicitud as $estado) {
            DB::table('estadossolicitud')->updateOrInsert(['IdEstado' => $estado['IdEstado']], $estado);
        }
    }
}
