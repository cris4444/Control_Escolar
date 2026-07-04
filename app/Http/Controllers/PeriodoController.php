<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function index()
    {
        $hoy = now()->toDateString();

        $periodos = Periodo::withCount('grupos')
            ->orderByDesc('fecha_inicio')
            ->get()
            ->map(function ($periodo) use ($hoy) {
                if ($hoy < $periodo->fecha_inicio) {
                    $periodo->estado_calculado = 'proximo';
                } elseif ($hoy > $periodo->fecha_fin) {
                    $periodo->estado_calculado = 'cerrado';
                } else {
                    $periodo->estado_calculado = 'activo';
                }
                return $periodo;
            });

        return view('periodos.index', compact('periodos'));
    }

    public function create()
    {
        return view('periodos.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo'       => ['required', 'string', 'max:20', 'unique:Periodos,codigo'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin'    => ['required', 'date', 'after:fecha_inicio'],
        ]);

        Periodo::create($datos);

        return redirect()->route('periodos.index')->with('exito', 'Periodo creado correctamente.');
    }

    public function edit(Periodo $periodo)
    {
        return view('periodos.edit', compact('periodo'));
    }

    public function update(Request $request, Periodo $periodo)
    {
        $datos = $request->validate([
            'codigo'       => ['required', 'string', 'max:20', 'unique:Periodos,codigo,' . $periodo->id],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin'    => ['required', 'date', 'after:fecha_inicio'],
        ]);

        $periodo->update($datos);

        return redirect()->route('periodos.index')->with('exito', 'Periodo actualizado correctamente.');
    }

    public function destroy(Periodo $periodo)
    {
        $periodo->delete();
        return redirect()->route('periodos.index')->with('exito', 'Periodo eliminado correctamente.');
    }
}