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

        if ($viaje->IdConductor == $usuario->IdUsuario) {
            return back()->withErrors(['No puedes unirte a tu propio viaje.']);
        }

        $request->validate([
            'AsientosSolicitados' => 'required|integer|min:1|max:' . $viaje->AsientosDisponibles,
            'CorreosInvitados' => 'nullable|string|max:200'
        ]);

        if ($viaje->AsientosDisponibles < $request->AsientosSolicitados) {
            return back()->withErrors(['Este viaje no tiene suficientes asientos disponibles.']);
        }

        $correosValidos = [];
        if ($request->CorreosInvitados) {
            $correosArray = array_map('trim', explode(',', $request->CorreosInvitados));
            foreach ($correosArray as $c) {
                if ($c == $usuario->Correo) {
                    return back()->withErrors(['No te puedes agregar a ti mismo como acompañante. Ya estás incluido al enviar la solicitud.']);
                }
                $userCheck = \App\Models\Usuario::where('Correo', $c)->first();
                if (!$userCheck) {
                    return back()->withErrors(["El acompañante $c no ha creado cuenta en la plataforma."]);
                }
                $correosValidos[] = $c;
            }
        }

        $horaSalida = \Carbon\Carbon::parse($viaje->FechaSalida);
        $horaInicio = (clone $horaSalida)->subHours(1);
        $horaFin = (clone $horaSalida)->addHours(1);

        if ($request->AsientosSolicitados < count($correosValidos) + 1) {
            return back()->withErrors(['Estás cediendo asientos a ' . count($correosValidos) . ' acompañante(s), por lo que en la cajita numérica debes reservar al menos ' . (count($correosValidos) + 1) . ' lugares (incluyéndote a ti).']);
        }

        $empalmeComoConductor = Viaje::where('IdConductor', $usuario->IdUsuario)
            ->whereIn('IdEstado', [1, 2])
            ->whereBetween('FechaSalida', [$horaInicio, $horaFin])
            ->exists();
            
        $empalmeComoPasajero = $usuario->viajesComoPasajero()
            ->whereIn('Viajes.IdEstado', [1, 2])
            ->whereBetween('Viajes.FechaSalida', [$horaInicio, $horaFin])
            ->exists();

        if ($empalmeComoConductor || $empalmeComoPasajero) {
            return back()->withErrors(['No puedes unirte a este viaje porque ya tienes otro programado en un margen de ±1 hora.']);
        }

        $mensajeStr = 'Hola, me gustaría unirme a tu viaje.';
        if (!empty($correosValidos)) {
            $mensajeStr = 'Invitados: ' . implode(', ', $correosValidos);
        }

        SolicitudViaje::create([
            'IdViaje' => $viaje->IdViaje,
            'IdUsuario' => $usuario->IdUsuario,
            'IdEstado' => 1, // Pendiente
            'FechaSolicitud' => now(),
            'AsientosSolicitados' => $request->AsientosSolicitados,
            'Mensaje' => $mensajeStr,
        ]);

        return redirect()->route('search.index')->with('success', 'Solicitud enviada al conductor. Espera su respuesta.');
    }

    // Para el conductor: ver solicitudes de sus viajes
    public function index()
    {
        $usuario = Auth::user();

        // Obtener todos los viajes del conductor activos y sus solicitudes pendientes
        $viajes = Viaje::with(['solicitudes.usuario'])
            ->where('IdConductor', $usuario->IdUsuario)
            ->where('IdEstado', 1) // Publicado
            ->get();

        return view('solicitudes.index', compact('viajes'));
    }

    // Para el conductor: aceptar o rechazar solicitud
    public function update(Request $request, SolicitudViaje $solicitud)
    {
        $request->validate([
            'accion' => 'required|in:aceptar,rechazar',
        ]);

        // Verificar que el usuario autenticado es el conductor del viaje
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

            if (str_starts_with($solicitud->Mensaje, 'Invitados: ')) {
                $correosStr = substr($solicitud->Mensaje, 11);
                $correosArray = array_map('trim', explode(',', $correosStr));
                foreach ($correosArray as $correo) {
                    if (!empty($correo)) {
                        \App\Models\InvitadoViaje::firstOrCreate([
                            'IdViaje' => $viaje->IdViaje,
                            'Correo' => $correo
                        ]);
                    }
                }
            }

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

    public function cancelar(Request $request, SolicitudViaje $solicitud)
    {
        $usuario = Auth::user();
        if ($solicitud->IdUsuario != $usuario->IdUsuario && $solicitud->viaje->IdConductor != $usuario->IdUsuario) {
            abort(403, 'No tienes permiso para cancelar este pasaje.');
        }

        if ($solicitud->IdEstado == 4) {
            return back()->withErrors(['Esta solicitud ya fue cancelada.']);
        }

        $viaje = $solicitud->viaje;
        $esConductor = ($viaje->IdConductor == $usuario->IdUsuario);

        if ($solicitud->IdEstado == 2) { // Aceptada
            $viaje->update([
                'AsientosDisponibles' => $viaje->AsientosDisponibles + $solicitud->AsientosSolicitados,
            ]);

            \App\Models\ParticipanteViaje::where('IdSolicitud', $solicitud->IdSolicitud)
                ->delete();
        }

        $solicitud->update([
            'IdEstado' => $esConductor ? 5 : 4, // 5: Expulsado, 4: Cancelada
        ]);

        $mensaje = $esConductor ? 'Pasajero expulsado y lugar liberado.' : 'Pasaje cancelado y lugar liberado correctamente.';
        return back()->with('success', $mensaje);

    }

    public function dismiss(SolicitudViaje $solicitud)
    {
        if ($solicitud->IdUsuario !== Auth::id()) {
            abort(403);
        }

        // Simplemente marcamos como cancelada o la eliminamos para que no aparezca en notificaciones
        $solicitud->update(['IdEstado' => 4]); // Cancelada/Leída

        return back();
    }
}

