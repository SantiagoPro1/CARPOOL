<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Viaje;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        
        // El dashboard muestra estadísticas iniciales para el usuario
        $viajesComoConductor = Viaje::where('IdConductor', $usuario->IdUsuario)
            ->whereIn('IdEstado', [1, 2]) // 1: Publicado, 2: En Curso
            ->count();
            
        $viajesComoPasajero = $usuario->viajesComoPasajero()
            ->whereIn('Viajes.IdEstado', [1, 2])
            ->count();
            
        $solicitudesPendientes = \App\Models\SolicitudViaje::whereHas('viaje', function($query) use ($usuario) {
            $query->where('IdConductor', $usuario->IdUsuario);
        })->where('IdEstado', 1)->count();
        $calificacion = number_format($usuario->calificacionesRecibidas()->avg('Estrellas') ?? 0, 1);

        return view('dashboard', compact(
            'usuario', 
            'viajesComoConductor', 
            'viajesComoPasajero', 
            'solicitudesPendientes', 
            'calificacion'
        ));
    }
}
