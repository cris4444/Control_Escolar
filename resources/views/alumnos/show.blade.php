@extends('layouts.app')
@section('titulo', 'Expediente del Alumno')

@section('contenido')
<div class="py-3 d-flex justify-content-between align-items-start">
    <div>
        <a href="{{ route('alumnos.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Volver a Alumnos
        </a>
        <h5 class="fw-bold mt-1">{{ $alumno->nombres }} {{ $alumno->apellidos }}</h5>
        <span class="badge {{ $alumno->estatus === 'Activo' ? 'bg-success' : 'bg-secondary' }}">
            {{ $alumno->estatus }}
        </span>
    </div>
    <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-pencil me-1"></i>Editar
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent fw-semibold">Datos Personales</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Matrícula</dt><dd class="col-7">{{ $alumno->matricula }}</dd>
                    <dt class="col-5 text-muted">CURP</dt><dd class="col-7">{{ $alumno->curp }}</dd>
                    <dt class="col-5 text-muted">Carrera</dt><dd class="col-7">{{ $alumno->carrera->nombre ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Correo</dt><dd class="col-7">{{ $alumno->usuario->correo_institucional ?? '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

{{-- Kardex --}}
<h6 class="fw-semibold mb-2">Kardex de Inscripciones</h6>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-0">
        <table class="table table-sm table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Materia</th>
                    <th>Periodo</th>
                    <th>Calificación</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumno->kardexInscripciones as $k)
                <tr>
                    <td>{{ $k->grupo->materia->nombre ?? '—' }}</td>
                    <td>{{ $k->grupo->periodo->codigo ?? '—' }}</td>
                    <td>{{ $k->calificacion_final ?? '—' }}</td>
                    <td><span class="badge bg-secondary">{{ $k->estatus_materia }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-3">Sin inscripciones.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Asistencias recientes --}}
<h6 class="fw-semibold mb-2">Últimas Asistencias</h6>
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-sm table-hover mb-0">
            <thead class="table-light">
                <tr><th>Fecha</th><th>Grupo / Materia</th><th>Estatus</th></tr>
            </thead>
            <tbody>
                @forelse($alumno->asistencias->take(10) as $a)
                <tr>
                    <td>{{ $a->fecha }}</td>
                    <td>{{ $a->grupo->materia->nombre ?? '—' }}</td>
                    <td><span class="badge {{ $a->estatus_asistencia === 'Presente' ? 'bg-success' : 'bg-danger' }}">{{ $a->estatus_asistencia }}</span></td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-3">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
