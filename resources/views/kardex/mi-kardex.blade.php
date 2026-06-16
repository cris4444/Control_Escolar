@extends('layouts.app')
@section('titulo', 'Mi Kardex')

@section('contenido')
<div class="py-3">
    <h5 class="fw-bold mb-0">Mi Kardex Académico</h5>
    <p class="text-muted small">{{ $alumno->nombres }} {{ $alumno->apellidos }} — {{ $alumno->matricula }}</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Materia</th>
                    <th>Periodo</th>
                    <th>Tipo Evaluación</th>
                    <th>Calificación</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscripciones as $k)
                <tr>
                    <td class="fw-semibold">{{ $k->grupo->materia->nombre ?? '—' }}</td>
                    <td>{{ $k->grupo->periodo->codigo ?? '—' }}</td>
                    <td>{{ $k->tipoEvaluacion->nombre ?? '—' }}</td>
                    <td>
                        @if($k->calificacion_final !== null)
                            <span class="fw-bold {{ $k->calificacion_final >= 6 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($k->calificacion_final, 2) }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{
                            $k->estatus_materia === 'Aprobada' ? 'bg-success' :
                            ($k->estatus_materia === 'Reprobada' ? 'bg-danger' : 'bg-secondary')
                        }}">{{ $k->estatus_materia }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No tienes inscripciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
