@extends('layouts.app')

@section('content')
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 85vh;">
    <div class="auth-card">
        <div class="text-center mb-6">
            <h1 class="auth-logo">CARPOOL</h1>
            <p style="color: var(--text-muted);">TecNM Campus Colima</p>
        </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="list-style: none; padding: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="Correo">Correo Institucional</label>
            <input type="email" id="Correo" name="Correo" class="form-control" placeholder="usuario@colima.tecnm.mx" value="{{ old('Correo') }}" required autofocus>
        </div>

        <div class="form-group mb-6">
            <label class="form-label" for="Contrasena">Contraseña</label>
            <input type="password" id="Contrasena" name="Contrasena" class="form-control" required>
        </div>

        <button type="submit" class="btn">INICIAR SESIÓN</button>
    </form>

        <div class="text-center mt-4">
            <p style="color: var(--text-muted); font-size: 0.875rem;">
                ¿No tienes cuenta? <a href="{{ route('register') }}" style="color: var(--primary-color); text-decoration: none;">Regístrate</a>
            </p>
        </div>
    </div>
</div>
@endsection
