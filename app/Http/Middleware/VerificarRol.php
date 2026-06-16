<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    /**
     * Verifica que el usuario autenticado tenga alguno de los roles permitidos.
     * Uso en rutas: middleware('rol:Admin,Docente')
     */
    public function handle(Request $request, Closure $next, string ...$rolesPermitidos): Response
    {
        $usuario = $request->user();

        if (!$usuario || !$usuario->rol) {
            abort(403, 'Acceso denegado: usuario sin rol asignado.');
        }

        if (!in_array($usuario->rol->nombre, $rolesPermitidos)) {
            abort(403, 'Acceso denegado: no tienes permisos para esta sección.');
        }

        return $next($request);
    }
}
