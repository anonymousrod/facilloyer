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
    // Validation des données du formulaire
    $request->validate([
        'libelle' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    // Assurez-vous que le locataire est authentifié
    $locataire_id = auth()->user()->id; // Ou récupérez l'ID du locataire de manière appropriée

    // Créer la demande de maintenance
    DemandeMaintenance::create([
        'locataire_id' => $locataire_id,
        'libelle' => $request->libelle,
        'description' => $request->description,
    ]);

    // Retourner un message ou rediriger vers une autre page
    return redirect()->route('demandes.index')->with('success', 'Demande soumise avec succès');
}

public function index()
{
    // Récupérer les demandes du locataire connecté
    $demandes = DemandeMaintenance::where('locataire_id', auth()->user()->id)->get();

    // Mettre à jour les demandes avec un statut vide pour qu'elles soient marquées "En attente"
    foreach ($demandes as $demande) {
        if (empty($demande->statut)) {
            $demande->statut = 'En attente';
            $demande->save();
        }
    }

    return view('demandes.index', compact('demandes'));
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
