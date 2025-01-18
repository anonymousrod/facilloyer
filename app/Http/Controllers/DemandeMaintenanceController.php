<?php

namespace App\Http\Controllers;

use App\Models\DemandeMaintenance;
use App\Models\Locataire;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeMaintenanceController extends Controller
{

        /**
     * Afficher les demandes de maintenance pour un agent immobilier connecté.
     *
     * @return \Illuminate\View\View
     */

     //   POUR AFFICHER LES DEMAMNDE DE MAINTENANCE DANS LE DASHBOARD LOCATAIRE 
public function afficherDemandesAgent()
    {
        // Récupérer l'agent connecté
        $agentId = auth()->user()->id;
    
        // Récupérer les demandes de maintenance des biens de l'agent connecté
        $demandes = DemandeMaintenance::with(['locataire', 'bien'])
            ->whereHas('bien', function ($query) use ($agentId) {
                $query->where('agent_immobilier_id', $agentId);
            })
            ->get();
    
        // Log des résultats pour déboguer
        \Log::info('Demandes récupérées : ', $demandes->toArray());
    
        // Retourner la vue avec les données
        return view('agent.demandes', compact('demandes'));
    }

    /**
     * Récupère les demandes de maintenance regroupées par agence, locataire et bien.
     */
public function indexGrouped()
    {
        // Récupérer les demandes de maintenance avec leurs relations
        $demandes = DemandeMaintenance::with(['locataire', 'bien.agent_immobilier'])
            ->get()
            ->groupBy(function ($demande) {
                return $demande->bien->agent_immobilier->nom_agence?? 'Agence inconnue';
            });

        return view('admin.demandes.grouped', compact('demandes'));
    }
    
     // POUR QUE L'AGENT CHANGENT LES STATUT DEs DEMANDEs ENCOOURS OU TERMINE
public function mettreAJourStatut(Request $request, $id)
    {
        // Valider le statut
        $request->validate([
            'statut' => 'required|in:en attente,en cours,terminée',
        ]);

        // Trouver la demande de maintenance
        $demande = DemandeMaintenance::findOrFail($id);

        // Vérifier si l'agent est autorisé à modifier cette demande
        if ($demande->bien->agent_immobilier_id !== auth()->user()->id) {
            abort(403, 'Action non autorisée.');
        }

        // Mettre à jour le statut
        $demande->statut = $request->statut;
        $demande->save();

        // Rediriger avec un message de succès
        return redirect()->route('agent.demandes')->with('success', 'Statut mis à jour avec succès.');
    }

    

    // Afficher le formulaire de demande de maintenance pour un locataire
    public function create()
    {
        // Récupérer le locataire connecté
        $locataire = Auth::user()->locataires()->first();
        
        // Vérifier si le locataire a des biens associés
        if (!$locataire) {
            return redirect()->route('dashbord')->with('error', 'Il faut etre un locataire pour soumettre une demande de maintenance');
        }

        // Récupérer les biens associés au locataire
        $biens = $locataire->biens;

        // Passer les biens à la vue
        return view('locataire.demandes.create', compact('biens'));
    }

    // Enregistrer une nouvelle demande de maintenance
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'bien_id' => 'required|exists:biens,id',
            'description' => 'required|string|max:255',
            'statut' => 'required|in:en attente,en cours,terminée'
        ]);

        // Récupérer le locataire connecté
        $locataire = Auth::user()->locataires()->first();

        // Vérifier si le locataire existe
        if (!$locataire) {
            return redirect()->route('dashbord')->with('error', 'Desole nous n avons pas pu soumettre votre demande.');
        }

        // Créer la demande de maintenance
        try {
            DemandeMaintenance::create([
                'locataire_id' => $locataire->id,
                'bien_id' => $request->bien_id,
                'description' => $request->description,
                'statut' => $request->statut,
            ]);

            // Redirection avec message de succès
            return redirect()->route('locataire.demandes.index')->with('success', 'Votre demande de maintenance a été enregistrée.');
        } catch (\Exception $e) {
            // Si une erreur survient
            return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de votre demande.');
        }
    }

    // Afficher la liste des demandes de maintenance pour le locataire
    public function index()
    {
        // Récupérer le locataire connecté
        $locataire = Auth::user()->locataires()->first();

        // Vérifier si le locataire existe
        if (!$locataire) {
            return redirect()->route('dashboard')->with('error', 'Probleme lors de l afichage des demandes.');
        }

        // Récupérer les demandes de maintenance du locataire
        $demandes = $locataire->demandesMaintenance;

        return view('locataire.demandes.index', compact('demandes'));
    }

    // Afficher le formulaire d'édition d'une demande de maintenance



}
