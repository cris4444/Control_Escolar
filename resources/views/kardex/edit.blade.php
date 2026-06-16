@extends('layouts.app')
@section('titulo', 'Editar Calificación')

@section('contenido')
<div class="py-3">
    <a href="{{ route('kardex.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver al Kardex
    </a>
    <h5 class="fw-bold mt-1">Editar Calificación</h5>
    <p class="text-muted small mb-0">
        Alumno: <strong>{{ $kardex->alumno->nombres ?? '—' }} {{ $kardex->alumno->apellidos ?? '' }}</strong>
        &nbsp;|&nbsp;
        Materia: <strong>{{ $kardex->grupo->materia->nombre ?? '—' }}</strong>
    </p>
</div>

<div class="card border-0 shadow-sm" style="max-width:480px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('kardex.update', $kardex) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="tipo_evaluacion_id" class="form-label fw-semibold">Tipo de Evaluación <span class="text-danger">*</span></label>
                <select id="tipo_evaluacion_id" name="tipo_evaluacion_id"
                        class="form-select @error('tipo_evaluacion_id') is-invalid @enderror" required>
                    @foreach($tiposEvaluacion as $tipo)
                        <option value="{{ $tipo->id }}"
                            {{ old('tipo_evaluacion_id', $kardex->tipo_evaluacion_id) == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('tipo_evaluacion_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="calificacion_final" class="form-label fw-semibold">Calificación</label>
                    <input type="number" id="calificacion_final" name="calificacion_final"
                           class="form-control @error('calificacion_final') is-invalid @enderror"
                           value="{{ old('calificacion_final', $kardex->calificacion_final) }}"
                           step="0.01" min="0" max="10">
                    @error('calificacion_final')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6 mb-3">
                    <label for="estatus_materia" class="form-label fw-semibold">Estatus</label>
                    <select id="estatus_materia" name="estatus_materia" class="form-select">
                        @foreach(['En Curso', 'Aprobada', 'Reprobada'] as $est)
                            <option value="{{ $est }}"
                                {{ old('estatus_materia', $kardex->estatus_materia) === $est ? 'selected' : '' }}>
                                {{ $est }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
                <a href="{{ route('kardex.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
