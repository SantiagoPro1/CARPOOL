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

        // Verificar si el usuario es el conductor, pasajero confirmado o invitado
        $esParticipante = $viaje->IdConductor == $usuario->IdUsuario || 
                          $viaje->pasajeros()->where('Usuarios.IdUsuario', $usuario->IdUsuario)->exists() ||
                          $viaje->invitados()->where('Correo', $usuario->Correo)->exists();

        if (!$esParticipante) {
            abort(403, 'No tienes acceso a este chat. Solo participantes confirmados.');
        }

        $mensajes = Mensaje::with('remitente')
            ->where('IdViaje', $viaje->IdViaje)
            ->orderBy('FechaEnvio', 'asc')
            ->get();

        // Marcar el chat como leído guardando la fecha actual en la sesión
        session(['chat_leido_' . $viaje->IdViaje => now()]);

        return view('chat.show', compact('viaje', 'mensajes'));
    }

    public function store(Request $request, Viaje $viaje)
    {
        $request->validate([
            'Contenido' => 'required|string|max:1000',
        ]);

        $usuario = Auth::user();

        // Verificar si el usuario es participante o invitado
        $esParticipante = $viaje->IdConductor == $usuario->IdUsuario || 
                          $viaje->pasajeros()->where('Usuarios.IdUsuario', $usuario->IdUsuario)->exists() ||
                          $viaje->invitados()->where('Correo', $usuario->Correo)->exists();

        if (!$esParticipante) {
            abort(403);
        }

        if ($viaje->IdEstado >= 3) {
            abort(403, 'El chat ha sido cerrado porque el viaje concluyó.');
        }

        Mensaje::create([
            'IdViaje' => $viaje->IdViaje,
            'IdRemitente' => $usuario->IdUsuario,
            'Contenido' => $request->Contenido,
        ]);

        return back();
    }
}
