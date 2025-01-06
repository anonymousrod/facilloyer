<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PDF; // Si vous utilisez barryvdh/laravel-dompdf

use App\Models\User;
use App\Models\AgentImmobilier;
use App\Models\Locataire;
use App\Models\ContratsDeBail;
use App\Models\ContratDeBailLocataire;

use App\Models\Bien;

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

public function index()
    {
        $contrats = ContratsDeBail::with('bien.agent_immobilier', 'contrat_de_bail_locataires.locataire')->get();
        $biens = Bien::with('agent_immobilier')->get();
        $locataires = Locataire::all();

        return view('admin.contrats_de_bail.index', compact('contrats', 'biens', 'locataires'));
    }

    // Méthode pour créer un contrat de bail
public function store(Request $request)
    {
        $request->validate([
            'bien_id' => 'required|exists:biens,id',
            'locataire_id' => 'required|exists:locataires,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'loyer_mensuel' => 'required|numeric',
            'depot_de_garantie' => 'required|numeric',
        ]);

        try {
            // Création du contrat de bail
            $contrat = ContratsDeBail::create([
                'bien_id' => $request->bien_id,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'loyer_mensuel' => $request->loyer_mensuel,
                'depot_de_garantie' => $request->depot_de_garantie,
            ]);

            // Association avec le locataire
            $contrat->contrat_de_bail_locataires()->create([
                'locataire_id' => $request->locataire_id,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
            ]);

            return redirect()->route('admin.contrats_de_bail.index')
                ->with('success', 'Contrat de bail créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.contrats_de_bail.index')
                ->with('error', 'Une erreur est survenue lors de la création du contrat.');
        }
    }

    // Méthode pour supprimer un contrat de bail
public function destroy($id)
    {
        $contrat = ContratsDeBail::findOrFail($id);

        try {
            $contrat->delete();

            return redirect()->route('admin.contrats_de_bail.index')
                ->with('success', 'Contrat de bail supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.contrats_de_bail.index')
                ->with('error', 'Une erreur est survenue lors de la suppression du contrat.');
        }
    }



// Dans ActionAdminController.php

public function showContractDetails($id)
    {
        // Récupérer le contrat de bail du locataire avec les relations nécessaires
        $contratDeBailLocataire = ContratDeBailLocataire::with(['contrats_de_bail', 'locataire'])->findOrFail($id);
        
        // Retourner la vue avec les informations du contrat de bail
        return view('admin.contrats_de_bail.show', compact('contratDeBailLocataire'));
    }



// Dans ActionAdminController.php


public function exportContractToPDF($id)
{
    $contratDeBailLocataire = ContratDeBailLocataire::with(['contrats_de_bail', 'locataire'])->findOrFail($id);

    // Générer le PDF
    $pdf = PDF::loadView('admin.contrats_de_bail.pdf', compact('contratDeBailLocataire'));

    // Retourner le PDF en téléchargement
    return $pdf->download('Contrat_de_Bail_' . $contratDeBailLocataire->id . '.pdf');
}





}
