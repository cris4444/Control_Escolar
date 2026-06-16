@extends('layouts.app')
@section('titulo', 'Docentes')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Docentes</h5>
    <a href="{{ route('docentes.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nuevo Docente
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No. Empleado</th>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Correo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($docentes as $docente)
                <tr>
                    <td class="fw-semibold">{{ $docente->numero_empleado }}</td>
                    <td>{{ $docente->nombres }} {{ $docente->apellidos }}</td>
                    <td class="text-muted small">{{ $docente->especialidad ?? '—' }}</td>
                    <td class="text-muted small">{{ $docente->usuario->correo_institucional ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('docentes.show', $docente) }}" class="btn btn-sm btn-outline-info me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('docentes.edit', $docente) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('docentes.destroy', $docente) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este docente?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
