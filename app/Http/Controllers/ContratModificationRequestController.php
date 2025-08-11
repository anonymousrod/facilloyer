<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContratModificationRequest;
use App\Models\ContratsDeBail;
use App\Notifications\DemandeModifContratDecisionNotification;
use App\Notifications\DemandeModifContratNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;


class ContratModificationRequestController extends Controller
{
    // Soumettre une demande de modification
    public function demander(Request $request)
    {
        $data = $request->validate([
            'contrat_de_bail_id' => 'required|exists:contrats_de_bail,id',
            'motif' => 'required|string|max:1000',
        ]);

        // On vérifie le rôle de l'utilisateur connecté
        if (!Auth::check()) {
            Log::warning('Tentative d\'accès non authentifié.');
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = Auth::user();
        $role = $user->role->libelle; // "Locataire" ou "Agent immobilier"

        $demandePar = strtolower($role) === 'locataire' ? 'locataire' : 'agent';

        ContratModificationRequest::create([
            'contrat_de_bail_id' => $data['contrat_de_bail_id'],
            'motif' => $data['motif'],
            'demande_par' => $demandePar,
            'statut' => 'en_attente',
        ]);

        // Envoyer la notification à l'autre partie (locataire ou agent immobilier)
        $contrat = ContratsDeBail::find($data['contrat_de_bail_id']);
        $recepteur = $demandePar === 'locataire'
            ? $contrat->bien->agent_immobilier->user
            : $contrat->locataire->user;

        $recepteur->notify(new DemandeModifContratNotification($contrat, $user));
        // Envoi de la notification SMS après l'envoi de la notification push
        //a ne pas supprimer
        // $this->sendSmsNotification($contrat, $user);

        return back()->with('success', 'Demande de modification envoyée avec succès.');
    }
    //tres important a ne pas supprimer
    // private function sendSmsNotification($contrat, $user)
    // {
    //     // Récupérer le numéro de téléphone du récepteur (locataire ou agent immobilier)
    //     $phoneNumber = $user->role->libelle === 'Locataire'
    //         ? $contrat->bien->agent_immobilier->telephone_agence
    //         : $contrat->locataire->telephone;

    //     // Message à envoyer par SMS
    //     $message = "📑 Nouvelle demande de modification de contrat reçue de la part de votre" . ucfirst($user->role->libelle) . ". Veuillez vérifier les détails.";

    //     // Envoyer le SMS via Twilio
    //     $this->sendSmsViaTwilio($phoneNumber, $message);
    // }

    // private function sendSmsViaTwilio($phoneNumber, $message)
    // {
    //     // Créer une instance de Twilio Client
    //     $client = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

    //     // Envoi du message
    //     $client->messages->create(
    //         $phoneNumber, // Numéro du destinataire
    //         [
    //             'from' => env('TWILIO_PHONE_NUMBER'), // Ton numéro Twilio
    //             'body' => $message, // Le message à envoyer
    //         ]
    //     );
    // }

    // Accepter une demande
    public function accepter($id)
    {
        $demande = ContratModificationRequest::findOrFail($id);
        $demande->statut = 'acceptee';
        $demande->save();

        // Invalider les signatures du contrat concerné
        $contrat = $demande->contrat;
        $contrat->update([
            'signature_locataire' => null,
            'signature_agent_immobilier' => null,
        ]);

        // Envoyer la notification à l'autre partie (locataire ou agent immobilier)
        $user = Auth::user();

        $recepteur = $demande->demande_par === 'locataire'
            ? $contrat->locataire->user
            : $contrat->bien->agent_immobilier->user;


        $decision = 'acceptée'; // <-- ici tu déclares la variable

        // Envoyer la notification d'acceptation
        $recepteur->notify(new DemandeModifContratDecisionNotification($contrat, 'acceptée', $user));

        // A ne pas supprimer
        // Optionnel : envoyer un SMS si nécessaire
        // $this->sendSmsNotificationdecision($contrat, $user , $decision);

        return back()->with('success', 'Demande acceptée. Le contrat est à nouveau modifiable.');
    }

    // Refuser une demande
    public function refuser($id)
    {
        $demande = ContratModificationRequest::findOrFail($id);
        $demande->statut = 'refusee';
        $demande->save();

        // Envoyer la notification à l'autre partie (locataire ou agent immobilier)
        $user = Auth::user();
        $recepteur = $demande->demande_par === 'locataire'
            ? $demande->contrat->locataire->user
            : $demande->contrat->bien->agent_immobilier->user;


        $decision = 'refusée'; // <-- définir la variable ici

        // Envoyer la notification de refus
        $recepteur->notify(new DemandeModifContratDecisionNotification($demande->contrat, 'refusée', $user));
        // A ne pas supprimer
        // Optionnel : envoyer un SMS si nécessaire
        // $this->sendSmsNotificationdecision($demande->contrat, $user, $decision,);

        return back()->with('success', 'Demande refusée.');
    }
    // A ne pas supprimer
    // private function sendSmsNotificationdecision($contrat, $user, $decision)
    // {
    //     // Récupérer le numéro de téléphone du récepteur (locataire ou agent immobilier)
    //     $phoneNumber = $user->role->libelle === 'Locataire'
    //     ? $contrat->locataire->telephone
    //     : $contrat->bien->agent_immobilier->telephone_agence;


    //     // Définir le message en fonction de la décision (acceptée ou refusée)
    //     if ($decision === 'acceptée') {
    //         $message = "📑 Votre demande de modification du contrat a été acceptée. Le contrat est désormais modifiable.";
    //     } elseif ($decision === 'refusée') {
    //         $message = "📑 Votre demande de modification du contrat a été refusée.";
    //     } else {
    //         $message = "📑 Il y a eu une erreur avec la demande de modification de contrat.";
    //     }

    //     // Envoyer le SMS via Twilio
    //     $this->sendSmsViaTwilio($phoneNumber, $message);
    // }


    public function showDemandesModification()
    {
        $user = Auth::user();
        $role = $user->role->libelle;

        if ($role === 'Locataire') {
            // Demandes reçues par le locataire (faites par l’agent)
            $demandesRecues = ContratModificationRequest::with('contrat.bien')
                ->where('demande_par', 'agent')
                ->whereHas('contrat', function ($query) use ($user) {
                    $query->where('locataire_id', $user->locataires->first()->id)
                    ->where('statut_contrat', 'Actif');
                })
                ->latest()
                ->get();

            // Demandes envoyées par le locataire
            $demandesEnvoyees = ContratModificationRequest::with('contrat.bien')
                ->where('demande_par', 'locataire')
                ->whereHas('contrat', function ($query) use ($user) {
                    $query->where('locataire_id', $user->locataires->first()->id)
                    ->where('statut_contrat', 'Actif');
                })
                ->latest()
                ->get();
        } elseif ($role === 'Agent immobilier') {
            // Demandes reçues par l’agent (faites par les locataires)
            $demandesRecues = ContratModificationRequest::with('contrat.bien')
                ->where('demande_par', 'locataire')
                ->whereHas('contrat', function ($query) use ($user) {
                    $query->whereHas('locataire', function ($subQuery) use ($user) {
                        $subQuery->where('agent_id', $user->agent_immobiliers->first()->id)
                        ->where('statut_contrat', 'Actif');
                    });
                })
                ->latest()
                ->get();

            // Demandes envoyées par l’agent
            $demandesEnvoyees = ContratModificationRequest::with('contrat.bien')
                ->where('demande_par', 'agent')
                ->whereHas('contrat', function ($query) use ($user) {
                    $query->whereHas('locataire', function ($subQuery) use ($user) {
                        $subQuery->where('agent_id', $user->agent_immobiliers->first()->id)
                        ->where('statut_contrat', 'Actif');
                    });
                })
                ->latest()
                ->get();
        } else {
            return abort(403, 'Accès non autorisé.');
        }

        // Gérer les notifications
        if (request()->has('notification_id')) {
            auth()->user()->notifications()
                ->where('id', request('notification_id'))
                ->update(['read_at' => now()]);
        }

        return view('layouts.demandes_modification', [
            'demandesRecues' => $demandesRecues,
            'demandesEnvoyees' => $demandesEnvoyees,
            'role' => $role,
        ]);
    }
}
