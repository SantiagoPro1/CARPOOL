<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Usuario $usuario = null)
    {
        if (!$usuario) {
            $usuario = Auth::user();
        }

        $calificacion = number_format($usuario->calificacionesRecibidas()->avg('Estrellas') ?? 0, 1);
        $totalCalificaciones = $usuario->calificacionesRecibidas()->count();
        $vehiculos = $usuario->vehiculos;
        $resenas = $usuario->calificacionesRecibidas()->with(['emisor', 'viaje'])->latest('FechaCreacion')->get();

        return view('profile.show', compact('usuario', 'calificacion', 'totalCalificaciones', 'vehiculos', 'resenas'));
    }
}
