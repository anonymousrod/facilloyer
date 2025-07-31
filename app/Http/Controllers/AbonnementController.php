<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Abonnement;
use App\Models\AgentImmobilier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AbonnementController extends Controller
{
    // Affiche les plans disponibles
    public function index()
    {
        $plans = Plan::all();
        return view('plans_index', compact('plans'));
    }

    // Enregistre l'abonnement après paiement Kkiapay
    // public function success(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'agent_id' => 'required|exists:agent_immobilier,id',
    //             'plan_id' => 'required|exists:plans,id',
    //             'transaction_id' => 'required|string',
    //         ]);

    //         $existe = Abonnement::where('agent_id', $request->agent_id)
    //             ->where('status', 'actif')
    //             ->where('date_fin', '>', now())
    //             ->exists();

    //         if ($existe) {
    //             return response()->json([
    //                 'message' => 'Vous avez déjà un abonnement actif.'
    //             ], 409);
    //         }

    //         $plan = Plan::findOrFail($request->plan_id);
    //         Abonnement::create([
    //             'agent_id' => $request->agent_id,
    //             'plan_id' => $request->plan_id,
    //             'transaction_id' => $request->transaction_id,

    //             'date_debut' => now(),
    //             'date_fin' => now()->addDays($plan->duree),
    //             'status' => 'actif',
    //         ]);

    //         return response()->json([
    //             'message' => 'Abonnement activé avec succès.'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Erreur serveur',
    //             'details' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    //new
    public function success(Request $request)
    {
        try {
            $request->validate([
                'agent_id' => 'required|exists:agent_immobilier,id',
                'plan_id' => 'required|exists:plans,id',
                'transaction_id' => 'required|string',
            ]);

            $plan = Plan::findOrFail($request->plan_id);

            $ancien = Abonnement::where('agent_id', $request->agent_id)
                ->where('status', 'actif')
                ->where('date_fin', '>', now())
                ->latest('date_fin')
                ->first();

            if ($ancien) {
                // Ancien encore actif : renouvellement

                $date_debut = Carbon::parse($ancien->date_fin);
                $date_fin = Carbon::parse($ancien->date_fin)->addDays($plan->duree);


                // Marquer l’ancien abonnement comme expiré
                $ancien->update(['status' => 'expiré']);
            } else {
                // Nouvel abonnement (pas d’abonnement actif)
                $date_debut = now();
                $date_fin = now()->copy()->addDays($plan->duree);
            }

            Abonnement::create([
                'agent_id' => $request->agent_id,
                'plan_id' => $request->plan_id,
                'transaction_id' => $request->transaction_id,
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
                'status' => 'actif',
            ]);

            return response()->json([
                'message' => 'Abonnement activé avec succès.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Erreur serveur',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function current()
    {
        $agent = Auth::user()->agent_immobiliers->first();
        $abonnement = Abonnement::where('agent_id', $agent->id)->latest()->first();

        return view('layouts.abonnement_current', compact('abonnement'));
    }

    public function historique()
    {
        $agent = auth::user()->agent_immobiliers->first();
        $abonnements = Abonnement::where('agent_id', $agent->id)->latest()->get();

        return view('layouts.abonnement_historique', compact('abonnements'));
    }
}
