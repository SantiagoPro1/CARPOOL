@extends('layouts.app')

@section('content')
<div style="margin-top: 10px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
        <a href="{{ route('dashboard') }}" style="color: var(--text-muted); text-decoration: none; padding: 8px;">&larr; Volver</a>
        <h2 style="font-size: 1.5rem; margin: 0;">Publicar Viaje</h2>
    </div>

    @if (session('success'))
        <div class="alert" style="background: rgba(34, 197, 94, 0.1); color: var(--success-color); border: 1px solid rgba(34, 197, 94, 0.2);">
            {{ session('success') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="padding-left: 20px; list-style-type: decimal;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($vehiculos->isEmpty())
        <div class="card text-center" style="border-color: var(--primary-color);">
            <svg style="color: var(--primary-color); margin-bottom: 12px;" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <h3 style="margin-bottom: 8px;">Vehículo Requerido</h3>
            <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 16px;">Para publicar un viaje, primero necesitas registrar el vehículo que vas a conducir.</p>
            <a href="{{ route('vehiculos.create') }}" class="btn">Registrar Mi Vehículo</a>
        </div>
    @else
    <form method="POST" action="{{ route('viajes.store') }}" class="card">
        @csrf
        <div class="form-group">
            <label class="form-label">Ubicación de Origen</label>
            <select name="IdOrigen" class="form-control" required style="appearance: auto; background-color: var(--surface-color);">
                <option value="">Selecciona origen...</option>
                @foreach($ubicaciones as $ub)
                    <option value="{{ $ub->IdUbicacion }}" {{ old('IdOrigen') == $ub->IdUbicacion ? 'selected' : '' }}>{{ $ub->Nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Ubicación de Destino</label>
            <select name="IdDestino" class="form-control" required style="appearance: auto; background-color: var(--surface-color);">
                <option value="">Selecciona destino...</option>
                @foreach($ubicaciones as $ub)
                    <option value="{{ $ub->IdUbicacion }}" {{ old('IdDestino') == $ub->IdUbicacion ? 'selected' : '' }}>{{ $ub->Nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="stat-grid" style="margin-bottom: 0;">
            <div class="form-group">
                <label class="form-label">Fecha y Hora</label>
                <input type="datetime-local" name="FechaSalida" class="form-control" required value="{{ old('FechaSalida') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Vehículo Seleccionado</label>
                <select name="IdVehiculo" class="form-control" required style="appearance: auto; background-color: var(--surface-color);">
                    @foreach($vehiculos as $veh)
                        <option value="{{ $veh->IdVehiculo }}">{{ $veh->Modelo }} ({{ $veh->Placas }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="stat-grid" style="margin-bottom: 16px;">
            <div class="form-group">
                <label class="form-label">Asientos Libres</label>
                <input type="number" name="AsientosTotales" class="form-control" min="1" max="10" required value="{{ old('AsientosTotales', 3) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Aporte Individual ($)</label>
                <input type="number" name="PrecioPorPasajero" class="form-control" min="0" step="0.5" required value="{{ old('PrecioPorPasajero', 15) }}">
            </div>
        </div>
        <div class="form-group mb-6">
            <label class="form-label">Notas o Instrucciones (Opcional)</label>
            <textarea name="Notas" class="form-control" placeholder="Ej. Esperaré fuera del Oxxo, no comer en el auto, etc." rows="2">{{ old('Notas') }}</textarea>
        </div>
        
        <button type="submit" class="btn">Confirmar y Publicar</button>
    </form>
    @endif
</div>
@endsection
