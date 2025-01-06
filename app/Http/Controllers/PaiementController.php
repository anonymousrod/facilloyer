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
use App\Models\Locataire;



class PaiementController extends Controller

{

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
            ->where('montant', '>', 0) // Filtre pour les paiements effectués
            ->orderBy('date', 'desc')
            ->get();
    
        $stats = [
            'total_paye' => $paiements->sum('montant'),
            'nombre_paiements' => $paiements->count(),
            'montant_moyen' => $paiements->count() > 0 ? $paiements->sum('montant') / $paiements->count() : 0,
        ];
    
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


    
    


public function quittance($id)
    {
        $paiement = Paiement::with(['locataire', 'bien.agent_immobilier'])->findOrFail($id);

        $pdf = PDF::loadView('admin.paiements.quittance', compact('paiement'));
        return $pdf->download('quittance_paiement.pdf');
    }



    
    
    
public function index()
    {
        // Récupérer tous les paiements avec les relations nécessaires
        $paiements = Paiement::with(['locataire', 'bien.agent_immobilier'])
            ->orderBy('date', 'desc') // Trier par date du plus récent au plus ancien
            ->get();

        return view('admin.paiements.index', compact('paiements'));
    }
    

public function telechargerQuittancePaiement($id)
    {
        $paiement = Paiement::with(['locataire', 'bien', 'bien.agent_immobilier'])->findOrFail($id);
    
        $pdf = PDF::loadView('admin.paiements.quittance', compact('paiement'));
        return $pdf->download('quittance_paiement_' . $paiement->id . '.pdf');
    }


    
public function afficherDetailsPaiement($id)
    {
        $paiement = Paiement::with(['locataire', 'bien', 'bien.agent_immobilier'])->findOrFail($id);
        return view('admin.paiements.details', compact('paiement'));
    }
    




}
