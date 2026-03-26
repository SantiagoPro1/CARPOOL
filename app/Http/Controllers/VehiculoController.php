<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculoController extends Controller
{
    public function create()
    {
        return view('vehiculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Modelo' => 'required|string|max:100',
            'Placas' => 'required|string|max:20',
            'Color' => 'nullable|string|max:30',
            'Capacidad' => 'required|integer|min:1|max:10',
        ]);

        Vehiculo::create([
            'IdUsuario' => Auth::id(),
            'Modelo' => $request->Modelo,
            'Placas' => $request->Placas,
            'Color' => $request->Color,
            'Capacidad' => $request->Capacidad,
            'Activo' => true,
        ]);

        return redirect()->route('viajes.create')->with('success', 'Vehículo registrado. Ahora puedes publicar tu viaje.');
    }
}
