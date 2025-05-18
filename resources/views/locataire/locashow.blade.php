@extends('layouts.master_dash')

@section('title', 'Profil')

@section('content')
<style>
    :root {
        --dark-green: #012C1C;
        --light-green: #4CAF50;
        --green-gradient: linear-gradient(135deg, #012C1C, #4CAF50);
        --text-muted: #6c757d;
    }

 

    .profile-header {
        background: var(--green-gradient);
        color: white;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
        margin-top: 
    }

    .profile-pic {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .card-custom {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
        background: white;
        position: relative;
        z-index: 1;
    }

    .card-custom:hover {
        transform: scale(1.01);
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: bold;
        color: var(--dark-green);
    }

    .info-row {
        font-size: 1.05rem;
        margin-bottom: 1rem;
    }

    .info-label {
        font-weight: 600;
        color: var(--dark-green);
    }

    .info-icon {
        width: 18px;
        color: var(--light-green);
        margin-right: 8px;
    }

    .edit-btn {
        background: transparent;
        border: 2px solid white;
        color: white;
        transition: 0.3s;
    }

    .edit-btn:hover {
        background-color: white;
        color: var(--dark-green);
    }

    @media (max-width: 767px) {
        .profile-pic {
            width: 100px;
            height: 100px;
        }
    }
</style>

<div class="container py-5">
    <div class="profile-header d-flex flex-wrap align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img class="profile-pic me-4" src="{{ $locataire->photo_profil ? asset($locataire->photo_profil) : asset('images/default-avatar.png') }}" alt="Photo de profil">
            <div>
                <h2 class="mb-1">{{ $locataire->prenom }} {{ $locataire->nom }}</h2>
            </div>
        </div>
        @if (Auth::user()->id_role === 2)
            <a href="{{ route('locataire.edit', $locataire->user_id) }}" class="btn edit-btn px-4 py-2 mt-3 mt-md-0">
                <i class="fas fa-edit me-2"></i> Modifier mon profil
            </a>
        @endif
    </div>

    <div class="row mt-4 gy-4">
        <div class="col-lg-8">
            <div class="card card-custom p-4">
                <h5 class="section-title mb-3"><i class="fas fa-user-circle me-2"></i> Informations Générales</h5>

                @php
                    $infos = [
                        ['icon' => 'fa-user', 'label' => 'Nom', 'value' => $locataire->nom],
                        ['icon' => 'fa-user', 'label' => 'Prénom', 'value' => $locataire->prenom],
                        ['icon' => 'fa-map-marker-alt', 'label' => 'Adresse', 'value' => $locataire->adresse],
                        ['icon' => 'fa-phone', 'label' => 'Téléphone', 'value' => $locataire->telephone],
                        ['icon' => 'fa-birthday-cake', 'label' => 'Date de naissance', 'value' => $locataire->date_naissance ? $locataire->date_naissance->format('d/m/Y') : null],
                        ['icon' => 'fa-venus-mars', 'label' => 'Genre', 'value' => $locataire->genre],
                        ['icon' => 'fa-money-bill-wave', 'label' => 'Revenu mensuel', 'value' => $locataire->revenu_mensuel ? number_format($locataire->revenu_mensuel, 0, ',', ' ') . ' FCFA' : null],
                        ['icon' => 'fa-ring', 'label' => 'Statut matrimonial', 'value' => $locataire->statut_matrimoniale],
                        ['icon' => 'fa-briefcase', 'label' => 'Profession', 'value' => $locataire->statut_professionnel],
                        ['icon' => 'fa-user-shield', 'label' => 'Garant', 'value' => $locataire->garant],
                    ];
                @endphp

                @foreach ($infos as $info)
                    <div class="row info-row">
                        <div class="col-md-6 d-flex align-items-center">
                            <i class="fas {{ $info['icon'] }} info-icon"></i>
                            <span class="info-label">{{ $info['label'] }} :</span>&nbsp;
                            <span class="info-value">{{ $info['value'] ?? 'Non rempli' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if (Auth::user()->id_role === 2)
            <div class="col-lg-4">
                <div class="card card-custom p-4 h-100">
                    <h5 class="section-title mb-3"><i class="fas fa-building me-2"></i> Agent Immobilier Associé</h5>
                    @if ($locataire->agent_immobilier)
                        <p class="mb-2"><strong>Agence :</strong> {{ $locataire->agent_immobilier->nom_agence ?? 'Non rempli' }}</p>
                        <p class="mb-2"><strong>Nom :</strong> {{ $locataire->agent_immobilier->nom_admin ?? 'Non rempli' }}</p>
                        <p class="mb-0"><strong>Prénom :</strong> {{ $locataire->agent_immobilier->prenom_admin ?? 'Non rempli' }}</p>
                    @else
                        <p class="text-muted">Aucun agent immobilier associé.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
