@extends('layouts.master_dash')

@section('title', 'Profil')

@section('content')
    @if ($message)
        <div class="alert alert-warning text-center fade show" role="alert">
            <h5 class="text-warning mb-0">{{ $message }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container mt-4">
        @if (Auth::user()->id_role === 2)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-primary">Mon Profil</h4>
                <a href="{{ route('locataire.edit', $locataire->user_id) }}" class="btn btn-outline-primary btn-sm px-3">
                    <i class="fas fa-edit me-2"></i>Modifier
                </a>
            </div>
        @endif
        <!-- Titre et bouton d'édition -->

        <!-- Informations générales -->
        <div class="card shadow-sm mb-4 rounded-3 border-0">
            <div class="card-header bg-light py-3 border-bottom">
                <h4 class="mb-0 text-secondary">Informations Générales</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Photo de profil -->
                    <div class="col-md-4 text-center">
                        @if ($locataire->photo_profil)
                            <img src="{{ asset($locataire->photo_profil) }}" alt="Photo de profil"
                                class="img-fluid rounded-circle shadow-sm" style="max-width: 150px;">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="Photo par défaut"
                                class="img-fluid rounded-circle shadow-sm" style="max-width: 150px;">
                        @endif
                    </div>
                    <!-- Informations du locataire -->
                    <div class="col-md-8">
                        <div class="row mb-2">
                            <div class="col-sm-6"><strong>Nom :</strong> {{ $locataire->nom ?? 'Non rempli' }}</div>
                            <div class="col-sm-6"><strong>Prénom :</strong> {{ $locataire->prenom ?? 'Non rempli' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6"><strong>Adresse :</strong> {{ $locataire->adresse ?? 'Non rempli' }}</div>
                            <div class="col-sm-6"><strong>Téléphone :</strong> {{ $locataire->telephone ?? 'Non rempli' }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6"><strong>Date de naissance :</strong>
                                {{ $locataire->date_naissance ? $locataire->date_naissance->format('d/m/Y') : 'Non rempli' }}
                            </div>
                            <div class="col-sm-6"><strong>Genre :</strong> {{ $locataire->genre ?? 'Non rempli' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6"><strong>Revenu mensuel :</strong>
                                {{ $locataire->revenu_mensuel ? number_format($locataire->revenu_mensuel, 2, ',', ' ') . ' FCFA' : 'Non rempli' }}
                            </div>
                            <div class="col-sm-6"><strong>Statut matrimonial :</strong>
                                {{ $locataire->statut_matrimoniale ?? 'Non rempli' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6"><strong>Profession :</strong>
                                {{ $locataire->statut_professionnel ?? 'Non rempli' }}</div>
                            <div class="col-sm-6"><strong>Garant :</strong> {{ $locataire->garant ?? 'Non rempli' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->id_role === 2)
            <!-- Agent immobilier -->
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-header bg-light py-3 border-bottom">
                    <h4 class="mb-0 text-secondary">Agent Immobilier Associé</h4>
                </div>
                <div class="card-body">
                    @if ($locataire->agent_immobilier)
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Agence :</strong>
                                {{ $locataire->agent_immobilier->nom_agence ?? 'Non rempli' }}</li>
                            <li class="mb-2"><strong>Nom de l'agent :</strong>
                                {{ $locataire->agent_immobilier->nom_admin ?? 'Non rempli' }}</li>
                            <li class="mb-2"><strong>Prénom de l'agent :</strong>
                                {{ $locataire->agent_immobilier->prenom_admin ?? 'Non rempli' }}</li>
                        </ul>
                    @else
                        <p class="text-muted">Aucun agent immobilier associé.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
