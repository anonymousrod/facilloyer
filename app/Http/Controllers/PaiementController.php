<?php

namespace App\Http\Controllers;
use App\Models\Locataire;
use App\Models\ContratsDeBail;
use App\Models\Paiement;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF; // Si vous utilisez barryvdh/laravel-dompdf
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\GestionPeriode;
use Exception;




class PaiementController extends Controller

{
  // historique de paiement par le locataire pour un loctaire en fonction de ces biens
public function historique()
    {
        $user = Auth::user();
        $locataire = $user->locataires()->first();
        
        if (!$locataire) {
            return redirect()->route('dashboard')
                ->with('error', 'Accès non autorisé.');
        }
    
        // Récupérer les derniers paiements avec pagination pour un scroll infini
        $paiements = Paiement::where('locataire_id', $locataire->id)
            ->orderBy('date_debut_frequence', 'desc') // Trie par la date de début de la fréquence des paiements
            ->paginate(10); // 10 paiements par page pour la pagination
    
        // Optionnel : calculer des statistiques
        $stats = [
            'total_paye' => $paiements->sum('montant_paye'),
            'nombre_paiements' => $paiements->count(),
            'montant_moyen' => $paiements->count() > 0 ? $paiements->sum('montant_paye') / $paiements->count() : 0,
        ];
    
        // Retourner la vue avec les paiements paginés
        return view('locataire.paiements.historique', compact('paiements', 'stats'));
    }
    


public function store(Request $request)
        {
            // Validation des données
            $validatedData = $request->validate([
                'locataire_id' => 'required|exists:locataires,id',
                'bien_id' => 'required|exists:biens,id',
                'montant' => 'required|numeric',
                'montant_total_periode' => 'required|numeric',
                'mode_paiement' => 'required|string', // Exemple : 'Carte', 'Virement', etc.
                'date' => 'required|date',
            ]);
    
            // Récupérer le locataire
            $locataire = Locataire::findOrFail($validatedData['locataire_id']);
            
            // Créer le paiement
            $paiement = new Paiement();
            $paiement->locataire_id = $validatedData['locataire_id'];
            $paiement->bien_id = $validatedData['bien_id'];
            $paiement->montant = $validatedData['montant'];
            $paiement->montant_total_periode = $validatedData['montant_total_periode'];
            $paiement->montant_restant = $validatedData['montant_total_periode'] - $validatedData['montant'];
            $paiement->date = Carbon::parse($validatedData['date']);
            $paiement->mode_paiement = $validatedData['mode_paiement'];
            $paiement->status = $paiement->montant >= $paiement->montant_total_periode ? 'Payé' : 'En attente';
    
            // Sauvegarder le paiement
            $paiement->save();
    
            // Optionnel : mettre à jour le statut du paiement s'il est complet
            $paiement->updateStatus();
    
            // Retourner une réponse
            return response()->json([
                'message' => 'Paiement créé avec succès',
                'paiement' => $paiement
            ]);
        }
    

       // PAIEMENT DETAIL POUR UN LOCTAIRE
public function show($id)
        {
            // Récupération de l'utilisateur connecté (locataire)
            $user = Auth::user();
            $locataire = $user->locataires()->first();
        
            // Vérification si le locataire a le paiement
            $paiement = Paiement::with('bien') // Charger également les informations du logement (bien)
                ->where('locataire_id', $locataire->id)
                ->findOrFail($id); // Trouver le paiement par ID ou retourner une erreur 404
        
            // Calcul du montant payé (même si dans ce cas c'est déjà dans l'objet $paiement)
            $montantPaye = $paiement->montant_paye;
        
            // Passer les données à la vue
            return view('locataire.paiements.detail', compact('paiement', 'montantPaye'));
        }
         

