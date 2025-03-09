<?php

namespace App\Http\Controllers;

use App\Models\DemandeMaintenance;
use App\Models\Locataire;
use App\Models\AgentImmobilier;
use App\Models\Bien;
use App\Notifications\DemandeMaintenanceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class DemandeMaintenanceController extends Controller
{


    // Afficher les demandes de maintenance pour un agent immobilier connecté.


    //   POUR AFFICHER LES DEMAMNDE DE MAINTENANCE DANS LE DASHBOARD AGENT
    public function afficherDemandesAgent()
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = auth()->user()->id;

        // Récupérer l'agent immobilier correspondant à cet utilisateur
        $agent = AgentImmobilier::where('user_id', $userId)->first();

        // Vérifier si un agent a été trouvé
        if (!$agent) {
            abort(404, 'Agent immobilier introuvable pour cet utilisateur.');
        }

        // Récupérer les demandes de maintenance liées aux biens de cet agent immobilier
        $demandes = DemandeMaintenance::with(['locataire', 'bien'])
            ->whereHas('bien', function ($query) use ($agent) {
                $query->where('agent_immobilier_id', $agent->id);
            })
            ->get();
        // concernant la notification
        if (request()->has('notification_id')) {
            auth()->user()->notifications()
                ->where('id', request('notification_id'))
                ->update(['read_at' => now()]);
        }

        // Vérifier si des demandes ont été trouvées (pour les logs)
        if ($demandes->isEmpty()) {
            \Log::info("Aucune demande trouvée pour l'agent immobilier ID {$agent->id}.");
        } else {
            \Log::info("Demandes récupérées pour l'agent immobilier ID {$agent->id} : ", $demandes->toArray());
        }

        // Retourner la vue avec les données des demandes
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
                return $demande->bien->agent_immobilier->nom_agence ?? 'Agence inconnue';
            });

        return view('admin.demandes.grouped', compact('demandes'));
    }

    // POUR QUE L'AGENT CHANGENT LES STATUT DEs DEMANDEs ENCOOURS OU TERMINE

    public function mettreAJourStatut(Request $request, $id)
    {
        Log::info("Requête reçue pour mettre à jour le statut : ", $request->all());

        $agentId = AgentImmobilier::where('user_id', auth()->user()->id)->value('id');
        Log::info("Agent ID connecté : " . $agentId);

        $demande = DemandeMaintenance::find($id);
        if (!$demande) {
            Log::error("Demande introuvable pour ID : " . $id);
            abort(404, 'Demande introuvable.');
        }

        Log::info("Demande trouvée : ", $demande->toArray());
        if ($demande->bien->agent_immobilier_id !== $agentId) {
            Log::error("L'agent n'est pas autorisé à modifier cette demande.");
            abort(403, 'Action non autorisée.');
        }

        $demande->statut = $request->statut;
        $demande->save();

        Log::info("Statut mis à jour avec succès pour la demande ID : " . $id);

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
            $demande = DemandeMaintenance::create([
                'locataire_id' => $locataire->id,
                'bien_id' => $request->bien_id,
                'description' => $request->description,
                'statut' => $request->statut,
            ]);

            // Envoie de notification a l'argence
            $agent = $locataire->agent_immobilier;
            $agent->user->notify(new DemandeMaintenanceNotification($demande));
            $lien = route('agent.demandes');

            // Envoyer la notification par SMS (exemple avec Twilio)
            $this->sendSmsNotification($agent->telephone_agence, "🔔 [{$agent->nom_agence}] - Nouvelle Demande de Maintenance 🔧\n\n"
            . "Cher(e) {$agent->nom_admin} {$agent->prenom_admin}, une nouvelle demande a été soumise pour le bien situé à {$demande->bien->adresse_bien}.\n\n"
            . "📌 Description : {$demande->description}\n"
            . "⏳ Statut : En attente\n\n"
            . "📲 Gérez la demande ici : {$lien}");

            // Redirection avec message de succès
            return redirect()->route('locataire.demandes.index')->with('success', 'Votre demande de maintenance a été enregistrée.');
        } catch (\Exception $e) {
            // Si une erreur survient
            return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de votre demande.');
        }
    }
        /**
     * Envoie une notification par SMS via Twilio.
     */
    private function sendSmsNotification($phone, $message)
    {
        try {
            $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create($phone, [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => $message
            ]);
            Log::info("SMS envoyé à {$phone}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi du SMS : " . $e->getMessage());
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
