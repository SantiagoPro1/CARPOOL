@extends('layouts.app')

@section('content')
<div class="animate-up">

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="margin-right: 8px;"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Header Section -->
    <header style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <p style="color: var(--text-muted); font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Panel Principal</p>
            <h1 class="text-gradient" style="font-size: 2.4rem; font-weight: 800; letter-spacing: -0.03em;">Hola, {!! explode(' ', $usuario->NombreCompleto)[0] !!}</h1>
        </div>
        <a href="{{ route('perfil.show') }}" style="text-decoration: none;">
            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #2563eb, #38bdf8); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);">
                <span style="font-weight: 800; color: white; font-size: 1.2rem;">{{ substr($usuario->NombreCompleto, 0, 1) }}</span>
            </div>
        </a>
    </header>

    <!-- Hero Banner -->
    <div style="border-radius: 20px; overflow: hidden; margin-bottom: 24px; position: relative; height: 140px; border: 1px solid rgba(56, 189, 248, 0.1);">
        <img src="{{ asset('img/hero_carpool.png') }}" alt="Carpool" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        <div style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(2, 6, 23, 0.85), rgba(2, 6, 23, 0.3)); display: flex; align-items: center; padding: 24px;">
            <div>
                <p style="font-size: 1.1rem; font-weight: 800; color: white; margin-bottom: 4px;">Comparte tu camino 🚗</p>
                <p style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">Publica un viaje o encuentra aventón con compañeros del Tec.</p>
            </div>
        </div>
    </div>

    <!-- Reputation & Earnings Row -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 20px; display: flex; flex-direction: column; justify-content: center; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); border: none;">
            <p style="color: rgba(255,255,255,0.6); font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Reputación</p>
            <div style="font-size: 1.8rem; font-weight: 800; color: #fbbf24; display: flex; align-items: center; gap: 8px;">
                {{ $calificacion }} <span style="font-size: 1.2rem;">⭐</span>
            </div>
        </div>

        <a href="{{ route('ganancias.index') }}" class="card" style="padding: 20px; display: flex; flex-direction: column; justify-content: center; border-left: 4px solid #10b981; text-decoration: none;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p style="color: var(--text-muted); font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Ingresos</p>
                <svg width="14" height="14" fill="none" stroke="var(--text-muted)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
            <div style="font-size: 1.8rem; font-weight: 800; color: #10b981;">
                ${{ number_format($gananciasTotales, 0) }}
            </div>
        </a>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 32px;">
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div class="icon-bg" style="background: rgba(37, 99, 235, 0.1); color: var(--blue-bright);">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <span style="font-size: 0.65rem; font-weight: 800; color: var(--blue-bright); background: rgba(37, 99, 235, 0.1); padding: 2px 8px; border-radius: 10px; text-transform: uppercase;">Activos</span>
            </div>
            <h3 style="margin-top: 15px;">{{ $viajesComoConductor }}</h3>
            <p style="font-size: 0.9rem; color: var(--text-main); font-weight: 700;">Viajes que Ofrezco</p>
            <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 2px;">Viajes donde tú vas manejando</span>
        </div>

        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div class="icon-bg" style="background: rgba(14, 165, 233, 0.1); color: var(--accent-vivid);">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <span style="font-size: 0.65rem; font-weight: 800; color: var(--accent-vivid); background: rgba(14, 165, 233, 0.1); padding: 2px 8px; border-radius: 10px; text-transform: uppercase;">En Curso</span>
            </div>
            <h3 style="margin-top: 15px;">{{ $viajesComoPasajero }}</h3>
            <p style="font-size: 0.9rem; color: var(--text-main); font-weight: 700;">Mis Reservas</p>
            <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 2px;">Viajes donde apartaste asiento</span>
        </div>
    </div>

    
    <!-- Active Notifications / Pending Actions -->
    @if($viajesEnCursoPasajero->isNotEmpty())
        @foreach($viajesEnCursoPasajero as $vEnCurso)
        <a href="{{ route('viajes.index') }}" class="notification-banner" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); margin-bottom: 12px; animation: pulse 2s infinite;">
            <div class="banner-icon" style="background: rgba(255,255,255,0.2);">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24"><path d="M21 16.5c0 .38-.21.71-.53.88l-7.97 4.43c-.16.09-.33.14-.5.14s-.34-.05-.5-.14l-7.97-4.43c-.32-.17-.53-.5-.53-.88V7.5c0-.38.21-.71.53-.88l7.97-4.43c.16-.09.33-.14.5-.14s.34.05.5.14l7.97 4.43c.32.17.53.5.53.88v9z"/></svg>
            </div>
            <div style="flex: 1;">
                <p style="font-weight: 700; font-size: 0.95rem; color: white;">¡Tu viaje ha comenzado!</p>
                <p style="font-size: 0.8rem; color: rgba(255,255,255,0.8);">Vas camino a <strong>{{ $vEnCurso->ruta->destino->Nombre }}</strong> con {{ explode(' ', $vEnCurso->conductor->NombreCompleto)[0] }}.</p>
            </div>
            <div style="color: white; opacity: 0.8;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </a>
        @endforeach
    @endif

    @if($solicitudesNotificaciones->isNotEmpty())

        @foreach($solicitudesNotificaciones as $notif)
        <div class="notification-banner" style="background: linear-gradient(135deg, {{ $notif->IdEstado == 5 ? 'var(--danger-red)' : '#f59e0b' }} 0%, {{ $notif->IdEstado == 5 ? 'var(--danger-dark)' : '#d97706' }} 100%); margin-bottom: 12px; position: relative;">
            <div class="banner-icon" style="background: rgba(255,255,255,0.2);">
                @if($notif->IdEstado == 5)
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                @else
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                @endif
            </div>
            <div style="flex: 1;">
                <p style="font-weight: 700; font-size: 0.95rem; color: white;">{{ $notif->IdEstado == 5 ? '¡Atención!' : 'Solicitud Rechazada' }}</p>
                <p style="font-size: 0.8rem; color: rgba(255,255,255,0.8);">
                    {{ $notif->IdEstado == 5 
                        ? "Has sido removido del viaje a " . $notif->viaje->ruta->destino->Nombre
                        : "Tu solicitud para el viaje a " . $notif->viaje->ruta->destino->Nombre . " ha sido rechazada." }}
                </p>
            </div>
            <form action="{{ route('solicitudes.dismiss', $notif) }}" method="POST">
                @csrf
                <button type="submit" style="background: transparent; border: none; color: white; cursor: pointer; padding: 5px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </form>
        </div>
        @endforeach
    @endif


    @if($solicitudesPendientes > 0)
    <a href="{{ route('solicitudes.index') }}" class="notification-banner">
        <div class="banner-icon">
            <span class="pulse"></span>
            <svg width="20" height="20" fill="white" viewBox="0 0 24 24"><path d="M12 22a2 2 0 002-2h-4a2 2 0 002 2zm10-6v-5a8 8 0 00-5-7.3V3a3 3 0 00-6 0v.7A8 8 0 002 11v5l-2 2v1h24v-1l-2-2z"/></svg>
        </div>
        <div style="flex: 1;">
            <p style="font-weight: 700; font-size: 0.95rem; color: white;">{{ $solicitudesPendientes }} Solicitudes pendientes</p>
            <p style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">Hay personas esperando respuesta para viajar contigo</p>
        </div>
        <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </a>
    @endif

    <!-- Main Actions -->
    <div style="margin-bottom: 40px;">
        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px;">¿Qué quieres hacer hoy?</p>
        <div style="display: grid; gap: 12px;">
            <a href="{{ route('viajes.create') }}" class="btn action-btn">
                <div class="btn-icon" style="background: rgba(255,255,255,0.2);">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h18M5 13l1.5-6h11L19 13M5 13v4a2 2 0 002 2h10a2 2 0 002-2v-4M8 17v2M16 17v2"></path></svg>
                </div>
                <span>Publicar un Viaje</span>
            </a>
            <a href="{{ route('search.index') }}" class="btn btn-outline action-btn" style="border-width: 1.5px; background: rgba(255,255,255,0.03);">
                <div class="btn-icon" style="background: rgba(37, 99, 235, 0.1); color: var(--blue-primary);">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12a4 4 0 100-8 4 4 0 000 8z"></path></svg>
                </div>
                <span>Buscar Aventón</span>
            </a>
            <a href="{{ route('ganancias.index') }}" class="btn btn-outline action-btn" style="border-width: 1.5px; background: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2);">
                <div class="btn-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span>Mis Ingresos</span>
            </a>
        </div>
    </div>

    <!-- Quick Footer Links -->
    <footer style="margin-top: 48px; border-top: 1px solid var(--border); padding-top: 24px; text-align: center;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Cerrar Sesión
            </button>
        </form>
    </footer>
