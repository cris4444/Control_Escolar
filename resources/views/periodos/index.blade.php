@extends('layouts.app')
@section('titulo', 'Periodos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Periodos Escolares</h5>
    <a href="{{ route('periodos.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nuevo Periodo
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @forelse($periodos as $periodo)
            @php
                $config = match($periodo->estado_calculado) {
                    'activo'   => ['label' => 'Activo ahora', 'badge' => 'bg-success', 'punto' => 'bg-success', 'fondo' => 'bg-success-subtle'],
                    'proximo'  => ['label' => 'Próximo', 'badge' => 'bg-secondary', 'punto' => 'bg-secondary', 'fondo' => ''],
                    default    => ['label' => 'Cerrado', 'badge' => 'bg-light text-muted border', 'punto' => 'bg-light border', 'fondo' => ''],
                };
            @endphp
            <div class="d-flex gap-3">
                <div class="d-flex flex-column align-items-center">
                    <div class="rounded-circle {{ $config['punto'] }}" style="width:12px;height:12px;"></div>
                    @if(!$loop->last)
                        <div style="width:1px;flex:1;background:#dee2e6;min-height:38px;"></div>
                    @endif
                </div>
                <div class="flex-grow-1 pb-4 {{ $config['fondo'] ? 'p-3 rounded-3 ' . $config['fondo'] : '' }}" style="margin-top:-4px;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <span class="fw-semibold">{{ $periodo->codigo }}</span>
                            <span class="badge {{ $config['badge'] }} ms-2">{{ $config['label'] }}</span>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('periodos.edit', $periodo) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('periodos.destroy', $periodo) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este periodo?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <p class="small text-muted mb-0 mt-1">
                        {{ \Carbon\Carbon::parse($periodo->fecha_inicio)->translatedFormat('d M Y') }}
                        &mdash;
                        {{ \Carbon\Carbon::parse($periodo->fecha_fin)->translatedFormat('d M Y') }}
                        &middot; {{ $periodo->grupos_count }} grupo(s)
                    </p>
                </div>
            </div>
        @empty
            <p class="text-center text-muted py-4 mb-0">Sin registros.</p>
        @endforelse
    </div>
</div>
@endsection