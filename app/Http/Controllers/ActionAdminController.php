<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AgentImmobilier;
use App\Models\Locataire;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActionAdminController extends Controller
{
    // Afficher les locataires par agence
    public function afficherLocatairesParAgence()
    {
        // Récupérer toutes les agences avec leurs locataires
        $agences = AgentImmobilier::with('locataires.user')->get();

        return view('admin.locataires_par_agence', compact('agences'));
    }

    // Changer le statut du locataire
    public function changerEtatLocataire(Request $request, $locataireId)
    {
        // Trouver le locataire et son utilisateur
        $locataire = Locataire::findOrFail($locataireId);
        $user = $locataire->user;

        // Modifier le statut de l'utilisateur (locataire)
        $user->update(['statut' => !$user->statut]);

        return redirect()->back()->with('success', 'Le statut du locataire a été modifié avec succès.');
    }

    // Supprimer le locataire
    public function supprimerLocataire($locataireId)
    {
        $locataire = Locataire::findOrFail($locataireId);
        $locataire->delete();

        return redirect()->back()->with('success', 'Le locataire a été supprimé avec succès.');
    }




}
