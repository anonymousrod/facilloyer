<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF; // Si vous utilisez barryvdh/laravel-dompdf
use Illuminate\Support\Facades\DB;
use App\Models\ContratDeBailLocataire;

class PaiementController extends Controller


{


    // la sélection du bien, le calcul des montants, et la gestion des paiements 
    public function selectionBien()
{
    $user = Auth::user();
    $locataire = $user->locataires()->first();

    if (!$locataire) {
        return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
    }

    $contrats = ContratDeBailLocataire::with('contrats_de_bail')
        ->where('locataire_id', $locataire->id)
        ->get();

    return view('locataire.paiements.selection', compact('contrats'));
}

//le calcul des montants
public function calculMontant(Request $request)
{
    $request->validate([
        'contrat_id' => 'required|exists:contrat_de_bail_locataire,id',
        'complement' => 'nullable|numeric|min:0',
    ]);

    $contrat = ContratDeBailLocataire::with('contrats_de_bail')->find($request->contrat_id);

    if (!$contrat) {
        return redirect()->back()->with('error', 'Contrat introuvable.');
    }

    $loyerMensuel = $contrat->contrats_de_bail->loyer_mensuel;
    $complement = $request->input('complement', 0);
    $montantTotal = $loyerMensuel + $complement;

    $contrat->update([
        'complement_au_loyer' => $complement,
        'montant_total_periode' => $montantTotal,
    ]);

    return view('locataire.paiements.paiement', compact('contrat', 'montantTotal'));
}

public function effectuerPaiement(Request $request)
    {
        // Validation des champs
        $request->validate([
            'contrat_id' => 'required|exists:contrat_de_bail_locataire,id',
            'montant_paye' => 'required|numeric|min:0',
            'description_paiement' => 'required|string|max:255', // Validation de la description
        ]);

        // Récupérer le contrat
        $contrat = ContratDeBailLocataire::find($request->contrat_id);

        if (!$contrat) {
            return redirect()->back()->with('error', 'Contrat introuvable.');
        }

        // Calcul du montant restant
        $montantPaye = $request->input('montant_paye');
        $montantRestant = $contrat->montant_total_periode - $montantPaye;

        // Mettre à jour le contrat
        $contrat->update([
            'montant_restant' => $montantRestant,
            'statut_paiement' => $montantRestant > 0 ? 'Partiellement payé' : 'Payé',
        ]);

        // Enregistrer le paiement
        Paiement::create([
            'locataire_id' => $contrat->locataire_id,
            'bien_id' => $contrat->contrats_de_bail->bien_id,
            'montant' => $montantPaye,
            'description_paiement' => $request->input('description_paiement'), // Ajout de la description
            'date' => Carbon::now(),
        ]);

        // Retourner un message de succès
        return redirect()->route('locataire.paiements.selection')->with('success', 'Paiement effectué avec succès.');
    }

