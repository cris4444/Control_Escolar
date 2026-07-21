@extends('layouts.app')
@section('titulo', 'Nuevo Rol')

@section('contenido')
    <div class="py-3">
        <a href="{{ route('roles.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Volver a Roles
        </a>
        <h5 class="fw-bold mt-1">Nuevo Rol</h5>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="alert alert-warning small">
                <i class="bi bi-info-circle me-1"></i>
                Un rol nuevo no tiene acceso a ninguna sección hasta que un desarrollador agregue su nombre
                al middleware <code>rol:</code> correspondiente en <code>routes/web.php</code>. Los permisos que
                marques aquí solo tendrán efecto después de ese paso.
            </div>

            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre <span
                                class="text-danger">*</span></label>
                        <input type="text" id="nombre" name="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                            maxlength="50" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                        <input type="text" id="descripcion" name="descripcion"
                            class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion') }}"
                            maxlength="150">
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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
                                                {{ in_array($permiso->id, old('permisos', [])) ? 'checked' : '' }}>
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
                        <i class="bi bi-check-lg me-1"></i>Guardar
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
