<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use App\Models\Mensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show(Viaje $viaje)
    {
        $usuario = Auth::user();

        // Verificar si el usuario es el conductor o es un participante confirmado
        $esParticipante = $viaje->IdConductor == $usuario->IdUsuario || 
                          $viaje->pasajeros()->where('ParticipantesViaje.IdUsuario', $usuario->IdUsuario)->exists();

        if (!$esParticipante) {
            abort(403, 'No tienes acceso a este chat. Solo participantes confirmados.');
        }

        $mensajes = Mensaje::with('usuario')
            ->where('IdViaje', $viaje->IdViaje)
            ->orderBy('FechaEnvio', 'asc')
            ->get();

        return view('chat.show', compact('viaje', 'mensajes'));
    }

    public function store(Request $request, Viaje $viaje)
    {
        $request->validate([
            'Contenido' => 'required|string|max:1000',
        ]);

        $usuario = Auth::user();
        $esParticipante = $viaje->IdConductor == $usuario->IdUsuario || 
                          $viaje->pasajeros()->where('ParticipantesViaje.IdUsuario', $usuario->IdUsuario)->exists();

        if (!$esParticipante) {
            abort(403);
        }

        Mensaje::create([
            'IdViaje' => $viaje->IdViaje,
            'IdUsuario' => $usuario->IdUsuario,
            'Contenido' => $request->Contenido,
        ]);

        return back();
    }
}
