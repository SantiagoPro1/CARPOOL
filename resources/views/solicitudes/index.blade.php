
@extends('layouts.app')

@section('content')
<div style="margin-top: 10px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
        <a href="{{ route('dashboard') }}" style="color: var(--text-muted); text-decoration: none; padding: 8px;">&larr; Volver</a>
        <h2 style="font-size: 1.5rem; margin: 0;">Solicitudes Pendientes</h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
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
        @if($viaje->solicitudes->whereIn('IdEstado', [1, 2])->count() > 0)
            @php $haySolicitudes = true; @endphp
            <div class="card" style="border-left: 4px solid var(--blue-primary); padding-top: 16px;">
                <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
                    <h3 style="font-size: 1rem; margin-bottom: 4px; color: var(--text-bright);">{{ $viaje->ruta->origen->Nombre ?? 'Origen' }} &rarr; {{ $viaje->ruta->destino->Nombre ?? 'Destino' }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.8rem;">{{ \Carbon\Carbon::parse($viaje->FechaSalida)->format('d/m/Y h:i A') }} | Asientos libres: {{ $viaje->AsientosDisponibles }}</p>
                </div>

                @foreach($viaje->solicitudes->whereIn('IdEstado', [1, 2]) as $solicitud)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <div>
                            <p style="font-weight: 500; font-size: 0.95rem;">
                                {{ $solicitud->usuario->NombreCompleto ?? 'Usuario Desconocido' }}
                                @if($solicitud->IdEstado == 2)
                                    <span style="font-size: 0.65rem; background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 3px 6px; border-radius: 4px; margin-left: 8px;">Aceptado</span>
                                @endif
                            </p>
                            <p style="color: var(--text-muted); font-size: 0.8rem;">Solicita {{ $solicitud->AsientosSolicitados }} lugar(es)</p>
                            @if(str_starts_with($solicitud->Mensaje, 'Invitados: '))
                                <p style="color: var(--accent-vivid); font-size: 0.75rem; margin-top: 4px;">👥 Acompañantes: <strong>{{ substr($solicitud->Mensaje, 11) }}</strong></p>
                            @endif
                        </div>
                        <div style="display: flex; gap: 8px;">
                            @if($solicitud->IdEstado == 1)
                                <form method="POST" action="{{ route('solicitudes.update', $solicitud) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="accion" value="rechazar">
                                    <button type="submit" class="btn btn-outline" style="padding: 8px 12px; font-size: 0.75rem; color: var(--danger-text); border-color: var(--danger-soft);">Rechazar</button>
                                </form>
                                <form method="POST" action="{{ route('solicitudes.update', $solicitud) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="accion" value="aceptar">
                                    <button type="submit" class="btn" style="padding: 8px 16px; font-size: 0.75rem; background: var(--blue-primary); width: auto;">Aceptar</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('solicitudes.cancelar', $solicitud) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline" style="padding: 8px 12px; font-size: 0.75rem; color: var(--danger-red); border-color: rgba(239, 68, 68, 0.3);">Expulsar</button>
                                </form>
                            @endif
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
