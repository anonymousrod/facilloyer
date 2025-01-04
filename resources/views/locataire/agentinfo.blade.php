@extends('layouts.master_dash')

@section('content')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <!-- Card principale -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">
                        <i class="bi bi-info-circle"></i> {{ __('Informations de l\'agent immobilier') }}
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Informations sur le locataire -->
                    <div class="text-center mb-4">
                        <h5 class="text-secondary">
                            <i class="bi bi-person-fill"></i> Locataire : 
                            <span class="fw-bold">{{ $locataire->nom }} {{ $locataire->prenom }}</span>
                        </h5>
                        <hr class="w-50 mx-auto">
                    </div>

                    @if ($agent)
                    <div class="row gy-4">
                        <!-- Nom de l'agence -->
                        <div class="col-lg-6 col-md-12">
                            <div class="info-card">
                                <div class="info-icon bg-primary text-white">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Nom de l'agence</h6>
                                    <p>{{ $agent->nom_agence }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nom de l'administrateur -->
                        <div class="col-lg-6 col-md-12">
                            <div class="info-card">
                                <div class="info-icon bg-success text-white">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Nom de l'administrateur</h6>
                                    <p>{{ $agent->nom_admin }} {{ $agent->prenom_admin }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Téléphone -->
                        <div class="col-lg-6 col-md-12">
                            <div class="info-card">
                                <div class="info-icon bg-warning text-white">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Téléphone</h6>
                                    <p>{{ $agent->telephone_agence }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div class="col-lg-6 col-md-12">
                            <div class="info-card">
                                <div class="info-icon bg-danger text-white">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Adresse</h6>
                                    <p>{{ $agent->adresse_agence }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Territoire couvert -->
                        <div class="col-lg-6 col-md-12">
                            <div class="info-card">
                                <div class="info-icon bg-info text-white">
                                    <i class="bi bi-map"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Territoire couvert</h6>
                                    <p>{{ $agent->territoire_couvert }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Années d'expérience -->
                        <div class="col-lg-6 col-md-12">
                            <div class="info-card">
                                <div class="info-icon bg-secondary text-white">
                                    <i class="bi bi-award"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Années d'expérience</h6>
                                    <p>{{ $agent->annee_experience }} ans</p>
                                </div>
                            </div>
                        </div>

                        <!-- Heures d'ouverture -->
                        <div class="col-lg-6 col-md-12">
                            <div class="info-card">
                                <div class="info-icon bg-dark text-white">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Heures d'ouverture</h6>
                                    <p>{{ $agent->heures_ouverture ?? 'Non spécifiées' }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Icône Document -->
                        <!-- Icône Document -->
                            <<!-- Flèche Cliquable -->
<div class="d-flex justify-content-center mt-5">
    <a href="{r.r" 
       class="arrow-link">
        <i class="bi bi-arrow-right arrow-icon"></i>
    </a>
</div>

<style>
    /* Conteneur du lien */
    .arrow-link {
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        color: #000; /* Couleur noire */
        transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    /* Icône de la flèche */
    .arrow-icon {
        font-size: 3rem; /* Taille grande pour visibilité */
        color: #000; /* Flèche noire */
        transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
    }

    /* Effets au survol */
    .arrow-link:hover .arrow-icon {
        color: #333; /* Couleur légèrement plus claire au survol */
        transform: translateX(5px); /* Légère translation vers la droite */
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .arrow-icon {
            font-size: 2.5rem; /* Taille réduite sur mobile */
        }
    }
</style>






                        <!-- Évaluation de l'agence -->
                        <div class="col-lg-6 col-md-12">
                            <div class="info-card">
                                <div class="info-icon bg-light text-dark">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Évaluation</h6>
                                    <form id="evaluation-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="evaluation" class="form-label">Attribuer une note (1 à 5)</label>
                                            <input type="number" step="0.1" min="1" max="5" name="evaluation" id="evaluation" class="form-control" value="{{ $agent->evaluation }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </form>
                                    <p class="mt-3">
                                        Évaluation actuelle : 
                                        <span id="current-evaluation" class="d-inline-flex align-items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $agent->evaluation)
                                                    <!-- Étoile jaune (pleine) -->
                                                    <i class="fas fa-star text-warning" aria-hidden="true"></i>
                                                @else
                                                    <!-- Étoile blanche (vide) -->
                                                    <i class="far fa-star text-secondary" aria-hidden="true"></i>
                                                @endif
                                            @endfor
                                        </span>
                                    </p>

                                </div>
                            </div>
                        </div>

                    </div>
                    @else
                    <div class="alert alert-warning text-center mt-4">
                        <i class="bi bi-exclamation-triangle"></i> Aucun agent immobilier associé à ce locataire.
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const evaluationForm = document.querySelector('#evaluation-form');

        evaluationForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const evaluation = document.querySelector('#evaluation').value;
            const agentId = {{ $agent->id }}; // Assurez-vous que $agent est défini

            fetch(`/agent/evaluation/${agentId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ evaluation }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau ou serveur.');
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        document.querySelector('#current-evaluation').innerText = data.evaluation;
                        alert(data.success);
                    } else if (data.error) {
                        alert(data.error);
                    }
                })
                .catch((error) => console.error('Erreur:', error));
        });
    });
</script>


@endsection
