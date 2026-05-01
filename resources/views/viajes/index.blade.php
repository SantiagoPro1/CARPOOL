@extends('layouts.app')

@section('content')
<div class="animate-up">
    
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="margin-right: 8px;"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="background: linear-gradient(135deg, #2563eb, #1d4ed8); width: 50px; height: 50px; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4); flex-shrink: 0;">
                <svg width="26" height="26" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
            </div>
            <div>
                <h1 class="text-gradient" style="font-size: 2.2rem; font-weight: 800; letter-spacing: -0.02em;">Mis Viajes</h1>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Gestiona tus trayectos activos y pasados</p>
            </div>
        </div>
        <a href="{{ route('viajes.create') }}" class="btn" style="width: auto; padding: 12px 20px; font-size: 0.9rem; border-radius: 14px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Publicar
        </a>
    </div>

    <!-- FILTROS Y GANANCIAS -->
    <div class="card" style="margin-bottom: 24px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; background: rgba(15, 23, 42, 0.4); border: 1px solid var(--border);">
        <form method="GET" action="{{ route('viajes.index') }}" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end;">
            <div>
                <label style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; margin-bottom: 4px; display: block;">Estado</label>
                <select name="estado" class="form-control" style="padding: 8px 12px; font-size: 0.85rem; border-radius: 8px; width: 140px;">
                    <option value="todos" {{ $filtroEstado == 'todos' ? 'selected' : '' }}>Todos</option>
                    <option value="activos" {{ $filtroEstado == 'activos' ? 'selected' : '' }}>Activos</option>
                    <option value="historial" {{ $filtroEstado == 'historial' ? 'selected' : '' }}>Historial</option>
                </select>
            </div>
            <div>
                <label style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; margin-bottom: 4px; display: block;">Período</label>
                <select name="fecha" class="form-control" style="padding: 8px 12px; font-size: 0.85rem; border-radius: 8px; width: 140px;">
                    <option value="todos" {{ $filtroFecha == 'todos' ? 'selected' : '' }}>Desde siempre</option>
                    <option value="mes" {{ $filtroFecha == 'mes' ? 'selected' : '' }}>Este Mes</option>
                    <option value="anio" {{ $filtroFecha == 'anio' ? 'selected' : '' }}>Este Año</option>
                </select>
            </div>
            <button type="submit" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.85rem; border-radius: 8px; height: 38px;">Filtrar</button>
        </form>
    </div>

    <!-- TABS DE NAVEGACIÓN -->
    <div style="display: flex; gap: 8px; margin-bottom: 24px; background: rgba(15, 23, 42, 0.5); padding: 6px; border-radius: 14px; border: 1px solid var(--border);">
        <button onclick="showSection('conductor')" id="tab-conductor" class="tab-btn active" style="flex: 1; padding: 12px; border: none; background: transparent; color: white; font-weight: 700; cursor: pointer; border-radius: 10px; transition: var(--transition);">Soy Conductor</button>
        <button onclick="showSection('pasajero')" id="tab-pasajero" class="tab-btn" style="flex: 1; padding: 12px; border: none; background: transparent; color: var(--text-muted); font-weight: 700; cursor: pointer; border-radius: 10px; transition: var(--transition);">Soy Pasajero</button>
    </div>

    <!-- SECCIÓN CONDUCTOR -->
    <div id="section-conductor" class="ride-section active">
        @if($viajes->isEmpty())
            <div class="card text-center" style="padding: 40px 20px; border-style: dashed; border-color: rgba(37, 99, 235, 0.2); background: transparent;">
                <img src="{{ asset('img/trips_empty.png') }}" alt="Sin viajes" style="width: 180px; height: 180px; object-fit: cover; border-radius: 20px; margin: 0 auto 20px; display: block; opacity: 0.85;">
                <h3 style="margin-bottom: 8px;">Aún no tienes viajes</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 24px;">Publica tu primer viaje y ayuda a la comunidad del Tec a moverse mejor.</p>
                <a href="{{ route('viajes.create') }}" class="btn" style="width: auto; padding: 12px 30px;">Comenzar ahora</a>
            </div>
        @else
            <div style="display: grid; gap: 20px;">
                @foreach($viajes as $viaje)
                    @php
                        $ultimoMsg = \App\Models\Mensaje::where('IdViaje', $viaje->IdViaje)->latest('FechaEnvio')->first();
                        $ultimaLectura = session('chat_leido_' . $viaje->IdViaje);
                        $hayMensajeNuevo = $ultimoMsg && $ultimoMsg->IdRemitente != Auth::id() && (!$ultimaLectura || $ultimoMsg->FechaEnvio > $ultimaLectura);
                        $statusColor = match($viaje->IdEstado) {
                            1 => 'var(--blue-bright)',
                            2 => '#fbbf24',
                            3 => '#10b981',
                            4 => 'var(--danger-red)',
                            default => 'var(--text-muted)'
                        };
                    @endphp
                    <div class="card" style="border-top: 4px solid {{ $statusColor }};">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                            <div>
                                <span style="font-size: 0.7rem; font-weight: 800; color: {{ $statusColor }}; text-transform: uppercase; letter-spacing: 0.05em;">VIAJE #{{ $viaje->IdViaje }}</span>
                                <h3 style="font-size: 1.3rem; margin: 4px 0;">{{ $viaje->ruta->origen->Nombre }} &rarr; {{ $viaje->ruta->destino->Nombre }}</h3>
                                <div style="display: flex; align-items: center; gap: 6px; color: var(--text-muted); font-size: 0.85rem;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($viaje->FechaSalida)->format('d M, h:i A') }}
                                </div>
                            </div>
                            <span style="font-size: 0.75rem; font-weight: 700; padding: 6px 12px; border-radius: 12px; background: {{ $statusColor }}20; color: {{ $statusColor }}; border: 1px solid {{ $statusColor }}30;">
                                {{ $viaje->estado->NombreEstado ?? 'Publicado' }}
                            </span>
                        </div>

                        @if($viaje->IdEstado == 3)
                            <div style="background: rgba(251, 191, 36, 0.05); border: 1px solid rgba(251, 191, 36, 0.2); border-radius: 12px; padding: 12px; margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <p style="font-size: 0.65rem; color: #fbbf24; text-transform: uppercase; font-weight: 800; margin: 0;">Resumen del Viaje</p>
                                    @if($viaje->pasajeros->isNotEmpty())
                                        <div style="display: flex; gap: 4px;">
                                            @foreach($viaje->pasajeros as $pasajero)
                                                @php
                                                    $yaCalificadoPasajero = \App\Models\Calificacion::where('IdViaje', $viaje->IdViaje)->where('IdEmisor', Auth::id())->where('IdUsuario', $pasajero->IdUsuario)->exists();
                                                @endphp
                                                @if(!$yaCalificadoPasajero)
                                                    <a href="{{ route('calificar.create', ['viaje' => $viaje->IdViaje, 'evaluado' => $pasajero->IdUsuario]) }}" title="Calificar a {{ explode(' ', $pasajero->NombreCompleto)[0] }}" style="width: 24px; height: 24px; border-radius: 50%; background: var(--blue-deep); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: bold; text-decoration: none; border: 1px solid rgba(255,255,255,0.1);">
                                                        {{ substr($pasajero->NombreCompleto, 0, 1) }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                @if($viaje->ObservacionesFinales)
                                    <p style="font-size: 0.85rem; font-style: italic; color: var(--text-muted);">"{{ $viaje->ObservacionesFinales }}"</p>
                                @endif
                            </div>
                        @endif



                        <div style="background: rgba(0,0,0,0.2); border-radius: 12px; padding: 12px; display: flex; justify-content: space-around; margin-bottom: 20px;">
                            <div style="text-align: center;">
                                <p style="font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; font-weight: 800;">Pasajeros</p>
                                <p style="font-weight: 700;">{{ $viaje->AsientosTotales - $viaje->AsientosDisponibles }} / {{ $viaje->AsientosTotales }}</p>
                            </div>
                            <div style="width: 1px; background: var(--border);"></div>
                            <div style="text-align: center;">
                                <p style="font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; font-weight: 800;">Recaudado</p>
                                <p style="font-weight: 700; color: #10b981;">${{ number_format(($viaje->AsientosTotales - $viaje->AsientosDisponibles) * $viaje->PrecioPorPasajero, 2) }}</p>
                            </div>
                        </div>

                        <!-- ACCIONES -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <a href="{{ route('chat.show', $viaje) }}" class="btn btn-outline" style="padding: 12px; font-size: 0.85rem;">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Chat
                                @if($hayMensajeNuevo) 
                                    <span style="display: inline-block; width: 8px; height: 8px; background: var(--blue-bright); border-radius: 50%; margin-left: 6px; box-shadow: 0 0 10px var(--blue-bright);"></span> 
                                @endif
                            </a>
                            <a href="{{ route('solicitudes.index') }}" class="btn btn-outline" style="padding: 12px; font-size: 0.85rem;">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Solicitudes
                            </a>

                            @if($viaje->IdEstado == 1) {{-- Publicado --}}
                                <form action="{{ route('viajes.iniciar', $viaje) }}" method="POST" style="grid-column: span 2;">
                                    @csrf
                                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="margin-right: 8px;"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                        Iniciar Viaje Ahora
                                    </button>
                                </form>
                            @elseif($viaje->IdEstado == 2) {{-- En Curso --}}
                                <div style="grid-column: span 2; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 12px; padding: 12px; text-align: center; color: #10b981; font-weight: 700; font-size: 0.9rem;">
                                    🚀 ¡En camino! El viaje ha comenzado.
                                </div>
                                <form action="{{ route('viajes.finalizar', $viaje) }}" method="POST" style="grid-column: span 2; display: flex; flex-direction: column; gap: 12px;">
                                    @csrf
                                    <textarea name="ObservacionesFinales" class="form-control" placeholder="¿Alguna observación? (Ej: Pasajero no llegó, contratiempo, etc.)" style="font-size: 0.85rem; padding: 10px; min-height: 60px; resize: none;"></textarea>
                                    <button type="submit" class="btn" style="background: var(--blue-deep);">
                                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="margin-right: 8px;"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"></path></svg>
                                        Finalizar Viaje
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Paginación personalizada para Conductor -->
            <div style="margin-top: 24px; display: flex; justify-content: center; width: 100%;">
                {{ $viajes->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>

    <!-- SECCIÓN PASAJERO -->
    <div id="section-pasajero" class="ride-section" style="display: none;">
        @if($viajesPasajero->isEmpty())
            <div class="card text-center" style="padding: 40px 20px;">
                <img src="{{ asset('img/search_empty.png') }}" alt="Sin viajes" style="width: 140px; height: 140px; object-fit: cover; border-radius: 20px; margin: 0 auto 16px; display: block; opacity: 0.8;">
                <h4 style="margin-bottom: 8px; font-weight: 700;">No te has unido a ningún viaje aún</h4>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 16px;">Busca un aventón y únete a un viaje con compañeros del campus.</p>
                <a href="{{ route('search.index') }}" class="btn btn-outline" style="width: auto; padding: 12px 24px;">Buscar un aventón</a>
            </div>
        @else
            <div style="display: grid; gap: 20px;">
                @foreach($viajesPasajero as $viaje)
                    <div class="card" style="border-left: 4px solid var(--accent-vivid);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                            <div style="flex: 1;">
                                <span style="font-size: 0.7rem; font-weight: 800; color: var(--accent-vivid); text-transform: uppercase;">ACOMPAÑANTE</span>
                                <h3 style="font-size: 1.2rem; margin: 4px 0;">{{ $viaje->ruta->origen->Nombre }} &rarr; {{ $viaje->ruta->destino->Nombre }}</h3>
                                <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px;">
                                    <div style="display: flex; align-items: center; gap: 4px; color: var(--text-muted); font-size: 0.8rem;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ \Carbon\Carbon::parse($viaje->FechaSalida)->format('d M Y') }}
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 4px; color: var(--text-muted); font-size: 0.8rem;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($viaje->FechaSalida)->format('h:i A') }}
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 4px; color: #10b981; font-size: 0.8rem; font-weight: 600;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        ${{ number_format($viaje->PrecioPorPasajero, 2) }}
                                    </div>
                                </div>
                                <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 8px;">Conductor: <strong>{{ $viaje->conductor->NombreCompleto }}</strong></p>
                            </div>
                            <span style="font-size: 0.75rem; font-weight: 700; padding: 6px 12px; border-radius: 12px; background: var(--accent-subtle); color: var(--accent-vivid); flex-shrink: 0; margin-left: 8px;">
                                {{ $viaje->estado->NombreEstado ?? 'Confirmado' }}
                            </span>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; border-top: 1px solid var(--border); padding-top: 16px;">
                            <a href="{{ route('chat.show', $viaje) }}" class="btn btn-outline" style="padding: 10px; font-size: 0.85rem;">Chat</a>
                            
                            @if($viaje->IdEstado == 2)
                                <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 12px; padding: 12px; text-align: center; color: #10b981; font-weight: 700; font-size: 0.9rem; margin-bottom: 20px; animation: pulse 2s infinite;">
                                    🚀 ¡En camino! El conductor ha iniciado el viaje.
                                </div>
                            @endif

                            @if($viaje->IdEstado == 3)

                                @php
                                    $yaCalifico = \App\Models\Calificacion::where('IdViaje', $viaje->IdViaje)->where('IdEmisor', Auth::id())->exists();
                                @endphp
                                @if(!$yaCalifico)
                                    <a href="{{ route('calificar.create', ['viaje' => $viaje->IdViaje, 'evaluado' => $viaje->IdConductor]) }}" class="btn" style="padding: 10px; font-size: 0.85rem;">Calificar Conductor</a>
                                @else

                                    <div style="display: flex; align-items: center; justify-content: center; font-size: 0.85rem; color: #10b981; font-weight: 700;">Completado ✓</div>
                                @endif
                            @elseif(in_array($viaje->IdEstado, [1, 2]))
                                @php
                                    $solic = \App\Models\SolicitudViaje::where('IdViaje', $viaje->IdViaje)->where('IdUsuario', Auth::id())->first();
                                @endphp
                                @if($solic && $solic->IdEstado != 4)
                                <form action="{{ route('solicitudes.cancelar', $solic) }}" method="POST" style="grid-column: span 2;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background: linear-gradient(135deg, var(--danger-red), var(--danger-dark)); color: white; font-size: 0.85rem; width: 100%;">Cancelar Pasaje</button>
                                </form>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación personalizada para Pasajero -->
            <div style="margin-top: 24px; display: flex; justify-content: center; width: 100%;">
                {{ $viajesPasajero->links('pagination::bootstrap-4') }}
            </div>
        @endif

        @if($solicitudesRechazadas->isNotEmpty())
            <div style="margin-top: 32px;">
                <h4 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--danger-text); margin-bottom: 16px;">Avisos Recientes</h4>
                <div style="display: grid; gap: 12px;">
                    @foreach($solicitudesRechazadas as $rechazada)
                        <div class="card" style="border-left: 4px solid var(--danger-red); opacity: 0.9;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <h3 style="font-size: 1rem; margin: 0;">{{ $rechazada->viaje->ruta->origen->Nombre }} &rarr; {{ $rechazada->viaje->ruta->destino->Nombre }}</h3>
                                    <p style="color: var(--text-muted); font-size: 0.8rem;">
                                        {{ $rechazada->IdEstado == 5 ? '¡Atención! El conductor te ha removido del viaje.' : 'El conductor ha declinado tu solicitud.' }}
                                    </p>
                                </div>
                                <form action="{{ route('solicitudes.dismiss', $rechazada) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline" style="width: auto; padding: 6px 12px; font-size: 0.75rem;">Entendido</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

<style>
    .tab-btn.active {
        background: var(--blue-primary) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    .ride-section {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function showSection(type) {
        document.querySelectorAll('.ride-section').forEach(s => s.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('active');
            b.style.color = 'var(--text-muted)';
        });
        
        document.getElementById('section-' + type).style.display = 'grid';
        document.getElementById('tab-' + type).classList.add('active');
        document.getElementById('tab-' + type).style.color = 'white';
    }
</script>
@endsection
