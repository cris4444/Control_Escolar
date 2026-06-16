@extends('layouts.app')
@section('titulo', 'Nuevo Alumno')

@section('contenido')
<div class="py-3">
    <a href="{{ route('alumnos.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Alumnos
    </a>
    <h5 class="fw-bold mt-1">Registrar Nuevo Alumno</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:620px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('alumnos.store') }}">
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
            <h6 class="fw-semibold text-muted mb-3">Datos Académicos</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="matricula" class="form-label fw-semibold">Matrícula <span class="text-danger">*</span></label>
                    <input type="text" id="matricula" name="matricula"
                           class="form-control @error('matricula') is-invalid @enderror"
                           value="{{ old('matricula') }}" maxlength="50" required>
                    @error('matricula')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="carrera_id" class="form-label fw-semibold">Carrera <span class="text-danger">*</span></label>
                    <select id="carrera_id" name="carrera_id"
                            class="form-select @error('carrera_id') is-invalid @enderror" required>
                        <option value="">— Seleccionar —</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera->id }}" {{ old('carrera_id') == $carrera->id ? 'selected' : '' }}>
                                {{ $carrera->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('carrera_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-3">
            <h6 class="fw-semibold text-muted mb-3">Datos Personales</h6>
            <div class="row">
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
                <div class="col-md-8 mb-3">
                    <label for="curp" class="form-label fw-semibold">CURP <span class="text-danger">*</span></label>
                    <input type="text" id="curp" name="curp"
                           class="form-control @error('curp') is-invalid @enderror"
                           value="{{ old('curp') }}" maxlength="18" minlength="18"
                           style="text-transform:uppercase" required>
                    @error('curp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="estatus" class="form-label fw-semibold">Estatus</label>
                    <select id="estatus" name="estatus" class="form-select">
                        <option value="Activo" {{ old('estatus', 'Activo') === 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Baja" {{ old('estatus') === 'Baja' ? 'selected' : '' }}>Baja</option>
                        <option value="Egresado" {{ old('estatus') === 'Egresado' ? 'selected' : '' }}>Egresado</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
                <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
