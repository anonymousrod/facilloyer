<?php

namespace Database\Seeders;

use App\Models\ContratDeBailLocataire;
use App\Models\Locataire;
use App\Models\Paiement;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       // Récupérer tous les contrats de bail locataire
       $contratsLocataires = ContratDeBailLocataire::all();

       foreach ($contratsLocataires as $contratLocataire) {
           // Récupérer les informations du contrat de bail
           $contrat = $contratLocataire->contrats_de_bail;
           $dateDebut = Carbon::parse($contratLocataire->date_debut);
           $periodePaiement = $contratLocataire->periode_paiement;  // Mensuel, Trimestriel, etc.

           // Calcul de la date limite de paiement
           $dateLimite = $dateDebut->addMonths($periodePaiement); // Calcul de la date limite

           // Simuler des paiements
           for ($i = 0; $i < 12; $i++) { // Créer 12 paiements (1 par mois)
               $datePaiement = $dateDebut->copy()->addMonths($i); // Date de paiement

               // Si la date de paiement dépasse la date limite, le paiement est en retard
               $status = ($datePaiement > $dateLimite) ? 'Retard' : 'Payé';

               // Création du paiement
               Paiement::create([
                   'locataire_id' => $contratLocataire->locataire_id,
                   'bien_id' => $contrat->bien_id,
                   'montant' => $contrat->loyer_mensuel, // Montant du loyer
                   'date' => $datePaiement, // Date du paiement
                   'mode_paiement' => 'Virement', // Exemple de mode de paiement
                   'status' => $status, // Statut basé sur la date
               ]);
           }
       }
    }
}
