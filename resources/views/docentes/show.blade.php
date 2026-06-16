@extends('layouts.app')
@section('titulo', 'Perfil del Docente')

@section('contenido')
<div class="py-3 d-flex justify-content-between align-items-start">
    <div>
        <a href="{{ route('docentes.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Volver a Docentes
        </a>
        <h5 class="fw-bold mt-1">{{ $docente->nombres }} {{ $docente->apellidos }}</h5>
        <span class="text-muted small">No. Empleado: {{ $docente->numero_empleado }}</span>
    </div>
    <a href="{{ route('docentes.edit', $docente) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-pencil me-1"></i>Editar
    </a>
</div>

<div class="card border-0 shadow-sm mb-4" style="max-width:500px">
    <div class="card-header bg-transparent fw-semibold">Datos del Docente</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-5 text-muted">Especialidad</dt><dd class="col-7">{{ $docente->especialidad ?? '—' }}</dd>
            <dt class="col-5 text-muted">Correo</dt><dd class="col-7">{{ $docente->usuario->correo_institucional ?? '—' }}</dd>
        </dl>
    </div>
</div>

<h6 class="fw-semibold mb-2">Grupos que imparte</h6>
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-sm table-hover mb-0">
            <thead class="table-light">
                <tr><th>Materia</th><th>Periodo</th><th>Cupo</th></tr>
            </thead>
            <tbody>
                @forelse($docente->grupos as $grupo)
                <tr>
                    <td>{{ $grupo->materia->nombre ?? '—' }}</td>
                    <td>{{ $grupo->periodo->codigo ?? '—' }}</td>
                    <td>{{ $grupo->cupo_maximo }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-3">Sin grupos asignados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
