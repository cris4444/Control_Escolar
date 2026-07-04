<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Periodo;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index()
    {
        $hoy = now()->toDateString();

        // Periodo vigente según la fecha de hoy (puede no existir si no hay uno activo)
        $periodoActual = Periodo::where('fecha_inicio', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy)
            ->first();

        // Cargamos solo los grupos del periodo actual, con el total de alumnos inscritos en cada uno
        $aulas = Aula::with(['grupos' => function ($query) use ($periodoActual) {
                $query->when($periodoActual, fn ($q) => $q->where('periodo_id', $periodoActual->id))
                    ->withCount('kardexInscripciones');
            }])
            ->orderBy('edificio')
            ->orderBy('numero_identificador')
            ->get()
            ->map(function ($aula) {
                $aula->inscritos_actuales = $aula->grupos->sum('kardex_inscripciones_count');
                $aula->grupos_actuales = $aula->grupos->count();
                $aula->porcentaje_ocupacion = $aula->capacidad_maxima > 0
                    ? min(100, round(($aula->inscritos_actuales / $aula->capacidad_maxima) * 100))
                    : 0;
                return $aula;
            });

        return view('aulas.index', compact('aulas', 'periodoActual'));
    }

    public function create()
    {
        return view('aulas.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'edificio'             => ['nullable', 'string', 'max:100'],
            'numero_identificador' => ['required', 'string', 'max:50'],
            'capacidad_maxima'     => ['required', 'integer', 'min:1'],
            'tipo_aula'            => ['nullable', 'string', 'max:100'],
            'estatus'              => ['boolean'],
        ]);

        Aula::create($datos);

        return redirect()->route('aulas.index')->with('exito', 'Aula creada correctamente.');
    }

    public function edit(Aula $aula)
    {
        return view('aulas.edit', compact('aula'));
    }

    public function update(Request $request, Aula $aula)
    {
        $datos = $request->validate([
            'edificio'             => ['nullable', 'string', 'max:100'],
            'numero_identificador' => ['required', 'string', 'max:50'],
            'capacidad_maxima'     => ['required', 'integer', 'min:1'],
            'tipo_aula'            => ['nullable', 'string', 'max:100'],
            'estatus'              => ['boolean'],
        ]);

        $aula->update($datos);

        return redirect()->route('aulas.index')->with('exito', 'Aula actualizada correctamente.');
    }

    public function destroy(Aula $aula)
    {
        $aula->delete();
        return redirect()->route('aulas.index')->with('exito', 'Aula eliminada correctamente.');
    }
}