@extends('layouts.app')

@section('content')
<div style="margin-top: 10px;">
    <h2 style="font-size: 1.5rem; margin-bottom: 24px;">Buscar Viaje</h2>

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
        <div class="card text-center">
            <p style="color: var(--text-muted); margin-bottom: 0;">No se encontraron viajes disponibles con estos filtros.</p>
        </div>
    @else
        @foreach($viajes as $viaje)
            <div class="card" style="border-left: 4px solid var(--primary-color);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <div>
                        <h3 style="font-size: 1.1rem; margin-bottom: 2px;">
                            {{ $viaje->ruta->origen->Nombre ?? 'Origen' }} &rarr; {{ $viaje->ruta->destino->Nombre ?? 'Destino' }}
                        </h3>
                        <p style="color: var(--text-muted); font-size: 0.875rem;">
                            Conductor: {{ $viaje->conductor->NombreCompleto ?? 'Usuario' }}
                        </p>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 1.1rem; font-weight: bold; color: var(--primary-color);">${{ number_format($viaje->PrecioPorPasajero, 2) }}</span>
                    </div>
                </div>
                
                <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                    <div style="font-size: 0.875rem;">
                        <span style="color: var(--text-muted);">Fecha:</span> <strong>{{ \Carbon\Carbon::parse($viaje->FechaSalida)->format('d/m/Y h:i A') }}</strong>
                    </div>
                    <div style="font-size: 0.875rem;">
                        <span style="color: var(--text-muted);">Lugares:</span> <strong>{{ $viaje->AsientosDisponibles }}</strong>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('solicitudes.store', $viaje) }}" style="width: 100%;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding: 8px 12px; font-size: 0.875rem; width: 100%;">Enviar Solicitud</button>
                </form>
            </div>
        @endforeach
    @endif
</div>
@endsection
