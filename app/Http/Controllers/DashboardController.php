<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        // $user = Auth::user();
        // if (!$user->statut) {
        //     // Rediriger l'utilisateur avec un message d'information
        //     return view('layouts.dashboard', [
        //         'message' => "Votre compte est en attente d'activation par l'administrateur. Vous aurez accès aux autres fonctionnalités une fois activé."

        //     ]);
        // }

        // // Charger les éléments du tableau de bord si le compte est activé
        // return view('layouts.dashboard', [
        //     'message' => null,
        //     'statut' => " statu valide "
        // ]);

        $user = Auth::user();
        if (Auth::user()->id_role == 2) {
            return redirect()->route('locataire.locashow', Auth::user()->id);
        }
        if (Auth::user()->id_role == 3 && !$user->statut) {
            return redirect()->route('agent_immobilier.create');
        } elseif (Auth::user()->id_role == 3 && $user->statut) {
            return redirect()->route('profil_agent');
        }

        // Charger les éléments du tableau de bord si le compte est activé
        return view('layouts.dashboard', [
            'message' => null,
            'statut' => " statu valide "
        ]);
    }
}
