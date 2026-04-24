@extends('layouts.app')

@section('content')
<div class="animate-up" style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 85vh; padding-top: 40px; padding-bottom: 40px;">
    <div class="auth-card">
        <div class="text-center mb-6">
            <div style="margin-bottom: 16px;">
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #2563eb, #38bdf8); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);">
                    <svg width="32" height="32" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
            </div>
            <h2 class="auth-logo" style="font-size: 2.2rem; letter-spacing: -0.05em;">REGISTRO</h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">Únete a la nueva red de Carpool TecNM</p>
        </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="NombreCompleto">Nombre Completo</label>
            <input type="text" id="NombreCompleto" name="NombreCompleto" class="form-control" placeholder="Juan Pérez" value="{{ old('NombreCompleto') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="Correo">Correo Institucional</label>
            <input type="email" id="Correo" name="Correo" class="form-control" placeholder="usuario@colima.tecnm.mx" value="{{ old('Correo') }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="Telefono">Teléfono (Opcional)</label>
            <input type="tel" id="Telefono" name="Telefono" class="form-control" placeholder="312 000 0000" value="{{ old('Telefono') }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="Contrasena">Contraseña</label>
            <input type="password" id="Contrasena" name="Contrasena" class="form-control" placeholder="Mín. 8 caracteres" required>
        </div>
        
        <div class="form-group mb-6">
            <label class="form-label" for="Contrasena_confirmation">Confirmar Contraseña</label>
            <input type="password" id="Contrasena_confirmation" name="Contrasena_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn mb-4">CREAR MI CUENTA</button>
        <a href="{{ route('login') }}" class="btn btn-outline" style="font-size: 0.9rem;">Ya tengo acceso</a>
    </form>
    </div>
</div>
@endsection
