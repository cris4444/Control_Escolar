@extends('layouts.app')
@section('titulo', 'Editar Rol')

@section('contenido')
    <div class="py-3">
        <a href="{{ route('roles.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Volver a Roles
        </a>
        <h5 class="fw-bold mt-1">Editar Rol: {{ $rol->nombre }}</h5>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('roles.update', $rol) }}">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre <span
                                class="text-danger">*</span></label>
                        <input type="text" id="nombre" name="nombre"
                            class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre', $rol->nombre) }}" maxlength="50" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                        <input type="text" id="descripcion" name="descripcion"
                            class="form-control @error('descripcion') is-invalid @enderror"
                            value="{{ old('descripcion', $rol->descripcion) }}" maxlength="150">
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input type="checkbox" name="activo" value="1" id="activo" class="form-check-input"
                        {{ old('activo', $rol->activo) ? 'checked' : '' }}>
                    <label class="form-check-label" for="activo">
                        Rol activo (aparece como opción al crear/editar usuarios)
                    </label>
                </div>

                <label class="form-label fw-semibold">Permisos</label>
                <div class="row mb-3">
                    @forelse ($permisosPorModulo as $modulo => $permisos)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border">
                                <div class="card-header text-capitalize fw-semibold small bg-light">
                                    {{ $modulo }}
                                </div>
                                <div class="card-body py-2">
                                    @foreach ($permisos as $permiso)
                                        <div class="form-check">
                                            <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}"
                                                id="perm-{{ $permiso->id }}" class="form-check-input"
                                                {{ in_array($permiso->id, old('permisos', $permisosAsignados)) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="perm-{{ $permiso->id }}">
                                                {{ $permiso->descripcion ?? $permiso->clave }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-muted small">No hay permisos registrados todavía.</div>
                    @endforelse
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Actualizar
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
