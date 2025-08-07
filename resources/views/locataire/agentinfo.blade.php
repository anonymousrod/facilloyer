@extends('layouts.master_dash')

@section('title', "Détails de l'Agence Immobilière")

@section('content')

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-xl-7 col-lg-8 col-md-10">

      <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

        <!-- Header -->
        <div class="card-header border-bottom d-flex align-items-center gap-3 px-4 py-3">
          <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
            <i class="fas fa-building fa-xl"></i>
          </div>
          <h4 class="mb-0 fw-bold text-success">Détails de l'Agence Immobilière</h4>
        </div>

        <!-- Body -->
        <div class="card-body px-4 py-4">

          <!-- Section photo de profil -->
          <div class="mb-4">
            <h5 class="fw-bold mb-3"><i class="fas fa-image me-2 text-muted"></i>Photo de Profil</h5>
            <div class="text-center">
              @if(!empty($agent->photo_profil))
                <img src="{{ asset($agent->photo_profil) }}" alt="Photo de profil"
                     class="rounded-circle shadow border" style="width: 130px; height: 130px; object-fit: cover;">
              @else
                <p class="text-muted fst-italic">Aucune photo de profil disponible.</p>
              @endif
            </div>
          </div>

          <!-- Détails de l'agence -->
          <div>
            <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-muted"></i>Informations Générales</h5>
            <div class="list-group list-group-flush small shadow-sm">

              @php
                $infos = [
                  ['🏢 Nom de l\'agence', $agent->nom_agence ?? 'Non spécifié'],
                  ['👤 Nom Agent', $agent->nom_admin ?? 'Non spécifié'],
                  ['👤 Prénom Agent', $agent->prenom_admin ?? 'Non spécifié'],
                  ['📞 Téléphone', $agent->telephone_agence ?? 'Non spécifié'],
                  ['📍 Adresse', $agent->adresse_agence ?? 'Non spécifié'],
                  ['🗓️ Années d\'expérience', $agent->annee_experience ? $agent->annee_experience.' ans' : 'Non spécifié'],
                  ['🌍 Territoire couvert', $agent->territoire_couvert ?? 'Non spécifié'],
                  ['⭐ Évaluation', $agent->evaluation ? $agent->evaluation.'/5' : 'Non spécifié'],
                ];
              @endphp

              @foreach($infos as [$label, $value])
                <div class="list-group-item d-flex justify-content-between py-2 px-3">
                  <span class="fw-semibold">{{ $label }}</span>
                  <span class="text-end text-muted">{{ $value }}</span>
                </div>
              @endforeach

            </div>
          </div>

          <!-- Bouton retour -->
          <div class="text-center mt-5">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-success px-4">
              <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
            </a>
          </div>

        </div>
      </div>
      
    </div>
  </div>
</div>

@endsection
