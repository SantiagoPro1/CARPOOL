@extends('layouts.app')

@section('content')
<div style="display: flex; flex-direction: column; height: 80vh; margin-top: 10px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
        <a href="{{ route('viajes.index') }}" style="color: var(--text-muted); text-decoration: none; padding: 8px;">&larr; Volver</a>
        <div>
            <h2 style="font-size: 1.25rem; margin: 0;">Chat del Viaje</h2>
            <p style="font-size: 0.75rem; color: var(--text-muted);">{{ $viaje->ruta->origen->Nombre ?? 'Origen' }} &rarr; {{ $viaje->ruta->destino->Nombre ?? 'Destino' }}</p>
        </div>
    </div>

    <!-- Área de Mensajes -->
    <div class="card" style="flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; margin-bottom: 16px; padding: 16px;">
        @if($mensajes->isEmpty())
            <p style="text-align: center; color: var(--text-muted); margin: auto;">No hay mensajes aún. ¡Comienza a comunicarte para planear el viaje!</p>
        @else
            @foreach($mensajes as $msg)
                @php $esMio = $msg->IdRemitente == Auth::id(); @endphp
                <div style="display: flex; flex-direction: column; align-items: {{ $esMio ? 'flex-end' : 'flex-start' }};">
                    <span style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 2px;">{{ $msg->remitente->NombreCompleto ?? 'Usuario' }}</span>
                    <div style="background: {{ $esMio ? 'var(--primary-color)' : 'rgba(255,255,255,0.1)' }}; color: #fff; padding: 8px 12px; border-radius: {{ $esMio ? '16px 16px 4px 16px' : '16px 16px 16px 4px' }}; max-width: 85%; font-size: 0.95rem;">
                        {{ $msg->Contenido }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Enviar Mensaje -->
    <form method="POST" action="{{ route('chat.store', $viaje) }}" style="display: flex; gap: 8px;">
        @csrf
        <input type="text" name="Contenido" class="form-control" placeholder="Escribe un mensaje..." required style="flex: 1;" autocomplete="off" autofocus>
        <button type="submit" class="btn" style="width: auto; padding: 12px 20px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
        </button>
    </form>
</div>
@endsection
