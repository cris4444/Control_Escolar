<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Carrera;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::with('carrera')->get();
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        $carreras = Carrera::all();
        return view('materias.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'carrera_id'       => ['required', 'exists:Carreras,id'],
            'clave_materia'    => ['required', 'string', 'max:50', 'unique:Materias,clave_materia'],
            'nombre'           => ['required', 'string', 'max:150'],
            'creditos'         => ['required', 'integer', 'min:1'],
            'semestre_sugerido'=> ['nullable', 'integer', 'min:1'],
        ]);

        Materia::create($datos);

        return redirect()->route('materias.index')->with('exito', 'Materia creada correctamente.');
    }

    public function edit(Materia $materia)
    {
        $carreras = Carrera::all();
        return view('materias.edit', compact('materia', 'carreras'));
    }

    public function update(Request $request, Materia $materia)
    {
        $datos = $request->validate([
            'carrera_id'       => ['required', 'exists:Carreras,id'],
            'clave_materia'    => ['required', 'string', 'max:50', 'unique:Materias,clave_materia,' . $materia->id],
            'nombre'           => ['required', 'string', 'max:150'],
            'creditos'         => ['required', 'integer', 'min:1'],
            'semestre_sugerido'=> ['nullable', 'integer', 'min:1'],
        ]);

        $materia->update($datos);

        return redirect()->route('materias.index')->with('exito', 'Materia actualizada correctamente.');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();
        return redirect()->route('materias.index')->with('exito', 'Materia eliminada correctamente.');
    }
}
