<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si no está logueado, al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Si está logueado pero no es un empleado (2) o un admin (3)
        if (!in_array(Auth::user()->id_rol, [2, 3])) {
            // Lo echamos a la página principal con un mensaje de error
            return redirect()->route('principal')
                ->withErrors(['error' => 'No tienes permisos para acceder al área de gestión.']);
        }

        // Si es empleado o admin se le deja pasar
        return $next($request);
    }
}