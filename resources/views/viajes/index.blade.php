@extends('layouts.app')

@section('content')
<div class="animate-up">
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <h1 class="text-gradient" style="font-size: 2rem; font-weight: 800; letter-spacing: -0.02em;">Mis Viajes</h1>
        <a href="{{ route('viajes.create') }}" class="btn" style="width: auto; padding: 10px 18px; font-size: 0.85rem;">+ Nuevo</a>
    </div>

    <!-- Sección Conductor -->
    <h3 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--blue-bright); margin-bottom: 16px;">Como Conductor</h3>
    
    @if($viajes->isEmpty())
        <div class="card text-center" style="padding: 40px 20px;">
            <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 20px;">No has publicado viajes hoy.</p>
            <a href="{{ route('viajes.create') }}" class="btn" style="background: var(--blue-deep);">Empezar</a>
        </div>
    @else
        <div style="display: grid; gap: 16px; margin-bottom: 40px;">
            @foreach($viajes as $viaje)
                @php
                    $ultimoMsg = \App\Models\Mensaje::where('IdViaje', $viaje->IdViaje)->latest('FechaEnvio')->first();
                    $ultimaLectura = session('chat_leido_' . $viaje->IdViaje);
                    $hayMensajeNuevo = $ultimoMsg 
                        && $ultimoMsg->IdRemitente != Auth::id()
                        && (!$ultimaLectura || $ultimoMsg->FechaEnvio > $ultimaLectura);
                @endphp
                <div class="card" style="border-left: 4px solid var(--blue-primary);">
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 0.7rem; font-weight: 700; color: var(--blue-bright); text-transform: uppercase;">VIAJE #{{ $viaje->IdViaje }}</span>
                            <span style="font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; background: rgba(37, 99, 235, 0.1); color: var(--blue-bright);">{{ $viaje->estado->NombreEstado ?? 'Publicado' }}</span>
                        </div>
                        <h3 style="font-size: 1.2rem; margin-bottom: 4px;">{{ $viaje->ruta->origen->Nombre }} &rarr; {{ $viaje->ruta->destino->Nombre }}</h3>
                        <p style="color: var(--text-muted); font-size: 0.85rem;">{{ \Carbon\Carbon::parse($viaje->FechaSalida)->format('d M, h:i A') }}</p>
                    </div>
                    
                    <div style="display: flex; gap: 24px; margin-bottom: 20px; border-top: 1px solid var(--border); padding-top: 16px;">
                        <div>
                            <p style="font-size: 0.65rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Asientos</p>
                            <span style="font-size: 1rem; font-weight: 700;">{{ $viaje->AsientosDisponibles }} disp.</span>
                        </div>
                        <div>
                            <p style="font-size: 0.65rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Precio</p>
                            <span style="font-size: 1rem; font-weight: 700;">${{ number_format($viaje->PrecioPorPasajero, 2) }}</span>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <a href="{{ route('chat.show', $viaje) }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 10px;">
                            Chat 
                            @if($hayMensajeNuevo) 
                                <span style="display: inline-block; width: 6px; height: 6px; background: var(--blue-bright); border-radius: 50%; margin-left: 6px; box-shadow: 0 0 8px var(--blue-bright);"></span> 
                            @endif
                        </a>
                        <a href="{{ route('solicitudes.index') }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 10px;">Solicitudes</a>
                        
                        @if(in_array($viaje->IdEstado, [1, 2]))
                        <form action="{{ route('viajes.update', $viaje) }}" method="POST" style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                            @csrf
                            @method('PUT')
                            <button name="IdEstado" value="3" type="submit" class="btn" style="background: var(--blue-deep); font-size: 0.85rem;">Terminar</button>
                            <button name="IdEstado" value="4" type="submit" class="btn" style="background: linear-gradient(135deg, var(--danger-red), var(--danger-dark)); color: white; font-size: 0.85rem;">✕ Cancelar</button>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Sección Pasajero -->
    <h3 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--accent-vivid); margin-bottom: 16px;">Como Pasajero</h3>
    
    @if($viajesPasajero->isEmpty())
        <div class="card text-center">
            <p style="color: var(--text-muted); font-size: 0.95rem;">No tienes viajes pendientes como pasajero.</p>
        </div>
    @else
        <div style="display: grid; gap: 16px;">
            @foreach($viajesPasajero as $viaje)
                @php
                    $ultimoMsgPasajero = \App\Models\Mensaje::where('IdViaje', $viaje->IdViaje)->latest('FechaEnvio')->first();
                    $ultimaLecturaPasajero = session('chat_leido_' . $viaje->IdViaje);
                    $hayNuevoPasajero = $ultimoMsgPasajero 
                        && $ultimoMsgPasajero->IdRemitente != Auth::id()
                        && (!$ultimaLecturaPasajero || $ultimoMsgPasajero->FechaEnvio > $ultimaLecturaPasajero);
                @endphp
                <div class="card" style="border-left: 4px solid var(--accent-vivid);">
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 0.7rem; font-weight: 700; color: var(--accent-vivid); text-transform: uppercase;">PASAJERO</span>
                            <span style="font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; background: var(--accent-subtle); color: var(--accent-vivid);">{{ $viaje->estado->NombreEstado ?? 'Confirmado' }}</span>
                        </div>
                        <h3 style="font-size: 1.2rem; margin-bottom: 4px;">{{ $viaje->ruta->origen->Nombre }} &rarr; {{ $viaje->ruta->destino->Nombre }}</h3>
                        <p style="color: var(--text-muted); font-size: 0.85rem;">Conductor: <strong>{{ $viaje->conductor->NombreCompleto }}</strong></p>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; border-top: 1px solid var(--border); padding-top: 16px;">
                        <a href="{{ route('chat.show', $viaje) }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 10px;">
                            Chat
                            @if($hayNuevoPasajero) 
                                <span style="display: inline-block; width: 6px; height: 6px; background: var(--blue-bright); border-radius: 50%; margin-left: 6px; box-shadow: 0 0 8px var(--blue-bright);"></span> 
                            @endif
                        </a>

                        @if($viaje->IdEstado == 3)
                            @php
                                $yaCalifico = \App\Models\Calificacion::where('IdViaje', $viaje->IdViaje)
                                    ->where('IdEmisor', Auth::id())
                                    ->exists();
                            @endphp
                            @if(!$yaCalifico)
                                <a href="{{ route('calificar.create', ['viaje' => $viaje->IdViaje, 'evaluado' => $viaje->IdConductor]) }}" class="btn" style="font-size: 0.85rem; padding: 10px;">Calificar</a>
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; font-size: 0.85rem; color: #10b981; font-weight: 700;">Calificado ✓</div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
