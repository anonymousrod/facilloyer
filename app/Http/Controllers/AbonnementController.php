<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Abonnement;
use App\Models\AgentImmobilier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

    //     $request->validate([
    //         'agent_id' => 'required|exists:agent_immobilier,id',
    //         'plan_id' => 'required|exists:plans,id',
    //         'transaction_id' => 'required|string',
    //     ]);
    //     // Vérification (optionnelle) si l'agent a déjà un abonnement actif
    //     $existe = Abonnement::where('agent_id', $request->agent_id)
    //         ->where('status', 'actif')
    //         ->where('date_fin', '>', now())
    //         ->exists();

    //     if ($existe) {
    //         return redirect()->route('plans.index')->with('success', 'Vous avez déjà un abonnement actif.');
    //     }

    //     // Création de l'abonnement
    //     $plan = Plan::find($request->plan_id);
    //     $abonnement = Abonnement::create([
    //         'agent_id' => $request->agent_id,
    //         'plan_id' => $request->plan_id,
    //         'date_debut' => now(),
    //         'date_fin' => now()->addDays($plan->duree),
    //         'status' => 'actif',
    //     ]);
    //     return redirect()->route('plans.index')->with('success', 'Abonnement activé avec succès.');
    // }
    // public function success(Request $request)
    // {
    //     $request->validate([
    //         'agent_id' => 'required|exists:agent_immobilier,id',
    //         'plan_id' => 'required|exists:plans,id',
    //         'transaction_id' => 'required|string',
    //     ]);

    //     $existe = Abonnement::where('agent_id', $request->agent_id)
    //         ->where('status', 'actif')
    //         ->where('date_fin', '>', now())
    //         ->exists();

    //     if ($existe) {
    //         return response()->json([
    //             'message' => 'Vous avez déjà un abonnement actif.'
    //         ], 409); // 409 = Conflict
    //     }

    //     $plan = Plan::find($request->plan_id);
    //     Abonnement::create([
    //         'agent_id' => $request->agent_id,
    //         'plan_id' => $request->plan_id,
    //         'date_debut' => now(),
    //         'date_fin' => now()->addDays($plan->duree),
    //         'status' => 'actif',
    //     ]);

    //     return response()->json([
    //         'message' => 'Abonnement activé avec succès.'
    //     ]);
    // }
    public function success(Request $request)
    {
        try {
            $request->validate([
                'agent_id' => 'required|exists:agent_immobilier,id',
                'plan_id' => 'required|exists:plans,id',
                'transaction_id' => 'required|string',
            ]);

            $existe = Abonnement::where('agent_id', $request->agent_id)
                ->where('status', 'actif')
                ->where('date_fin', '>', now())
                ->exists();

            if ($existe) {
                return response()->json([
                    'message' => 'Vous avez déjà un abonnement actif.'
                ], 409);
            }

            $plan = Plan::findOrFail($request->plan_id);
            Abonnement::create([
                'agent_id' => $request->agent_id,
                'plan_id' => $request->plan_id,
                'date_debut' => now(),
                'date_fin' => now()->addDays($plan->duree),
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
}
