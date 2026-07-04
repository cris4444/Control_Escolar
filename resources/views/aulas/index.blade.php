@extends('layouts.app')
@section('titulo', 'Aulas')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">Aulas</h5>
        @if($periodoActual)
            <small class="text-muted">Ocupación calculada con el periodo vigente: <strong>{{ $periodoActual->codigo }}</strong></small>
        @else
            <small class="text-muted">No hay un periodo vigente hoy; la ocupación se muestra en 0.</small>
        @endif
    </div>
    <a href="{{ route('aulas.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nueva Aula
    </a>
</div>

<div class="d-flex gap-2 mb-3 flex-wrap">
    <input type="text" id="buscadorAulas" class="form-control" style="max-width:260px"
        placeholder="Buscar por identificador o edificio...">
    <select id="filtroEdificio" class="form-select" style="max-width:200px">
        <option value="">Todos los edificios</option>
        @foreach($aulas->pluck('edificio')->filter()->unique()->sort() as $edificio)
            <option value="{{ $edificio }}">{{ $edificio }}</option>
        @endforeach
    </select>
    <select id="filtroEstatus" class="form-select" style="max-width:160px">
        <option value="">Todos los estatus</option>
        <option value="1">Activa</option>
        <option value="0">Inactiva</option>
    </select>
</div>

<div class="row g-3" id="listaAulas">
    @forelse($aulas as $aula)
        @php
            $porcentaje = $aula->porcentaje_ocupacion;
            $colorBarra = $porcentaje >= 90 ? 'bg-danger' : ($porcentaje >= 70 ? 'bg-warning' : 'bg-primary');
        @endphp
        <div class="col-md-4 col-lg-3 tarjeta-aula"
            data-nombre="{{ strtolower($aula->numero_identificador) }}"
            data-edificio="{{ strtolower($aula->edificio ?? '') }}"
            data-estatus="{{ $aula->estatus ? '1' : '0' }}">
            <div class="card border-0 shadow-sm h-100 {{ !$aula->estatus ? 'opacity-75' : '' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="fw-semibold mb-0">{{ $aula->numero_identificador }}</p>
                            <p class="text-muted small mb-0">
                                {{ $aula->edificio ?? 'Sin edificio' }}
                                @if($aula->tipo_aula) &middot; {{ $aula->tipo_aula }} @endif
                            </p>
                        </div>
                        <span class="badge {{ $aula->estatus ? 'bg-success' : 'bg-secondary' }}">
                            {{ $aula->estatus ? 'Activa' : 'Inactiva' }}
                        </span>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Ocupación</span>
                            <span>{{ $aula->inscritos_actuales }} / {{ $aula->capacidad_maxima }}</span>
                        </div>
                        <div class="progress" style="height:6px;">
                            <div class="progress-bar {{ $colorBarra }}" style="width: {{ $porcentaje }}%"></div>
                        </div>
                        <p class="small text-muted mt-1 mb-0">{{ $aula->grupos_actuales }} grupo(s) asignado(s) este periodo</p>
                    </div>

                    <div class="d-flex gap-1 mt-3">
                        <a href="{{ route('aulas.edit', $aula) }}" class="btn btn-sm btn-outline-secondary flex-fill">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('aulas.destroy', $aula) }}" method="POST" class="flex-fill"
                            onsubmit="return confirm('¿Eliminar esta aula?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center text-muted py-4">Sin registros.</div>
            </div>
        </div>
    @endforelse
</div>

<p id="sinResultados" class="text-center text-muted py-4 d-none">Ninguna aula coincide con tu búsqueda.</p>

@push('scripts')
<script>
    const buscador = document.getElementById('buscadorAulas');
    const filtroEdificio = document.getElementById('filtroEdificio');
    const filtroEstatus = document.getElementById('filtroEstatus');
    const tarjetas = document.querySelectorAll('.tarjeta-aula');
    const sinResultados = document.getElementById('sinResultados');

    function aplicarFiltros() {
        const texto = buscador.value.trim().toLowerCase();
        const edificio = filtroEdificio.value.toLowerCase();
        const estatus = filtroEstatus.value;
        let visibles = 0;

        tarjetas.forEach(tarjeta => {
            const coincideTexto = tarjeta.dataset.nombre.includes(texto) || tarjeta.dataset.edificio.includes(texto);
            const coincideEdificio = !edificio || tarjeta.dataset.edificio === edificio;
            const coincideEstatus = !estatus || tarjeta.dataset.estatus === estatus;
            const visible = coincideTexto && coincideEdificio && coincideEstatus;

            tarjeta.style.display = visible ? '' : 'none';
            if (visible) visibles++;
        });

        sinResultados.classList.toggle('d-none', visibles !== 0);
    }

    buscador.addEventListener('input', aplicarFiltros);
    filtroEdificio.addEventListener('change', aplicarFiltros);
    filtroEstatus.addEventListener('change', aplicarFiltros);
</script>
@endpush
@endsection