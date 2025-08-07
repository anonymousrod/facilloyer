<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::where('nom', '!=', 'Essai')->get();
        // Gérer les notifications
        if (request()->has('notification_id')) {
            auth()->user()->notifications()
                ->where('id', request('notification_id'))
                ->update(['read_at' => now()]);
        }
        return view('layouts.plans_index', compact('plans'));
    }

    public function subscribe($id)
    {
        $plan = Plan::findOrFail($id);
        $agent = Auth::user()->agent_immobiliers->first();

        // Supprimer l'abonnement précédent si besoin (facultatif)
        Abonnement::where('agent_id', $agent->id)->delete();

        $dateDebut = Carbon::now();
        $dateFin = $dateDebut->copy()->addDays($plan->duree);

        Abonnement::create([
            'agent_id' => $agent->id,
            'plan_id' => $plan->id,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'status' => 'actif',
        ]);

        return view('layouts.dashboard', ['message' => 'Abonnement activé avec succès.']);
    }
}
