@extends('layouts.master_dash') 

@section('title', 'Profil') 

@section('content') 
<div class="container mt-4">
    <!-- Titre et bouton d'édition -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">Profil Locataire</h1>
        <a href="{{ route('locataire.edit', $locataire->user_id) }}" class="btn btn-outline-primary btn-sm px-3">
            <i class="fas fa-edit me-2"></i>Modifier
        </a>
    </div>

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
                        <img src="{{ asset('storage/' . $locataire->photo_profil) }}" alt="Photo de profil" 
                             class="img-fluid rounded-circle shadow-sm" style="max-width: 150px;">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Photo par défaut" 
                             class="img-fluid rounded-circle shadow-sm" style="max-width: 150px;">
                    @endif
                </div>
                <!-- Informations du locataire -->
                <div class="col-md-8">
                    <div class="row mb-2">
                        <div class="col-sm-6"><strong>Nom :</strong> {{ $locataire->nom }}</div>
                        <div class="col-sm-6"><strong>Prénom :</strong> {{ $locataire->prenom }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6"><strong>Adresse :</strong> {{ $locataire->adresse }}</div>
                        <div class="col-sm-6"><strong>Téléphone :</strong> {{ $locataire->telephone }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6"><strong>Date de naissance :</strong> {{ $locataire->date_naissance->format('d/m/Y') }}</div>
                        <div class="col-sm-6"><strong>Genre :</strong> {{ $locataire->genre }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6"><strong>Revenu mensuel :</strong> {{ number_format($locataire->revenu_mensuel, 2, ',', ' ') }} €</div>
                        <div class="col-sm-6"><strong>Statut matrimonial :</strong> {{ $locataire->statut_matrimoniale }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6"><strong>Profession :</strong> {{ $locataire->statut_professionnel }}</div>
                        <div class="col-sm-6"><strong>Garant :</strong> {{ $locataire->garant }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biens loués -->
    <div class="card shadow-sm mb-4 rounded-3 border-0">
        <div class="card-header bg-light py-3 border-bottom">
            <h4 class="mb-0 text-secondary">Biens Loués</h4>
        </div>
        <div class="card-body">
            @if ($locataire->biens->isEmpty())
                <p class="text-muted">Aucun bien loué.</p>
            @else
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Bien</th>
                            <th>Adresse</th>
                            <th>Loyer mensuel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locataire->biens as $bien)
                            <tr>
                                <td>{{ $bien->name_bien }}</td>
                                <td>{{ $bien->adresse_bien }}</td>
                                <td>{{ number_format($bien->loyer_mensuel, 2, ',', ' ') }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Agent immobilier -->
    <div class="card shadow-sm rounded-3 border-0">
        <div class="card-header bg-light py-3 border-bottom">
            <h4 class="mb-0 text-secondary">Agent Immobilier Associé</h4>
        </div>
        <div class="card-body">
            @if ($locataire->agent_immobilier)
                <ul class="list-unstyled">
                    <li class="mb-2"><strong>Agence :</strong> {{ $locataire->agent_immobilier->nom_agence }}</li>
                    <li class="mb-2"><strong>Nom de l'agent :</strong> {{ $locataire->agent_immobilier->nom_admin }}</li>
                    <li class="mb-2"><strong>Prénom de l'agent :</strong> {{ $locataire->agent_immobilier->prenom_admin }}</li>
                </ul>
            @else
                <p class="text-muted">Aucun agent immobilier associé.</p>
            @endif
        </div>
    </div>
</div>
@endsection
