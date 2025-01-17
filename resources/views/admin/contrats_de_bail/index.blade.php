@extends('layouts.master_dash')

@section('content')
    <!-- Message de confirmation -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Gestion des Contrats de Bail</h5>

            <!-- Champ de recherche interactif -->
            <div class="position-relative">
                <button id="searchToggle" class="btn btn-light border">
                    <i class="fas fa-search"></i> Rechercher
                </button>
                <form id="searchForm" method="GET" action="{{ route('admin.contrats_de_bail.index') }}" class="d-none position-absolute top-100 start-50 translate-middle-x mt-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher par nom de locataire ou agence" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bouton pour ouvrir le formulaire modale -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createContractModal">
            <i class="fas fa-plus"></i> Ajouter un Contrat
        </button>

        <!-- Table des contrats -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Contrat ID</th>
                        <th>Bien</th>
                        <th>Locataire</th>
                        <th>Agence</th>
                        <th>Date Début</th>
                        <th>Date Fin</th>
                        <th>Loyer Mensuel</th>
                        <th>Dépôt de Garantie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contrats as $contrat)
                        <tr>
                            <td>{{ $contrat->id }}</td>
                            <td>{{ $contrat->bien->adresse_bien }}</td>
                            <td>{{ $contrat->contrat_de_bail_locataires->first()->locataire->nom ?? 'Non assigné' }}</td>
                            <td>{{ $contrat->bien->agent_immobilier->nom_agence ?? 'Non assigné' }}</td>
                            <td>{{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($contrat->date_fin)->format('d/m/Y') }}</td>
                            <td>{{ $contrat->loyer_mensuel }} XOF</td>
                            <td>{{ $contrat->depot_de_garantie }} XOF</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.contrats_de_bail.show', $contrat->id) }}" class="btn btn-warning btn-sm">Détail</a>
                                <form action="{{ route('admin.contrats_de_bail.destroy', $contrat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modale pour ajouter un nouveau contrat -->
    <div class="modal fade" id="createContractModal" tabindex="-1" aria-labelledby="createContractModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.contrats_de_bail.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createContractModalLabel">Créer un Nouveau Contrat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bien_id" class="form-label">Bien</label>
                            <select name="bien_id" id="bien_id" class="form-control" required>
                                <option value="">-- Sélectionner un bien --</option>
                                @foreach($biens as $bien)
                                    <option value="{{ $bien->id }}">{{ $bien->adresse_bien }} ({{ $bien->agent_immobilier->nom_agence }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="locataire_id" class="form-label">Locataire</label>
                            <select name="locataire_id" id="locataire_id" class="form-control" required>
                                <option value="">-- Sélectionner un locataire --</option>
                                @foreach($locataires as $locataire)
                                    <option value="{{ $locataire->id }}">{{ $locataire->nom }} {{ $locataire->prenom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de Début</label>
                            <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de Fin</label>
                            <input type="date" name="date_fin" id="date_fin" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="loyer_mensuel" class="form-label">Loyer Mensuel (XOF)</label>
                            <input type="number" name="loyer_mensuel" id="loyer_mensuel" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="depot_de_garantie" class="form-label">Dépôt de Garantie (XOF)</label>
                            <input type="number" name="depot_de_garantie" id="depot_de_garantie" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts pour gérer l'interaction -->
    <script>
        document.getElementById('searchToggle').addEventListener('click', function () {
            const searchForm = document.getElementById('searchForm');
            searchForm.classList.toggle('d-none');
        });
    </script>
@endsection
