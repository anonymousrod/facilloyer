@extends('layouts.master_dash')

@section('title', 'Profil')

@section('content')


<div class="container py-4">
  <!-- HEADER PROFIL COMPACT -->
  <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-3 gap-3">
    <div class="d-flex align-items-center">
      <img 
        src="{{ $locataire->photo_profil ? asset($locataire->photo_profil) : asset('images/default-avatar.png') }}"
        alt="Photo de profil"
        class="rounded-circle border shadow-sm"
        style="width: 80px; height: 80px; object-fit: cover;">
      <h3 class="ms-3 mb-0 fw-bold">{{ $locataire->prenom }} {{ $locataire->nom }}</h3>
    </div>
    @if (Auth::user()->id_role === 2)
      <a href="{{ route('locataire.edit', $locataire->user_id) }}" class="btn btn-primary px-3 py-1">
        <i class="fas fa-edit me-1"></i> Modifier
      </a>
    @endif
  </div>

  <!-- INFOS + AGENT -->
  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-3">
          <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-user-circle me-1"></i> Infos générales</h6>
          <div class="row g-2">
            @php
              $infos = [
                ['icon' => 'fa-user', 'label' => 'Nom', 'value' => $locataire->nom],
                ['icon' => 'fa-user', 'label' => 'Prénom', 'value' => $locataire->prenom],
                ['icon' => 'fa-map-marker-alt', 'label' => 'Adresse', 'value' => $locataire->adresse],
                ['icon' => 'fa-phone', 'label' => 'Téléphone', 'value' => $locataire->telephone],
                ['icon' => 'fa-birthday-cake', 'label' => 'Naissance', 'value' => $locataire->date_naissance ? $locataire->date_naissance->format('d/m/Y') : null],
                ['icon' => 'fa-venus-mars', 'label' => 'Genre', 'value' => $locataire->genre],
                ['icon' => 'fa-money-bill-wave', 'label' => 'Revenu', 'value' => $locataire->revenu_mensuel ? number_format($locataire->revenu_mensuel, 0, ',', ' ') . ' FCFA' : null],
                ['icon' => 'fa-ring', 'label' => 'Matrimonial', 'value' => $locataire->statut_matrimoniale],
                ['icon' => 'fa-briefcase', 'label' => 'Profession', 'value' => $locataire->statut_professionnel],
                ['icon' => 'fa-user-shield', 'label' => 'Garant', 'value' => $locataire->garant],
              ];
            @endphp

            @foreach ($infos as $info)
              <div class="col-12 col-md-6">
                <div class="d-flex align-items-center small mb-1">
                  <i class="fas {{ $info['icon'] }} text-primary me-2"></i>
                  <span class="fw-semibold">{{ $info['label'] }} :</span>
                  <span class="ms-1">{{ $info['value'] ?? 'Non rempli' }}</span>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    @if (Auth::user()->id_role === 2)
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-3">
            <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-building me-1"></i> Agent Associé</h6>
            @if ($locataire->agent_immobilier)
              <p class="mb-1 small"><strong>Agence :</strong> {{ $locataire->agent_immobilier->nom_agence ?? 'Non rempli' }}</p>
              <p class="mb-1 small"><strong>Nom :</strong> {{ $locataire->agent_immobilier->nom_admin ?? 'Non rempli' }}</p>
              <p class="mb-0 small"><strong>Prénom :</strong> {{ $locataire->agent_immobilier->prenom_admin ?? 'Non rempli' }}</p>
            @else
              <p class="text-muted small">Aucun agent immobilier associé.</p>
            @endif
          </div>
        </div>
      </div>
    @endif
  </div>
</div>


@endsection
