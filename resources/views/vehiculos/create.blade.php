@extends('layouts.app')

@section('content')
<div style="margin-top: 10px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
        <a href="{{ route('viajes.create') }}" style="color: var(--text-muted); text-decoration: none; padding: 8px;">&larr; Volver</a>
        <h2 style="font-size: 1.5rem; margin: 0;">Mi Vehículo</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="padding-left: 20px; list-style-type: decimal;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: rgba(37, 99, 235, 0.1); border-radius: 16px; padding: 24px; text-align: center; margin-bottom: 24px; border: 1px dashed rgba(37, 99, 235, 0.3);">
        <svg width="80" height="80" fill="none" stroke="var(--blue-bright)" viewBox="0 0 24 24" style="margin-bottom: 12px; filter: drop-shadow(0 0 15px rgba(56, 189, 248, 0.5));">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13h18M5 13l1.5-6h11L19 13M5 13v4a2 2 0 002 2h10a2 2 0 002-2v-4M8 17v2M16 17v2"></path>
        </svg>
        <p style="color: var(--text-main); font-weight: 700; font-size: 1.1rem; margin-bottom: 4px;">Detalles de tu Automóvil</p>
        <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">Registra tu auto para empezar a compartir viajes y ganar dinero con tus compañeros.</p>
    </div>

    <form method="POST" action="{{ route('vehiculos.store') }}" class="card">
        @csrf
        <div class="form-group">
            <label class="form-label">Modelo del Automóvil</label>
            <input type="text" name="Modelo" class="form-control" placeholder="Ej. Nissan Versa 2020" value="{{ old('Modelo') }}" required>
        </div>
        
        <div class="stat-grid" style="margin-bottom: 0;">
            <div class="form-group">
                <label class="form-label">Placas</label>
                <input type="text" name="Placas" class="form-control" placeholder="ABC-123" value="{{ old('Placas') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Color del auto</label>
                <input type="text" name="Color" class="form-control" placeholder="Gris" value="{{ old('Color') }}">
            </div>
        </div>

        <div class="form-group mb-6">
            <label class="form-label">Capacidad Disponible</label>
            <input type="number" name="Capacidad" class="form-control" min="1" max="10" value="{{ old('Capacidad', 4) }}" required>
            <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">Cuantos pasajeros caben en total, sin contarte a ti (el conductor).</p>
        </div>
        
        <button type="submit" class="btn">Guardar Vehículo</button>
    </form>
</div>
@endsection
