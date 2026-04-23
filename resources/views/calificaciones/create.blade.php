@extends('layouts.app')

@section('content')
<div class="animate-up">
    <div style="margin-bottom: 32px;">
        <h1 class="text-gradient" style="font-size: 2.2rem; font-weight: 800; letter-spacing: -0.02em;">Calificar Experiencia</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Tu opinión ayuda a mantener segura la comunidad</p>
    </div>

    <form method="POST" action="{{ route('calificar.store', ['viaje' => $viaje, 'evaluado' => $evaluado]) }}" class="card" style="padding: 32px;">
        @csrf
        
        <div style="text-align: center; margin-bottom: 40px;">
            <div style="width: 80px; height: 80px; background: var(--blue-deep); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 4px solid rgba(37, 99, 235, 0.1);">
                <span style="font-size: 2rem; font-weight: 800; color: white;">{{ substr($evaluado->NombreCompleto, 0, 1) }}</span>
            </div>
            <p style="color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700;">Calificando a</p>
            <h3 style="font-size: 1.5rem; margin-top: 4px;">{{ $evaluado->NombreCompleto }}</h3>
        </div>

        <div class="form-group" style="text-align: center;">
            <label class="form-label" style="font-size: 0.9rem; margin-bottom: 20px;">¿Cómo calificarías el viaje?</label>
            <div class="rating-group" style="display: flex; flex-direction: row-reverse; justify-content: center; gap: 4px; margin-bottom: 32px;">
                @for($i = 5; $i >= 1; $i--)
                    <label class="rating-star">
                        <input type="radio" name="Estrellas" value="{{ $i }}" class="sr-only" required>
                        <div class="star-icon">


                            <svg width="36" height="36" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                    </label>
                @endfor
            </div>

        </div>

        <div class="form-group">
            <label class="form-label">Comentarios del Viaje</label>
            <textarea name="Comentario" class="form-control" rows="4" placeholder="Cuéntanos más sobre tu experiencia con el conductor, el vehículo o el trayecto..." style="resize: none;"></textarea>
            <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 8px;">* Tus comentarios son anónimos para el conductor.</p>
        </div>

        
        <div style="margin-top: 32px;">
            <button type="submit" class="btn">Enviar Calificación</button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline" style="margin-top: 12px; border: none; color: var(--text-muted);">Omitir por ahora</a>
        </div>

    </form>
</div>

<style>
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }
    .rating-group {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 8px;
        margin-bottom: 32px;
    }
    .rating-star input {
        display: none;
    }
    .star-icon {
        color: #334155;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
    }
    /* Hover state: highlight hovered star and all subsequent siblings (which are visually to the left) */
    .rating-star:hover .star-icon,
    .rating-star:hover ~ .rating-star .star-icon {
        color: #fbbf24;
        transform: scale(1.1);
    }
    /* Checked state: highlight checked star and all subsequent siblings */
    .rating-star:has(input:checked) .star-icon,
    .rating-star:has(input:checked) ~ .rating-star .star-icon {
        color: #fbbf24;
    }
    /* Interaction: when hovering, hover state should override checked state for ALL stars */
    .rating-group:hover .star-icon {
        color: #334155;
    }
    .rating-group:hover .rating-star:hover .star-icon,
    .rating-group:hover .rating-star:hover ~ .rating-star .star-icon {
        color: #fbbf24;
    }





</style>
@endsection
