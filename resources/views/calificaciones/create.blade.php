@extends('layouts.app')

@section('content')
<div style="margin-top: 10px;">
    <h2 style="font-size: 1.5rem; margin-bottom: 24px;">Calificar Viaje</h2>

    <form method="POST" action="{{ route('calificar.store', ['viaje' => $viaje, 'evaluado' => $evaluado]) }}" class="card">
        @csrf
        <div class="text-center" style="margin-bottom: 24px;">
            <p style="color: var(--text-muted); margin-bottom: 8px;">Califica tu experiencia viajando con</p>
            <h3 style="font-size: 1.25rem; color: var(--primary-color);">{{ $evaluado->NombreCompleto }}</h3>
        </div>

        <div class="form-group text-center">
            <label class="form-label" style="font-size: 1rem; margin-bottom: 12px;">Estrellas (1-5)</label>
            <div style="display: flex; justify-content: center; gap: 16px; margin-bottom: 8px;">
                @for($i = 1; $i <= 5; $i++)
                    <label style="cursor: pointer; display: flex; flex-direction: column; align-items: center;">
                        <input type="radio" name="Estrellas" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} style="margin-bottom: 8px; transform: scale(1.2);">
                        <span style="font-size: 1.25rem;">⭐<br><small style="color:var(--text-muted);">{{ $i }}</small></span>
                    </label>
                @endfor
            </div>
        </div>

        <div class="form-group mb-6">
            <label class="form-label">Comentarios (Opcional)</label>
            <textarea name="Comentario" class="form-control" rows="3" placeholder="¿Cómo estuvo el viaje?"></textarea>
        </div>
        
        <button type="submit" class="btn">Enviar Calificación</button>
    </form>
</div>
@endsection
