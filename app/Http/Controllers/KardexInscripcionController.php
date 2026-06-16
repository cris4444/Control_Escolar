<?php

namespace App\Http\Controllers;

use App\Models\KardexInscripcion;
use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\TipoEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KardexInscripcionController extends Controller
{
    public function index()
    {
        $inscripciones = KardexInscripcion::with(['alumno', 'grupo.materia', 'tipoEvaluacion'])->get();
        return view('kardex.index', compact('inscripciones'));
    }

    public function create()
    {
        $alumnos         = Alumno::all();
        $grupos          = Grupo::with('materia')->get();
        $tiposEvaluacion = TipoEvaluacion::all();

        return view('kardex.create', compact('alumnos', 'grupos', 'tiposEvaluacion'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'alumno_id'          => ['required', 'exists:Alumnos,id'],
            'grupo_id'           => ['required', 'exists:Grupos,id'],
            'tipo_evaluacion_id' => ['required', 'exists:Tipos_Evaluacion,id'],
            'calificacion_final' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'estatus_materia'    => ['nullable', 'string', 'max:50'],
        ]);

        KardexInscripcion::create($datos);

        return redirect()->route('kardex.index')->with('exito', 'Inscripción registrada correctamente.');
    }

    public function show(KardexInscripcion $kardex)
    {
        $kardex->load(['alumno', 'grupo.materia', 'grupo.periodo', 'tipoEvaluacion']);
        return view('kardex.show', compact('kardex'));
    }

    public function edit(KardexInscripcion $kardex)
    {
        $alumnos         = Alumno::all();
        $grupos          = Grupo::with('materia')->get();
        $tiposEvaluacion = TipoEvaluacion::all();

        return view('kardex.edit', compact('kardex', 'alumnos', 'grupos', 'tiposEvaluacion'));
    }

    public function update(Request $request, KardexInscripcion $kardex)
    {
        $datos = $request->validate([
            'tipo_evaluacion_id' => ['required', 'exists:Tipos_Evaluacion,id'],
            'calificacion_final' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'estatus_materia'    => ['nullable', 'string', 'max:50'],
        ]);

        $kardex->update($datos);

        return redirect()->route('kardex.index')->with('exito', 'Calificación actualizada correctamente.');
    }

    public function destroy(KardexInscripcion $kardex)
    {
        $kardex->delete();
        return redirect()->route('kardex.index')->with('exito', 'Inscripción eliminada correctamente.');
    }

    /**
     * Vista del kardex personal del alumno autenticado.
     */
    public function miKardex()
    {
        $alumno = Auth::user()->alumno;
        $inscripciones = $alumno->kardexInscripciones()->with(['grupo.materia', 'grupo.periodo', 'tipoEvaluacion'])->get();

        return view('kardex.mi-kardex', compact('alumno', 'inscripciones'));
    }
}
