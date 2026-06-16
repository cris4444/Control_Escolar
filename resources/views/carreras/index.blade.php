@extends('layouts.app')
@section('titulo', 'Carreras')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Carreras</h5>
    <a href="{{ route('carreras.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nueva Carrera
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Clave</th>
                    <th>Nombre</th>
                    <th>Total Créditos</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($carreras as $carrera)
                <tr>
                    <td class="fw-semibold">{{ $carrera->clave_oficial }}</td>
                    <td>{{ $carrera->nombre }}</td>
                    <td>{{ $carrera->total_creditos }}</td>
                    <td class="text-end">
                        <a href="{{ route('carreras.edit', $carrera) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('carreras.destroy', $carrera) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta carrera?')">
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
