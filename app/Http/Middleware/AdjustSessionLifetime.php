<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class AdjustSessionLifetime
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si "Remember Me" était coché lors de la connexion
        if ($request->session()->get('remember_me', false)) {
            // 30 jours (43200 minutes) quand "Remember Me" est actif
            Config::set('session.lifetime', 43200);
        } else {
            // 24 heures (1440 minutes) par défaut
            Config::set('session.lifetime', 1440);
        }

        return $next($request);
    }
}
