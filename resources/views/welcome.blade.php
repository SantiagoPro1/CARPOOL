<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a CARPOOL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0f172a;
            --surface-color: #1e293b;
            --primary-color: #3b82f6;
            --text-color: #f8fafc;
            --text-muted: #94a3b8;
        }
        body, html {
            margin: 0; padding: 0; font-family: 'Inter', sans-serif;
            background-color: var(--bg-color); color: var(--text-color);
            display: flex; flex-direction: column; min-height: 100vh;
        }
        .navbar {
            padding: 20px 40px; display: flex; justify-content: space-between; align-items: center;
        }
        .navbar h1 { margin: 0; font-size: 1.5rem; font-weight: 800; color: var(--primary-color); }
        .nav-links a { color: var(--text-color); text-decoration: none; margin-left: 20px; font-weight: 500; }
        .hero {
            flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; padding: 40px 20px; background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);
        }
        h2 { font-size: 3rem; margin-bottom: 20px; font-weight: 800; max-width: 800px; line-height: 1.2; }
        p { font-size: 1.25rem; color: var(--text-muted); max-width: 600px; margin-bottom: 40px; }
        .btn {
            background-color: var(--primary-color); color: white; padding: 16px 32px;
            border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 1.1rem;
            transition: all 0.3s;
        }
        .btn:hover { background-color: #2563eb; transform: translateY(-2px); }
        .btn-outline { background: transparent; border: 2px solid var(--primary-color); margin-left: 16px; }
        .btn-outline:hover { background: rgba(59, 130, 246, 0.1); }
        .features {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; padding: 60px 40px;
        }
        .feature-card {
            background: var(--surface-color); padding: 30px; border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); text-align: center;
        }
        .feature-card h3 { color: var(--primary-color); margin-top: 0; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>CARPOOL</h1>
        <div class="nav-links">
            @if(Auth::check())
                <a href="{{ route('dashboard') }}" class="btn" style="padding: 10px 20px;">Mi Panel</a>
            @else
                <a href="{{ route('login') }}">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn" style="padding: 10px 20px;">Registrarse</a>
            @endif
        </div>
    </div>
    
    <div class="hero">
        <h2>Viaja más rápido, barato y de forma sostenible</h2>
        <p>Comparte tus viajes con amigos, ahorra dinero y reduce tu huella de carbono. Conecta con otros usuarios y haz que cada viaje cuente.</p>
        <div>
            @if(Auth::check())
            <a href="{{ route('dashboard') }}" class="btn">Ir a mi Panel</a>
            @else
            <a href="{{ route('register') }}" class="btn">Empieza Gratis</a>
            <a href="{{ route('login') }}" class="btn btn-outline">Ya tengo cuenta</a>
            @endif
        </div>
    </div>

    <div class="features">
        <div class="feature-card">
            <h3>Comparte Gastos</h3>
            <p>Divide los gastos de gasolina y peajes. Viaja cómodamente mientras ahorras.</p>
        </div>
        <div class="feature-card">
            <h3>Conoce Gente</h3>
            <p>Viaja con pasajeros de tu universidad o trabajo y haz el trayecto más ameno.</p>
        </div>
        <div class="feature-card">
            <h3>Ayuda al Planeta</h3>
            <p>Menos autos significan menos emisiones. Haz tu parte compartiendo el viaje.</p>
        </div>
    </div>
</body>
</html>
