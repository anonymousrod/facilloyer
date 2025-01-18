@extends('layouts.master_dash')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Détails du Paiement</h2>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Paiement ID : {{ $paiement->id }}</strong>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <h5 class="text-secondary"><i class="fas fa-user"></i> Locataire : {{ $paiement->locataire->nom ?? 'Inconnu' }} {{ $paiement->locataire->prenom ?? '' }}</h5>
            </div>
            <div class="mb-3">
                <h5 class="text-secondary"><i class="fas fa-building"></i> Bien : {{ $paiement->bien->name_bien ?? 'Bien inconnu' }}</h5>
            </div>
            <div class="mb-3">
                <h5 class="text-secondary"><i class="fas fa-money-bill-wave"></i> Montant payé : {{ number_format($paiement->montant_paye, 2) }} FCFA</h5>
            </div>
            <div class="mb-3">
                <h5 class="text-secondary"><i class="fas fa-calendar-day"></i> Date du paiement : {{ $paiement->created_at->format('d/m/Y') }}</h5>
            </div>
            <div class="mb-3">
                <h5 class="text-secondary"><i class="fas fa-sync-alt"></i> Fréquence de paiement : {{ $paiement->frequence_paiement }}</h5>
            </div>
            <div class="mb-3">
                <h5 class="text-secondary"><i class="fas fa-align-left"></i> Description : {{ $paiement->description ?? 'Aucune description' }}</h5>
            </div>

            <!-- Icône de téléchargement de la quittance -->
            <div class="mb-3">
                <a href="{{ route('locataire.paiements.quittance', $paiement->id) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Télécharger la quittance
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
