<?php

namespace Database\Seeders;

use App\Models\Bien;
use App\Models\Locataire;
use Illuminate\Database\Seeder;

class LocataireBienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les locataires
        $locataires = Locataire::all();

        foreach ($locataires as $locataire) {
            // Récupérer tous les biens qui ne sont pas déjà associés à ce locataire
            $biensDisponibles = Bien::whereDoesntHave('locataires', function($query) use ($locataire) {
                $query->where('locataire_id', $locataire->id);
            })->get();

            // Vérifier s'il y a des biens disponibles
            if ($biensDisponibles->count() > 0) {
                // Sélectionner entre 1 et 3 biens
                $nombreBiens = min(3, $biensDisponibles->count());
                $biensSelectionnes = $biensDisponibles->random(max(1, $nombreBiens));

                // Attacher les biens sélectionnés au locataire
                foreach ($biensSelectionnes as $bien) {
                    $locataire->biens()->attach($bien->id);
                }
            }
        }
    }
}
