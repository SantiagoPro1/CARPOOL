<?php

namespace App\Http\Controllers;

use App\Models\SolicitudViaje;
use App\Models\Viaje;
use App\Models\ParticipanteViaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    // Para el pasajero: enviar solicitud a un viaje
    public function store(Request $request, Viaje $viaje)
    {
        $usuario = Auth::user();

        // Validar si ya envió solicitud a este viaje
        $existe = SolicitudViaje::where('IdViaje', $viaje->IdViaje)
            ->where('IdUsuario', $usuario->IdUsuario)
            ->whereIn('IdEstado', [1, 2]) // Pendiente o Aceptada
            ->exists();

        if ($existe) {
            return back()->withErrors(['Ya tienes una solicitud activa para este viaje.']);
        }

        if ($viaje->AsientosDisponibles < 1) {
            return back()->withErrors(['Este viaje ya no tiene asientos disponibles.']);
        }

        SolicitudViaje::create([
            'IdViaje' => $viaje->IdViaje,
            'IdUsuario' => $usuario->IdUsuario,
            'AsientosSolicitados' => 1,
            'IdEstado' => 1, // 1: Pendiente
        ]);

        return redirect()->route('search.index')->with('success', 'Solicitud enviada al conductor. Espera su respuesta.');
    }

    // Para el conductor: ver solicitudes de sus viajes
    public function index()
    {
        $usuario = Auth::user();

        // Obtener todos los viajes del conductor que están activos y sus solicitudes pendientes
        $viajes = Viaje::with(['solicitudes.usuario'])
            ->where('IdConductor', $usuario->IdUsuario)
            ->where('IdEstado', 1) // Publicado
            ->get();

        return view('solicitudes.index', compact('viajes'));
    }

    // Para el conductor: aceptar o rechazar
    public function update(Request $request, SolicitudViaje $solicitud)
    {
        $request->validate([
            'accion' => 'required|in:aceptar,rechazar',
        ]);

        // Asegurar que el usuario autenticado es el conductor del viaje
        $viaje = $solicitud->viaje;
        if ($viaje->IdConductor !== Auth::id()) {
            abort(403);
        }

        if ($solicitud->IdEstado != 1) {
            return back()->withErrors(['Esta solicitud ya fue procesada.']);
        }

        if ($request->accion === 'aceptar') {
            if ($viaje->AsientosDisponibles < $solicitud->AsientosSolicitados) {
                return back()->withErrors(['No hay suficientes asientos disponibles en el viaje.']);
            }

            $solicitud->update([
                'IdEstado' => 2, // Aceptada
                'FechaRespuesta' => now(),
            ]);

            $viaje->update([
                'AsientosDisponibles' => $viaje->AsientosDisponibles - $solicitud->AsientosSolicitados,
            ]);

            ParticipanteViaje::create([
                'IdViaje' => $viaje->IdViaje,
                'IdUsuario' => $solicitud->IdUsuario,
                'IdSolicitud' => $solicitud->IdSolicitud,
            ]);

            return back()->with('success', 'Solicitud aceptada correctamente.');
        } else {
            $solicitud->update([
                'IdEstado' => 3, // Rechazada
                'FechaRespuesta' => now(),
            ]);

            return back()->with('success', 'Solicitud rechazada.');
        }
    }
}
