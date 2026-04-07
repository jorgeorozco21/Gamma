<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTipoUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $tipoEsperado): Response
    {
        if (session('tipo') !== $tipoEsperado){
            return redirect('/seleccionar-tipo-usuario')->with('error', 'No tienes acceso a esta área.');
        }

        return $next($request);
    }
}
