<?php

namespace App\Observers;

use App\Models\Abonnement;
use App\Models\AgentImmobilier;
use App\Models\Plan;
use Illuminate\Support\Carbon;

class AgentImmobilierObserver
{
    /**
     * Handle the AgentImmobilier "created" event.
     */
    // public function created(AgentImmobilier $agentImmobilier): void
    // {
    //     // Récupère le plan Essai
    //     $plan = Plan::where('nom', 'Essai')->first();

    //     if ($plan) {
    //         $dateDebut = Carbon::now();
    //         $dateFin = $dateDebut->copy()->addDays($plan->duree);

    //         // Crée l’abonnement automatiquement
    //         Abonnement::create([
    //             'agent_id' => $agentImmobilier->id,
    //             'plan_id' => $plan->id,
    //             'date_debut' => $dateDebut,
    //             'date_fin' => $dateFin,
    //             'status' => 'actif',
    //         ]);
    //     }
    // }

    public function created(AgentImmobilier $agentImmobilier): void
    {
        // Récupère le plan Gratuit (lancement)
        $plan = Plan::where('nom', 'Gratuit')
            ->where('type', 'mensuel')
            ->first();

        if ($plan) {
            $dateDebut = Carbon::now();
            $dateFin = $dateDebut->copy()->addDays($plan->duree);

            // Crée l’abonnement automatiquement
            Abonnement::create([
                'agent_id'   => $agentImmobilier->id,
                'plan_id'    => $plan->id,
                'date_debut' => $dateDebut,
                'date_fin'   => $dateFin,
                'status'     => 'actif',
            ]);
        }
    }

    /**
     * Handle the AgentImmobilier "updated" event.
     */
    public function updated(AgentImmobilier $agentImmobilier): void
    {
        //
    }

    /**
     * Handle the AgentImmobilier "deleted" event.
     */
    public function deleted(AgentImmobilier $agentImmobilier): void
    {
        //
    }

    /**
     * Handle the AgentImmobilier "restored" event.
     */
    public function restored(AgentImmobilier $agentImmobilier): void
    {
        //
    }

    /**
     * Handle the AgentImmobilier "force deleted" event.
     */
    public function forceDeleted(AgentImmobilier $agentImmobilier): void
    {
        //
    }
}
