@extends('layouts.app')
@section('titulo', 'Usuarios')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center py-3">
        <h5 class="fw-bold mb-0">Usuarios del Sistema</h5>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Nuevo Usuario
        </a>
    </div>

    {{-- Zona de filtros --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form action="{{ route('usuarios.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small text-muted mb-1">Buscar por correo</label>
                    <input type="text" name="buscar" value="{{ request('buscar') }}"
                        class="form-control form-control-sm" placeholder="ejemplo@saes.edu.mx">
                </div>

                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">Rol</label>
                    <select name="rol_id" class="form-select form-select-sm">
                        <option value="">Todos los roles</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}" @selected(request('rol_id') == $rol->id)>
                                {{ $rol->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-search me-1"></i>Filtrar
                    </button>
                    @if (request('buscar') || request('rol_id'))
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-sm w-100">
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
                        <th>Correo Institucional</th>
                        <th>Rol</th>
                        <th>Registro</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->correo_institucional }}</td>
                            <td><span class="badge bg-primary">{{ $usuario->rol->nombre ?? '—' }}</span></td>
                            <td class="text-muted small">{{ $usuario->consentimiento_aviso }}</td>
                            <td class="text-end">
                                <a href="{{ route('usuarios.edit', $usuario) }}"
                                    class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST"
                                    class="d-inline form-eliminar-usuario"
                                    data-correo="{{ $usuario->correo_institucional }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger"><i
                                            class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Sin registros con los filtros
                                aplicados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($usuarios->hasPages())
            <div class="card-footer bg-white border-0">
                {{ $usuarios->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.form-eliminar-usuario').forEach(form => {
            const boton = form.querySelector('button');
            boton.addEventListener('click', function() {
                const correo = form.dataset.correo;
                Swal.fire({
                    title: '¿Eliminar usuario?',
                    html: `Esta acción eliminará a <b>${correo}</b>.`,
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
