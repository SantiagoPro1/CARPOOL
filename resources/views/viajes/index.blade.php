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

    <style>
        .tabs-nav { display: flex; gap: 12px; margin-bottom: 32px; border-bottom: 2px solid var(--border); padding-bottom: 12px; }
        .tab-btn { background: none; border: none; color: var(--text-muted); font-size: 1.05rem; font-weight: 600; cursor: pointer; padding: 10px 20px; border-radius: 8px; transition: all 0.3s; }
        .tab-btn:hover { background: rgba(255,255,255,0.05); color: white; }
        .tab-btn.active { background: var(--blue-primary); color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="tabs-nav">
        <button class="tab-btn active" onclick="showTab('conductor', this)">Como Conductor</button>
        <button class="tab-btn" onclick="showTab('pasajero', this)">Como Pasajero</button>
    </div>

    <!-- Sección Conductor -->
    <div id="tab-conductor" class="tab-content active">
    
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
                            <span style="font-size: 0.7rem; font-weight: 700; color: var(--blue-bright); text-transform: uppercase;">CONDUCTOR</span>
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
                        <a href="{{ route('chat.show', $viaje) }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 10px; grid-column: span 1;">
                            Chat 
                            @if($hayMensajeNuevo) 
                                <span style="display: inline-block; width: 6px; height: 6px; background: var(--blue-bright); border-radius: 50%; margin-left: 6px; box-shadow: 0 0 8px var(--blue-bright);"></span> 
                            @endif
                        </a>
                        <a href="{{ route('solicitudes.index') }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 10px; grid-column: span 1;">Solicitudes</a>
                        
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
    </div>

    <!-- Sección Pasajero -->
    <div id="tab-pasajero" class="tab-content">
    
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
                        @elseif(in_array($viaje->IdEstado, [1, 2]))
                            @php
                                $solic = \App\Models\SolicitudViaje::where('IdViaje', $viaje->IdViaje)->where('IdUsuario', Auth::id())->first();
                            @endphp
                            @if($solic && $solic->IdEstado != 4)
                            <form action="{{ route('solicitudes.cancelar', $solic) }}" method="POST" style="margin-top: 12px; height: 100%;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" style="background: linear-gradient(135deg, var(--danger-red), var(--danger-dark)); color: white; font-size: 0.85rem; width: 100%; padding: 12px; border-radius: 8px;">Cancelar Pasaje</button>
                            </form>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    </div>

    <script>
        function showTab(tabId, element) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('tab-' + tabId).classList.add('active');
            element.classList.add('active');
        }
    </script>
</div>
@endsection
