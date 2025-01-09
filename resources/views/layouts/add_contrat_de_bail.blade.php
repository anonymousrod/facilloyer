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
                                    <input type="number" name="penalite_retard" class="form-control"
                                        id="penalite_retard" placeholder="Pénalité en Francs CFA">
                                </div>

                                <!-- Clauses Spécifiques -->
                                <div class="col-md-12">
                                    <label for="clauses_specifiques1" class="form-label fw-bold">Clauses Spécifiques N°1</label>
                                    <textarea name="clauses_specifiques1" id="clauses_specifiques1" class="form-control" rows="3"
                                        placeholder="Entrez les clauses spécifiques au Locataire (facultatif)"></textarea>
                                </div>
                                <!-- Clauses Spécifiques -->
                                <div class="col-md-12">
                                    <label for="clauses_specifiques2" class="form-label fw-bold">Clauses Spécifiques N°2</label>
                                    <textarea name="clauses_specifiques2" id="clauses_specifiques2" class="form-control" rows="3"
                                        placeholder="Entrez les clauses spécifiques à l'agent immobilier (facultatif)"></textarea>
                                </div>
                                <!-- Clauses Spécifiques -->
                                <div class="col-md-12">
                                    <label for="clauses_specifiques3" class="form-label fw-bold">Clauses Spécifiques N°3</label>
                                    <textarea name="clauses_specifiques3" id="clauses_specifiques3" class="form-control" rows="3"
                                        placeholder="Entrez les clauses spécifiques au renouvellement du contrat (facultatif)"></textarea>
                                </div>
                                <!-- Clauses Spécifiques -->
                                <div class="col-md-12">
                                    <label for="clauses_specifiques4" class="form-label fw-bold">Clauses Spécifiques N°4</label>
                                    <textarea name="clauses_specifiques4" id="clauses_specifiques4" class="form-control" rows="3"
                                        placeholder="Entrez les clauses spécifiques pour la résiliation (facultatif)"></textarea>
                                </div>
                                <!-- Clauses Spécifiques -->
                                <div class="col-md-12">
                                    <label for="clauses_specifiques5" class="form-label fw-bold">Clauses Spécifiques N°5</label>
                                    <textarea name="clauses_specifiques5" id="clauses_specifiques5" class="form-control" rows="3"
                                        placeholder=" Conformité des lieux loue (facultatif)"></textarea>
                                </div>
                                <!-- Clauses Spécifiques -->
                                <div class="col-md-12">
                                    <label for="clauses_specifiques6" class="form-label fw-bold">Clauses Spécifiques N°6</label>
                                    <textarea name="clauses_specifiques6" id="clauses_specifiques6" class="form-control" rows="3"
                                        placeholder="Règlement et litige (facultatif)"></textarea>
                                </div>

                                <!-- Lieu de Signature -->
                                <div class="col-md-6">
                                    <label for="lieu_signature" class="form-label fw-bold">Lieu de Signature</label>
                                    <input type="text" name="lieu_signature" class="form-control" id="lieu_signature"
                                        placeholder="Lieu de la signature" required>
                                </div>

                                <!-- Date de Signature -->
                                <div class="col-md-6">
                                    <label for="date_signature" class="form-label fw-bold">Date de Signature</label>
                                    <input type="date" name="date_signature" class="form-control" id="date_signature"
                                        required>
                                </div>
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
                                        <option value="bimestre">Bimestre</option>
                                        <option value="trimestre">Trimestre</option>
                                    </select>
                                </div>

                                <!-- Mode de Paiement -->
                                <div class="col-md-6">
                                    <label for="mode_paiement" class="form-label fw-bold">Mode de Paiement</label>
                                    <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                                        <option value="virement">Virement</option>
                                        <option value="especes">Espèces</option>
                                    </select>
                                </div>

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
