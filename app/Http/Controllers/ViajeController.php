<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use App\Models\Ruta;
use App\Models\Ubicacion;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViajeController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $viajes = Viaje::where('IdConductor', $usuario->IdUsuario)->orderBy('FechaSalida', 'asc')->get();
        return view('viajes.index', compact('viajes'));
    }

    public function create()
    {
        $usuario = Auth::user();
        $vehiculos = $usuario->vehiculos;
        // In a real scenario, this would have a seeder.
        // If empty, user can still see the form but selects will be empty.
        $ubicaciones = Ubicacion::all();
        
        return view('viajes.create', compact('vehiculos', 'ubicaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'IdOrigen' => 'required',
            'IdDestino' => 'required|different:IdOrigen',
            'FechaSalida' => 'required|date|after:now',
            'IdVehiculo' => 'required|exists:Vehiculos,IdVehiculo',
            'AsientosTotales' => 'required|integer|min:1',
            'PrecioPorPasajero' => 'required|numeric|min:0',
        ]);

        $usuario = Auth::user();

        // Check if Ruta exists or create it
        $ruta = Ruta::firstOrCreate([
            'IdOrigen' => $request->IdOrigen,
            'IdDestino' => $request->IdDestino,
        ]);

        Viaje::create([
            'IdRuta' => $ruta->IdRuta,
            'IdConductor' => $usuario->IdUsuario,
            'IdVehiculo' => $request->IdVehiculo,
            'FechaSalida' => $request->FechaSalida,
            'AsientosTotales' => $request->AsientosTotales,
            'AsientosDisponibles' => $request->AsientosTotales,
            'PrecioPorPasajero' => $request->PrecioPorPasajero,
            'Notas' => $request->Notas,
            'IdEstado' => 1, // 1: Publicado
        ]);

        return redirect()->route('dashboard')->with('success', '¡Viaje publicado exitosamente!');
    }
}
