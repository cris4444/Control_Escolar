<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Alumno;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    public function index()
    {
        $asistencias = Asistencia::with(['alumno', 'grupo.materia'])->orderByDesc('fecha')->get();
        return view('asistencias.index', compact('asistencias'));
    }

    public function create()
    {
        $alumnos = Alumno::all();
        $grupos  = Grupo::with('materia')->get();

        return view('asistencias.create', compact('alumnos', 'grupos'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'alumno_id'         => ['required', 'exists:Alumnos,id'],
            'grupo_id'          => ['required', 'exists:Grupos,id'],
            'fecha'             => ['required', 'date'],
            'estatus_asistencia'=> ['required', 'string', 'max:50'],
        ]);

        Asistencia::create($datos);

        return redirect()->route('asistencias.index')->with('exito', 'Asistencia registrada correctamente.');
    }

    public function edit(Asistencia $asistencia)
    {
        $alumnos = Alumno::all();
        $grupos  = Grupo::with('materia')->get();

        return view('asistencias.edit', compact('asistencia', 'alumnos', 'grupos'));
    }

    public function update(Request $request, Asistencia $asistencia)
    {
        $datos = $request->validate([
            'alumno_id'         => ['required', 'exists:Alumnos,id'],
            'grupo_id'          => ['required', 'exists:Grupos,id'],
            'fecha'             => ['required', 'date'],
            'estatus_asistencia'=> ['required', 'string', 'max:50'],
        ]);

        $asistencia->update($datos);

        return redirect()->route('asistencias.index')->with('exito', 'Asistencia actualizada correctamente.');
    }

    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();
        return redirect()->route('asistencias.index')->with('exito', 'Asistencia eliminada correctamente.');
    }

    /**
     * Listado de asistencias del alumno autenticado.
     */
    public function misAsistencias()
    {
        $alumno      = Auth::user()->alumno;
        $asistencias = $alumno->asistencias()->with(['grupo.materia'])->orderByDesc('fecha')->get();

        return view('asistencias.mis-asistencias', compact('alumno', 'asistencias'));
    }
}
