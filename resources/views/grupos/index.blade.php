@extends('layouts.app')
@section('titulo', 'Grupos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Grupos</h5>
    <a href="{{ route('grupos.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nuevo Grupo
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Materia</th>
                    <th>Docente</th>
                    <th>Periodo</th>
                    <th>Aula</th>
                    <th>Cupo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grupos as $grupo)
                <tr>
                    <td class="fw-semibold">{{ $grupo->materia->nombre ?? '—' }}</td>
                    <td>{{ $grupo->docente->nombres ?? '—' }} {{ $grupo->docente->apellidos ?? '' }}</td>
                    <td><span class="badge bg-info text-dark">{{ $grupo->periodo->codigo ?? '—' }}</span></td>
                    <td>{{ $grupo->aula->numero_identificador ?? '—' }}</td>
                    <td>{{ $grupo->cupo_maximo }}</td>
                    <td class="text-end">
                        <a href="{{ route('grupos.show', $grupo) }}" class="btn btn-sm btn-outline-info me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('grupos.edit', $grupo) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este grupo?')">
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
