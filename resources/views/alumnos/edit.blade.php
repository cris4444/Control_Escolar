@extends('layouts.app')
@section('titulo', 'Editar Alumno')

@section('contenido')
<div class="py-3">
    <a href="{{ route('alumnos.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Alumnos
    </a>
    <h5 class="fw-bold mt-1">Editar Alumno: {{ $alumno->nombres }} {{ $alumno->apellidos }}</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:620px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('alumnos.update', $alumno) }}">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="matricula" class="form-label fw-semibold">Matrícula <span class="text-danger">*</span></label>
                    <input type="text" id="matricula" name="matricula"
                           class="form-control @error('matricula') is-invalid @enderror"
                           value="{{ old('matricula', $alumno->matricula) }}" maxlength="50" required>
                    @error('matricula')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="carrera_id" class="form-label fw-semibold">Carrera <span class="text-danger">*</span></label>
                    <select id="carrera_id" name="carrera_id"
                            class="form-select @error('carrera_id') is-invalid @enderror" required>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera->id }}"
                                {{ old('carrera_id', $alumno->carrera_id) == $carrera->id ? 'selected' : '' }}>
                                {{ $carrera->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('carrera_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nombres" class="form-label fw-semibold">Nombres <span class="text-danger">*</span></label>
                    <input type="text" id="nombres" name="nombres"
                           class="form-control @error('nombres') is-invalid @enderror"
                           value="{{ old('nombres', $alumno->nombres) }}" maxlength="100" required>
                    @error('nombres')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="apellidos" class="form-label fw-semibold">Apellidos <span class="text-danger">*</span></label>
                    <input type="text" id="apellidos" name="apellidos"
                           class="form-control @error('apellidos') is-invalid @enderror"
                           value="{{ old('apellidos', $alumno->apellidos) }}" maxlength="100" required>
                    @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label for="curp" class="form-label fw-semibold">CURP <span class="text-danger">*</span></label>
                    <input type="text" id="curp" name="curp"
                           class="form-control @error('curp') is-invalid @enderror"
                           value="{{ old('curp', $alumno->curp) }}" maxlength="18" minlength="18"
                           style="text-transform:uppercase" required>
                    @error('curp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="estatus" class="form-label fw-semibold">Estatus</label>
                    <select id="estatus" name="estatus" class="form-select">
                        <option value="Activo" {{ old('estatus', $alumno->estatus) === 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Baja" {{ old('estatus', $alumno->estatus) === 'Baja' ? 'selected' : '' }}>Baja</option>
                        <option value="Egresado" {{ old('estatus', $alumno->estatus) === 'Egresado' ? 'selected' : '' }}>Egresado</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
                <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
