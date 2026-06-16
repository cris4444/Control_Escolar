<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Muestra el panel principal según el rol del usuario autenticado.
     */
    public function index()
    {
        $usuario = Usuario::with('rol')->find(Auth::id());

        return view('dashboard.index', compact('usuario'));
    }
}
