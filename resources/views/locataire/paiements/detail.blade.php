@extends('layouts.master_dash')

@section('title', 'Détails du paiement')

@section('content')

<div class="container py-4">
  <!-- TITRE + BOUTON -->
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <h4 class="mb-0 fw-bold">
        <i class="fas fa-receipt me-2 text-primary"></i>
        Détails du paiement #{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}
      </h4>
      <a href="{{ route('locataire.paiements.quittance', $paiement->id) }}" class="btn btn-success">
        <i class="fas fa-download me-1"></i> Télécharger quittance
      </a>
    </div>
  </div>

  <!-- CONTENU -->
  <div class="row g-4">
    <!-- INFOS PAIEMENT -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="fw-bold text-primary mb-3">
            <i class="fas fa-money-check-alt me-1"></i> Informations du paiement
          </h5>

          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
              <span class="text-muted">Montant payé</span>
              <span class="fw-bold text-success">{{ number_format($paiement->montant_paye, 2, ',', ' ') }} FCFA</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="text-muted">Locataire</span>
              <span>{{ $paiement->locataire->nom }} {{ $paiement->locataire->prenom }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="text-muted">Date de paiement</span>
              <span>{{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : 'Non disponible' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="text-muted">Statut</span>
              <span class="badge bg-success">Paiement réussi</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- INFOS LOGEMENT -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-body">
          <h5 class="fw-bold text-primary mb-3">
            <i class="fas fa-home me-1"></i> Informations logement
          </h5>

          <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item px-0 d-flex justify-content-between">
              <span class="text-muted">Adresse</span>
              <span>{{ $paiement->bien->adresse_bien ?? 'Non défini' }}</span>
            </li>
            <li class="list-group-item px-0 d-flex justify-content-between">
              <span class="text-muted">Type</span>
              <span>{{ $paiement->bien->type_bien ?? 'Non défini' }}</span>
            </li>
            <li class="list-group-item px-0 d-flex justify-content-between">
              <span class="text-muted">Superficie</span>
              <span>{{ $paiement->bien->superficie ?? 'Non défini' }} m²</span>
            </li>
          </ul>

          <p class="small text-muted mb-1">
            Quittance générée le {{ now()->format('d/m/Y') }}.
          </p>
          <p class="small text-muted mb-3">Merci pour votre confiance !</p>

          <a href="{{ route('locataire.paiements.quittance', $paiement->id) }}" class="btn btn-outline-primary w-100">
            <i class="fas fa-download me-1"></i> Télécharger quittance
          </a>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
