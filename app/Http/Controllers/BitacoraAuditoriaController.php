<?php

namespace App\Http\Controllers;

use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;

class BitacoraAuditoriaController extends Controller
{
    /**
     * Muestra el listado de registros de auditoría (solo Admin).
     */
    public function index(Request $request)
    {
        $registros = BitacoraAuditoria::with('usuario')
            ->when($request->filled('accion'), fn($q) => $q->where('accion', $request->accion))
            ->when($request->filled('tabla'), fn($q) => $q->where('tabla_afectada', $request->tabla))
            ->orderByDesc('created_at')
            ->paginate(50);

        return view('bitacora.index', compact('registros'));
    }
}