</div>

<style>
    .stat-card {
        background: var(--surface-elevated);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        text-align: left;
        transition: var(--transition);
    }
    .stat-card:hover { transform: translateY(-4px); border-color: var(--blue-primary); }
    .stat-card h3 { font-size: 1.8rem; font-weight: 800; margin: 10px 0 2px; }
    .stat-card p { font-size: 0.8rem; color: var(--text-muted); font-weight: 600; }
    .icon-bg { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
    
    .notification-banner {
        background: linear-gradient(135deg, var(--blue-primary) 0%, #1d4ed8 100%);
        padding: 16px 20px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none;
        margin-bottom: 32px;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        transition: var(--transition);
    }
    .notification-banner:hover { transform: scale(1.02); filter: brightness(1.1); }
    .banner-icon { position: relative; width: 44px; height: 44px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    
    .pulse {
        position: absolute;
        top: -2px; right: -2px;
        width: 10px; height: 10px;
        background: #ef4444;
        border-radius: 50%;
        border: 2px solid #2563eb;
        animation: pulse-animation 2s infinite;
    }
    
    @keyframes pulse-animation {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    .action-btn {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 16px;
        padding: 18px 24px;
        height: auto;
    }
    .btn-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

    .logout-btn {
        background: transparent;
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: var(--danger-text);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        font-weight: 700;
        padding: 12px 24px;
        border-radius: 14px;
        transition: var(--transition);
    }
    .logout-btn:hover { background: var(--danger-soft); border-color: var(--danger-red); transform: translateY(-2px); }
</style>
@endsection
