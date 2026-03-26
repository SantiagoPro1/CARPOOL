<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $ubicaciones = Ubicacion::all();
        $usuario = Auth::user();
        
        $query = Viaje::with(['ruta.origen', 'ruta.destino', 'conductor'])
            ->where('AsientosDisponibles', '>', 0)
            ->where('IdEstado', 1) // 1: Publicado
            ->where('IdConductor', '!=', $usuario->IdUsuario) // No mostrar sus propios viajes
            ->where('FechaSalida', '>', now());

        if ($request->filled('IdOrigen')) {
            $query->whereHas('ruta', function ($q) use ($request) {
                $q->where('IdOrigen', $request->IdOrigen);
            });
        }

        if ($request->filled('IdDestino')) {
            $query->whereHas('ruta', function ($q) use ($request) {
                $q->where('IdDestino', $request->IdDestino);
            });
        }
        
        if ($request->filled('Fecha')) {
            $query->whereDate('FechaSalida', $request->Fecha);
        }

        $viajes = $query->orderBy('FechaSalida', 'asc')->get();

        return view('search.index', compact('ubicaciones', 'viajes'));
    }
}
