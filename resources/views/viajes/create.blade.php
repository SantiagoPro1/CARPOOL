@extends('layouts.app')

@section('content')
<div style="margin-top: 10px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
        <a href="{{ route('dashboard') }}" style="color: var(--text-muted); text-decoration: none; padding: 8px;">&larr; Volver</a>
        <h2 style="font-size: 1.5rem; margin: 0;">Publicar Viaje</h2>
    </div>

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

    @if($vehiculos->isEmpty())
        <div class="card text-center" style="border-left: 4px solid var(--blue-primary);">
            <svg style="color: var(--blue-primary); margin-bottom: 12px;" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
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
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" style="display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--primary-color)"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                ¿Cuándo es tu viaje?
            </label>
            <input type="text" name="FechaSalida" id="fecha-hora-picker" class="form-control" required value="{{ old('FechaSalida') }}" placeholder="Toca aquí para elegir tu fecha y hora amigablemente..." style="background-color: var(--surface-color); cursor: pointer; padding: 12px; font-size: 1rem;">
        </div>
        
        <div class="form-group" style="margin-top: 16px;">
            <label class="form-label" style="display: flex; justify-content: space-between;">
                <span>Vehículo Seleccionado</span>
                <a href="{{ route('vehiculos.create') }}" style="font-size: 0.8rem; color: var(--blue-bright); text-decoration: none;">+ Registrar otro vehículo</a>
            </label>
            <select name="IdVehiculo" class="form-control" required style="appearance: auto; background-color: var(--surface-color);">
                @foreach($vehiculos as $veh)
                    <option value="{{ $veh->IdVehiculo }}">{{ $veh->Modelo }} ({{ $veh->Placas }})</option>
                @endforeach
            </select>
        </div>

        <div class="stat-grid" style="margin-bottom: 16px;">
            <div class="form-group">
                <label class="form-label">Asientos Libres</label>
                <input type="number" name="AsientosTotales" class="form-control" min="1" max="10" required value="{{ old('AsientosTotales', 3) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Aporte Individual ($)</label>
                <input type="number" name="PrecioPorPasajero" class="form-control" min="0" step="0.5" required value="{{ old('PrecioPorPasajero', 15) }}" style="background-color: var(--bg-dark);">
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

<!-- Flatpickr for highly intuitive date/time picking -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#fecha-hora-picker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: new Date(),
            defaultHour: new Date().getHours() + 1,
            defaultMinute: 0,
            time_24hr: false,
            locale: "es",
            disableMobile: true,
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates[0] && selectedDates[0] < new Date()) {
                    var ahora = new Date();
                    ahora.setMinutes(ahora.getMinutes() + 5);
                    instance.setDate(ahora);
                    alert("No puedes seleccionar una hora en el pasado. Se ajustó automáticamente.");
                }
            }
        });
    });
</script>
@endsection
