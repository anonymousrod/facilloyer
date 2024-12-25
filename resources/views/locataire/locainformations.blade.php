@extends('layouts.master_dash')
@section('title', 'Mon Espace Locataire')

@section('styles')
<style>
    .dashboard-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .profile-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: url('data:image/svg+xml,...') center/cover;
        opacity: 0.1;
    }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1rem;
        margin: -1rem 1rem 0;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.25rem;
    }

    .transactions-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .transaction-item {
        padding: 1rem;
        border-left: 4px solid transparent;
        transition: all 0.2s;
    }

    .transaction-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
    }

    @media (max-width: 768px) {
        .quick-stats {
            grid-template-columns: 1fr;
        }
        
        .profile-header {
            text-align: center;
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête du profil -->
    <div class="dashboard-card">
        <div class="profile-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2">PROFILE, {{ $locataire->user->name }}</h1>
                    <div class="d-flex align-items-center gap-4">
                        <span><i class="fas fa-envelope me-2"></i>{{ $locataire->user->email }}</span>
                        <span><i class="fas fa-phone me-2"></i>{{ $locataire->telephone ?? 'Non renseigné' }}</span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    @if(auth()->user()->id_role === 2)
                        <a href="{{ route('locataire.show', $locataire->id) }}" class="btn btn-light">
                            <i class="fas fa-edit me-2"></i>Modifier mes informations
                        </a>
                    @endif
                    @if(auth()->user()->id_role === 1)
                        <a href="{{ route('locataire.edit', $locataire->id) }}" class="btn btn-light">
                            <i class="fas fa-edit me-2"></i>Modifier mes informations
                        </a>
                    @endif
                </div>
            </div>
        </div>

        
    </div>

    <div class="dashboard-card p-4 mt-4">
   <!-- Dans la section Profile -->
       

        <div class="row g-4">
            <!-- Informations personnelles -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3">
                    <h3 class="h6 mb-3 text-primary">
                        <i class="fas fa-user-circle me-2"></i>Identité
                    </h3>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Nom complet</small>
                            <span class="fw-medium">{{ $locataire->nom }} {{ $locataire->prenom }}</span>
                        </div>
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Date de naissance</small>
                            <span class="fw-medium">{{ \Carbon\Carbon::parse($locataire->date_naissance)->format('d/m/Y') }}</span>
                        </div>
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Genre</small>
                            <span class="fw-medium">{{ $locataire->genre }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coordonnées -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3">
                    <h3 class="h6 mb-3 text-primary">
                        <i class="fas fa-address-card me-2"></i>Coordonnées
                    </h3>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Adresse</small>
                            <span class="fw-medium">{{ $locataire->adresse }}</span>
                        </div>
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Téléphone</small>
                            <span class="fw-medium">{{ $locataire->telephone }}</span>
                        </div>
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Email</small>
                            <span class="fw-medium">{{ $locataire->user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Situation professionnelle -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3">
                    <h3 class="h6 mb-3 text-primary">
                        <i class="fas fa-briefcase me-2"></i>Situation Professionnelle
                    </h3>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Statut professionnel</small>
                            <span class="fw-medium">{{ $locataire->statut_professionnel }}</span>
                        </div>
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Revenu mensuel</small>
                            <span class="fw-medium">{{ number_format($locataire->revenu_mensuel, 2, ',', ' ') }}€</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Situation personnelle -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3">
                    <h3 class="h6 mb-3 text-primary">
                        <i class="fas fa-home me-2"></i>Situation Personnelle
                    </h3>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Statut matrimonial</small>
                            <span class="fw-medium">{{ $locataire->statut_matrimoniale }}</span>
                        </div>
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Nombre de personnes dans le foyer</small>
                            <span class="fw-medium">{{ $locataire->nombre_personne_foyer }} personne(s)</span>
                        </div>
                        <div class="list-group-item bg-transparent px-0 py-2">
                            <small class="text-muted d-block">Garant</small>
                            <span class="fw-medium">{{ $locataire->garant ?: 'Non renseigné' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations sur le bien loué -->
            <div class="col-md-12">
                <div class="p-3 bg-light rounded-3">
                    <h3 class="h6 mb-3 text-primary">
                        <i class="fas fa-building me-2"></i>Bien(s) Loué(s)
                    </h3>
                    <div class="list-group list-group-flush">
                        @forelse($biensLoues as $key => $location)
                            @if($location['bien'])
                                <div class="list-group-item bg-transparent px-0 py-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Type de bien</small>
                                            <span class="fw-medium">{{ $location['bien']->type_bien }}</span>
                                            
                                            <small class="text-muted d-block mt-2">Adresse</small>
                                            <span class="fw-medium">{{ $location['bien']->adresse_bien }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Caractéristiques</small>
                                            <span class="fw-medium">
                                                {{ $location['bien']->nombre_de_piece }} pièces - {{ $location['bien']->superficie }}m²
                                            </span>

                                            <small class="text-muted d-block mt-2">Loyer mensuel</small>
                                            <span class="fw-medium">{{ number_format($location['bien']->loyer_mensuel, 2, ',', ' ') }}€</span>
                                            
                                            <small class="text-muted d-block mt-2">Année de construction</small>
                                            <span class="fw-medium">{{ $location['bien']->annee_construction }}</span>
                                        </div>
                                    </div>
                                    @if($location['bien']->description)
                                        <div class="mt-2">
                                            <small class="text-muted d-block">Description</small>
                                            <span class="fw-medium">{{ $location['bien']->description }}</span>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <small class="text-muted d-block">Statut</small>
                                        <span class="badge {{ $location['bien']->statut_bien === 'Loué' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $location['bien']->statut_bien }}
                                        </span>
                                    </div>
                                </div>
                                @if($key !== count($biensLoues) - 1)
                                    <hr class="my-3">
                                @endif
                            @endif
                        @empty
                            <div class="list-group-item bg-transparent px-0 py-2">
                                <span class="text-muted">Aucun bien loué actuellement</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Dernières transactions -->
        <div class="col-lg-8">
            <div class="dashboard-card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0">Dernières transactions</h2>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-list me-1"></i>Voir tout
                    </a>
                </div>
                <div class="transactions-list">
                    @forelse($locataire->paiements->sortByDesc('date')->take(5) as $paiement)
                        <div class="transaction-item border-start {{ $paiement->status === 'Payé' ? 'border-success' : 'border-warning' }}">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <i class="fas fa-calendar-alt me-2 text-muted"></i>
                                    {{ \Carbon\Carbon::parse($paiement->date)->format('d/m/Y') }}
                                </div>
                                <div class="col-md-3">
                                    <span class="fw-bold">{{ number_format($paiement->montant, 2, ',', ' ') }}€</span>
                                </div>
                                <div class="col-md-3">
                                    <i class="fas fa-credit-card me-2 text-muted"></i>
                                    {{ $paiement->mode_paiement }}
                                </div>
                                <div class="col-md-3 text-end">
                                    <span class="badge {{ $paiement->status === 'Payé' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $paiement->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Aucune transaction récente</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Agent Immobilier -->
        <div class="col-lg-4">
            <div class="dashboard-card p-3">
                <h2 class="h5 mb-3">Mon agent immobilier</h2>
                <div class="text-center p-3 border rounded-3 bg-light">
                    <i class="fas fa-user-tie fa-2x text-primary mb-3"></i>
                    <h5 class="mb-2">{{ $locataire->agent_immobilier->nom_agence ?? 'Non assigné' }}</h5>
                    <p class="mb-2">
                        {{ $locataire->agent_immobilier->nom_admin ?? 'N/A' }} 
                        {{ $locataire->agent_immobilier->prenom_admin ?? '' }}
                    </p>
                    <hr class="my-3">
                    <div class="d-flex flex-column gap-2">
                        <a href="tel:{{ $locataire->agent_immobilier->telephone_agence ?? '' }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-phone me-2"></i>Contacter
                        </a>
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $locataire->agent_immobilier->adresse_agence ?? 'Adresse non renseignée' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier les informations -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier mes informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Formulaire de modification -->
                <form action="{{ route('locataire.update', $locataire->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" name="telephone" value="{{ $locataire->telephone }}">
                    </div>
                    <!-- Ajoutez d'autres champs selon vos besoins -->
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection