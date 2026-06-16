@extends('layouts.app')
@section('titulo', 'Nueva Carrera')

@section('contenido')
<div class="py-3">
    <a href="{{ route('carreras.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Carreras
    </a>
    <h5 class="fw-bold mt-1">Nueva Carrera</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:500px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('carreras.store') }}">
            @csrf
            <div class="mb-3">
                <label for="clave_oficial" class="form-label fw-semibold">Clave Oficial <span class="text-danger">*</span></label>
                <input type="text" id="clave_oficial" name="clave_oficial"
                       class="form-control @error('clave_oficial') is-invalid @enderror"
                       value="{{ old('clave_oficial') }}" maxlength="50" required>
                @error('clave_oficial')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" name="nombre"
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre') }}" maxlength="150" required>
                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="total_creditos" class="form-label fw-semibold">Total de Créditos <span class="text-danger">*</span></label>
                <input type="number" id="total_creditos" name="total_creditos"
                       class="form-control @error('total_creditos') is-invalid @enderror"
                       value="{{ old('total_creditos') }}" min="1" required>
                @error('total_creditos')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
                <a href="{{ route('carreras.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
