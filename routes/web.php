<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\KardexInscripcionController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\BitacoraAuditoriaController;

// ==========================================
// Rutas públicas: Autenticación
// ==========================================

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Redirección raíz al login
Route::get('/', fn() => redirect()->route('login'));

// ==========================================
// Rutas protegidas: requieren autenticación
// ==========================================

Route::middleware(['auth'])->group(function () {

    // Dashboard general (todos los roles)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==========================================
    // Solo Admin: gestión del sistema completo
    // ==========================================
    Route::middleware(['rol:Admin'])->group(function () {

        // Roles
        Route::resource('roles', RolController::class)->except(['show']);

        // Usuarios
        Route::resource('usuarios', UsuarioController::class)->except(['show']);

        // Bitácora de auditoría (solo lectura)
        Route::get('/bitacora', [BitacoraAuditoriaController::class, 'index'])->name('bitacora.index');

        // Catálogos base
        Route::resource('aulas', AulaController::class)->except(['show']);
        Route::resource('periodos', PeriodoController::class)->except(['show']);
        Route::resource('carreras', CarreraController::class)->except(['show']);
    });

    // ==========================================
    // Admin y Personal Administrativo
    // ==========================================
    Route::middleware(['rol:Admin,Personal Administrativo'])->group(function () {

        // Materias
        Route::resource('materias', MateriaController::class)->except(['show']);

        // Alumnos
        Route::resource('alumnos', AlumnoController::class);

        // Docentes
        Route::resource('docentes', DocenteController::class);

        // Grupos
        Route::resource('grupos', GrupoController::class);

        // Inscripciones / Kardex (gestión administrativa)
        Route::resource('kardex', KardexInscripcionController::class)
            ->parameters(['kardex' => 'kardex']);
    });

    // ==========================================
    // Docente: gestión de calificaciones y asistencia
    // ==========================================
    Route::middleware(['rol:Docente'])->group(function () {

        // Solo puede actualizar calificaciones, no crear/eliminar inscripciones
        Route::get('/kardex', [KardexInscripcionController::class, 'index'])->name('kardex.index');
        Route::get('/kardex/{kardex}/edit', [KardexInscripcionController::class, 'edit'])->name('kardex.edit');
        Route::put('/kardex/{kardex}', [KardexInscripcionController::class, 'update'])->name('kardex.update');

        // Gestión completa de asistencias de sus grupos
        Route::resource('asistencias', AsistenciaController::class)->except(['show']);
    });

    // ==========================================
    // Alumno: solo vista de su propia información
    // ==========================================
    Route::middleware(['rol:Alumno'])->group(function () {

        Route::get('/mi-kardex', [KardexInscripcionController::class, 'miKardex'])->name('kardex.mi-kardex');
        Route::get('/mis-asistencias', [AsistenciaController::class, 'misAsistencias'])->name('asistencias.mis-asistencias');
    });
});
