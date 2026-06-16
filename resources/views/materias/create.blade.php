@extends('layouts.app')
@section('titulo', 'Nueva Materia')

@section('contenido')
<div class="py-3">
    <a href="{{ route('materias.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Materias
    </a>
    <h5 class="fw-bold mt-1">Nueva Materia</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:540px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('materias.store') }}">
            @csrf
            <div class="mb-3">
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
            <div class="mb-3">
                <label for="clave_materia" class="form-label fw-semibold">Clave <span class="text-danger">*</span></label>
                <input type="text" id="clave_materia" name="clave_materia"
                       class="form-control @error('clave_materia') is-invalid @enderror"
                       value="{{ old('clave_materia') }}" maxlength="50" required>
                @error('clave_materia')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" name="nombre"
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre') }}" maxlength="150" required>
                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="creditos" class="form-label fw-semibold">Créditos <span class="text-danger">*</span></label>
                    <input type="number" id="creditos" name="creditos"
                           class="form-control @error('creditos') is-invalid @enderror"
                           value="{{ old('creditos') }}" min="1" required>
                    @error('creditos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6 mb-3">
                    <label for="semestre_sugerido" class="form-label fw-semibold">Semestre Sugerido</label>
                    <input type="number" id="semestre_sugerido" name="semestre_sugerido"
                           class="form-control"
                           value="{{ old('semestre_sugerido') }}" min="1">
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
                <a href="{{ route('materias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
