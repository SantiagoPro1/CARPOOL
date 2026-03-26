@extends('layouts.app')

@section('content')
<div>
    <div class="text-center mb-6" style="margin-top: 20px;">
        <h2 class="auth-logo" style="font-size: 2rem;">REGISTRO</h2>
        <p style="color: var(--text-muted);">Únete a la comunidad de Carpool</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.875rem;">
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
            <input type="text" id="NombreCompleto" name="NombreCompleto" class="form-control" value="{{ old('NombreCompleto') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="Correo">Correo Institucional (@colima.tecnm.mx)</label>
            <input type="email" id="Correo" name="Correo" class="form-control" placeholder="ejemplo@colima.tecnm.mx" value="{{ old('Correo') }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="Telefono">Teléfono (Opcional)</label>
            <input type="tel" id="Telefono" name="Telefono" class="form-control" value="{{ old('Telefono') }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="Contrasena">Contraseña</label>
            <input type="password" id="Contrasena" name="Contrasena" class="form-control" required>
        </div>
        
        <div class="form-group mb-6">
            <label class="form-label" for="Contrasena_confirmation">Confirmar Contraseña</label>
            <input type="password" id="Contrasena_confirmation" name="Contrasena_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn mb-4">REGISTRARME</button>
        <a href="{{ route('login') }}" class="btn btn-outline">Ya tengo cuenta</a>
    </form>
</div>
@endsection
