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
