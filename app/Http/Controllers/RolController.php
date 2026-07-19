<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index(Request $request)
    {
        $roles = Rol::query()
            ->withCount(['usuarios', 'permisos'])
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%');
            })
            ->orderBy('nombre')
            ->get();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permisosPorModulo = Permiso::orderBy('clave')->get()->groupBy('modulo');

        return view('roles.create', compact('permisosPorModulo'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'      => ['required', 'string', 'max:50', 'unique:Roles,nombre'],
            'descripcion' => ['nullable', 'string', 'max:150'],
            'permisos'    => ['array'],
            'permisos.*'  => ['exists:Permisos,id'],
        ]);

        $rol = Rol::create([
            'nombre'      => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
            'activo'      => true,
        ]);

        $rol->permisos()->sync($datos['permisos'] ?? []);

        return redirect()->route('roles.index')->with('exito', "Rol '{$rol->nombre}' creado correctamente.");
    }

    public function edit(Rol $rol)
    {
        $permisosPorModulo = Permiso::orderBy('clave')->get()->groupBy('modulo');
        $permisosAsignados = $rol->permisos()->pluck('Permisos.id')->toArray();

        return view('roles.edit', compact('rol', 'permisosPorModulo', 'permisosAsignados'));
    }

    public function update(Request $request, Rol $rol)
    {
        $datos = $request->validate([
            'nombre'      => ['required', 'string', 'max:50', 'unique:Roles,nombre,' . $rol->id],
            'descripcion' => ['nullable', 'string', 'max:150'],
            'activo'      => ['nullable', 'boolean'],
            'permisos'    => ['array'],
            'permisos.*'  => ['exists:Permisos,id'],
        ]);

        $rol->update([
            'nombre'      => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
            'activo'      => $request->boolean('activo'),
        ]);

        $rol->permisos()->sync($datos['permisos'] ?? []);

        return redirect()->route('roles.index')->with('exito', "Rol '{$rol->nombre}' actualizado correctamente.");
    }

    public function destroy(Rol $rol)
    {
        if ($rol->usuarios()->count() > 0) {
            return back()->with('error', "No puedes eliminar '{$rol->nombre}': tiene usuarios asignados a este rol.");
        }

        if (in_array($rol->nombre, ['Admin', 'Docente', 'Alumno', 'Personal Administrativo'])) {
            return back()->with('error', "El rol '{$rol->nombre}' es un rol base del sistema y no se puede eliminar.");
        }

        $rol->delete();

        return redirect()->route('roles.index')->with('exito', 'Rol eliminado correctamente.');
    }
}