    // LOCTAIRE QUUITTANCE D'UN PAIEMENT SËCIFIUQE 

public function generateQuittance($id)
        {
            // Récupérer les informations du paiement à partir de l'ID
            $paiement = Paiement::findOrFail($id);
            
            // Récupérer les informations du bien
            $bien = $paiement->bien;
        
            // Passer les données à la vue
            $pdf = PDF::loadView('locataire.paiements.quittance', compact('paiement', 'bien'));
        
            // Retourner le PDF généré en tant que téléchargement
            return $pdf->download("quittance_paiement_{$paiement->id}.pdf");
        }

    
    

/**
     * Affiche A lADMINISTRATEUR  la liste des paiements regroupés par agence, locataire et bien.
     */

public function index(Request $request)
        {
            // Recherche des paiements par locataire ou agence
            $query = Paiement::with(['bien.agent_immobilier', 'locataire'])
                             ->orderBy('created_at', 'desc');
    
            if ($request->has('search')) {
                $searchTerm = $request->input('search');
                $query->whereHas('locataire', function($q) use ($searchTerm) {
                    $q->where('nom', 'like', "%{$searchTerm}%")
                      ->orWhere('prenom', 'like', "%{$searchTerm}%");
                })
                ->orWhereHas('bien.agent_immobilier', function($q) use ($searchTerm) {
                    $q->where('nom_agence', 'like', "%{$searchTerm}%");
                });
            }
    
            // Récupère les paiements paginés, 5 paiements par agence
            $paiements = $query->get()->groupBy(function ($paiement) {
                return $paiement->bien->agent_immobilier->nom_agence ?? 'Agence inconnue';
            });
    
            return view('admin.paiements.index', compact('paiements'));
        }
    
        // Méthodes supplémentaires (afficherDetailsPaiement, telechargerQuittancePaiement) restent inchangées.
    
    

    /**
     * Affiche  A LADMINISTRATEUR les détails d'un paiement spécifique.
     */
public function afficherDetailsPaiement($id)
    {
        $paiement = Paiement::with(['bien', 'locataire'])->findOrFail($id);

        return view('admin.paiements.details', compact('paiement'));
    }

    /**
     * Télécharge  A L4AMDINISTRAEUR la quittance d'un paiement.
     */
public function telechargerQuittancePaiement($id)
    {
        $paiement = Paiement::findOrFail($id);

        // Ici, générez un PDF ou un fichier pour la quittance.
        // Code pour la génération de quittance.

        return response()->download('chemin_du_fichier.pdf');
    }























// PaiementController.php

public function trouverPeriode(Request $request)
{
    // Récupération de l'utilisateur connecté
    $user = auth()->user();

    // Vérification que l'utilisateur a bien un locataire associé
    $locataire = $user->locataires()->first();
    if (!$locataire) {
        return response()->json(['message' => 'Aucun locataire trouvé pour cet utilisateur.'], 404);
    }

    // Récupération du contrat de bail actif du locataire
    $contratBail = $locataire->contratsDeBail()->where('statut_contrat', '<>', 'Résilié')->first();
    if (!$contratBail) {
        return response()->json(['message' => 'Aucun contrat de bail actif trouvé'], 404);
    }

    // Date de début du contrat de bail
    $dateDebutContrat = Carbon::parse($contratBail->date_debut);

    // Recherche de la période en cours
    $periode = 1;
    $dateDebutPeriode = $dateDebutContrat->copy();
    $dateFinPeriode = $dateDebutPeriode->copy()->addMonth();

    while (!now()->between($dateDebutPeriode, $dateFinPeriode)) {
        $periode++;
        $dateDebutPeriode = $dateDebutContrat->copy()->addMonths($periode - 1);
        $dateFinPeriode = $dateDebutPeriode->copy()->addMonth();
    }

    // Vérification si la période existe déjà dans la table 'gestion_periode'
    $periodeExistante = GestionPeriode::where('locataire_id', $locataire->id)
        ->where('date_debut_periode', $dateDebutPeriode)
        ->where('date_fin_periode', $dateFinPeriode)
        ->first();

    if ($periodeExistante) {
        // La période existe déjà, on retourne les informations
        return view('periodes.show', [
            'periode' => $periodeExistante,
        ]);
    } else {
        // La période n'existe pas, on la crée
        $nouvellePeriode = new GestionPeriode();
        $nouvellePeriode->locataire_id = $locataire->id; // ID du locataire connecté
        $nouvellePeriode->contrat_de_bail_id = $contratBail->id; // ID du contrat de bail
        $nouvellePeriode->bien_id = $contratBail->bien_id; // ID du bien associé au contrat
        $nouvellePeriode->date_debut_periode = $dateDebutPeriode; // Date de début de la période
        $nouvellePeriode->date_fin_periode = $dateFinPeriode; // Date de fin de la période
        $nouvellePeriode->montant_total_periode = 0; // Montant total initialisé à 0
        $nouvellePeriode->complement_periode = 0; // Complément initialisé à 0
        $nouvellePeriode->montant_restant_periode = 0; // Montant restant initialisé à 0
        $nouvellePeriode->save();

        return view('periodes.show', [
            'periode' => $nouvellePeriode,
        ]);
    }
}


    




}
