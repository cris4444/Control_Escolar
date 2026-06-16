@extends('layouts.app')
@section('titulo', 'Dashboard')

@section('contenido')
<div class="py-3">
    <h5 class="fw-bold mb-1">Bienvenido, {{ auth()->user()->correo_institucional }}</h5>
    <p class="text-muted">Rol: <span class="badge bg-primary">{{ auth()->user()->rol->nombre }}</span></p>
</div>

@php $rol = auth()->user()->rol->nombre; @endphp

<div class="row g-3">

    @if($rol === 'Admin')
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-people-fill text-primary fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Usuarios</div>
                        <a href="{{ route('usuarios.index') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-warning bg-opacity-10 p-3">
                        <i class="bi bi-shield-lock text-warning fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Roles</div>
                        <a href="{{ route('roles.index') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-info bg-opacity-10 p-3">
                        <i class="bi bi-building text-info fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Carreras</div>
                        <a href="{{ route('carreras.index') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-danger bg-opacity-10 p-3">
                        <i class="bi bi-journal-text text-danger fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Bitácora</div>
                        <a href="{{ route('bitacora.index') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(in_array($rol, ['Admin', 'Personal Administrativo']))
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-success bg-opacity-10 p-3">
                        <i class="bi bi-person-badge text-success fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Alumnos</div>
                        <a href="{{ route('alumnos.index') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-secondary bg-opacity-10 p-3">
                        <i class="bi bi-person-workspace text-secondary fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Docentes</div>
                        <a href="{{ route('docentes.index') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-collection text-primary fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Grupos</div>
                        <a href="{{ route('grupos.index') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-warning bg-opacity-10 p-3">
                        <i class="bi bi-card-list text-warning fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Kardex</div>
                        <a href="{{ route('kardex.index') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rol === 'Docente')
        <div class="col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-card-list text-primary fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Calificaciones</div>
                        <a href="{{ route('kardex.index') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Capturar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-success bg-opacity-10 p-3">
                        <i class="bi bi-check2-square text-success fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Asistencias</div>
                        <a href="{{ route('asistencias.index') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Registrar</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rol === 'Alumno')
        <div class="col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-card-list text-primary fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Mis Calificaciones</div>
                        <a href="{{ route('kardex.mi-kardex') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Ver Kardex</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-success bg-opacity-10 p-3">
                        <i class="bi bi-check2-square text-success fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Mis Asistencias</div>
                        <a href="{{ route('asistencias.mis-asistencias') }}" class="stretched-link fw-semibold text-decoration-none text-dark">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
