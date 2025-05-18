@extends('layouts.master_dash')
@section('title', 'Créer un contrat de bail')
@section('content')
<div class="container-xxl py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-primary text-white rounded-top-4 d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Créer un Contrat de Bail</h4>
                    <i class="fas fa-file-contract fa-lg"></i>
                </div>

                <div class="card-body p-4 bg-light">
                    {{-- Alertes de succès --}}
                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif

                    {{-- Affichage des erreurs --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulaire --}}
                    <form method="POST" action="{{ route('contrat.store') }}" class="needs-validation">
                        @csrf

                        {{-- Informations générales --}}
                        <div class="mb-4 border-start border-4 border-primary ps-3">
                            <h5 class="fw-bold text-primary">Informations Générales</h5>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="reference" class="form-label fw-bold">Référence du Contrat</label>
                                <input type="text" name="reference" class="form-control" id="reference" placeholder="Référence du contrat" required>
                            </div>
                            <div class="col-md-6">
                                <label for="bien_id" class="form-label fw-bold">Bien</label>
                                <input type="text" class="form-control" value="{{ $bien->name_bien }}" readonly required>
                                <input type="hidden" name="bien_id" value="{{ $bien->id }}">
                            </div>

                            <div class="col-md-6">
                                <label for="caution" class="form-label fw-bold">Dépôt de garantie</label>
                                <input type="number" name="caution" class="form-control" id="caution" placeholder="Montant (en FCFA)" required>
                            </div>
                            <div class="col-md-6">
                                <label for="caution_eau" class="form-label fw-bold">Caution Eau</label>
                                <input type="number" name="caution_eau" class="form-control" id="caution_eau" placeholder="Montant (en FCFA)" required>
                            </div>
                            <div class="col-md-6">
                                <label for="caution_electricite" class="form-label fw-bold">Caution Électricité</label>
                                <input type="number" name="caution_electricite" class="form-control" id="caution_electricite" placeholder="Montant (en FCFA)" required>
                            </div>
                            <div class="col-md-6">
                                <label for="penalite_retard" class="form-label fw-bold">Pénalité de retard</label>
                                <input type="number" name="penalite_retard" class="form-control" id="penalite_retard" placeholder="Montant (en FCFA)" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lieu_signature" class="form-label fw-bold">Lieu de Signature</label>
                                <input type="text" name="lieu_signature" class="form-control" id="lieu_signature" placeholder="Fait à ..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="date_signature" class="form-label fw-bold">Date de Création</label>
                                <input type="date" name="date_signature" class="form-control" id="date_signature" required>
                            </div>
                        </div>

                        {{-- Séparateur --}}
                        <hr class="my-4">

                        {{-- Informations locataire --}}
                        <div class="mb-4 border-start border-4 border-primary ps-3">
                            <h5 class="fw-bold text-primary">Informations du Locataire</h5>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="locataire_id" class="form-label fw-bold">Locataire</label>
                                <input type="text" class="form-control" value="{{ $locataire->nom }} {{ $locataire->prenom }}" readonly required>
                                <input type="hidden" name="locataire_id" value="{{ $locataire->id }}">
                            </div>
                            <div class="col-md-6">
                                <label for="date_debut" class="form-label fw-bold">Date de Début</label>
                                <input type="date" name="date_debut" class="form-control" id="date_debut" required>
                            </div>
                            <div class="col-md-6">
                                <label for="date_fin" class="form-label fw-bold">Date de Fin (facultatif)</label>
                                <input type="date" name="date_fin" class="form-control" id="date_fin">
                            </div>
                        </div>

                        {{-- Séparateur --}}
                        <hr class="my-4">

                        {{-- Paiement --}}
                        <div class="mb-4 border-start border-4 border-primary ps-3">
                            <h5 class="fw-bold text-primary">Paiement</h5>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="frequence_paiement" class="form-label fw-bold">Fréquence de Paiement</label>
                                <select name="frequence_paiement" id="frequence_paiement" class="form-select" required>
                                    <option value="mois">Mensuelle</option>
                                    <option value="bimestre">Bimestrielle</option>
                                    <option value="trimestre">Trimestrielle</option>
                                    <option value="semestriel">Semestrielle</option>
                                    <option value="annuel">Annuelle</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="mode_paiement" class="form-label fw-bold">Mode de Paiement</label>
                                <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                                    <option value="virement">Virement</option>
                                    <option value="especes">Espèces</option>
                                </select>
                            </div>
                            <input type="hidden" name="montant_total_frequence" id="montant_total_frequence">
                            <input type="hidden" id="loyer_bien" value="{{ $bien->loyer_mensuel }}">
                        </div>

                        {{-- Script JS pour calcul montant --}}
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const loyer = parseFloat(document.getElementById('loyer_bien').value || 0);
                                const frequenceSelect = document.getElementById('frequence_paiement');
                                const montantField = document.getElementById('montant_total_frequence');

                                function updateMontant() {
                                    const frequence = frequenceSelect.value;
                                    let mois = 1;
                                    if (frequence === 'bimestre') mois = 2;
                                    else if (frequence === 'trimestre') mois = 3;
                                    else if (frequence === 'semestriel') mois = 6;
                                    else if (frequence === 'annuel') mois = 12;

                                    const montant = loyer * mois;
                                    montantField.value = montant;
                                }

                                frequenceSelect.addEventListener('change', updateMontant);
                                updateMontant();
                            });
                        </script>

                        {{-- Séparateur --}}
                        <hr class="my-4">

                        {{-- Options --}}
                        <div class="mb-4 border-start border-4 border-primary ps-3">
                            <h5 class="fw-bold text-primary">Options</h5>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6 form-check">
                                <input type="checkbox" class="form-check-input" name="renouvellement_automatique" id="renouvellement_automatique">
                                <label class="form-check-label fw-bold" for="renouvellement_automatique">Renouvellement Automatique</label>
                            </div>
                            <div class="col-md-6 form-check">
                                <input type="checkbox" class="form-check-input" name="ajouter_articles_par_defaut" id="ajouter_articles_par_defaut">
                                <label class="form-check-label fw-bold" for="ajouter_articles_par_defaut">Ajouter les articles par défaut</label>
                            </div>
                        </div>

                        {{-- Bouton --}}
                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm">
                                <i class="fas fa-paper-plane"></i> Soumettre le Contrat de Bail
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
