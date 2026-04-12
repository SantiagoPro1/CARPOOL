@extends('layouts.app')

@section('content')
<div class="animate-up" style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 85vh;">
    <div class="auth-card">
        <div class="text-center mb-6">
            <h1 class="auth-logo">CARPOOL</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500; letter-spacing: 0.05em;">TECNM CAMPUS COLIMA</p>
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

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="Correo">Correo Institucional</label>
            <input type="email" id="Correo" name="Correo" class="form-control" placeholder="usuario@colima.tecnm.mx" value="{{ old('Correo') }}" required autofocus>
        </div>

        <div class="form-group mb-6">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label class="form-label" for="Contrasena" style="margin-bottom: 0;">Contraseña</label>
            </div>
            <input type="password" id="Contrasena" name="Contrasena" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn">INICIAR SESIÓN</button>
    </form>

        <div class="text-center mt-4">
            <p style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">
                ¿Eres nuevo aquí? <a href="{{ route('register') }}" style="color: var(--blue-bright); text-decoration: none; font-weight: 700;">Crea una cuenta</a>
            </p>
        </div>
    </div>
</div>
@endsection
