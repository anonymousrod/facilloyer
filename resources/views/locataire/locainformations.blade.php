@extends('layouts.master_dash')
@section('title', 'Informations du Locataire')

@section('styles')
<style>
    .profile-card {
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.08);
        border-radius: 15px;
    }

    .profile-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        padding: 2rem;
        border-radius: 15px 15px 0 0;
        position: relative;
        overflow: hidden;
    }

    .profile-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E") repeat;
        opacity: 0.1;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        transition: transform 0.2s;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .info-table th {
        color: #6c757d;
        font-weight: 600;
        width: 40%;
    }

    .payment-history {
        max-height: 400px;
        overflow-y: auto;
    }

    .payment-item {
        transition: all 0.2s;
        border-left: 4px solid transparent;
    }

    .payment-item:hover {
        background: #f8f9fa;
        border-left-color: #4e73df;
    }

    .property-card {
        transition: all 0.3s;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .badge-outline {
        background: transparent;
        border: 1px solid currentColor;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="profile-card card mb-4">
        <!-- En-tête du profil -->
        <div class="profile-header text-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">{{ $locataire->nom }} {{ $locataire->prenom }}</h3>
                    <div class="d-flex flex-wrap gap-3">
                        <span><i class="fas fa-envelope me-2"></i>{{ $locataire->user->email }}</span>
                        <span><i class="fas fa-phone me-2"></i>{{ $locataire->telephone ?? 'Non renseigné' }}</span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    @if(auth()->user()->id_role === 2)
                        <a href="{{ route('locataire.show', $locataire->id) }}" class="btn btn-light">
                            <i class="fas fa-edit me-2"></i>Modifier le profil
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Statistiques de paiement -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <h6 class="text-primary mb-2">Total payé</h6>
                        <h3 class="mb-0">{{ number_format($statsPaiements['total_paye'], 2, ',', ' ') }} €</h3>
                        <small class="text-muted">Cumul des paiements effectués</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h6 class="text-warning mb-2">Montant restant</h6>
                        <h3 class="mb-0">{{ number_format($statsPaiements['montant_restant'], 2, ',', ' ') }} €</h3>
                        <small class="text-muted">À régler pour la période en cours</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h6 class="text-success mb-2">Total période</h6>
                        <h3 class="mb-0">{{ number_format($statsPaiements['montant_total_periode'], 2, ',', ' ') }} €</h3>
                        <small class="text-muted">Montant total de la période</small>
                    </div>
                </div>
            </div>

            <!-- Informations personnelles et professionnelles -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-circle me-2 text-primary"></i>
                                Informations personnelles
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table info-table">
                                <tr>
                                    <th>Adresse</th>
                                    <td>{{ $locataire->adresse }}</td>
                                </tr>
                                <tr>
                                    <th>Date de naissance</th>
                                    <td>{{ $locataire->date_naissance ? $locataire->date_naissance->format('d/m/Y') : 'Non renseigné' }}</td>
                                </tr>
                                <tr>
                                    <th>Situation familiale</th>
                                    <td>{{ $locataire->statut_matrimoniale }}</td>
                                </tr>
                                <tr>
                                    <th>Personnes à charge</th>
                                    <td>{{ $locataire->nombre_personne_foyer }} personne(s)</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-briefcase me-2 text-primary"></i>
                                Situation professionnelle
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table info-table">
                                <tr>
                                    <th>Statut</th>
                                    <td>{{ $locataire->statut_professionnel }}</td>
                                </tr>
                                <tr>
                                    <th>Revenu mensuel</th>
                                    <td>{{ number_format($locataire->revenu_mensuel, 2, ',', ' ') }} €</td>
                                </tr>
                                <tr>
                                    <th>Garant</th>
                                    <td>{{ $locataire->garant ?: 'Non renseigné' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique des paiements -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Derniers paiements
                    </h5>
                </div>
                <div class="card-body payment-history">
                    @forelse($statsPaiements['derniers_paiements'] as $paiement)
                        <div class="payment-item p-3 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <i class="far fa-calendar-alt me-2 text-muted"></i>
                                    {{ $paiement->date->format('d/m/Y') }}
                                </div>
                                <div class="col-md-3">
                                    <strong>{{ number_format($paiement->montant, 2, ',', ' ') }} €</strong>
                                </div>
                                <div class="col-md-3">
                                    {{ $paiement->bien->designation ?? 'Bien non spécifié' }}
                                </div>
                                <div class="col-md-3 text-end">
                                    <span class="badge {{ $paiement->montant_restant > 0 ? 'bg-warning' : 'bg-success' }}">
                                        {{ $paiement->montant_restant > 0 ? 'Reste ' . number_format($paiement->montant_restant, 2, ',', ' ') . ' €' : 'Soldé' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucun paiement enregistré</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Biens loués -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-home me-2 text-primary"></i>
                        Biens loués
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @forelse($biensLoues as $location)
                            @if($location['bien'])
                                <div class="col-md-6">
                                    <div class="property-card card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">{{ $location['bien']->designation }}</h5>
                                            <p class="text-muted mb-3">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                {{ $location['bien']->adresse_bien }}
                                            </p>
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Loyer mensuel</small>
                                                    <strong>{{ number_format($location['contrat']['loyer_mensuel'], 2, ',', ' ') }} €</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Dépôt de garantie</small>
                                                    <strong>{{ number_format($location['contrat']['depot_garantie'], 2, ',', ' ') }} €</strong>
                                                </div>
                                               
                                                
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Périodicité</small>
                                                    <strong>{{ $location['contrat']['periode_paiement'] }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="col-12 text-center py-4">
                                <i class="fas fa-home fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucun bien loué actuellement</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection