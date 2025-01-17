@extends('layouts.master_dash')

@section('content')
<div class="container py-4">
    <!-- Titre principal -->
    <h2 class="mb-4 text-center text-dark font-weight-bold">Détails du Paiement</h2>

    <div class="invoice-container border rounded shadow-sm p-4 bg-white">
        <!-- Header de la facture -->
        <div class="invoice-header d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
            <div>
                <h6 class="text-uppercase text-primary font-weight-bold">Paiement #{{ $paiement->id }}</h6>
                <p class="text-muted mb-0">Effectué le {{ $paiement->date->format('d/m/Y') }}</p>
            </div>
            <div class="text-right">
                <h5 class="text-dark">Agence Immobilière</h5>
                <p class="text-muted mb-0">{{ $paiement->bien->agent_immobilier->nom_agence }}</p>
                <p class="text-muted">{{ $paiement->bien->agent_immobilier->adresse_agence }}</p>
            </div>
        </div>

        <!-- Section des informations principales -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h5 class="font-weight-bold text-secondary">Locataire</h5>
                <p class="mb-0">{{ $paiement->locataire->nom }} {{ $paiement->locataire->prenom }}</p>
                <p class="text-muted">ID Locataire : {{ $paiement->locataire->id }}</p>
            </div>
            <div class="col-md-6 text-md-right text-left">
                <h5 class="font-weight-bold text-secondary">Montant du Paiement</h5>
                <p class="text-success font-weight-bold h4">
                    {{ number_format($paiement->montant, 2, ',', ' ') }} €
                </p>
            </div>
        </div>

        <!-- Détails du bien -->
        <div class="border-top pt-3">
            <h5 class="font-weight-bold text-secondary">Détails du Bien</h5>
            <p><strong>Nom :</strong> {{ $paiement->bien->name_bien }}</p>
            <p><strong>Adresse :</strong> {{ $paiement->bien->adresse_bien }}</p>
        </div>

        <!-- Footer avec actions -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top">
            <a href="{{ route('admin.paiements.quittance', $paiement->id) }}" class="btn btn-primary mb-3 mb-md-0">
                <i class="fas fa-download mr-2"></i> Télécharger la Quittance
            </a>
            <a href="{{ route('admin.paiements.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Retour à la Liste
            </a>
        </div>
    </div>
</div>
@endsection
