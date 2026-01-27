<?php

//------------------------------------------------
//protège toutes les routes réservées aux admins
//------------------------------------------------

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est connecté ET admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403); // Interdit l'accès
        }

        return $next($request);
    }
}
