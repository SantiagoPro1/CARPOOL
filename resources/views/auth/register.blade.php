@extends('layouts.app')

@section('content')
<div class="animate-up" style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 85vh; padding-top: 40px; padding-bottom: 40px;">
    <div class="auth-card">
        <div class="text-center mb-6">
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
