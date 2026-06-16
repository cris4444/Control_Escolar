<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::all();
        return view('carreras.index', compact('carreras'));
    }

    public function create()
    {
        return view('carreras.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'clave_oficial'  => ['required', 'string', 'max:50', 'unique:Carreras,clave_oficial'],
            'nombre'         => ['required', 'string', 'max:150'],
            'total_creditos' => ['required', 'integer', 'min:1'],
        ]);

        Carrera::create($datos);

        return redirect()->route('carreras.index')->with('exito', 'Carrera creada correctamente.');
    }

    public function edit(Carrera $carrera)
    {
        return view('carreras.edit', compact('carrera'));
    }

    public function update(Request $request, Carrera $carrera)
    {
        $datos = $request->validate([
            'clave_oficial'  => ['required', 'string', 'max:50', 'unique:Carreras,clave_oficial,' . $carrera->id],
            'nombre'         => ['required', 'string', 'max:150'],
            'total_creditos' => ['required', 'integer', 'min:1'],
        ]);

        $carrera->update($datos);

        return redirect()->route('carreras.index')->with('exito', 'Carrera actualizada correctamente.');
    }

    public function destroy(Carrera $carrera)
    {
        $carrera->delete();
        return redirect()->route('carreras.index')->with('exito', 'Carrera eliminada correctamente.');
    }
}
