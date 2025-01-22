<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\ContratDeBailLocataire;
use App\Models\ContratsDeBail;
use App\Models\Locataire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ContratDeBailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $bienId = $request->input('bien_id');
        $locataireId = $request->input('locataire_id');

        $bien = Bien::findOrFail($bienId);
        $locataire = $locataireId ? Locataire::findOrFail($locataireId) : null;

        return view('layouts.add_contrat_de_bail', compact('bien', 'locataire'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'bien_id' => 'required|exists:biens,id',
            'reference' => 'required|unique:contrats_de_bail,reference',
            'caution' => 'required|numeric',
            'caution_eau' => 'nullable|numeric',
            'caution_electricite' => 'nullable|numeric',
            'montant_total_frequence' => 'nullable|numeric',
            'lieu_signature' => 'required|string',
            'date_signature' => 'required|date',
            'locataire_id' => 'required|exists:locataires,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'frequence_paiement' => 'required|string',
            'penalite_retard' => 'nullable|numeric',
            'mode_paiement' => 'required|string',
            'statut_contrat' => 'required|string',
        ]);

        // Création du contrat de bail
        $contratDeBail = ContratsDeBail::create([
            'bien_id' => $request->bien_id,
            'reference' => $request->reference,
            'caution' => $request->caution,
            'caution_eau' => $request->caution_eau,
            'caution_electricite' => $request->caution_electricite,

            'lieu_signature' => $request->lieu_signature,
            'date_signature' => $request->date_signature,
            'locataire_id' => $request->locataire_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'frequence_paiement' => $request->frequence_paiement,
            'penalite_retard' => $request->penalite_retard,
            'montant_total_frequence' => $request->montant_total_frequence,
            'mode_paiement' => $request->mode_paiement,
            'renouvellement_automatique' => $request->has('renouvellement_automatique'),
            'statut_contrat' => $request->statut_contrat,
        ]);

        // Retourner vers la page avec succès
        return redirect()->route('biens.show', $request->bien_id)->with('success', 'Contrat de bail ajouté avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    //update signature_photo_only
    public function updatePhoto(Request $request, string $id)
    {
        $contrat = ContratsDeBail::findOrFail($id);

        // Validation du fichier uploadé
        $request->validate([
            'signature_agent_immobilier' => 'nullable|image|mimes:svg,jpeg,png,jpg,gif|max:2048',
            'signature_locataire' => 'nullable|image|mimes:svg,jpeg,png,jpg,gif|max:2048',
        ]);

        // Stocker la nouvelle signature
        if ($request->hasFile('signature_agent_immobilier')) {
            $signaturePath = $request->file('signature_agent_immobilier')->store('signatures_agent', 'public');

            // Ajouter `/storage/` au chemin pour l'URL publique
            $signaturePublicPath = '/storage/' . $signaturePath;

            // Mettre à jour le champ dans la base de données
            $contrat->update(['signature_agent_immobilier' => $signaturePublicPath]);
        }
        
        if ($request->hasFile('signature_locataire')) {
            $signaturePath = $request->file('signature_locataire')->store('signatures_locataire', 'public');

            // Ajouter `/storage/` au chemin pour l'URL publique
            $signaturePublicPath = '/storage/' . $signaturePath;

            // Mettre à jour le champ dans la base de données
            $contrat->update(['signature_locataire' => $signaturePublicPath]);
        }

        // Retour avec message de succès
        return redirect()->back()->with('success', 'Signature mise à jour avec succès!');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $contrat = ContratsDeBail::findOrFail($id);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
