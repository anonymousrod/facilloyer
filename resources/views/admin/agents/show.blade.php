@extends('layouts.master_dash')

@section('content')
<div class="container-xxl mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Section (Banner + Avatar) -->
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-body p-0">
                    <!-- Banner Image -->
                    <div class="position-relative">
                        <img src="{{ asset('images/profile-banner.jpg') }}" alt="Banner" class="img-fluid w-100" style="height: 250px; object-fit: cover;">
                    </div>

                    <div class="position-absolute top-50 start-50 translate-middle">
                        <!-- Profile Avatar -->
                        <div class="rounded-circle overflow-hidden shadow" style="width: 150px; height: 150px;">
                            @if ($agent->photo_profil)
                                <img src="{{ asset('uploads/agents/' . $agent->photo_profil) }}" 
                                     alt="Photo de profil" 
                                     class="img-fluid" 
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" 
                                     alt="Avatar par défaut" 
                                     class="img-fluid" 
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Info Section -->
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-body">
                    <h3 class="text-primary">{{ $agent->nom_admin }} {{ $agent->prenom_admin }}</h3>
                    <p class="text-muted">Agence : <strong>{{ $agent->nom_agence }}</strong></p>
                    <p class="text-muted">Téléphone : <strong>{{ $agent->telephone_agence }}</strong></p>
                    <p class="text-muted">Évaluation : <strong>{{ $agent->evaluation }} ★</strong></p>

                    <!-- Button to toggle activation status -->
                    <form action="{{ route('agents.updateStatus', $agent->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @if ($agent->deleted_at)
                            <button type="submit" class="btn btn-outline-success w-100">
                                <i class="fas fa-check-circle"></i> Activer
                            </button>
                        @else
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-ban"></i> Désactiver
                            </button>
                        @endif
                    </form>
                </div>
            </div>

            <!-- About Agent (General Info Section) -->
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-header bg-light text-dark">
                    <h5 class="mb-0">À propos de l'Agent</h5>
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

            <!-- Documents Section (Similar to a Facebook "About" section) -->
            <div class="card shadow-lg border-0 rounded-3 mb-4">
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
                                   class="btn btn-sm btn-outline-primary ms-2">Voir</a>
                            @else
                                <span class="text-danger">Non disponible</span>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <strong>RCCM :</strong>
                            @if ($agent->rccm_pdf)
                                <a href="{{ asset('uploads/documents/' . $agent->rccm_pdf) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary ms-2">Voir</a>
                            @else
                                <span class="text-danger">Non disponible</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Associated Properties Section (like Facebook posts section) -->
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Biens Associés</h5>
                </div>
                <div class="card-body">
                    @if ($agent->biens->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
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
                                            <td>{{ number_format($bien->loyer_mensuel, 2) }} FCFA</td>
                                            <td>
                                                <span class="badge 
                                                    @if ($bien->statut_bien == 'Disponible') bg-success 
                                                    @elseif ($bien->statut_bien == 'Réservé') bg-warning 
                                                    @else bg-danger @endif">
                                                    {{ $bien->statut_bien }}
                                                </span>
                                            </td>
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
