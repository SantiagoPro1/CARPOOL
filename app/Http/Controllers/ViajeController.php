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
        $viajesPasajero = $usuario->viajesComoPasajero()->orderBy('FechaSalida', 'asc')->get();
        
        return view('viajes.index', compact('viajes', 'viajesPasajero'));
    }

    public function update(Request $request, Viaje $viaje)
    {
        $usuario = Auth::user();
        if ($viaje->IdConductor != $usuario->IdUsuario) {
            abort(403, 'Solo el conductor puede actualizar el estado del viaje.');
        }

        $request->validate([
            'IdEstado' => 'required|integer|in:1,2,3,4',
        ]);

        $viaje->update([
            'IdEstado' => $request->IdEstado
        ]);

        return back()->with('success', 'Estado del viaje actualizado correctamente.');
    }

    public function create()
    {
        $usuario = Auth::user();
        $vehiculos = $usuario->vehiculos;
        // Ubicaciones disponibles para los selectores de origen y destino
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

        // Buscar si la ruta ya existe o crearla
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
            'IdEstado' => 1, // Publicado
        ]);

        return redirect()->route('dashboard')->with('success', '¡Viaje publicado exitosamente!');
    }
}
