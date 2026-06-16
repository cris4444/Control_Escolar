<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Usuario;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::with(['carrera', 'usuario.rol'])->get();
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $carreras = Carrera::all();
        return view('alumnos.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'correo_institucional' => ['required', 'email', 'max:150', 'unique:Usuarios,correo_institucional'],
            'password'             => ['required', 'string', 'min:8'],
            'carrera_id'           => ['required', 'exists:Carreras,id'],
            'matricula'            => ['required', 'string', 'max:50', 'unique:Alumnos,matricula'],
            'nombres'              => ['required', 'string', 'max:100'],
            'apellidos'            => ['required', 'string', 'max:100'],
            'curp'                 => ['required', 'string', 'size:18', 'unique:Alumnos,curp'],
            'estatus'              => ['nullable', 'string', 'max:50'],
        ]);

        // Obtener el rol de Alumno dinámicamente
        $rolAlumno = \App\Models\Rol::where('nombre', 'Alumno')->firstOrFail();

        // Crear el usuario base
        $usuario = Usuario::create([
            'rol_id'               => $rolAlumno->id,
            'correo_institucional' => $datos['correo_institucional'],
            'password_hash'        => Hash::make($datos['password']),
        ]);

        // Crear el perfil del alumno
        Alumno::create([
            'usuario_id' => $usuario->id,
            'carrera_id' => $datos['carrera_id'],
            'matricula'  => $datos['matricula'],
            'nombres'    => $datos['nombres'],
            'apellidos'  => $datos['apellidos'],
            'curp'       => $datos['curp'],
            'estatus'    => $datos['estatus'] ?? 'Activo',
        ]);

        return redirect()->route('alumnos.index')->with('exito', 'Alumno registrado correctamente.');
    }

    public function show(Alumno $alumno)
    {
        $alumno->load(['carrera', 'usuario', 'kardexInscripciones.grupo.materia', 'asistencias']);
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        $carreras = Carrera::all();
        return view('alumnos.edit', compact('alumno', 'carreras'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $datos = $request->validate([
            'carrera_id' => ['required', 'exists:Carreras,id'],
            'matricula'  => ['required', 'string', 'max:50', 'unique:Alumnos,matricula,' . $alumno->id],
            'nombres'    => ['required', 'string', 'max:100'],
            'apellidos'  => ['required', 'string', 'max:100'],
            'curp'       => ['required', 'string', 'size:18', 'unique:Alumnos,curp,' . $alumno->id],
            'estatus'    => ['nullable', 'string', 'max:50'],
        ]);

        $alumno->update($datos);

        return redirect()->route('alumnos.index')->with('exito', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('exito', 'Alumno eliminado correctamente.');
    }
}
