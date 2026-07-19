<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = Usuario::with('rol')
            ->when($request->filled('rol_id'), function ($query) use ($request) {
                $query->where('rol_id', $request->rol_id);
            })
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('correo_institucional', 'like', '%' . $request->buscar . '%');
            })
            ->orderBy('correo_institucional')
            ->paginate(15)
            ->withQueryString();

        $roles = Rol::all();

        return view('usuarios.index', compact('usuarios', 'roles'));
    }

    public function create()
    {
        $roles = Rol::where('activo', true)->get();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'rol_id'                 => ['required', 'exists:Roles,id'],
            'correo_institucional'   => ['required', 'email', 'max:150', 'unique:Usuarios,correo_institucional'],
            'password'               => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Usuario::create([
            'rol_id'               => $datos['rol_id'],
            'correo_institucional' => $datos['correo_institucional'],
            'password_hash'        => Hash::make($datos['password']),
        ]);

        return redirect()->route('usuarios.index')->with('exito', 'Usuario creado correctamente.');
    }

    public function edit(Usuario $usuario)
    {
        $roles = Rol::where('activo', true)
            ->orWhere('id', $usuario->rol_id)
            ->get();

        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $datos = $request->validate([
            'rol_id'               => ['required', 'exists:Roles,id'],
            'correo_institucional' => ['required', 'email', 'max:150', 'unique:Usuarios,correo_institucional,' . $usuario->id],
            'password'             => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // NUEVO: evita que el usuario logueado se quite su propio rol de Admin
        if ($usuario->id === auth()->id() && $usuario->rol->nombre === 'Admin' && (int) $datos['rol_id'] !== $usuario->rol_id) {
            return back()
                ->withInput()
                ->with('error', 'No puedes cambiar tu propio rol de Admin. Pide a otro Admin que lo haga por ti.');
        }

        $actualizacion = [
            'rol_id'               => $datos['rol_id'],
            'correo_institucional' => $datos['correo_institucional'],
        ];

        if (!empty($datos['password'])) {
            $actualizacion['password_hash'] = Hash::make($datos['password']);
        }

        $usuario->update($actualizacion);

        return redirect()->route('usuarios.index')->with('exito', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        // NUEVO: evita que el usuario logueado se autoelimine
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta mientras tienes sesión iniciada.');
        }

        // NUEVO: evita que se quede el sistema sin ningún Admin
        if ($usuario->rol->nombre === 'Admin' && Usuario::whereHas('rol', fn ($q) => $q->where('nombre', 'Admin'))->count() <= 1) {
            return back()->with('error', 'No puedes eliminar al último Admin del sistema.');
        }

        $usuario->delete();
        return redirect()->route('usuarios.index')->with('exito', 'Usuario eliminado correctamente.');
    }
}
