@extends('layouts.master_dash')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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

                        
                    </div>
                    @else
                    <div class="alert alert-warning text-center mt-4">
                        <i class="bi bi-exclamation-triangle"></i> Aucun agent immobilier associé à ce locataire.
                    </div>
                    @endif

                    <!-- Boutons d'action -->
                    <div class="mt-4 text-center">
                        <a href="ok.gf" class="btn btn-danger mx-2">
                            <i class="bi bi-envelope-exclamation"></i> Faire une réclamation
                        </a>
                        <a href="#" class="btn btn-primary mx-2">
                        <i class="bi bi-telephone-forward"></i> Contacter l'agent
                        </a>
                        <a href="#" class="btn btn-success mx-2">
                        <i class="bi bi-house"></i> Voir les nouveaux bien disponible
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
