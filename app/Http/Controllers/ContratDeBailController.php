<?php

namespace App\Http\Controllers;

use App\Models\ArticleContratBail;
use App\Models\Bien;
use App\Models\ContratDeBailLocataire;
use App\Models\ContratsDeBail;
use App\Models\Locataire;
use App\Models\LocataireBien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

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
    // public function updatePhoto(Request $request, string $id)
    // {
    //     $contrat = ContratsDeBail::findOrFail($id);

    //     // Validation du fichier uploadé
    //     $request->validate([
    //         'signature_agent_immobilier' => 'nullable|image|mimes:svg,jpeg,png,jpg,gif|max:2048',
    //         'signature_locataire' => 'nullable|image|mimes:svg,jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     // Stocker la nouvelle signature
    //     if ($request->hasFile('signature_agent_immobilier')) {
    //         $signaturePath = $request->file('signature_agent_immobilier')->store('signatures_agent', 'public');

    //         // Ajouter `/storage/` au chemin pour l'URL publique
    //         $signaturePublicPath = '/storage/' . $signaturePath;

    //         // Mettre à jour le champ dans la base de données
    //         $contrat->update(['signature_agent_immobilier' => $signaturePublicPath]);
    //     }

    //     if ($request->hasFile('signature_locataire')) {
    //         $signaturePath = $request->file('signature_locataire')->store('signatures_locataire', 'public');

    //         // Ajouter `/storage/` au chemin pour l'URL publique
    //         $signaturePublicPath = '/storage/' . $signaturePath;

    //         // Mettre à jour le champ dans la base de données
    //         $contrat->update(['signature_locataire' => $signaturePublicPath]);
    //     }

    //     // Retour avec message de succès
    //     return redirect()->back()->with('success', 'Signature mise à jour avec succès!');
    // }

    //update photot signature pad
    public function saveSignature(Request $request)
    {
        // Validation des données
        $request->validate([
            'signature' => 'required|string', // base64 est une chaîne
            'type' => 'required|string|in:agent,locataire',
            'contrat_id' => 'required|exists:contrats_de_bail,id',
        ]);

        // Récupération de l'ID du contrat
        $contratId = $request->contrat_id;

        // Récupérer le contrat à partir de l'ID
        $contrat = ContratsDeBail::findOrFail($contratId);

        // Décoder l'image base64
        $image_parts = explode(";base64,", $request->signature);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1]; // ex: png
        $image_base64 = base64_decode($image_parts[1]);

        // Générer un nom de fichier unique pour la signature
        $fileName = $request->type . '_signature_' . time() . '.' . $image_type;
        $filePath = 'signatures/' . $fileName;

        // Enregistrer l'image dans le dossier public
        $folderPath = public_path('storage/signatures/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true); // Créer le dossier s'il n'existe pas
        }
        file_put_contents($folderPath . $fileName, $image_base64);

        // Mettre à jour la signature dans le contrat
        if ($request->type == 'agent') {
            $contrat->signature_agent_immobilier = '/storage/' . $filePath;
        } elseif ($request->type == 'locataire') {
            $contrat->signature_locataire = '/storage/' . $filePath;
        }

        // Sauvegarder les modifications
        $contrat->save();

        // Retourner une réponse JSON
        return response()->json([
            'message' => 'Signature sauvegardée avec succès.',
            'file' => $filePath,
        ]);
    }

    //export contrat de bail

    public function export(string $bien_id, ?string $agent_id = null)
    {
        // Récupérer les articles en fonction du rôle de l'utilisateur connecté
        if (Auth::user()->id_role == 2) {
            $articles = ArticleContratBail::where('agent_immobilier_id', $agent_id)->get();
        }
        if (Auth::user()->id_role == 3) {
            $agent_connecter = Auth::user()->agent_immobiliers->first()->id;
            $articles = ArticleContratBail::where('agent_immobilier_id', $agent_connecter)->get();
        }

        // Récupérer le bien, locataire assigné et contrat
        $bien = Bien::findOrFail($bien_id);
        $locataireAssigné = LocataireBien::where('bien_id', $bien_id)->with('locataire')->first();
        $contrat = ContratsDeBail::where('bien_id', $bien->id)
            ->where('locataire_id', $locataireAssigné?->locataire->id)
            ->first();

        // return view('exports.contrat_pdf', [
        //     'bien' => $bien,
        //     'locataireAssigné' => $locataireAssigné,
        //     'contrat' => $contrat,
        //     'articles' => $articles,
        // ]);

        // Générer le PDF
        $pdf = PDF::loadView('exports.contrat_pdf', [
            'bien' => $bien,
            'locataireAssigné' => $locataireAssigné,
            'contrat' => $contrat,
            'articles' => $articles,
        ]);

        // Retourner le PDF pour téléchargement
        return $pdf->download('contrat_de_bail_' . $bien->id . '.pdf');
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
