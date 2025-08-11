<?php

namespace App\Http\Controllers;

use App\Models\Locataire;
use App\Models\ContratsDeBail;
use App\Models\Paiement;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use GuzzleHttp\Client;
use PDF; // Si vous utilisez barryvdh/laravel-dompdf
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\GestionPeriode;
use Exception;
use Kkiapay\Kkiapay;
use Illuminate\Support\Facades\Log;







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

        // Récupérer tous les paiements pour le locataire connecté
        $paiements = Paiement::where('locataire_id', $locataire->id)
            ->orderBy('date_paiement', 'desc') // Trie par date de paiement décroissante
            ->paginate(10); // Pagination : 10 paiements par page

        // Optionnel : calcul des statistiques
        $stats = [
            'total_paye' => $paiements->sum('montant_paye'),
            'nombre_paiements' => $paiements->count(),
            'montant_moyen' => $paiements->count() > 0 ? $paiements->sum('montant_paye') / $paiements->count() : 0,
        ];

        //concernant notification
        if (request()->has('notification_id')) {
            auth()->user()->notifications()
                ->where('id', request('notification_id'))
                ->update(['read_at' => now()]);
        }

        // Retourner la vue avec les paiements et les statistiques
        return view('locataire.paiements.historique', compact('paiements', 'stats'));
    }

    // historique (agent immo) de paiement  pour un loctaire en fonction de ces biens
    public function historiqueTousLocataires()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté.');
        }

        $agent = Auth::user()->agent_immobiliers->first();

        if (!$agent) {
            return redirect()->route('dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        // Récupérer les locataires associés à l'agent immobilier
        $locataires = Locataire::where('agent_id', $agent->id)->pluck('id');

        // Récupérer tous les paiements effectués par ces locataires
        $paiements = Paiement::whereIn('locataire_id', $locataires)
            ->orderBy('date_paiement', 'desc')
            ->paginate(10);

        // Optionnel : calcul des statistiques
        $stats = [
            'total_paye' => $paiements->sum('montant_paye'),
            'nombre_paiements' => $paiements->count(),
            'montant_moyen' => $paiements->count() > 0 ? $paiements->sum('montant_paye') / $paiements->count() : 0,
        ];

        // Retourner la vue avec les paiements et les statistiques
        return view('layouts.agent_immo_historique', compact('paiements', 'stats'));
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
        $locataire = Auth::user()->locataires->first();
        if ($locataire) {
            // Vérification si le locataire a le paiement
            $paiement = Paiement::with('bien') // Charger également les informations du logement (bien)
                ->where('locataire_id', $locataire->id)
                ->findOrFail($id); // Trouver le paiement par ID ou retourner une erreur 404

            // Calcul du montant payé (même si dans ce cas c'est déjà dans l'objet $paiement)
            $montantPaye = $paiement->montant_paye;

            // Passer les données à la vue
            return view('locataire.paiements.detail', compact('paiement', 'montantPaye'));
        } else {

            $agent = Auth::user()->agent_immobiliers->first();
            // Récupérer les locataires associés à l'agent immobilier
            $locataires = Locataire::where('agent_id', $agent->id)->pluck('id');


            // Vérification si le locataire a le paiement
            $paiement = Paiement::with('bien') // Charger également les informations du logement (bien)
                ->whereIn('locataire_id', $locataires)
                ->findOrFail($id); // Trouver le paiement par ID ou retourner une erreur 404

            // Calcul du montant payé (même si dans ce cas c'est déjà dans l'objet $paiement)
            $montantPaye = $paiement->montant_paye;

            if (request()->has('notification_id')) {
                auth()->user()->notifications()
                    ->where('id', request('notification_id'))
                    ->update(['read_at' => now()]);
            }

            // Passer les données à la vue
            return view('locataire.paiements.detail', compact('paiement', 'montantPaye'));
        }
    }


    // LOCTAIRE QUUITTANCE D'UN PAIEMENT SËCIFIUQE

    public function generateQuittance($id)
    {
        // Récupérer les informations du paiement à partir de l'ID
        $paiement = Paiement::findOrFail($id);

        // Récupérer les informations du bien
        $bien = $paiement->bien;
        $montant_restant_periode=$paiement->montant_restant_periode;



        

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
            $query->whereHas('locataire', function ($q) use ($searchTerm) {
                $q->where('nom', 'like', "%{$searchTerm}%")
                    ->orWhere('prenom', 'like', "%{$searchTerm}%");
            })
                ->orWhereHas('bien.agent_immobilier', function ($q) use ($searchTerm) {
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























    // ETAPE DE PAIEMENT   FONCTION 01

    // public function trouverPeriode(Request $request)
    // {
    //     // Récupération de l'utilisateur connecté
    //     $user = auth()->user();

    //     // Vérification que l'utilisateur a bien un locataire associé
    //     $locataire = $user->locataires()->first();
    //     if (!$locataire) {
    //         return redirect()->route('dashboard')->with('error', '❌ Aucun locataire trouvé pour votre compte.');
    //     }

    //     // Récupération du contrat de bail actif du locataire
    //     $contratBail = $locataire->contratsDeBail()->where('statut_contrat', '<>', 'Résilié')->first();
    //     if (!$contratBail) {
    //         return redirect()->route('dashboard')->with('error', '❌ Vous n\'avez pas de contrat de bail actif.');
    //     }

    //     // Date de début du contrat de bail
    //     $dateDebutContrat = Carbon::parse($contratBail->date_debut);

    //     // Recherche de la période en cours
    //     $periode = 1;
    //     $dateDebutPeriode = $dateDebutContrat->copy();
    //     $dateFinPeriode = $dateDebutPeriode->copy()->addMonth();

    //     while (!now()->between($dateDebutPeriode, $dateFinPeriode)) {
    //         $periode++;
    //         $dateDebutPeriode = $dateDebutContrat->copy()->addMonths($periode - 1);
    //         $dateFinPeriode = $dateDebutPeriode->copy()->addMonth();
    //     }

    //     // Vérification si la période existe déjà dans la table 'gestion_periode'
    //     $periodeExistante = GestionPeriode::where('locataire_id', $locataire->id)
    //         ->where('date_debut_periode', $dateDebutPeriode)
    //         ->where('date_fin_periode', $dateFinPeriode)
    //         ->first();

    //     if ($periodeExistante) {
    //         // La période existe déjà, on retourne les informations
    //         return view('periodes.show', [
    //             'periode' => $periodeExistante,
    //         ]);
    //     } else {
    //         // La période n'existe pas, on la crée
    //         $nouvellePeriode = new GestionPeriode();
    //         $nouvellePeriode->locataire_id = $locataire->id; // ID du locataire connecté
    //         $nouvellePeriode->contrat_de_bail_id = $contratBail->id; // ID du contrat de bail
    //         $nouvellePeriode->bien_id = $contratBail->bien_id; // ID du bien associé au contrat
    //         $nouvellePeriode->date_debut_periode = $dateDebutPeriode; // Date de début de la période
    //         $nouvellePeriode->date_fin_periode = $dateFinPeriode; // Date de fin de la période
    //         $nouvellePeriode->montant_total_periode = 0; // Montant total initialisé à 0
    //         $nouvellePeriode->complement_periode = 0; // Complément initialisé à 0
    //         $nouvellePeriode->montant_restant_periode = 0; // Montant restant initialisé à 0
    //         $nouvellePeriode->save();

    //         return view('periodes.show', [
    //             'periode' => $nouvellePeriode,
    //         ]);
    //     }
    // }

    public function trouverPeriode(Request $request)
    {
        $user = auth()->user();
        $locataire = $user->locataires()->first();

        if (!$locataire) {
            return redirect()->route('dashboard')->with('error', '❌ Aucun locataire trouvé pour votre compte.');
        }

        $contratBail = $locataire->contratsDeBail()->where('statut_contrat', '<>', 'Résilié')->first();

        if (!$contratBail) {
            // Pas de contrat actif, on retourne la vue avec un message d'info
            return view('periodes.show', [
                'periode' => null,
                'message' => "⚠️ Vous n'avez pas de contrat de bail actif.",
            ]);
        }

        // Début période
        $dateDebutContrat = Carbon::parse($contratBail->date_debut);
        $periode = 1;
        $dateDebutPeriode = $dateDebutContrat->copy();
        $dateFinPeriode = $dateDebutPeriode->copy()->addMonth();

        while (!now()->between($dateDebutPeriode, $dateFinPeriode)) {
            $periode++;
            $dateDebutPeriode = $dateDebutContrat->copy()->addMonths($periode - 1);
            $dateFinPeriode = $dateDebutPeriode->copy()->addMonth();
        }

        $periodeExistante = GestionPeriode::where('locataire_id', $locataire->id)
            ->where('date_debut_periode', $dateDebutPeriode)
            ->where('date_fin_periode', $dateFinPeriode)
            ->first();

        if ($periodeExistante) {
            return view('periodes.show', ['periode' => $periodeExistante]);
        } else {
            $nouvellePeriode = new GestionPeriode();
            $nouvellePeriode->locataire_id = $locataire->id;
            $nouvellePeriode->contrat_de_bail_id = $contratBail->id;
            $nouvellePeriode->bien_id = $contratBail->bien_id;
            $nouvellePeriode->date_debut_periode = $dateDebutPeriode;
            $nouvellePeriode->date_fin_periode = $dateFinPeriode;
            $nouvellePeriode->montant_total_periode = 0;
            $nouvellePeriode->complement_periode = 0;
            $nouvellePeriode->montant_restant_periode = 0;
            $nouvellePeriode->save();

            return view('periodes.show', ['periode' => $nouvellePeriode]);
        }
    }






    //ETAPE DE PAIEMENT FONCTION 02

    public function partiepaiement(Request $request)
    {
        $user = auth()->user(); // Utilisateur actuellement connecté

        // Vérifier si l'utilisateur est bien associé à un locataire
        $locataire = Locataire::where('user_id', $user->id)->first();

        if (!$locataire) {
            return redirect()->route('dashboard')->with('error', '❌ Aucun contrat de bail ou bien associé trouvé.');
        }

        $locataireId = $locataire->id; // ID du locataire

        // Étape 1 : Récupération de la dernière période de gestion
        $gestionPeriode = GestionPeriode::where('locataire_id', $locataireId)
            ->orderBy('id', 'desc')
            ->first();

        if (!$gestionPeriode) {
            return redirect()->route('dashboard')->with('error', '❌ Aucune période de gestion n\'a été trouvée.');
        }

        // Vérification du montant total de la période
        if ($gestionPeriode->montant_total_periode != 0) {
            // Calcul du montant restant
            $paiementsEffectues = Paiement::where('locataire_id', $locataireId)
                ->whereBetween('date_paiement', [$gestionPeriode->date_debut_periode, $gestionPeriode->date_fin_periode])
                ->sum('montant_paye');

            $montantRestant = $gestionPeriode->montant_total_periode - $paiementsEffectues;
            $gestionPeriode->montant_restant_periode = $montantRestant > 0 ? $montantRestant : 0;
            $gestionPeriode->save();
        } else {
            // Si montant_total_periode = 0
            $complementPeriode = $request->input('complement_periode', null); // Valeur par défaut null

            if (!is_null($complementPeriode)) {
                // Récupération du loyer mensuel via la relation avec biens et contrats
                $contrat = ContratsDeBail::where('locataire_id', $locataireId)
                    ->with('bien')
                    ->first();

                if (!$contrat || !$contrat->bien) {
                    return redirect()->route('dashboard')->with('error', '❌ Aucun contrat de bail ou bien associé trouvé.');
                }

                $loyerMensuel = $contrat->bien->loyer_mensuel;

                // Calcul du nouveau montant total pour la période
                $montantTotalPeriode = $loyerMensuel + $complementPeriode;
                $gestionPeriode->montant_total_periode = $montantTotalPeriode;
                $gestionPeriode->complement_periode = $complementPeriode;
                $gestionPeriode->save();

                // Calcul du montant restant
                $paiementsEffectues = Paiement::where('locataire_id', $locataireId)
                    ->whereBetween('date_paiement', [$gestionPeriode->date_debut_periode, $gestionPeriode->date_fin_periode])
                    ->sum('montant_paye');

                $montantRestant = $montantTotalPeriode - $paiementsEffectues;
                $gestionPeriode->montant_restant_periode = $montantRestant > 0 ? $montantRestant : 0;
                $gestionPeriode->save();
            } else {
                // Si aucun montant total défini et aucun complément fourni
                return view('paiement.partiepaiement', [
                    'gestionPeriode' => $gestionPeriode,
                    'complementRequis' => true, // Indiquer que le complément est requis
                ]);
            }
        }

        // Retourner les informations pour la vue
        return view('paiement.partiepaiement', [
            'gestionPeriode' => $gestionPeriode,
            'complementRequis' => false, // Complément non requis
        ]);
    }

  
    public function showForm()
    {
        $user = auth()->user(); // Utilisateur actuellement connecté

        // Vérifier si l'utilisateur est bien associé à un locataire
        $locataire = Locataire::where('user_id', $user->id)->first();

        if (!$locataire) {
            abort(404, "Locataire non trouvé, Reconecter vous svp");
        }

        // Exemple : récupérer un bien associé (tu peux adapter)
        $bien = $locataire->biens()->first(); // ou une autre logique

        if (!$bien) {
            abort(404, "Bien non trouvé, Reconecter vous svp");
        }

        // Exemple montant à payer calculé
        $montant_restant = 50000; // récupère ou calcule ce montant dynamiquement

        return view('paiement.form', compact('locataire', 'bien', 'montant_restant'));
    }


    public function enregistrerPaiement(Request $request)
    {
        $request->validate([
            'locataire_id' => 'required|exists:locataires,id',
            'bien_id' => 'required|exists:biens,id',
            'montant' => 'required|numeric|min:100',
            'transaction_id' => 'required|string|unique:paiements,reference_paiement',
        ]);

        // Créer le paiement
        $paiement = Paiement::create([
            'locataire_id' => $request->locataire_id,
            'bien_id' => $request->bien_id,
            'montant_paye' => $request->montant,
            'date_paiement' => now(),
            'statut_paiement' => 'payé',
            'mode_paiement' => 'kkiapay',
            'reference_paiement' => $request->transaction_id,
            'description' => 'Paiement via Kkiapay',
            'notified' => true,
        ]);

        return response()->json(['success' => true, 'paiement_id' => $paiement->id]);
    }





    
}





