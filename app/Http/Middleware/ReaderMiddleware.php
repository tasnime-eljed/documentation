<?php

//------------------------------------------------
//protège toutes les routes réservées aux readers
//------------------------------------------------

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReaderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est connecté ET reader
        if (!auth()->check() || !auth()->user()->isReader()) {
            abort(403); // interdit l'accès si pas reader
        }

        return $next($request); // laisse passer la requête si ok
    }
}
