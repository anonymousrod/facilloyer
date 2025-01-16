<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; // Ajoutez cette ligne en haut du fichier

use App\Models\DemandeMaintenance;
use Illuminate\Http\Request;


class DemandeMaintenanceController extends Controller
{


public function create()
{
    return view('demandes.create'); // Retourne la vue avec le formulaire
}



  


// Locataire : soumettre une demande
public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        $locataire = Auth::user(); // Récupérer l'utilisateur connecté
        $agentId = $locataire->agent_id; // Supposons que le locataire a un champ `agent_id`

        DemandeMaintenance::create([
            'locataire_id' => $locataire->id,
            'agent_id' => $agentId,
            'libelle' => $validated['libelle'],
            'description' => $validated['description'],
            'statut' => 'en attente',
        ]);

        return redirect()->route('locataire.demandes.index')->with('success', 'Votre demande a été soumise avec succès.');
    }



public function index()
    {
        $locataire = Auth::user();
        $demandes = DemandeMaintenance::where('locataire_id', $locataire->id)->get();
    
        return view('locataire.demandes.index', compact('demandes'));
    }
    


    // Agent immobilier : mettre à jour le statut
    public function update(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|string',
        ]);

        $demande = DemandeMaintenance::findOrFail($id);
        $demande->update([
            'statut' => $request->statut,
        ]);

        return response()->json(['message' => 'Statut mis à jour avec succès']);
    }


    public function showAgentDemands()
    {
        $agent = Auth::user(); // Récupère l'utilisateur authentifié (l'agent)
        // Récupère les demandes des locataires assignés à cet agent
        $demandes = DemandeMaintenance::whereHas('locataire', function ($query) use ($agent) {
            $query->where('agent_id', $agent->id); // Filtrer par agent
        })->get();
    
        return view('agent_demande', compact('demandes')); // Retourne la vue avec les demandes
    }
    

}
