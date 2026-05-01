@extends('layouts.app')

@section('content')
<div class="animate-up">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
        <a href="{{ route('viajes.index') }}" style="color: var(--text-muted); text-decoration: none; padding: 8px;">&larr; Volver a Viajes</a>
        <h2 style="font-size: 1.5rem; margin: 0;">Mis Ingresos</h2>
    </div>

    <!-- Header / Total Banner -->
    <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.3) 100%); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 20px; padding: 30px; text-align: center; margin-bottom: 30px; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.1);">
        <img src="{{ asset('img/earnings_hero.png') }}" alt="Ganancias" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; margin: 0 auto 16px; display: block; border: 3px solid rgba(16, 185, 129, 0.3); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);">
        <p style="color: var(--text-main); font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px;">Ingresos Totales</p>
        <h1 style="font-size: 3.5rem; font-weight: 800; color: #10b981; margin: 0; line-height: 1;">${{ number_format($gananciasTotales, 2) }}</h1>
        <p style="color: rgba(255, 255, 255, 0.6); font-size: 0.85rem; margin-top: 12px;">Basado en el período seleccionado</p>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 30px; background: rgba(15, 23, 42, 0.4); border: 1px solid var(--border);">
        <form method="GET" action="{{ route('ganancias.index') }}" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; margin-bottom: 8px; display: block; text-transform: uppercase;">Filtrar Período</label>
                <div style="position: relative;">
                    <select name="fecha" class="form-control" style="appearance: none; padding-right: 40px; border-radius: 12px;">
                        <option value="todos" {{ $filtroFecha == 'todos' ? 'selected' : '' }}>Desde siempre</option>
                        <option value="mes" {{ $filtroFecha == 'mes' ? 'selected' : '' }}>Este Mes</option>
                        <option value="anio" {{ $filtroFecha == 'anio' ? 'selected' : '' }}>Este Año</option>
                    </select>
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="position: absolute; right: 14px; top: 16px; color: var(--text-muted); pointer-events: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            <button type="submit" class="btn" style="width: auto; padding: 14px 28px; border-radius: 12px; background: var(--blue-deep);">Aplicar Filtro</button>
        </form>
    </div>

    <!-- Detailed Breakdown -->
    <div>
        <h3 style="font-size: 1.2rem; margin-bottom: 16px; font-weight: 800;">Detalle de Ingresos</h3>
        
        @if($viajesTerminados->isEmpty())
            <div class="card text-center" style="padding: 40px 20px; border-style: dashed; border-color: rgba(16, 185, 129, 0.2); background: transparent;">
                <img src="{{ asset('img/earnings_hero.png') }}" alt="Sin ingresos" style="width: 140px; height: 140px; object-fit: cover; border-radius: 20px; margin: 0 auto 20px; display: block; opacity: 0.8;">
                <h4 style="margin-bottom: 8px;">No hay ingresos en este período</h4>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Finaliza viajes para ver tus ingresos aquí.</p>
            </div>
        @else
            <div style="display: grid; gap: 16px;">
                @foreach($viajesTerminados as $viaje)
                    <div class="card" style="padding: 16px 20px; display: flex; flex-direction: column; gap: 12px; border-left: 4px solid #10b981;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <span style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 800; letter-spacing: 0.05em;">VIAJE #{{ $viaje->IdViaje }}</span>
                                <h4 style="font-size: 1.1rem; margin: 4px 0 2px;">{{ $viaje->ruta->origen->Nombre }} &rarr; {{ $viaje->ruta->destino->Nombre }}</h4>
                                <span style="font-size: 0.8rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($viaje->FechaSalida)->format('d M Y, h:i A') }}</span>
                            </div>
                            <div style="text-align: right;">
                                <p style="font-size: 1.3rem; font-weight: 800; color: #10b981; margin: 0;">+${{ number_format($viaje->gananciaTotal, 2) }}</p>
                            </div>
                        </div>
                        <div style="background: rgba(0,0,0,0.2); border-radius: 12px; padding: 12px; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
                            <div style="display: flex; gap: 16px;">
                                <div>
                                    <span style="color: var(--text-muted); font-weight: 700;">Pasajeros:</span> 
                                    <span style="font-weight: 800; color: white;">{{ $viaje->pasajerosCount }}</span>
                                </div>
                                <div>
                                    <span style="color: var(--text-muted); font-weight: 700;">Precio P/P:</span> 
                                    <span style="font-weight: 800; color: white;">${{ number_format($viaje->PrecioPorPasajero, 2) }}</span>
                                </div>
                            </div>
                            <a href="{{ route('viajes.show', $viaje->IdViaje) }}" style="color: var(--blue-bright); text-decoration: none; font-weight: 700; font-size: 0.8rem;">Ver Detalles &rarr;</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
