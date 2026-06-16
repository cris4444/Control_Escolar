@extends('layouts.app')
@section('titulo', 'Alumnos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Alumnos</h5>
    <a href="{{ route('alumnos.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nuevo Alumno
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Carrera</th>
                    <th>Estatus</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumnos as $alumno)
                <tr>
                    <td class="fw-semibold">{{ $alumno->matricula }}</td>
                    <td>{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
                    <td class="text-muted small">{{ $alumno->carrera->nombre ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $alumno->estatus === 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $alumno->estatus }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('alumnos.show', $alumno) }}" class="btn btn-sm btn-outline-info me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este alumno?')">
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
