@extends('layouts.app')
@section('titulo', 'Nuevo Rol')

@section('contenido')
<div class="py-3">
    <a href="{{ route('roles.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Roles
    </a>
    <h5 class="fw-bold mt-1">Nuevo Rol</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:500px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" name="nombre"
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre') }}" maxlength="50" required>
                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                <textarea id="descripcion" name="descripcion"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          rows="3">{{ old('descripcion') }}</textarea>
                @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Guardar
                </button>
                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
