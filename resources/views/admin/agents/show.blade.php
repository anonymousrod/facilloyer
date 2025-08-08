@extends('layouts.master_dash')

@section('content')
<div class="container-xxl pt-3">
    <div class="row justify-content-center g-3">
        <div class="col-lg-10">
            <!-- Bannière + Avatar -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
                <div class="position-relative" style="height: 220px;">
                    <img src="{{ asset('images/profile-banner.jpeg') }}" class="w-100 h-100 object-fit-cover" alt="Bannière">
                    <div class="position-absolute bottom-0 start-50 translate-middle-x" style="transform: translateY(50%);">
                        <div class="rounded-circle overflow-hidden shadow" style="width: 130px; height: 130px;">
                            <img src="{{ $agent->photo_profil ? asset($agent->photo_profil) : asset('images/default-avatar.png') }}" class="w-100 h-100 object-fit-cover" alt="Avatar">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Infos principales -->
            <div class="card border-0 shadow-sm rounded-4 text-center pt-5 pb-3 mb-3">
                <h4 class="fw-bold text-primary">{{ $agent->nom_admin }} {{ $agent->prenom_admin }}</h4>
                <p class="text-muted mb-1"><i class="bi bi-building me-1 text-primary"></i><strong>{{ $agent->nom_agence }}</strong></p>
                <p class="text-muted mb-1"><i class="bi bi-telephone me-1 text-success"></i>{{ $agent->telephone_agence }}</p>
                <p class="text-muted"><i class="bi bi-star-fill me-1 text-warning"></i><strong>{{ $agent->evaluation }} ★</strong></p>
            </div>

            <!-- À propos -->
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-light fw-semibold text-dark">
                    <i class="bi bi-person-lines-fill me-2 text-secondary"></i>À propos
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Adresse :</strong> {{ $agent->adresse_agence }}</li>
                    <li class="list-group-item"><strong>Expérience :</strong> {{ $agent->annee_experience }} ans</li>
                    <li class="list-group-item"><strong>Territoire :</strong> {{ $agent->territoire_couvert }}</li>
                    <li class="list-group-item"><strong>Biens disponibles :</strong> {{ $agent->nombre_bien_disponible }}</li>
                </ul>
            </div>

            <!-- Documents -->
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-success text-white fw-semibold">
                    <i class="bi bi-file-earmark-text me-2"></i>Documents
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Carte d'identité :</strong>
                        @if ($agent->carte_identite_pdf)
                            <a href="{{ asset($agent->carte_identite_pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">Voir</a>
                        @else
                            <span class="text-danger">Non disponible</span>
                        @endif
                    </li>
                    <li class="list-group-item">
                        <strong>RCCM :</strong>
                        @if ($agent->rccm_pdf)
                            <a href="{{ asset($agent->rccm_pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">Voir</a>
                        @else
                            <span class="text-danger">Non disponible</span>
                        @endif
                    </li>
                </ul>
            </div>

            <!-- Biens associés -->
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-info text-white fw-semibold">
                    <i class="bi bi-house-door me-2"></i>Biens Associés
                </div>
                <div class="card-body p-0">
                    @if ($agent->biens->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Adresse</th>
                                        <th>Type</th>
                                        <th>Loyer</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agent->biens as $bien)
                                        <tr>
                                            <td>{{ $bien->adresse_bien }}</td>
                                            <td>{{ $bien->type_bien }}</td>
                                            <td>{{ number_format($bien->loyer_mensuel, 0, ',', ' ') }} FCFA</td>
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
                        <p class="text-muted p-3">Aucun bien associé.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bouton d’appel rapide (mobile uniquement) -->
<a href="tel:{{ $agent->telephone_agence }}" class="btn btn-success btn-lg rounded-circle shadow d-md-none position-fixed bottom-0 end-0 m-4">
    <i class="bi bi-telephone-fill"></i>
</a>
@endsection
