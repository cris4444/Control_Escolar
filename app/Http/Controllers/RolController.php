<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'      => ['required', 'string', 'max:50', 'unique:Roles,nombre'],
            'descripcion' => ['nullable', 'string'],
        ]);

        Rol::create($datos);

        return redirect()->route('roles.index')->with('exito', 'Rol creado correctamente.');
    }

    public function edit(Rol $rol)
    {
        return view('roles.edit', compact('rol'));
    }

    public function update(Request $request, Rol $rol)
    {
        $datos = $request->validate([
            'nombre'      => ['required', 'string', 'max:50', 'unique:Roles,nombre,' . $rol->id],
            'descripcion' => ['nullable', 'string'],
        ]);

        $rol->update($datos);

        return redirect()->route('roles.index')->with('exito', 'Rol actualizado correctamente.');
    }

    public function destroy(Rol $rol)
    {
        $rol->delete();
        return redirect()->route('roles.index')->with('exito', 'Rol eliminado correctamente.');
    }
}
