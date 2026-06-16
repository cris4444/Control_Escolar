<?php

namespace App\Http\Controllers;

use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function mostrarLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Procesa las credenciales y autentica al usuario.
     */
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'correo_institucional' => ['required', 'email'],
            'password'             => ['required', 'string'],
        ]);

        // Auth usa correo_institucional como campo de usuario
        $intentoExitoso = Auth::attempt([
            'correo_institucional' => $credenciales['correo_institucional'],
            'password'             => $credenciales['password'],
        ], $request->boolean('recordarme'));

        if (!$intentoExitoso) {
            throw ValidationException::withMessages([
                'correo_institucional' => 'Las credenciales no coinciden con nuestros registros.',
            ]);
        }

        $request->session()->regenerate();

        // Registrar acceso en la bitácora
        BitacoraAuditoria::create([
            'usuario_id'     => Auth::id(),
            'accion'         => 'LOGIN',
            'tabla_afectada' => 'Usuarios',
            'valores_json'   => ['ip' => $request->ip()],
        ]);

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Cierra la sesión del usuario autenticado.
     */
    public function logout(Request $request)
    {
        // Registrar cierre de sesión en la bitácora
        if (Auth::check()) {
            BitacoraAuditoria::create([
                'usuario_id'     => Auth::id(),
                'accion'         => 'LOGOUT',
                'tabla_afectada' => 'Usuarios',
                'valores_json'   => ['ip' => $request->ip()],
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
