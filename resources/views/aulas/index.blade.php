@extends('layouts.app')
@section('titulo', 'Aulas')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Aulas</h5>
    <a href="{{ route('aulas.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nueva Aula
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Identificador</th>
                    <th>Edificio</th>
                    <th>Tipo</th>
                    <th>Capacidad</th>
                    <th>Estatus</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aulas as $aula)
                <tr>
                    <td class="fw-semibold">{{ $aula->numero_identificador }}</td>
                    <td>{{ $aula->edificio ?? '—' }}</td>
                    <td>{{ $aula->tipo_aula ?? '—' }}</td>
                    <td>{{ $aula->capacidad_maxima }}</td>
                    <td>
                        @if($aula->estatus)
                            <span class="badge bg-success">Activa</span>
                        @else
                            <span class="badge bg-secondary">Inactiva</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('aulas.edit', $aula) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('aulas.destroy', $aula) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta aula?')">
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
