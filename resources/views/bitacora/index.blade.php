@extends('layouts.app')
@section('titulo', 'Bitácora de Auditoría')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Bitácora de Auditoría</h5>
</div>

{{-- Filtros --}}
<form method="GET" action="{{ route('bitacora.index') }}" class="card border-0 shadow-sm mb-3">
    <div class="card-body py-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold small mb-1">Acción</label>
                <select name="accion" class="form-select form-select-sm">
                    <option value="">Todas</option>
                    @foreach(['LOGIN', 'LOGOUT', 'CREATE', 'UPDATE', 'DELETE'] as $accion)
                        <option value="{{ $accion }}" {{ request('accion') === $accion ? 'selected' : '' }}>
                            {{ $accion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small mb-1">Tabla</label>
                <input type="text" name="tabla" class="form-control form-control-sm"
                       value="{{ request('tabla') }}" placeholder="Ej. Alumnos">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i>Filtrar
                </button>
            </div>
        </div>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-sm mb-0">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Tabla</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registros as $registro)
                <tr>
                    <td class="text-muted small text-nowrap">{{ $registro->created_at }}</td>
                    <td class="small">{{ $registro->usuario->correo_institucional ?? '—' }}</td>
                    <td>
                        <span class="badge {{
                            $registro->accion === 'LOGIN' ? 'bg-success' :
                            ($registro->accion === 'LOGOUT' ? 'bg-secondary' :
                            ($registro->accion === 'DELETE' ? 'bg-danger' : 'bg-primary'))
                        }}">{{ $registro->accion }}</span>
                    </td>
                    <td class="small">{{ $registro->tabla_afectada }}</td>
                    <td class="small text-muted">
                        @if($registro->valores_json)
                            <code>{{ json_encode($registro->valores_json) }}</code>
                        @else
                            —
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($registros->hasPages())
    <div class="card-footer bg-transparent">
        {{ $registros->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
