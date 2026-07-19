@extends('layouts.app')
@section('titulo', 'Roles')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center py-3">
        <h5 class="fw-bold mb-0">Roles del Sistema</h5>
        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Nuevo Rol
        </a>
    </div>

    {{-- Zona de filtros --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form action="{{ route('roles.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label small text-muted mb-1">Buscar por nombre</label>
                    <input type="text" name="buscar" value="{{ request('buscar') }}"
                        class="form-control form-control-sm" placeholder="Ej. Docente">
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-search me-1"></i>Filtrar
                    </button>
                    @if (request('buscar'))
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Permisos</th>
                        <th>Usuarios</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $rol)
                        <tr>
                            <td class="text-muted small">{{ $rol->id }}</td>
                            <td class="fw-semibold">{{ $rol->nombre }}</td>
                            <td class="text-muted">{{ $rol->descripcion ?? '—' }}</td>
                            <td>{{ $rol->permisos_count }}</td>
                            <td>{{ $rol->usuarios_count }}</td>
                            <td>
                                @if ($rol->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('roles.edit', $rol) }}" class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('roles.destroy', $rol) }}" method="POST"
                                    class="d-inline form-eliminar-rol" data-nombre="{{ $rol->nombre }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Sin registros con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.form-eliminar-rol').forEach(form => {
            const boton = form.querySelector('button');
            boton.addEventListener('click', function() {
                const nombre = form.dataset.nombre;
                Swal.fire({
                    title: '¿Eliminar rol?',
                    text: `Se eliminará el rol "${nombre}".`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#dc2626',
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
@endpush
