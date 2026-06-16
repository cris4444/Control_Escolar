@extends('layouts.app')
@section('titulo', 'Editar Aula')

@section('contenido')
<div class="py-3">
    <a href="{{ route('aulas.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Aulas
    </a>
    <h5 class="fw-bold mt-1">Editar Aula: {{ $aula->numero_identificador }}</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:500px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('aulas.update', $aula) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="numero_identificador" class="form-label fw-semibold">Identificador <span class="text-danger">*</span></label>
                <input type="text" id="numero_identificador" name="numero_identificador"
                       class="form-control @error('numero_identificador') is-invalid @enderror"
                       value="{{ old('numero_identificador', $aula->numero_identificador) }}" maxlength="50" required>
                @error('numero_identificador')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="edificio" class="form-label fw-semibold">Edificio</label>
                <input type="text" id="edificio" name="edificio"
                       class="form-control"
                       value="{{ old('edificio', $aula->edificio) }}" maxlength="100">
            </div>
            <div class="mb-3">
                <label for="tipo_aula" class="form-label fw-semibold">Tipo de Aula</label>
                <input type="text" id="tipo_aula" name="tipo_aula"
                       class="form-control"
                       value="{{ old('tipo_aula', $aula->tipo_aula) }}" maxlength="100">
            </div>
            <div class="mb-3">
                <label for="capacidad_maxima" class="form-label fw-semibold">Capacidad Máxima <span class="text-danger">*</span></label>
                <input type="number" id="capacidad_maxima" name="capacidad_maxima"
                       class="form-control @error('capacidad_maxima') is-invalid @enderror"
                       value="{{ old('capacidad_maxima', $aula->capacidad_maxima) }}" min="1" required>
                @error('capacidad_maxima')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="estatus" name="estatus" value="1"
                       {{ old('estatus', $aula->estatus) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="estatus">Aula Activa</label>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
                <a href="{{ route('aulas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
