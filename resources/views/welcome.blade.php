<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARPOOL — TecNM Colima</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #020617;
            --surface-color: #0f172a;
            --primary-color: #2563eb;
            --text-color: #f8fafc;
            --text-muted: #64748b;
            --blue-bright: #38bdf8;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body, html {
            font-family: 'Outfit', -apple-system, sans-serif;
            background-color: var(--bg-color); color: var(--text-color);
            min-height: 100vh; -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            padding: 20px 40px; display: flex; justify-content: space-between; align-items: center;
            position: relative; z-index: 10;
        }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-icon { width: 42px; height: 42px; background: linear-gradient(135deg, #2563eb, #38bdf8); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4); }
        .brand h1 { font-size: 1.4rem; font-weight: 800; background: linear-gradient(135deg, #f8fafc, #38bdf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links { display: flex; align-items: center; gap: 16px; }
        .nav-links a { color: var(--text-muted); text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.3s; }
        .nav-links a:hover { color: white; }

        /* Hero */
        .hero {
            text-align: center; padding: 40px 20px 60px;
            position: relative;
        }
        .hero::before {
            content: ''; position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 800px; height: 800px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, transparent 60%);
            pointer-events: none;
        }
        .hero-img {
            width: 100%; max-width: 600px; border-radius: 24px; margin: 0 auto 40px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.5); position: relative; z-index: 2;
            border: 1px solid rgba(56, 189, 248, 0.15);
        }
        .hero h2 {
            font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 800; max-width: 700px;
            margin: 0 auto 20px; line-height: 1.15; letter-spacing: -0.03em;
            background: linear-gradient(135deg, #f8fafc 30%, #38bdf8 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero p { font-size: 1.1rem; color: var(--text-muted); max-width: 550px; margin: 0 auto 36px; line-height: 1.6; }
        .hero-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; padding: 16px 36px;
            border-radius: 16px; text-decoration: none; font-weight: 700; font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.4);
            display: inline-flex; align-items: center; gap: 10px; border: none; cursor: pointer;
        }
        .btn-primary:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 10px 30px rgba(37, 99, 235, 0.6); }
        .btn-ghost {
            background: rgba(255,255,255,0.05); color: white; padding: 16px 36px;
            border-radius: 16px; text-decoration: none; font-weight: 700; font-size: 1rem;
            border: 1px solid rgba(255,255,255,0.1); transition: all 0.4s; cursor: pointer;
            display: inline-flex; align-items: center; gap: 10px;
        }
        .btn-ghost:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); transform: translateY(-2px); }

        /* Features */
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; padding: 60px 40px; max-width: 1000px; margin: 0 auto; }
        .feature-card {
            background: linear-gradient(135deg, #111827, #0f172a); padding: 30px; border-radius: 20px;
            border: 1px solid rgba(148, 163, 184, 0.08); text-align: center;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); position: relative; overflow: hidden;
        }
        .feature-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 60%);
            pointer-events: none;
        }
        .feature-card:hover { transform: translateY(-6px); border-color: rgba(37, 99, 235, 0.3); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        .feature-icon {
            width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center;
            justify-content: center; margin: 0 auto 20px;
        }
        .feature-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 10px; }
        .feature-card p { font-size: 0.9rem; color: var(--text-muted); line-height: 1.5; }

        /* Footer */
        .footer { text-align: center; padding: 40px 20px; color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid rgba(148, 163, 184, 0.08); margin-top: 40px; }

        /* Animations */
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-in { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="brand">
            <div class="brand-icon">
                <svg width="24" height="24" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H7c-.6 0-1.1.2-1.6.6C4.6 8.5 3 10 3 10H1v3c0 .6.4 1 1 1h1m16 3a3 3 0 11-6 0m-4 0a3 3 0 11-6 0"></path></svg>
            </div>
            <h1>CARPOOL</h1>
        </div>
        <div class="nav-links">
            @if(Auth::check())
                <a href="{{ route('dashboard') }}" class="btn-primary" style="padding: 10px 24px; font-size: 0.9rem;">Mi Panel</a>
            @else
                <a href="{{ route('login') }}">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn-primary" style="padding: 10px 24px; font-size: 0.9rem;">Registrarse</a>
            @endif
        </div>
    </div>
    
    <div class="hero">
        <img src="{{ asset('img/hero_carpool.png') }}" alt="Carpool TecNM" class="hero-img animate-in delay-1" style="animation: fadeUp 0.8s ease forwards, float 6s ease-in-out 1s infinite;">
        <h2 class="animate-in delay-2">Viaja más rápido, barato y con compañeros del Tec</h2>
        <p class="animate-in delay-3">Comparte tus viajes, ahorra dinero y reduce tu huella de carbono. Conecta con otros estudiantes y haz que cada trayecto cuente.</p>
        <div class="hero-btns animate-in delay-4">
            @if(Auth::check())
                <a href="{{ route('dashboard') }}" class="btn-primary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    Ir a mi Panel
                </a>
            @else
                <a href="{{ route('register') }}" class="btn-primary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    Empieza Gratis
                </a>
                <a href="{{ route('login') }}" class="btn-ghost">Ya tengo cuenta</a>
            @endif
        </div>
    </div>

    <div class="features">
        <div class="feature-card animate-in delay-2">
            <div class="feature-icon" style="background: rgba(37, 99, 235, 0.1);">
                <svg width="28" height="28" fill="none" stroke="#38bdf8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3>Comparte Gastos</h3>
            <p>Divide los gastos de gasolina y peajes. Viaja cómodamente mientras ahorras dinero cada semana.</p>
        </div>
        <div class="feature-card animate-in delay-3">
            <div class="feature-icon" style="background: rgba(16, 185, 129, 0.1);">
                <svg width="28" height="28" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3>Conoce Gente</h3>
            <p>Viaja con pasajeros de tu campus y haz el trayecto más ameno. Chat en tiempo real con tu grupo.</p>
        </div>
        <div class="feature-card animate-in delay-4">
            <div class="feature-icon" style="background: rgba(251, 191, 36, 0.1);">
                <svg width="28" height="28" fill="none" stroke="#fbbf24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3>Ayuda al Planeta</h3>
            <p>Menos autos significan menos emisiones. Haz tu parte compartiendo el viaje con tus compañeros.</p>
        </div>
    </div>

    <div class="footer">
        <p>CARPOOL &copy; 2026 — TecNM Campus Colima. Hecho con 💙 por estudiantes, para estudiantes.</p>
    </div>
</body>
</html>
