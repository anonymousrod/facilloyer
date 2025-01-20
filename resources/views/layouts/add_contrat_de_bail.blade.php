@extends('layouts.master_dash')
@section('title', 'Créer un contrat de bail')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                <h5 class="text-success">{{ session('success') }}</h5>
                            </div>
                        @endif
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Ajouter un Contrat de Bail</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contrat.store') }}">
                            @csrf
                            <div class="row g-3">
                                <!-- Référence du Contrat -->
                                <div class="col-md-6">
                                    <label for="reference" class="form-label fw-bold">Référence du Contrat</label>
                                    <input type="text" name="reference" class="form-control" id="reference"
                                        placeholder="Référence du contrat" required>
                                </div>
                                <!--  Bien -->
                                <div class="col-md-6">
                                    <label for="bien_id" class="form-label fw-bold">Bien</label>
                                    <input type="text" class="form-control" id="bien" value="{{ $bien->name_bien }}"
                                        readonly>
                                    <input type="hidden" name="bien_id" value="{{ $bien->id }}">
                                </div>

                                <!-- Caution -->
                                <div class="col-md-6">
                                    <label for="caution" class="form-label fw-bold">Dépôt de garantie</label>
                                    <input type="number" name="caution" class="form-control" id="caution"
                                        placeholder="Dépôt de garantie de trois mois" required>
                                </div>

                                <!-- Caution Eau -->
                                <div class="col-md-6">
                                    <label for="caution_eau" class="form-label fw-bold">Caution Eau</label>
                                    <input type="number" name="caution_eau" class="form-control" id="caution_eau"
                                        placeholder="Montant de la caution eau">
                                </div>

                                <!-- Caution Electricité -->
                                <div class="col-md-6">
                                    <label for="caution_electricite" class="form-label fw-bold">Caution Electricité</label>
                                    <input type="number" name="caution_electricite" class="form-control"
                                        id="caution_electricite" placeholder="Montant de la caution électricité">
                                </div>

                                <!-- Pénalité de retard -->
                                <div class="col-md-6">
                                    <label for="penalite_retard" class="form-label fw-bold">Pénalité de retard</label>
                                    <input type="number" name="penalite_retard" class="form-control" id="penalite_retard"
                                        placeholder="Pénalité en Francs CFA">
                                </div>

                                <!-- Lieu de Signature -->
                                <div class="col-md-6">
                                    <label for="lieu_signature" class="form-label fw-bold">Lieu de Signature</label>
                                    <input type="text" name="lieu_signature" class="form-control" id="lieu_signature"
                                        placeholder="Lieu de redaction du contrat ( Fait à...)" required>
                                </div>

                                <!-- Date de Signature (Champ Caché) -->
                                <input type="hidden" name="date_signature" id="date_signature"
                                    value="{{ now()->format('Y-m-d') }}">

                                <hr class="custom-hr">

                                <!-- Locataire -->
                                <div class="col-md-6">
                                    <label for="locataire_id" class="form-label fw-bold">Locataire</label>
                                    <input type="text" class="form-control" id="locataire_id"
                                        value="{{ $locataire->nom }} {{ $locataire->prenom }}" readonly>
                                    <input type="hidden" name="locataire_id" value="{{ $locataire->id }}">

                                </div>

                                <!-- Date de Début du Contrat -->
                                <div class="col-md-6">
                                    <label for="date_debut" class="form-label fw-bold">Date de Début</label>
                                    <input type="date" name="date_debut" class="form-control" id="date_debut" required>
                                </div>

                                <!-- Date de Fin du Contrat -->
                                <div class="col-md-6">
                                    <label for="date_fin" class="form-label fw-bold">Date de Fin (facultatif)</label>
                                    <input type="date" name="date_fin" class="form-control" id="date_fin">
                                </div>

                                <!-- Fréquence de Paiement -->
                                <div class="col-md-6">
                                    <label for="frequence_paiement" class="form-label fw-bold">Fréquence de
                                        Paiement</label>
                                    <select name="frequence_paiement" id="frequence_paiement" class="form-select"
                                        required>
                                        <option value="mois">Mois</option>
                                        <option value="annuel">Annuel</option>
                                        <option value="bimestre">Bimestre</option>
                                        <option value="trimestre">Trimestre</option>
                                        <option value="semestriel">Semestriel</option>
                                    </select>
                                </div>

                                <!-- Script pour calculer montant_total_frequence -->
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const loyer = parseFloat(document.getElementById('loyer_bien').value || 0);
                                        const frequenceSelect = document.getElementById('frequence_paiement');
                                        const montantField = document.getElementById('montant_total_frequence');

                                        function updateMontant() {
                                            const frequence = frequenceSelect.value;
                                            let mois = 1; // Par défaut, un mois
                                            if (frequence === 'bimestre') mois = 2;
                                            else if (frequence === 'trimestre') mois = 3;
                                            else if (frequence === 'semestriel') mois = 6;
                                            else if (frequence === 'annuel') mois = 12;

                                            const montant = loyer * mois;
                                            montantField.value = montant;
                                            console.log(`Montant mis à jour : ${montant}`); // Debug
                                        }

                                        frequenceSelect.addEventListener('change', updateMontant);
                                        updateMontant(); // Calcul initial
                                    });
                                </script>

                                <!-- Mode de Paiement -->
                                <div class="col-md-6">
                                    <label for="mode_paiement" class="form-label fw-bold">Mode de Paiement</label>
                                    <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                                        <option value="virement">Virement</option>
                                        <option value="especes">Espèces</option>
                                    </select>
                                </div>

                                <!-- Champ caché pour montant_total_frequence -->
                                <input type="hidden" name="montant_total_frequence" id="montant_total_frequence"
                                    value="">
                                <!-- Champ caché pour loyer_bien -->

                                <input type="hidden" id="loyer_bien" value="{{ $bien->loyer_mensuel }}">


                                <!-- Renouvellement Automatique -->
                                <div class="col-md-6">
                                    <label for="renouvellement_automatique" class="form-label fw-bold">Renouvellement
                                        Automatique</label>
                                    <input type="checkbox" name="renouvellement_automatique"
                                        id="renouvellement_automatique">
                                </div>

                                <!-- Statut du Contrat -->
                                <div class="col-md-6">
                                    <label for="statut_contrat" class="form-label fw-bold">Statut du Contrat</label>
                                    <select name="statut_contrat" id="statut_contrat" class="form-select" required>
                                        <option value="actif">Actif</option>
                                        <option value="termine">Terminé</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Bouton de soumission -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Soumettre le Contrat de Bail</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .custom-hr {
        width: 60%;
        /* Limite la largeur de la ligne à 60% */
        margin: 20px auto;
        /* Centre horizontalement et ajoute des marges en haut et en bas */
        border: 0;
        /* Supprime la bordure par défaut */
        border-top: 3px solid #007bff;
        /* Ajoute une ligne de 3px de large et de couleur bleue */
    }
</style>
