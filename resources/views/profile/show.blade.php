@extends('layouts.app')

@section('content')
<div style="margin-top: 10px;">
    <h2 style="font-size: 1.5rem; margin-bottom: 24px;">Perfil de Usuario</h2>

    <div class="card text-center" style="padding: 24px 16px;">
        <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), #8b5cf6); margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; color: white;">
            {{ substr($usuario->NombreCompleto, 0, 1) }}
        </div>
        <h3 style="font-size: 1.25rem;">{{ $usuario->NombreCompleto }}</h3>
        <p style="color: var(--text-muted); font-size: 0.875rem;">{{ $usuario->Correo }}</p>
        
        <div style="margin-top: 16px; display: inline-flex; align-items: center; gap: 8px; background: rgba(251, 191, 36, 0.1); padding: 8px 16px; border-radius: 20px;">
            <span style="font-size: 1.25rem;">⭐</span>
            <span style="font-size: 1.1rem; font-weight: bold; color: #fbbf24;">{{ $calificacion }}</span>
            <span style="color: var(--text-muted); font-size: 0.875rem;">({{ $totalCalificaciones }} reseñas)</span>
        </div>
    </div>

    @if($vehiculos->isNotEmpty())
    <h3 style="font-size: 1.1rem; margin-top: 24px; margin-bottom: 12px;">Vehículos Registrados</h3>
    @foreach($vehiculos as $veh)
        <div class="card" style="border-left: 4px solid var(--text-muted);">
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <h4 style="margin-bottom: 4px; font-size: 1rem;">{{ $veh->Modelo }}</h4>
                    <p style="font-size: 0.875rem; color: var(--text-muted);">{{ $veh->Color }} | Placas: {{ $veh->Placas }}</p>
                </div>
                <div style="text-align: right; font-size: 0.875rem;">
                    <span style="color: var(--text-muted);">Capacidad:</span> <strong>{{ $veh->Capacidad }} pas.</strong>
                </div>
            </div>
        </div>
    @endforeach
    @endif
    
    @if($usuario->IdUsuario !== Auth::id())
    <div style="margin-top: 24px;">
        <a href="#" onclick="window.history.back(); return false;" class="btn btn-outline" style="text-decoration: none;">&larr; Volver atrás</a>
    </div>
    @endif
</div>
@endsection
