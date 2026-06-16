<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::with('usuario.rol')->get();
        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        return view('docentes.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'correo_institucional' => ['required', 'email', 'max:150', 'unique:Usuarios,correo_institucional'],
            'password'             => ['required', 'string', 'min:8'],
            'numero_empleado'      => ['required', 'string', 'max:50', 'unique:Docentes,numero_empleado'],
            'nombres'              => ['required', 'string', 'max:100'],
            'apellidos'            => ['required', 'string', 'max:100'],
            'especialidad'         => ['nullable', 'string', 'max:150'],
        ]);

        $rolDocente = Rol::where('nombre', 'Docente')->firstOrFail();

        $usuario = Usuario::create([
            'rol_id'               => $rolDocente->id,
            'correo_institucional' => $datos['correo_institucional'],
            'password_hash'        => Hash::make($datos['password']),
        ]);

        Docente::create([
            'usuario_id'      => $usuario->id,
            'numero_empleado' => $datos['numero_empleado'],
            'nombres'         => $datos['nombres'],
            'apellidos'       => $datos['apellidos'],
            'especialidad'    => $datos['especialidad'],
        ]);

        return redirect()->route('docentes.index')->with('exito', 'Docente registrado correctamente.');
    }

    public function show(Docente $docente)
    {
        $docente->load(['usuario', 'grupos.materia', 'grupos.periodo']);
        return view('docentes.show', compact('docente'));
    }

    public function edit(Docente $docente)
    {
        return view('docentes.edit', compact('docente'));
    }

    public function update(Request $request, Docente $docente)
    {
        $datos = $request->validate([
            'numero_empleado' => ['required', 'string', 'max:50', 'unique:Docentes,numero_empleado,' . $docente->id],
            'nombres'         => ['required', 'string', 'max:100'],
            'apellidos'       => ['required', 'string', 'max:100'],
            'especialidad'    => ['nullable', 'string', 'max:150'],
        ]);

        $docente->update($datos);

        return redirect()->route('docentes.index')->with('exito', 'Docente actualizado correctamente.');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();
        return redirect()->route('docentes.index')->with('exito', 'Docente eliminado correctamente.');
    }
}
