@extends('layouts.app')

@section('content')
<div class="animate-up">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header Section -->
    <header style="margin-bottom: 32px;">
        <p style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500; margin-bottom: 4px;">Panel de Control</p>
        <h1 class="text-gradient" style="font-size: 2.2rem; font-weight: 800; letter-spacing: -0.02em;">Hola, {!! explode(' ', $usuario->NombreCompleto)[0] !!}</h1>
    </header>

    <!-- Stats Section -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 16px; margin-bottom: 32px;">
        <div class="card" style="display: flex; align-items: center; justify-content: space-between; padding: 24px;">
            <div>
                <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Tu Calificación</p>
                <div style="font-size: 1.8rem; font-weight: 800; color: #fbbf24; display: flex; align-items: center; gap: 8px;">
                    ⭐ {{ $calificacion }}
                </div>
            </div>
            <div style="height: 50px; width: 50px; border-radius: 14px; background: rgba(251, 191, 36, 0.1); display: flex; align-items: center; justify-content: center;">
                <svg width="24" height="24" fill="#fbbf24" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="stat-box">
                <h3>{{ $viajesComoConductor }}</h3>
                <p>Como Conductor</p>
            </div>
            <div class="stat-box" style="background: rgba(14, 165, 233, 0.05); border-color: rgba(14, 165, 233, 0.1);">
                <h3 style="color: var(--blue-bright);">{{ $viajesComoPasajero }}</h3>
                <p>Como Pasajero</p>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div style="display: grid; gap: 12px; margin-bottom: 32px;">
        <a href="{{ route('viajes.create') }}" class="btn">
            <svg style="margin-right: 8px;" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Publicar un Viaje
        </a>
        <a href="{{ route('search.index') }}" class="btn btn-outline" style="border-width: 1.5px;">
            <svg style="margin-right: 8px;" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            Buscar Aventón
        </a>
    </div>

    @if($solicitudesPendientes > 0)
    <!-- Notifications -->
    <div class="card" style="border: 1px solid var(--blue-primary); background: rgba(37, 99, 235, 0.05);">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="height: 44px; width: 44px; border-radius: 12px; background: var(--blue-primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24"><path d="M12 22a2 2 0 002-2h-4a2 2 0 002 2zm10-6v-5a8 8 0 00-5-7.3V3a3 3 0 00-6 0v.7A8 8 0 002 11v5l-2 2v1h24v-1l-2-2z"/></svg>
            </div>
            <div style="flex: 1;">
                <h4 style="font-size: 1rem; margin-bottom: 2px;">{{ $solicitudesPendientes }} Solicitudes</h4>
                <p style="color: var(--text-muted); font-size: 0.8rem;">Tienes pasajeros esperando respuesta</p>
            </div>
            <a href="{{ route('solicitudes.index') }}" class="btn" style="width: auto; padding: 10px 16px; font-size: 0.8rem; background: var(--blue-primary);">Ver</a>
        </div>
    </div>
    @endif

    <footer style="margin-top: 48px; border-top: 1px solid var(--border); padding-top: 24px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: transparent; border: 1px solid rgba(239, 68, 68, 0.2); color: var(--danger-text); cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.9rem; font-weight: 600; font-family: inherit; margin: 0 auto; padding: 10px 20px; border-radius: 12px; transition: var(--transition);" onmouseover="this.style.background='var(--danger-soft)'; this.style.borderColor='var(--danger-red)'" onmouseout="this.style.background='transparent'; this.style.borderColor='rgba(239, 68, 68, 0.2)'">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Cerrar Sesión Activa
            </button>
        </form>
    </footer>
</div>
@endsection
