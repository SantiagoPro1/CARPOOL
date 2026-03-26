@extends('layouts.app')

@section('content')
<div style="margin-top: 10px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
        <a href="{{ route('dashboard') }}" style="color: var(--text-muted); text-decoration: none; padding: 8px;">&larr; Volver</a>
        <h2 style="font-size: 1.5rem; margin: 0;">Solicitudes Pendientes</h2>
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

    @php $haySolicitudes = false; @endphp

    @foreach($viajes as $viaje)
        @if($viaje->solicitudes->where('IdEstado', 1)->count() > 0)
            @php $haySolicitudes = true; @endphp
            <div class="card" style="border-top: 4px solid var(--primary-color);">
                <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                    <h3 style="font-size: 1rem; margin-bottom: 4px;">Viaje: {{ $viaje->ruta->origen->Nombre ?? 'Origen' }} &rarr; {{ $viaje->ruta->destino->Nombre ?? 'Destino' }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.875rem;">Fecha: {{ \Carbon\Carbon::parse($viaje->FechaSalida)->format('d/m/Y h:i A') }} | Asientos libres: {{ $viaje->AsientosDisponibles }}</p>
                </div>

                @foreach($viaje->solicitudes->where('IdEstado', 1) as $solicitud)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <div>
                            <p style="font-weight: 500; font-size: 0.95rem;">{{ $solicitud->usuario->NombreCompleto ?? 'Usuario Desconocido' }}</p>
                            <p style="color: var(--text-muted); font-size: 0.8rem;">Solicita {{ $solicitud->AsientosSolicitados }} lugar(es)</p>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <form method="POST" action="{{ route('solicitudes.update', $solicitud) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="accion" value="rechazar">
                                <button type="submit" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem; color: var(--error-color); border-color: rgba(239, 68, 68, 0.3);">Rechazar</button>
                            </form>
                            <form method="POST" action="{{ route('solicitudes.update', $solicitud) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="accion" value="aceptar">
                                <button type="submit" class="btn" style="padding: 6px 12px; font-size: 0.8rem; background: var(--success-color);">Aceptar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach

    @if(!$haySolicitudes)
        <div class="card text-center">
            <p style="color: var(--text-muted); margin-bottom: 0;">No tienes solicitudes pendientes por el momento.</p>
        </div>
    @endif
</div>
@endsection
