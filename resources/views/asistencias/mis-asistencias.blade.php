@extends('layouts.app')
@section('titulo', 'Mis Asistencias')

@section('contenido')
<div class="py-3">
    <h5 class="fw-bold mb-0">Mis Asistencias</h5>
    <p class="text-muted small">{{ $alumno->nombres }} {{ $alumno->apellidos }} — {{ $alumno->matricula }}</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Materia</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asistencias as $asistencia)
                <tr>
                    <td>{{ $asistencia->fecha }}</td>
                    <td>{{ $asistencia->grupo->materia->nombre ?? '—' }}</td>
                    <td>
                        <span class="badge {{
                            $asistencia->estatus_asistencia === 'Presente' ? 'bg-success' :
                            ($asistencia->estatus_asistencia === 'Justificada' ? 'bg-warning text-dark' : 'bg-danger')
                        }}">{{ $asistencia->estatus_asistencia }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">Sin registros de asistencia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
