<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // Módulos de permisos que realmente tienen efecto para cada rol,
    // según a qué grupos de rutas (middleware rol:) pertenece cada uno.
    // Si agregas un rol nuevo a un grupo de rutas en web.php, agrégalo aquí también.
    private array $modulosPorRol = [
        'Admin' => ['usuarios', 'roles', 'bitacora', 'aulas', 'periodos', 'carreras', 'materias', 'alumnos', 'docentes', 'grupos', 'kardex', 'asistencias'],
        'Personal Administrativo' => ['materias', 'alumnos', 'docentes', 'grupos', 'kardex'],
        'Docente' => ['kardex', 'asistencias'],
        'Alumno' => [], // sus rutas (mi-kardex, mis-asistencias) no usan permiso: todavía
    ];

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
        $todosLosPermisos = collect(Permiso::orderBy('clave')->get()->groupBy('modulo'));

        // Filtra solo los módulos que realmente aplican a este rol según las rutas
        $modulosAplicables = $this->modulosPorRol[$rol->nombre] ?? null;

        if ($modulosAplicables !== null) {
            $permisosPorModulo = $todosLosPermisos->only($modulosAplicables);
            $permisosSinEfecto = $todosLosPermisos->except($modulosAplicables);
        } else {
            // Rol nuevo/custom que no está en ningún grupo de rutas todavía
            $permisosPorModulo = $todosLosPermisos;
            $permisosSinEfecto = collect();
        }

        $permisosAsignados = $rol->permisos()->pluck('Permisos.id')->toArray();

        return view('roles.edit', compact('rol', 'permisosPorModulo', 'permisosAsignados', 'permisosSinEfecto', 'modulosAplicables'));
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
