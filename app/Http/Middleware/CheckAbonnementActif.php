<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAbonnementActif
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Si l'utilisateur est un agent immobilier
        if ($user && $user->agent_immobiliers->isNotEmpty()) {

            $agent = $user->agent_immobiliers->first();

            // Si l'abonnement est inactif
            if (!$agent->abonnementActif()) {
                return redirect()->route('plans.index')
                    ->with('error', 'Votre abonnement est expiré ou inactif.');
            }
        }

        // Pour les autres utilisateurs (admin, locataires…), on laisse passer sans vérification
        return $next($request);
    }
}

