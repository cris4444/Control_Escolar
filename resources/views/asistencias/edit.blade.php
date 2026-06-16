@extends('layouts.app')
@section('titulo', 'Editar Asistencia')

@section('contenido')
<div class="py-3">
    <a href="{{ route('asistencias.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Asistencias
    </a>
    <h5 class="fw-bold mt-1">Editar Asistencia</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:500px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('asistencias.update', $asistencia) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="alumno_id" class="form-label fw-semibold">Alumno <span class="text-danger">*</span></label>
                <select id="alumno_id" name="alumno_id"
                        class="form-select @error('alumno_id') is-invalid @enderror" required>
                    @foreach($alumnos as $alumno)
                        <option value="{{ $alumno->id }}"
                            {{ old('alumno_id', $asistencia->alumno_id) == $alumno->id ? 'selected' : '' }}>
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
                    @foreach($grupos as $grupo)
                        <option value="{{ $grupo->id }}"
                            {{ old('grupo_id', $asistencia->grupo_id) == $grupo->id ? 'selected' : '' }}>
                            {{ $grupo->materia->nombre ?? '—' }} ({{ $grupo->periodo->codigo ?? '—' }})
                        </option>
                    @endforeach
                </select>
                @error('grupo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label fw-semibold">Fecha <span class="text-danger">*</span></label>
                <input type="date" id="fecha" name="fecha"
                       class="form-control @error('fecha') is-invalid @enderror"
                       value="{{ old('fecha', $asistencia->fecha) }}" required>
                @error('fecha')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="estatus_asistencia" class="form-label fw-semibold">Estatus <span class="text-danger">*</span></label>
                <select id="estatus_asistencia" name="estatus_asistencia" class="form-select" required>
                    @foreach(['Presente', 'Ausente', 'Justificada'] as $est)
                        <option value="{{ $est }}"
                            {{ old('estatus_asistencia', $asistencia->estatus_asistencia) === $est ? 'selected' : '' }}>
                            {{ $est }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
                <a href="{{ route('asistencias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
