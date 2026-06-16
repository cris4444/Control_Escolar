@extends('layouts.app')
@section('titulo', 'Nueva Inscripción')

@section('contenido')
<div class="py-3">
    <a href="{{ route('kardex.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver al Kardex
    </a>
    <h5 class="fw-bold mt-1">Nueva Inscripción</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:560px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('kardex.store') }}">
            @csrf
            <div class="mb-3">
                <label for="alumno_id" class="form-label fw-semibold">Alumno <span class="text-danger">*</span></label>
                <select id="alumno_id" name="alumno_id"
                        class="form-select @error('alumno_id') is-invalid @enderror" required>
                    <option value="">— Seleccionar —</option>
                    @foreach($alumnos as $alumno)
                        <option value="{{ $alumno->id }}" {{ old('alumno_id') == $alumno->id ? 'selected' : '' }}>
                            {{ $alumno->matricula }} — {{ $alumno->nombres }} {{ $alumno->apellidos }}
                        </option>
                    @endforeach
                </select>
                @error('alumno_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="grupo_id" class="form-label fw-semibold">Grupo / Materia <span class="text-danger">*</span></label>
                <select id="grupo_id" name="grupo_id"
                        class="form-select @error('grupo_id') is-invalid @enderror" required>
                    <option value="">— Seleccionar —</option>
                    @foreach($grupos as $grupo)
                        <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                            {{ $grupo->materia->nombre ?? '—' }} ({{ $grupo->periodo->codigo ?? '—' }})
                        </option>
                    @endforeach
                </select>
                @error('grupo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="tipo_evaluacion_id" class="form-label fw-semibold">Tipo de Evaluación <span class="text-danger">*</span></label>
                <select id="tipo_evaluacion_id" name="tipo_evaluacion_id"
                        class="form-select @error('tipo_evaluacion_id') is-invalid @enderror" required>
                    <option value="">— Seleccionar —</option>
                    @foreach($tiposEvaluacion as $tipo)
                        <option value="{{ $tipo->id }}" {{ old('tipo_evaluacion_id') == $tipo->id ? 'selected' : '' }}>
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
                           value="{{ old('calificacion_final') }}" step="0.01" min="0" max="10">
                    @error('calificacion_final')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6 mb-3">
                    <label for="estatus_materia" class="form-label fw-semibold">Estatus</label>
                    <select id="estatus_materia" name="estatus_materia" class="form-select">
                        <option value="En Curso" {{ old('estatus_materia', 'En Curso') === 'En Curso' ? 'selected' : '' }}>En Curso</option>
                        <option value="Aprobada" {{ old('estatus_materia') === 'Aprobada' ? 'selected' : '' }}>Aprobada</option>
                        <option value="Reprobada" {{ old('estatus_materia') === 'Reprobada' ? 'selected' : '' }}>Reprobada</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
                <a href="{{ route('kardex.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
