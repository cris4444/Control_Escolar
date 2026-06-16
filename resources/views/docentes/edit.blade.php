@extends('layouts.app')
@section('titulo', 'Editar Docente')

@section('contenido')
<div class="py-3">
    <a href="{{ route('docentes.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Docentes
    </a>
    <h5 class="fw-bold mt-1">Editar Docente: {{ $docente->nombres }} {{ $docente->apellidos }}</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:580px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('docentes.update', $docente) }}">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="numero_empleado" class="form-label fw-semibold">No. Empleado <span class="text-danger">*</span></label>
                    <input type="text" id="numero_empleado" name="numero_empleado"
                           class="form-control @error('numero_empleado') is-invalid @enderror"
                           value="{{ old('numero_empleado', $docente->numero_empleado) }}" maxlength="50" required>
                    @error('numero_empleado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-7 mb-3">
                    <label for="especialidad" class="form-label fw-semibold">Especialidad</label>
                    <input type="text" id="especialidad" name="especialidad"
                           class="form-control"
                           value="{{ old('especialidad', $docente->especialidad) }}" maxlength="150">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nombres" class="form-label fw-semibold">Nombres <span class="text-danger">*</span></label>
                    <input type="text" id="nombres" name="nombres"
                           class="form-control @error('nombres') is-invalid @enderror"
                           value="{{ old('nombres', $docente->nombres) }}" maxlength="100" required>
                    @error('nombres')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="apellidos" class="form-label fw-semibold">Apellidos <span class="text-danger">*</span></label>
                    <input type="text" id="apellidos" name="apellidos"
                           class="form-control @error('apellidos') is-invalid @enderror"
                           value="{{ old('apellidos', $docente->apellidos) }}" maxlength="100" required>
                    @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
                <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
