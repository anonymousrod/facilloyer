<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentification de l'utilisateur
        $request->authenticate();

        // Vérifiez si l'utilisateur est un locataire avec un compte désactivé
        $user = Auth::user();
        if ($user->id_role == 2 && !$user->statut) {
            // Déconnectez l'utilisateur immédiatement
            Auth::logout();

            // Redirigez vers la page de login avec un message d'erreur
            return redirect()->route('login')->withErrors([
                'status' => 'Votre compte a été désactivé. Veuillez contacter votre agent immobilier pour plus d\'informations.',
            ]);
        }

        // Régénérez la session si tout est correct
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

