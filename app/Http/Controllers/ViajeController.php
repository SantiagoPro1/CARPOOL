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
        $viajes = Viaje::where('IdConductor', $usuario->IdUsuario)
            ->orderBy('IdEstado', 'asc')
            ->orderBy('FechaSalida', 'asc')
            ->get();
        $viajesPasajero = $usuario->viajesComoPasajero()
            ->orderBy('Viajes.IdEstado', 'asc')
            ->orderBy('Viajes.FechaSalida', 'asc')
            ->get();
        
        $solicitudesRechazadas = \App\Models\SolicitudViaje::with('viaje.ruta.destino')
            ->where('IdUsuario', $usuario->IdUsuario)
            ->whereIn('IdEstado', [3, 5]) // 3: Rechazada, 5: Expulsado
            ->get();

        
        return view('viajes.index', compact('viajes', 'viajesPasajero', 'solicitudesRechazadas'));
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

        $horaSalida = \Carbon\Carbon::parse($request->FechaSalida);
        $horaInicio = (clone $horaSalida)->subHours(1);
        $horaFin = (clone $horaSalida)->addHours(1);

        $empalmeComoConductor = Viaje::where('IdConductor', $usuario->IdUsuario)
            ->whereIn('IdEstado', [1, 2])
            ->whereBetween('FechaSalida', [$horaInicio, $horaFin])
            ->exists();
            
        $empalmeComoPasajero = $usuario->viajesComoPasajero()
            ->whereIn('Viajes.IdEstado', [1, 2])
            ->whereBetween('Viajes.FechaSalida', [$horaInicio, $horaFin])
            ->exists();

        if ($empalmeComoConductor || $empalmeComoPasajero) {
            return back()->withErrors(['Por logística, no puedes tener viajes empalmados. Ya tienes un viaje programado en un margen de ±1 hora.'])->withInput();
        }

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

    public function iniciar(Viaje $viaje)
    {
        if ($viaje->IdConductor != Auth::id()) {
            abort(403);
        }

        // Validar que haya al menos un pasajero
        if ($viaje->pasajeros()->count() < 1) {
            return back()->withErrors(['No puedes iniciar un viaje sin pasajeros. ¡Espera a que alguien se una!']);
        }

        $viaje->update(['IdEstado' => 2]); // En Curso

        return back()->with('success', '¡El viaje ha comenzado! Conduce con cuidado.');
    }

    public function finalizar(Request $request, Viaje $viaje)
    {
        if ($viaje->IdConductor != Auth::id()) {
            abort(403);
        }

        $viaje->update([
            'IdEstado' => 3, // Terminado
            'ObservacionesFinales' => $request->ObservacionesFinales
        ]);

        return redirect()->route('viajes.index')->with('success', 'Viaje finalizado. ¡Gracias por compartir tu viaje!');
    }


}
