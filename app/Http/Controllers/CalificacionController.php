<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use App\Models\Usuario;
use App\Models\Calificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function create(Viaje $viaje, Usuario $evaluado)
    {
        if ($evaluado->IdUsuario === Auth::id()) {
            abort(403, 'No puedes calificarte a ti mismo.');
        }

        return view('calificaciones.create', compact('viaje', 'evaluado'));
    }

    public function store(Request $request, Viaje $viaje, Usuario $evaluado)
    {
        $request->validate([
            'Estrellas' => 'required|integer|min:1|max:5',
            'Comentario' => 'nullable|string|max:500',
        ]);

        Calificacion::create([
            'IdViaje' => $viaje->IdViaje,
            'IdUsuario' => $evaluado->IdUsuario,
            'IdEmisor'  => Auth::id(),
            'Estrellas' => $request->Estrellas,
            'Comentario' => $request->Comentario,
        ]);

        return redirect()->route('dashboard')->with('success', '¡Gracias por calificar a ' . $evaluado->NombreCompleto . '!');
    }
}
