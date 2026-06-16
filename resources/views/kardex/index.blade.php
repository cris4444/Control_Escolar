@extends('layouts.app')
@section('titulo', 'Kardex de Inscripciones')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Kardex de Inscripciones</h5>
    @can('create', App\Models\KardexInscripcion::class)
    <a href="{{ route('kardex.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nueva Inscripción
    </a>
    @endcan
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Alumno</th>
                    <th>Materia</th>
                    <th>Periodo</th>
                    <th>Calificación</th>
                    <th>Estatus</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscripciones as $k)
                <tr>
                    <td>{{ $k->alumno->nombres ?? '—' }} {{ $k->alumno->apellidos ?? '' }}</td>
                    <td>{{ $k->grupo->materia->nombre ?? '—' }}</td>
                    <td><span class="badge bg-info text-dark">{{ $k->grupo->periodo->codigo ?? '—' }}</span></td>
                    <td class="fw-semibold">{{ $k->calificacion_final ?? '—' }}</td>
                    <td><span class="badge bg-secondary">{{ $k->estatus_materia }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('kardex.edit', $k) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if(auth()->user()->rol->nombre === 'Admin' || auth()->user()->rol->nombre === 'Personal Administrativo')
                        <form action="{{ route('kardex.destroy', $k) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta inscripción?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
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
