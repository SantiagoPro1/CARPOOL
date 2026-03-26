@extends('layouts.app')

@section('content')
<div style="margin-top: 10px;">
    <!-- Encabezado -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-size: 1.25rem;">Hola,</h2>
            <h1 style="font-size: 1.75rem; background: linear-gradient(135deg, #f0f6fc, #8b949e); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $usuario->NombreCompleto }}</h1>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 1.25rem; font-weight: bold; color: #fbbf24;">⭐ {{ $calificacion }}</div>
            <div style="font-size: 0.75rem; color: var(--text-muted);">Calificación</div>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="stat-grid">
        <div class="stat-box">
            <h3>{{ $viajesComoConductor }}</h3>
            <p>Viajes Activos (Conductor)</p>
        </div>
        <div class="stat-box" style="background: rgba(34, 197, 94, 0.1); border-color: rgba(34, 197, 94, 0.2);">
            <h3 style="color: var(--success-color);">{{ $viajesComoPasajero }}</h3>
            <p>Viajes Activos (Pasajero)</p>
        </div>
    </div>
    
    <!-- Botones de Acción Rápida -->
    <div style="display: grid; gap: 12px; margin-bottom: 24px;">
        <a href="{{ route('viajes.create') }}" class="btn" style="text-decoration: none;">🚗 Publicar Viaje</a>
        <a href="{{ route('search.index') }}" class="btn btn-outline" style="text-decoration: none;">🔍 Buscar Viaje</a>
    </div>

    @if($solicitudesPendientes > 0)
    <!-- Notificaciones / Solicitudes -->
    <div class="card" style="border-left: 4px solid var(--primary-color);">
        <h3 style="font-size: 1rem; margin-bottom: 8px;">Mis Solicitudes</h3>
        <p style="color: var(--text-muted); font-size: 0.875rem;">
            Tienes {{ $solicitudesPendientes }} solicitudes pendientes de revisión.
        </p>
        <a href="{{ route('solicitudes.index') }}" style="color: var(--primary-color); text-decoration: none; font-size: 0.875rem; font-weight: 500; display: inline-block; margin-top: 8px;">Gestionar Solicitudes &rarr;</a>
    </div>
    @endif

    <form method="POST" action="{{ route('logout') }}" style="margin-top: 40px;">
        @csrf
        <button type="submit" style="background: transparent; border: none; color: var(--error-color); cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 500;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Cerrar Sesión
        </button>
    </form>
</div>
@endsection
