<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index()
    {
        $aulas = Aula::all();
        return view('aulas.index', compact('aulas'));
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
