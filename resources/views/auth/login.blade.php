@extends('layouts.app')

@section('content')
<div class="animate-up" style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 85vh;">
    <div class="auth-card">
        <div class="text-center mb-6">
            <div style="margin-bottom: 20px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #2563eb, #38bdf8); border-radius: 24px; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 10px 30px rgba(37, 99, 235, 0.4);">
                    <svg width="40" height="40" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H7c-.6 0-1.1.2-1.6.6C4.6 8.5 3 10 3 10H1v3c0 .6.4 1 1 1h1m16 3a3 3 0 11-6 0m-4 0a3 3 0 11-6 0"></path></svg>
                </div>
            </div>
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
