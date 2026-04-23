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

    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px; margin-bottom: 12px;">
        <h3 style="font-size: 1.1rem; margin: 0;">Vehículos Registrados</h3>
        @if($usuario->IdUsuario === Auth::id())
            <a href="{{ route('vehiculos.create') }}" class="btn btn-outline" style="width: auto; padding: 6px 12px; font-size: 0.8rem; border-radius: 10px;">
                + Agregar Vehículo
            </a>
        @endif
    </div>
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

    <h3 style="font-size: 1.1rem; margin-top: 24px; margin-bottom: 12px;">Reseñas Recibidas</h3>
    @if($resenas->isEmpty())

        <div class="card text-center">
            <p style="color: var(--text-muted); margin-bottom: 0;">Aún no tiene reseñas.</p>
        </div>
    @else
        <div style="display: grid; gap: 12px;">
            @foreach($resenas as $resena)
                <div class="card" style="border-left: 4px solid #fbbf24;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #fbbf24, #f59e0b); display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: bold; color: white; flex-shrink: 0;">
                                {{ substr($resena->emisor->NombreCompleto ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p style="font-weight: 600; font-size: 0.95rem; margin-bottom: 2px;">{{ $resena->emisor->NombreCompleto ?? 'Usuario' }}</p>
                                <div style="display: flex; gap: 2px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span style="font-size: 0.85rem;">{{ $i <= $resena->Estrellas ? '⭐' : '☆' }}</span>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <span style="font-size: 0.7rem; color: var(--text-muted); white-space: nowrap;">{{ \Carbon\Carbon::parse($resena->FechaCreacion)->format('d/m/Y') }}</span>
                    </div>
                    @if($resena->Comentario)
                        <p style="font-size: 0.875rem; color: var(--text-color); margin: 0; padding-left: 46px; font-style: italic;">"{{ $resena->Comentario }}"</p>
                    @else
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0; padding-left: 46px; font-style: italic;">Sin comentario</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
    
    @if($usuario->IdUsuario !== Auth::id())
    <div style="margin-top: 24px;">
        <a href="#" onclick="window.history.back(); return false;" class="btn btn-outline" style="text-decoration: none;">&larr; Volver atrás</a>
    </div>
    @endif
</div>
@endsection
