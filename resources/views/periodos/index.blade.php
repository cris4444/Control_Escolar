@extends('layouts.app')
@section('titulo', 'Periodos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Periodos Escolares</h5>
    <a href="{{ route('periodos.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nuevo Periodo
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($periodos as $periodo)
                <tr>
                    <td class="fw-semibold">{{ $periodo->codigo }}</td>
                    <td>{{ $periodo->fecha_inicio }}</td>
                    <td>{{ $periodo->fecha_fin }}</td>
                    <td class="text-end">
                        <a href="{{ route('periodos.edit', $periodo) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('periodos.destroy', $periodo) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este periodo?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
