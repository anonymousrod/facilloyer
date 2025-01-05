@extends('layouts.master_dash')

@section('content')
<div class="container-xxl mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Agent Header -->
            <div class="card mb-4 shadow-lg">
                <div class="card-body text-center">
                    <div class="d-flex flex-column align-items-center">
                        <!-- Photo de profil -->
                        @if ($agent->photo_profil)
                            <img src="{{ asset('uploads/agents/' . $agent->photo_profil) }}" 
                                 alt="Photo de profil" 
                                 class="rounded-circle shadow" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" 
                                 alt="Avatar par défaut" 
                                 class="rounded-circle shadow" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @endif

                        <!-- Nom et Agence -->
                        <h3 class="mt-3 text-primary">{{ $agent->nom_admin }} {{ $agent->prenom_admin }}</h3>
                        <p class="text-muted mb-2">Agence : <strong>{{ $agent->nom_agence }}</strong></p>
                        <p class="text-muted">Téléphone : <strong>{{ $agent->telephone_agence }}</strong></p>
                        <div class="badge bg-success fs-6 px-3 py-2 mb-3">Évaluation : {{ $agent->evaluation }} ★</div>

                        <!-- Bouton Activer/Désactiver -->
                        <form action="{{ route('agents.updateStatus', $agent->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            @if ($agent->deleted_at)
                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fas fa-check-circle"></i> Activer
                                </button>
                            @else
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-ban"></i> Désactiver
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Informations Générales -->
            <div class="card mb-4 shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations de l'Agence</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nom de l'agence :</strong> {{ $agent->nom_agence }}</li>
                        <li class="list-group-item"><strong>Adresse :</strong> {{ $agent->adresse_agence }}</li>
                        <li class="list-group-item"><strong>Années d'expérience :</strong> {{ $agent->annee_experience }} ans</li>
                        <li class="list-group-item"><strong>Territoire couvert :</strong> {{ $agent->territoire_couvert }}</li>
                        <li class="list-group-item"><strong>Biens disponibles :</strong> {{ $agent->nombre_bien_disponible }}</li>
                    </ul>
                </div>
            </div>

            <!-- Documents -->
            <div class="card mb-4 shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Documents</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Carte d'identité :</strong>
                            @if ($agent->carte_identite_pdf)
                                <a href="{{ asset('uploads/documents/' . $agent->carte_identite_pdf) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary ms-2">Voir</a>
                            @else
                                <span class="text-danger">Non disponible</span>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <strong>RCCM :</strong>
                            @if ($agent->rccm_pdf)
                                <a href="{{ asset('uploads/documents/' . $agent->rccm_pdf) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary ms-2">Voir</a>
                            @else
                                <span class="text-danger">Non disponible</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Biens Associés -->
            <div class="card mb-4 shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Biens Associés</h5>
                </div>
                <div class="card-body">
                    @if ($agent->biens->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Adresse</th>
                                        <th>Type</th>
                                        <th>Loyer Mensuel</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agent->biens as $bien)
                                        <tr>
                                            <td>{{ $bien->adresse_bien }}</td>
                                            <td>{{ $bien->type_bien }}</td>
                                            <td>{{ number_format($bien->loyer_mensuel, 2) }} €</td>
                                            <td>{{ $bien->statut_bien }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Aucun bien associé.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
