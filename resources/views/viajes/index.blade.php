@extends('layouts.app')

@section('content')
<div style="margin-top: 10px;">
    <h2 style="font-size: 1.5rem; margin-bottom: 24px;">Mis Viajes Publicados</h2>

    @if($viajes->isEmpty())
        <div class="card text-center">
            <p style="color: var(--text-muted); margin-bottom: 16px;">Aún no has publicado ningún viaje como conductor.</p>
            <a href="{{ route('viajes.create') }}" class="btn">Publicar mi primer viaje</a>
        </div>
    @else
        <div style="margin-bottom: 24px;">
            <a href="{{ route('viajes.create') }}" class="btn">Publicar Nuevo Viaje</a>
        </div>
        
        @foreach($viajes as $viaje)
            <div class="card" style="border-left: 4px solid var(--primary-color);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <div>
                        <h3 style="font-size: 1.1rem; margin-bottom: 2px;">
                            {{ $viaje->ruta->origen->Nombre ?? 'Un origen' }} &rarr; {{ $viaje->ruta->destino->Nombre ?? 'Un destino' }}
                        </h3>
                        <p style="color: var(--text-muted); font-size: 0.875rem;">
                            Salida: {{ \Carbon\Carbon::parse($viaje->FechaSalida)->format('d M Y, h:i A') }}
                        </p>
                    </div>
                    <span style="font-size: 0.75rem; padding: 4px 8px; border-radius: 4px; background: rgba(59, 130, 246, 0.1); color: var(--primary-color); font-weight: 500;">
                        {{ $viaje->estado->ClaveEstado ?? 'Publicado' }}
                    </span>
                </div>
                
                <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                    <div style="font-size: 0.875rem;">
                        <span style="color: var(--text-muted);">Asientos libres:</span> <strong style="color: var(--primary-color);">{{ $viaje->AsientosDisponibles }}</strong>
                    </div>
                    <div style="font-size: 0.875rem;">
                        <span style="color: var(--text-muted);">Aporte:</span> <strong>${{ number_format($viaje->PrecioPorPasajero, 2) }}</strong>
                    </div>
                </div>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('solicitudes.index') }}" class="btn btn-outline" style="padding: 8px 12px; font-size: 0.875rem; flex: 1; text-decoration: none; display:block; text-align:center;">
                        Ver Solicitudes
                        @if($viaje->solicitudes->where('IdEstado', 1)->count() > 0)
                            <span style="background: var(--primary-color); color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.70rem; margin-left: 4px;">{{ $viaje->solicitudes->where('IdEstado', 1)->count() }}</span>
                        @endif
                    </a>
                    <a href="{{ route('chat.show', $viaje) }}" class="btn btn-outline" style="padding: 8px 12px; font-size: 0.875rem; flex: 1; display:flex; justify-content:center; align-items:center; text-decoration:none;">Chat</a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
