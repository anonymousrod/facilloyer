@extends('layouts.master_dash')

@section('title', 'Détails de l\'Agence Immobilière')

@section('content')
<div class="container-xxl mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <!-- En-tête de la carte -->
                <div class="card-header bg-light text-center py-4 rounded-top">
                    <h4 class="card-title fw-bold">
                        <i class="fas fa-building me-2"></i>Informations de l'Agence Immobilière
                    </h4>
                </div>
                <!-- Corps de la carte -->
                <div class="card-body p-4">
                    <!-- Photo de profil -->
                    <h5 class="mb-3"><i class="fas fa-image me-2"></i>Photo de Profil</h5>
                    <div class="text-center mb-4">
                        @if(!empty($agent->photo_profil))
                            <img src="{{asset($agent->photo_profil) }}" 
                                 alt="Photo de profil" 
                                 class="img-thumbnail shadow rounded-circle" 
                                 style="max-width: 180px;">
                        @else
                            <p class="text-muted">Aucune photo de profil disponible.</p>
                        @endif
                    </div>

                    <!-- Détails de l'agence -->
                    <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Détails de l'Agence</h5>
                    <div class="row">
                        <div class="col-12">
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Nom de l'agence :</span>
                                    <span class="text-break">{{ $agent->nom_agence ?? 'Non spécifié' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Nom Agent :</span>
                                    <span class="text-break">{{ $agent->nom_admin ?? 'Non spécifié' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Prénom Agent :</span>
                                    <span class="text-break">{{ $agent->prenom_admin ?? 'Non spécifié' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Téléphone :</span>
                                    <span class="text-break">{{ $agent->telephone_agence ?? 'Non spécifié' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Adresse :</span>
                                    <span class="text-break">{{ $agent->adresse_agence ?? 'Non spécifié' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Années d'expérience :</span>
                                    <span class="text-break">{{ $agent->annee_experience ?? 'Non spécifié' }} ans</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Territoire couvert :</span>
                                    <span class="text-break">{{ $agent->territoire_couvert ?? 'Non spécifié' }}</span>
                                </li>
                                <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Biens disponibles :</span>
                                    <span class="text-break">{{ $agent->nombre_bien_disponible ?? 'Non spécifié' }}</span>
                                </li> -->
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Évaluation :</span>
                                    <span class="text-break">
                                        {{ $agent->evaluation ?? 'Non spécifié' }}/5
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bouton de retour -->
                    <div class="text-center mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
