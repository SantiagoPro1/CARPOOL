<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'Correo' => ['required', 'email'],
            'Contrasena' => ['required'],
        ]);

        $usuario = Usuario::where('Correo', $credentials['Correo'])->first();
        
        if ($usuario && Hash::check($credentials['Contrasena'], $usuario->getAuthPassword())) {
            Auth::login($usuario, $request->has('remember'));
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'Correo' => 'Las credenciales proporcionadas son incorrectas.',
        ])->onlyInput('Correo');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'NombreCompleto' => ['required', 'string', 'max:150'],
            'Correo' => [
                'required', 
                'email', 
                'max:120', 
                'unique:Usuarios', 
                'regex:/^[a-zA-Z0-9._%+-]+@colima\.tecnm\.mx$/'
            ],
            'Telefono' => ['nullable', 'string', 'max:20'],
            'Contrasena' => ['required', 'min:8', 'confirmed'],
        ], [
            'Correo.regex' => 'Debe utilizar su correo institucional (@colima.tecnm.mx).',
            'Correo.unique' => 'Este correo ya se encuentra registrado.',
            'Contrasena.confirmed' => 'Las contraseñas no coinciden.',
            'Contrasena.min' => 'La contraseña debe tener al menos 8 caracteres.'
        ]);

        $usuario = Usuario::create([
            'NombreCompleto' => $request->NombreCompleto,
            'Correo' => $request->Correo,
            'Telefono' => $request->Telefono,
            'Contrasena' => Hash::make($request->Contrasena),
            'Activo' => true,
        ]);

        Auth::login($usuario);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
