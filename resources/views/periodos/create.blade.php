@extends('layouts.app')
@section('titulo', 'Nuevo Periodo')

@section('contenido')
<div class="py-3">
    <a href="{{ route('periodos.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Periodos
    </a>
    <h5 class="fw-bold mt-1">Nuevo Periodo</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:500px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('periodos.store') }}">
            @csrf
            <div class="mb-3">
                <label for="codigo" class="form-label fw-semibold">Código <span class="text-danger">*</span></label>
                <input type="text" id="codigo" name="codigo"
                       class="form-control @error('codigo') is-invalid @enderror"
                       value="{{ old('codigo') }}" placeholder="Ej. 2025-A" maxlength="20" required>
                @error('codigo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label fw-semibold">Fecha Inicio <span class="text-danger">*</span></label>
                <input type="date" id="fecha_inicio" name="fecha_inicio"
                       class="form-control @error('fecha_inicio') is-invalid @enderror"
                       value="{{ old('fecha_inicio') }}" required>
                @error('fecha_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="fecha_fin" class="form-label fw-semibold">Fecha Fin <span class="text-danger">*</span></label>
                <input type="date" id="fecha_fin" name="fecha_fin"
                       class="form-control @error('fecha_fin') is-invalid @enderror"
                       value="{{ old('fecha_fin') }}" required>
                @error('fecha_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
                <a href="{{ route('periodos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
