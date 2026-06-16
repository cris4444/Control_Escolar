@extends('layouts.app')
@section('titulo', 'Detalle del Grupo')

@section('contenido')
<div class="py-3 d-flex justify-content-between align-items-start">
    <div>
        <a href="{{ route('grupos.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Volver a Grupos
        </a>
        <h5 class="fw-bold mt-1">{{ $grupo->materia->nombre ?? 'Grupo' }}</h5>
        <span class="badge bg-info text-dark">{{ $grupo->periodo->codigo ?? '—' }}</span>
    </div>
    <a href="{{ route('grupos.edit', $grupo) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-pencil me-1"></i>Editar
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent fw-semibold">Información del Grupo</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Docente</dt>
                    <dd class="col-7">{{ $grupo->docente->nombres ?? '—' }} {{ $grupo->docente->apellidos ?? '' }}</dd>
                    <dt class="col-5 text-muted">Aula</dt>
                    <dd class="col-7">{{ $grupo->aula->numero_identificador ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Cupo Máximo</dt>
                    <dd class="col-7">{{ $grupo->cupo_maximo }}</dd>
                    <dt class="col-5 text-muted">Inscritos</dt>
                    <dd class="col-7">{{ $grupo->kardexInscripciones->count() }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<h6 class="fw-semibold mb-2">Alumnos Inscritos</h6>
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-sm table-hover mb-0">
            <thead class="table-light">
                <tr><th>Matrícula</th><th>Alumno</th><th>Calificación</th><th>Estatus</th></tr>
            </thead>
            <tbody>
                @forelse($grupo->kardexInscripciones as $k)
                <tr>
                    <td>{{ $k->alumno->matricula ?? '—' }}</td>
                    <td>{{ $k->alumno->nombres ?? '—' }} {{ $k->alumno->apellidos ?? '' }}</td>
                    <td>{{ $k->calificacion_final ?? '—' }}</td>
                    <td><span class="badge bg-secondary">{{ $k->estatus_materia }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-3">Sin alumnos inscritos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
