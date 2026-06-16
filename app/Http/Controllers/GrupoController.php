<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Docente;
use App\Models\Aula;
use App\Models\Periodo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with(['periodo', 'materia', 'docente', 'aula'])->get();
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $periodos  = Periodo::all();
        $materias  = Materia::all();
        $docentes  = Docente::all();
        $aulas     = Aula::where('estatus', true)->get();

        return view('grupos.create', compact('periodos', 'materias', 'docentes', 'aulas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'periodo_id'  => ['required', 'exists:Periodos,id'],
            'materia_id'  => ['required', 'exists:Materias,id'],
            'docente_id'  => ['required', 'exists:Docentes,id'],
            'aula_id'     => ['required', 'exists:Aulas,id'],
            'cupo_maximo' => ['required', 'integer', 'min:1'],
        ]);

        Grupo::create($datos);

        return redirect()->route('grupos.index')->with('exito', 'Grupo creado correctamente.');
    }

    public function show(Grupo $grupo)
    {
        $grupo->load(['periodo', 'materia', 'docente', 'aula', 'horariosGrupo', 'kardexInscripciones.alumno']);
        return view('grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        $periodos = Periodo::all();
        $materias = Materia::all();
        $docentes = Docente::all();
        $aulas    = Aula::where('estatus', true)->get();

        return view('grupos.edit', compact('grupo', 'periodos', 'materias', 'docentes', 'aulas'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $datos = $request->validate([
            'periodo_id'  => ['required', 'exists:Periodos,id'],
            'materia_id'  => ['required', 'exists:Materias,id'],
            'docente_id'  => ['required', 'exists:Docentes,id'],
            'aula_id'     => ['required', 'exists:Aulas,id'],
            'cupo_maximo' => ['required', 'integer', 'min:1'],
        ]);

        $grupo->update($datos);

        return redirect()->route('grupos.index')->with('exito', 'Grupo actualizado correctamente.');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
        return redirect()->route('grupos.index')->with('exito', 'Grupo eliminado correctamente.');
    }
}
