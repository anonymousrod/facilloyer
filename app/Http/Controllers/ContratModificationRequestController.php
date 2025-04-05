<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContratModificationRequest;
use App\Models\ContratsDeBail;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $role = $user->role->libelle; // "Locataire" ou "Agent immobilier"

        $demandePar = strtolower($role) === 'locataire' ? 'locataire' : 'agent';

        ContratModificationRequest::create([
            'contrat_de_bail_id' => $data['contrat_de_bail_id'],
            'motif' => $data['motif'],
            'demande_par' => $demandePar,
            'statut' => 'en_attente',
        ]);

        return back()->with('success', 'Demande de modification envoyée avec succès.');
    }

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

        return back()->with('success', 'Demande acceptée. Le contrat est à nouveau modifiable.');
    }

    // Refuser une demande
    public function refuser($id)
    {
        $demande = ContratModificationRequest::findOrFail($id);
        $demande->statut = 'refusee';
        $demande->save();

        return back()->with('success', 'Demande refusée.');
    }

    public function showDemandesModification()
    {
        $user = Auth::user();
        $role = $user->role->libelle;

        if ($role === 'Locataire') {
            // Demandes reçues par le locataire (faites par l’agent)
            $demandesRecues = ContratModificationRequest::where('demande_par', 'agent')
                ->whereHas('contrat', function ($query) use ($user) {
                    $query->where('locataire_id', $user->locataires->first()->id);
                })
                ->latest()
                ->get();

            // Demandes envoyées par le locataire
            $demandesEnvoyees = ContratModificationRequest::where('demande_par', 'locataire')
                ->whereHas('contrat', function ($query) use ($user) {
                    $query->where('locataire_id', $user->locataires->first()->id);
                })
                ->latest()
                ->get();

        } elseif ($role === 'Agent immobilier') {
            // Demandes reçues par l’agent (faites par les locataires)
            $demandesRecues = ContratModificationRequest::where('demande_par', 'locataire')
                ->whereHas('contrat', function ($query) use ($user) {
                    $query->whereHas('locataire', function ($subQuery) use ($user) {
                        $subQuery->where('agent_id', $user->agent_immobiliers->first()->id);
                    });
                })
                ->latest()
                ->get();

            // Demandes envoyées par l’agent
            $demandesEnvoyees = ContratModificationRequest::where('demande_par', 'agent')
                ->whereHas('contrat', function ($query) use ($user) {
                    $query->whereHas('locataire', function ($subQuery) use ($user) {
                        $subQuery->where('agent_id', $user->agent_immobiliers->first()->id);
                    });
                })
                ->latest()
                ->get();
        } else {
            return abort(403, 'Accès non autorisé.');
        }

        return view('layouts.demandes_modification', [
            'demandesRecues' => $demandesRecues,
            'demandesEnvoyees' => $demandesEnvoyees,
            'role' => $role,
        ]);
    }
}
