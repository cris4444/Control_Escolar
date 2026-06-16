@extends('layouts.app')
@section('titulo', 'Nuevo Docente')

@section('contenido')
<div class="py-3">
    <a href="{{ route('docentes.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Docentes
    </a>
    <h5 class="fw-bold mt-1">Registrar Nuevo Docente</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:580px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('docentes.store') }}">
            @csrf
            <h6 class="fw-semibold text-muted mb-3">Cuenta de Acceso</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="correo_institucional" class="form-label fw-semibold">Correo Institucional <span class="text-danger">*</span></label>
                    <input type="email" id="correo_institucional" name="correo_institucional"
                           class="form-control @error('correo_institucional') is-invalid @enderror"
                           value="{{ old('correo_institucional') }}" required>
                    @error('correo_institucional')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-semibold">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           minlength="8" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <hr class="my-3">
            <h6 class="fw-semibold text-muted mb-3">Datos del Docente</h6>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="numero_empleado" class="form-label fw-semibold">No. Empleado <span class="text-danger">*</span></label>
                    <input type="text" id="numero_empleado" name="numero_empleado"
                           class="form-control @error('numero_empleado') is-invalid @enderror"
                           value="{{ old('numero_empleado') }}" maxlength="50" required>
                    @error('numero_empleado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-7 mb-3">
                    <label for="especialidad" class="form-label fw-semibold">Especialidad</label>
                    <input type="text" id="especialidad" name="especialidad"
                           class="form-control"
                           value="{{ old('especialidad') }}" maxlength="150">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nombres" class="form-label fw-semibold">Nombres <span class="text-danger">*</span></label>
                    <input type="text" id="nombres" name="nombres"
                           class="form-control @error('nombres') is-invalid @enderror"
                           value="{{ old('nombres') }}" maxlength="100" required>
                    @error('nombres')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="apellidos" class="form-label fw-semibold">Apellidos <span class="text-danger">*</span></label>
                    <input type="text" id="apellidos" name="apellidos"
                           class="form-control @error('apellidos') is-invalid @enderror"
                           value="{{ old('apellidos') }}" maxlength="100" required>
                    @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
                <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
