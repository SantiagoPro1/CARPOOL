@extends('layouts.app')

@section('content')
<div class="animate-up">
    <div style="margin-bottom: 32px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4); flex-shrink: 0;">
            <svg width="26" height="26" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <div>
            <h1 class="text-gradient" style="font-size: 2.2rem; font-weight: 800; letter-spacing: -0.02em;">Buscar Aventón</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Encuentra compañeros para tu próximo viaje</p>
        </div>
    </div>


    <form method="GET" action="{{ route('search.index') }}" class="card">
        <div class="form-group">
            <label class="form-label">Origen</label>
            <select name="IdOrigen" class="form-control" style="appearance: auto; background-color: var(--surface-color);">
                <option value="">Cualquier origen</option>
                @foreach($ubicaciones as $ub)
                    <option value="{{ $ub->IdUbicacion }}" {{ request('IdOrigen') == $ub->IdUbicacion ? 'selected' : '' }}>{{ $ub->Nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Destino</label>
            <select name="IdDestino" class="form-control" style="appearance: auto; background-color: var(--surface-color);">
                <option value="">Cualquier destino</option>
                @foreach($ubicaciones as $ub)
                    <option value="{{ $ub->IdUbicacion }}" {{ request('IdDestino') == $ub->IdUbicacion ? 'selected' : '' }}>{{ $ub->Nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-6">
            <label class="form-label">Fecha (Opcional)</label>
            <input type="date" name="Fecha" class="form-control" value="{{ request('Fecha') }}">
        </div>
        
        <button type="submit" class="btn">Aplicar Filtros</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <h3 style="font-size: 1.25rem; margin-top: 32px; margin-bottom: 16px;">Resultados encontrados ({{ $viajes->count() }})</h3>
    
    @if($viajes->isEmpty())
        <div class="card text-center" style="padding: 40px 20px;">
            <img src="{{ asset('img/search_empty.png') }}" alt="Sin resultados" style="width: 160px; height: 160px; object-fit: cover; border-radius: 20px; margin: 0 auto 20px; display: block; opacity: 0.8;">
            <h4 style="margin-bottom: 8px; font-weight: 700;">No se encontraron viajes</h4>
            <p style="color: var(--text-muted); margin-bottom: 0; font-size: 0.9rem;">Intenta con otros filtros o vuelve más tarde. ¡Siempre hay nuevos viajes apareciendo!</p>
        </div>
    @else
        @foreach($viajes as $viaje)
            <div class="card" style="border-left: 4px solid var(--blue-primary);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                    <div>
                        <h3 style="font-size: 1.15rem; margin-bottom: 4px; font-weight: 700;">
                            {{ $viaje->ruta->origen->Nombre }} &rarr; {{ $viaje->ruta->destino->Nombre }}
                        </h3>
                        <p style="color: var(--text-muted); font-size: 0.85rem; display: flex; align-items: center; gap: 6px;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $viaje->conductor->NombreCompleto }}
                        </p>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-size: 0.65rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 2px;">Costo</p>
                        <span style="font-size: 1.25rem; font-weight: 800; color: #10b981;">${{ number_format($viaje->PrecioPorPasajero, 0) }}</span>
                    </div>
                </div>
                
                <div style="background: rgba(0,0,0,0.2); border-radius: 12px; padding: 12px; display: flex; justify-content: space-around; margin-bottom: 20px;">
                    <div style="text-align: center;">
                        <p style="font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; font-weight: 800; margin-bottom: 2px;">Salida</p>
                        <p style="font-size: 0.85rem; font-weight: 700;">{{ \Carbon\Carbon::parse($viaje->FechaSalida)->format('h:i A') }}</p>
                    </div>
                    <div style="width: 1px; background: var(--border);"></div>
                    <div style="text-align: center;">
                        <p style="font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; font-weight: 800; margin-bottom: 2px;">Lugares</p>
                        <p style="font-size: 0.85rem; font-weight: 700;">{{ $viaje->AsientosDisponibles }} disp.</p>
                    </div>
                </div>

                @if($viaje->AsientosDisponibles > 0)
                <form method="POST" action="{{ route('solicitudes.store', $viaje) }}" style="width: 100%; border-top: 1px solid var(--border); padding-top: 16px;">
                    @csrf
                    <div style="display: grid; grid-template-columns: 80px 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-size: 0.6rem;">LUGARES</label>
                            <input type="number" name="AsientosSolicitados" value="1" min="1" max="{{ $viaje->AsientosDisponibles }}" class="form-control" style="padding: 10px; text-align: center;" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-size: 0.6rem;">INVITADOS (OPCIONAL)</label>
                            <input type="text" name="CorreosInvitados" placeholder="ejemplo@tecnm.mx" class="form-control" style="padding: 10px; font-size: 0.85rem;">
                        </div>
                    </div>
                    <button type="submit" class="btn" style="padding: 12px; font-size: 0.9rem;">Solicitar Viaje</button>
                </form>
                @else
                <div style="background: var(--danger-soft); color: var(--danger-text); padding: 12px; border-radius: 12px; text-align: center; font-size: 0.85rem; font-weight: 700;">
                    Viaje Completo
                </div>
                @endif
            </div>
        @endforeach

    @endif
</div>
@endsection
