<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
        // Ajusta esta lista según tus carpetas reales en resources/views
        $modulos = [
            'usuarios'    => ['ver', 'crear', 'editar', 'eliminar'],
            'roles'       => ['ver', 'crear', 'editar', 'eliminar'],
            'alumnos'     => ['ver', 'crear', 'editar', 'eliminar'],
            'docentes'    => ['ver', 'crear', 'editar', 'eliminar'],
            'materias'    => ['ver', 'crear', 'editar', 'eliminar'],
            'grupos'      => ['ver', 'crear', 'editar', 'eliminar'],
            'aulas'       => ['ver', 'crear', 'editar', 'eliminar'],
            'carreras'    => ['ver', 'crear', 'editar', 'eliminar'],
            'periodos'    => ['ver', 'crear', 'editar', 'eliminar'],
            'asistencias' => ['ver', 'registrar'],
            'kardex'      => ['ver'],
            'bitacora'    => ['ver'],
        ];

        foreach ($modulos as $modulo => $acciones) {
            foreach ($acciones as $accion) {
                Permiso::firstOrCreate(
                    ['clave' => "{$modulo}.{$accion}"],
                    ['modulo' => $modulo, 'descripcion' => ucfirst($accion) . ' ' . $modulo]
                );
            }
        }

        // Admin: todos los permisos
        $admin = Rol::where('nombre', 'Admin')->first();
        if ($admin) {
            $admin->permisos()->sync(Permiso::pluck('id'));
        }

        // Director: lectura amplia + edición académica, sin gestionar usuarios/roles
        $director = Rol::where('nombre', 'Director')->first();
        if ($director) {
            $claves = [
                'alumnos.ver', 'docentes.ver', 'materias.ver', 'materias.editar',
                'grupos.ver', 'grupos.editar', 'aulas.ver', 'carreras.ver', 'carreras.editar',
                'periodos.ver', 'periodos.editar', 'asistencias.ver', 'kardex.ver', 'bitacora.ver',
            ];
            $director->permisos()->sync(Permiso::whereIn('clave', $claves)->pluck('id'));
        }

        // Coordinador de Carrera: gestiona lo académico de su área
        $coordinador = Rol::where('nombre', 'Coordinador de Carrera')->first();
        if ($coordinador) {
            $claves = [
                'alumnos.ver', 'docentes.ver', 'materias.ver', 'materias.editar',
                'grupos.ver', 'grupos.crear', 'grupos.editar', 'carreras.ver', 'aulas.ver',
            ];
            $coordinador->permisos()->sync(Permiso::whereIn('clave', $claves)->pluck('id'));
        }

        // Docente: su operación diaria
        $docente = Rol::where('nombre', 'Docente')->first();
        if ($docente) {
            $claves = ['alumnos.ver', 'materias.ver', 'grupos.ver', 'asistencias.ver', 'asistencias.registrar', 'kardex.ver'];
            $docente->permisos()->sync(Permiso::whereIn('clave', $claves)->pluck('id'));
        }

        // Contador: por ahora solo lectura de lo académico (ajusta si tienes módulo de pagos)
        $contador = Rol::where('nombre', 'Contador')->first();
        if ($contador) {
            $claves = ['alumnos.ver', 'kardex.ver', 'bitacora.ver'];
            $contador->permisos()->sync(Permiso::whereIn('clave', $claves)->pluck('id'));
        }

        // Alumno: solo su kardex
        $alumno = Rol::where('nombre', 'Alumno')->first();
        if ($alumno) {
            $alumno->permisos()->sync(Permiso::whereIn('clave', ['kardex.ver'])->pluck('id'));
        }
    }
}
