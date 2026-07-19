@extends('layouts.app')
@section('titulo', 'Editar Usuario')

@section('contenido')
    <div class="py-3">
        <a href="{{ route('usuarios.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Volver a Usuarios
        </a>
        <h5 class="fw-bold mt-1">Editar Usuario</h5>
    </div>

    <div class="card border-0 shadow-sm" style="max-width:500px">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label for="rol_id" class="form-label fw-semibold">Rol <span class="text-danger">*</span></label>
                    <select id="rol_id" name="rol_id" class="form-select @error('rol_id') is-invalid @enderror"
                        required>
                        <option value="">— Seleccionar —</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}"
                                {{ old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : '' }}>
                                {{ $rol->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('rol_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="correo_institucional" class="form-label fw-semibold">Correo Institucional <span
                            class="text-danger">*</span></label>
                    <input type="email" id="correo_institucional" name="correo_institucional"
                        class="form-control @error('correo_institucional') is-invalid @enderror"
                        value="{{ old('correo_institucional', $usuario->correo_institucional) }}" maxlength="150" required>
                    @error('correo_institucional')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Nueva Contraseña <span
                            class="text-muted small">(dejar vacío para no cambiar)</span></label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" minlength="8">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirmar Nueva Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        minlength="8">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
