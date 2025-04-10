<?php

namespace App\Http\Controllers;

use App\Models\ArticleContratBail;
use App\Models\Bien;
use App\Models\ContratDeBailArticle;
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
        $contrats = ContratsDeBail::with(['bien', 'locataire'])->get();
        return view('admin.contrats_de_bail.list_all_contrat_by_admin', compact('contrats'));
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
            // 'statut_contrat' => 'required|string',
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
            'ajouter_articles_par_defaut' => $request->has('ajouter_articles_par_defaut'),
            // 'statut_contrat' => $request->statut_contrat,
        ]);
        // Si l'option est activée, on ajoute les articles par défaut
        $contratDeBail->ajouterArticlesParDefaut();
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
            ->with(['articles', 'articlesSpecifiques']) // Charge les articles liés au contrat
            ->first();

        // Récupérer les articles associés à ce contrat de bail à travers la table pivot
        if ($contrat) {
            $articles = $contrat->articles; // Relation définie dans le modèle ContratsDeBail
        }
        //$frequence utiliser dans l'afficharge de contrat de bail
        // Convertir la fréquence en jours si c'est une période (mois, bimestre, trimestre)
        $frequences = [
            'mois' => 30,
            'bimestre' => 60,
            'trimestre' => 90,
            'semestriel' => 180, // Virgule ajoutée ici
            'annuel' => 360,
        ];

        // Par défaut, la valeur brute est utilisée si la clé n'est pas reconnue
        $delai_retard =
            $frequences[$contrat?->frequence_paiement] ?? $contrat?->frequence_paiement;

        // Générer le PDF
        $pdf = PDF::loadView('exports.contrat_pdf', [
            'bien' => $bien,
            'locataireAssigné' => $locataireAssigné,
            'contrat' => $contrat,
            'delai_retard' => $delai_retard,
            'articles' => $contrat?->articles ?? [],
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
        $contrat = ContratsDeBail::findOrFail($id);
        $contrat->delete();
        return back()->with('success', 'Contrat supprimé avec succès.');
    }

    public function detachArticle($contratId, $articleId)
    {
        $contrat = ContratsDeBail::findOrFail($contratId);
        $contrat->articles()->detach($articleId);

        return back()->with('success', 'Article retiré du contrat.');
    }

    //supprimer article specifique
    public function supprimerArticleSpecifique($articleId)
    {
        $article = \App\Models\ContratDeBailArticle::findOrFail($articleId);
        $bien_id = $article->contrat->bien->id;

        $article->delete();

        return redirect()->route('biens.show', $bien_id)
            ->with('success', 'Article spécifique supprimé avec succès.');
    }

    public function updateArticleSpecifique(Request $request, $articleId)
    {
        $request->validate([
            'titre_article' => 'required|string|max:255',
            'contenu_article' => 'required|string',
        ]);

        $article = ContratDeBailArticle::findOrFail($articleId);
        $article->update([
            'titre_article' => $request->titre_article,
            'contenu_article' => $request->contenu_article,
        ]);

        return redirect()->back()->with('success', 'Article spécifique mis à jour.');
    }
}
