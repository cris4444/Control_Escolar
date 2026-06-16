@extends('layouts.app')
@section('titulo', 'Asistencias')

@section('contenido')
<div class="d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Registro de Asistencias</h5>
    <a href="{{ route('asistencias.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Registrar Asistencia
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Alumno</th>
                    <th>Materia / Grupo</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asistencias as $asistencia)
                <tr>
                    <td>{{ $asistencia->alumno->nombres ?? '—' }} {{ $asistencia->alumno->apellidos ?? '' }}</td>
                    <td class="text-muted small">{{ $asistencia->grupo->materia->nombre ?? '—' }}</td>
                    <td>{{ $asistencia->fecha }}</td>
                    <td>
                        <span class="badge {{
                            $asistencia->estatus_asistencia === 'Presente' ? 'bg-success' :
                            ($asistencia->estatus_asistencia === 'Justificada' ? 'bg-warning text-dark' : 'bg-danger')
                        }}">{{ $asistencia->estatus_asistencia }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('asistencias.edit', $asistencia) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('asistencias.destroy', $asistencia) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este registro?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
