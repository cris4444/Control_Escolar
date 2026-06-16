<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all();
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
        $roles = Rol::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $datos = $request->validate([
            'rol_id'               => ['required', 'exists:Roles,id'],
            'correo_institucional' => ['required', 'email', 'max:150', 'unique:Usuarios,correo_institucional,' . $usuario->id],
            'password'             => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

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
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('exito', 'Usuario eliminado correctamente.');
    }
}
