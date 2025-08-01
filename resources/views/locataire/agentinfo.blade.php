@extends('layouts.master_dash')

@section('title', 'Détails de l\'Agence Immobilière')

@section('content')



<div class="container-xxl my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

        <!-- Header -->
        <div class="card-header bg-primary text-white d-flex align-items-center gap-2">
          <i class="fas fa-building fa-lg"></i>
          <h5 class="mb-0 fw-bold">Informations de l'Agence Immobilière</h5>
        </div>

        <!-- Body -->
        <div class="card-body p-4">

          <!-- Photo de profil -->
          <h5 class="fw-bold mb-3"><i class="fas fa-image me-1"></i> Photo de Profil</h5>
          <div class="text-center mb-4">
            @if(!empty($agent->photo_profil))
              <img src="{{ asset($agent->photo_profil) }}"
                   alt="Photo de profil"
                   class="img-thumbnail shadow rounded-circle"
                   style="width: 150px; height: 150px; object-fit: cover;">
            @else
              <p class="text-muted fst-italic">Aucune photo de profil disponible.</p>
            @endif
          </div>

          <!-- Détails -->
          <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-1"></i> Détails de l'Agence</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
              <span class="fw-semibold">🏢 Nom de l'agence</span>
              <span class="text-break text-end">{{ $agent->nom_agence ?? 'Non spécifié' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="fw-semibold">👤 Nom Agent</span>
              <span class="text-break text-end">{{ $agent->nom_admin ?? 'Non spécifié' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="fw-semibold">👤 Prénom Agent</span>
              <span class="text-break text-end">{{ $agent->prenom_admin ?? 'Non spécifié' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="fw-semibold">📞 Téléphone</span>
              <span class="text-break text-end">{{ $agent->telephone_agence ?? 'Non spécifié' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="fw-semibold">📍 Adresse</span>
              <span class="text-break text-end">{{ $agent->adresse_agence ?? 'Non spécifié' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="fw-semibold">🗓️ Années d'expérience</span>
              <span class="text-break text-end">{{ $agent->annee_experience ?? 'Non spécifié' }} ans</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="fw-semibold">🌍 Territoire couvert</span>
              <span class="text-break text-end">{{ $agent->territoire_couvert ?? 'Non spécifié' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="fw-semibold">⭐ Évaluation</span>
              <span class="text-break text-end">{{ $agent->evaluation ?? 'Non spécifié' }}/5</span>
            </li>
          </ul>

          <!-- Retour -->
          <div class="text-center mt-5">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary px-4">
              <i class="fas fa-arrow-left me-1"></i> Retour au tableau de bord
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection
