@extends('layouts.app')
@section('titulo', 'Nuevo Grupo')

@section('contenido')
<div class="py-3">
    <a href="{{ route('grupos.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Volver a Grupos
    </a>
    <h5 class="fw-bold mt-1">Nuevo Grupo</h5>
</div>

<div class="card border-0 shadow-sm" style="max-width:580px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('grupos.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="periodo_id" class="form-label fw-semibold">Periodo <span class="text-danger">*</span></label>
                    <select id="periodo_id" name="periodo_id"
                            class="form-select @error('periodo_id') is-invalid @enderror" required>
                        <option value="">— Seleccionar —</option>
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo->id }}" {{ old('periodo_id') == $periodo->id ? 'selected' : '' }}>
                                {{ $periodo->codigo }}
                            </option>
                        @endforeach
                    </select>
                    @error('periodo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cupo_maximo" class="form-label fw-semibold">Cupo Máximo <span class="text-danger">*</span></label>
                    <input type="number" id="cupo_maximo" name="cupo_maximo"
                           class="form-control @error('cupo_maximo') is-invalid @enderror"
                           value="{{ old('cupo_maximo') }}" min="1" required>
                    @error('cupo_maximo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="materia_id" class="form-label fw-semibold">Materia <span class="text-danger">*</span></label>
                    <select id="materia_id" name="materia_id"
                            class="form-select @error('materia_id') is-invalid @enderror" required>
                        <option value="">— Seleccionar —</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
                                {{ $materia->clave_materia }} — {{ $materia->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('materia_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="docente_id" class="form-label fw-semibold">Docente <span class="text-danger">*</span></label>
                    <select id="docente_id" name="docente_id"
                            class="form-select @error('docente_id') is-invalid @enderror" required>
                        <option value="">— Seleccionar —</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id }}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
                                {{ $docente->nombres }} {{ $docente->apellidos }}
                            </option>
                        @endforeach
                    </select>
                    @error('docente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="aula_id" class="form-label fw-semibold">Aula <span class="text-danger">*</span></label>
                    <select id="aula_id" name="aula_id"
                            class="form-select @error('aula_id') is-invalid @enderror" required>
                        <option value="">— Seleccionar —</option>
                        @foreach($aulas as $aula)
                            <option value="{{ $aula->id }}" {{ old('aula_id') == $aula->id ? 'selected' : '' }}>
                                {{ $aula->numero_identificador }} (cap. {{ $aula->capacidad_maxima }})
                            </option>
                        @endforeach
                    </select>
                    @error('aula_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
                <a href="{{ route('grupos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