    public function historique()
    {
        $user = Auth::user();
        $locataire = $user->locataires()->first();

        if (!$locataire) {
            return redirect()->route('dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        $paiements = Paiement::with(['bien'])
            ->where('locataire_id', $locataire->id)
            ->orderBy('date', 'desc')
            ->get();

        $stats = [
            'total_paye' => $paiements->sum('montant'),
            'total_restant' => $paiements->sum('montant_restant'),
            'nombre_paiements' => $paiements->count(),
            'montant_moyen' => $paiements->count() > 0 ? $paiements->sum('montant') / $paiements->count() : 0,
        ];

        return view('locataire.paiements.historique', compact('paiements', 'stats'));
    }

    public function create()
    {
        // Vérifier si l'utilisateur connecté a un locataire associé
        $user = auth()->user();
        if (!$user || !$user->locataire) {
            return redirect()->back()
                ->with('error', 'Vous devez être enregistré comme locataire pour effectuer un paiement.');
        }
        
        // Récupérer les biens associés au locataire
        $biens = $user->locataire->biens;
        
        return view('locataire.paiements.create', compact('biens'));
    }

    public function getBienDetails($bienId)
    {
        $bien = Bien::findOrFail($bienId);
        return response()->json([
            'loyer_mensuel' => $bien->loyer_mensuel
        ]);
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
    
    

    public function show($id)
    {
        $user = Auth::user();
        $locataire = $user->locataires()->first();

        if (!$locataire) {
            return redirect()->route('dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        $paiement = Paiement::with(['bien.agent_immobilier', 'locataire'])
            ->where('locataire_id', $locataire->id)
            ->findOrFail($id);

        // Calcul du montant total payé pour la période
        $montantTotalPaye = Paiement::where('locataire_id', $locataire->id)
            ->where('bien_id', $paiement->bien_id)
            ->whereMonth('date', $paiement->date->month)
            ->whereYear('date', $paiement->date->year)
            ->sum('montant');

        // Calcul du montant restant
        $loyerMensuel = $paiement->bien->loyer_mensuel ?? $paiement->montant_total_periode;
        $montantRestant = max(0, $loyerMensuel - $montantTotalPaye);

        return view('locataire.paiements.show', compact('paiement', 'montantRestant', 'loyerMensuel'));
    }

    // public function generateReceipt($id)
    // {
    //     $user = Auth::user();
    //     $locataire = $user->locataires()->first();

    //     if (!$locataire) {
    //         return redirect()->route('dashboard')
    //             ->with('error', 'Accès non autorisé.');
    //     }

    //     $paiement = Paiement::where('locataire_id', $locataire->id)
    //         ->with(['bien', 'locataire'])
    //         ->findOrFail($id);

    //     $pdf = PDF::loadView('locataire.paiements.receipt', compact('paiement'));
        
    //     return $pdf->download('recu-paiement-' . $paiement->reference . '.pdf');
    // }

    // public function bienPaiements($bien_id)
    // {
    //     $user = Auth::user();
    //     $locataire = $user->locataires()->first();

    //     if (!$locataire) {
    //         return redirect()->route('dashboard')
    //             ->with('error', 'Accès non autorisé.');
    //     }

    //     $bien = Bien::where('id', $bien_id)
    //         ->whereHas('locataires', function($query) use ($locataire) {
    //             $query->where('locataire_id', $locataire->id);
    //         })
    //         ->firstOrFail();

    //     $paiements = Paiement::where('bien_id', $bien_id)
    //         ->where('locataire_id', $locataire->id)
    //         ->orderBy('date', 'desc')
    //         ->get();

    //     return view('locataire.paiements.bien', compact('bien', 'paiements'));
    // }

    // public function dashboard()
    // {
    //     $user = Auth::user();
    //     $locataire = $user->locataires()->first();

    //     if (!$locataire) {
    //         return redirect()->route('dashboard')
    //             ->with('error', 'Accès non autorisé.');
    //     }

    //     $stats = [
    //         'total_paye' => $locataire->paiements()->sum('montant'),
    //         'total_restant' => $locataire->paiements()->sum('montant_restant'),
    //         'nombre_paiements' => $locataire->paiements()->count(),
    //         'derniers_paiements' => $locataire->paiements()
    //             ->with('bien')
    //             ->orderBy('date', 'desc')
    //             ->limit(5)
    //             ->get(),
    //         'paiements_par_mois' => $locataire->paiements()
    //             ->selectRaw('MONTH(date) as mois, YEAR(date) as annee, SUM(montant) as total')
    //             ->groupBy('mois', 'annee')
    //             ->orderBy('annee', 'desc')
    //             ->orderBy('mois', 'desc')
    //             ->limit(12)
    //             ->get()
    //     ];

    //     return view('locataire.paiements.dashboard', compact('stats'));
    // }

    public function generateQuittance($id)
    {
        $user = Auth::user();
        $locataire = $user->locataires()->first();

        if (!$locataire) {
            return redirect()->route('dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        $paiement = Paiement::with(['bien.agent_immobilier', 'locataire'])
            ->where('locataire_id', $locataire->id)
            ->findOrFail($id);

        // Calcul du montant total payé pour la période
        $montantTotalPaye = Paiement::where('locataire_id', $locataire->id)
            ->where('bien_id', $paiement->bien_id)
            ->whereMonth('date', $paiement->date->month)
            ->whereYear('date', $paiement->date->year)
            ->sum('montant');

        // Calcul du montant restant
        $loyerMensuel = $paiement->bien->loyer_mensuel ?? $paiement->montant_total_periode;
        $montantRestant = max(0, $loyerMensuel - $montantTotalPaye);

        // Ajout des montants calculés au paiement
        $paiement->montant_total_periode = $loyerMensuel;
        $paiement->montant_restant = $montantRestant;

        $pdf = PDF::loadView('locataire.paiements.quittance', compact('paiement'));
        
        return $pdf->download('quittance-' . str_pad($paiement->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }
}
