@extends('layouts.app')
@section('titulo', 'Materias')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Materias</h5>
    <a href="{{ route('materias.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nueva Materia
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Clave</th>
                    <th>Nombre</th>
                    <th>Carrera</th>
                    <th>Créditos</th>
                    <th>Semestre</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materias as $materia)
                <tr>
                    <td class="fw-semibold">{{ $materia->clave_materia }}</td>
                    <td>{{ $materia->nombre }}</td>
                    <td class="text-muted small">{{ $materia->carrera->nombre ?? '—' }}</td>
                    <td>{{ $materia->creditos }}</td>
                    <td>{{ $materia->semestre_sugerido ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('materias.edit', $materia) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('materias.destroy', $materia) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta materia?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
