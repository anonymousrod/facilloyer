@extends('layouts.master_dash')

@section('title', 'Détails de l\'Agence Immobilière')

@section('content')

<style>
    :root {
        --dark-green: #012C1C;
        --light-green: #4CAF50;
        --green-gradient: linear-gradient(135deg, #012C1C, #4CAF50);
        --text-muted: #6c757d;
        --border-radius: 12px;
        --shadow-card: 0 4px 20px rgba(1, 44, 28, 0.15);
        --font-primary: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f6f8f7;
        font-family: var(--font-primary);
    }

    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-card);
        background: #fff;
        overflow: hidden;
    }

    .card-header {
        background: var(--green-gradient);
        color: white;
        padding: 1.5rem 2rem;
        border-top-left-radius: var(--border-radius);
        border-top-right-radius: var(--border-radius);
        text-align: center;
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
    }

    .card-header i {
        font-size: 1.6rem;
    }

    .card-body {
        padding: 2rem;
    }

    h5 {
        font-weight: 600;
        color: var(--dark-green);
        margin-bottom: 1.5rem;
        border-bottom: 2px solid var(--light-green);
        padding-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 1.25rem;
    }

    h5 i {
        color: var(--light-green);
        font-size: 1.3rem;
    }

    .img-thumbnail {
        border-radius: 50%;
        border: 5px solid var(--light-green);
        max-width: 180px;
        max-height: 180px;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .list-group-item {
        border: none;
        padding: 1rem 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e9ecef;
        font-size: 1.05rem;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-item span.fw-bold {
        color: var(--dark-green);
        font-weight: 700;
        max-width: 45%;
    }

    .list-group-item span.text-break {
        color: #333;
        max-width: 50%;
        text-align: right;
        word-wrap: break-word;
    }

    .btn-outline-secondary {
        color: var(--dark-green);
        border-color: var(--dark-green);
        font-weight: 600;
        padding: 0.5rem 1.8rem;
        font-size: 1rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(1,44,28,0.2);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-outline-secondary:hover {
        background-color: var(--light-green);
        border-color: var(--light-green);
        color: white;
        box-shadow: 0 4px 15px rgba(76,175,80,0.7);
        text-decoration: none;
    }

    .text-center.mb-4 {
        margin-bottom: 2.5rem !important;
    }

    @media (max-width: 767px) {
        .card-header {
            font-size: 1.2rem;
            padding: 1rem 1.2rem;
        }
        h5 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        .img-thumbnail {
            max-width: 130px;
            max-height: 130px;
        }
        .list-group-item span.fw-bold,
        .list-group-item span.text-break {
            max-width: 48%;
            font-size: 0.95rem;
        }
    }
</style>

<div class="container-xxl mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header">
                    <i class="fas fa-building"></i>
                    Informations de l'Agence Immobilière
                </div>

                <div class="card-body">
                    <!-- Photo de profil -->
                    <h5><i class="fas fa-image"></i> Photo de Profil</h5>
                    <div class="text-center mb-4">
                        @if(!empty($agent->photo_profil))
                            <img src="{{ asset($agent->photo_profil) }}" 
                                 alt="Photo de profil" 
                                 class="img-thumbnail shadow rounded-circle">
                        @else
                            <p class="text-muted fst-italic">Aucune photo de profil disponible.</p>
                        @endif
                    </div>

                    <!-- Détails de l'agence -->
                    <h5><i class="fas fa-info-circle"></i> Détails de l'Agence</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="fw-bold">Nom de l'agence :</span>
                            <span class="text-break">{{ $agent->nom_agence ?? 'Non spécifié' }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Nom Agent :</span>
                            <span class="text-break">{{ $agent->nom_admin ?? 'Non spécifié' }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Prénom Agent :</span>
                            <span class="text-break">{{ $agent->prenom_admin ?? 'Non spécifié' }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Téléphone :</span>
                            <span class="text-break">{{ $agent->telephone_agence ?? 'Non spécifié' }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Adresse :</span>
                            <span class="text-break">{{ $agent->adresse_agence ?? 'Non spécifié' }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Années d'expérience :</span>
                            <span class="text-break">{{ $agent->annee_experience ?? 'Non spécifié' }} ans</span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Territoire couvert :</span>
                            <span class="text-break">{{ $agent->territoire_couvert ?? 'Non spécifié' }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Évaluation :</span>
                            <span class="text-break">{{ $agent->evaluation ?? 'Non spécifié' }}/5</span>
                        </li>
                    </ul>

                    <!-- Bouton de retour -->
                    <div class="text-center mt-5">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
