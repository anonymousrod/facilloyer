@extends('layouts.master_dash')
@section('title', 'Mon profil')

@section('content')
    <div class="container-xl py-4">

        {{-- Section Profil --}}
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center gy-4 gx-5">

                            {{-- Photo & Infos --}}
                            <div class="col-md-4 text-center">
                                <img src="{{ asset($agent->photo_profil) }}" alt="Photo de profil"
                                     class="rounded-circle border border-3 border-success shadow-sm" width="120" height="120">
                                <div class="mt-3">
                                    <h5 class="fw-bold text-dark mb-1">
                                        {{ \Illuminate\Support\Str::words($agent->nom_agence, 2, '...') }}
                                    </h5>
                                    <p class="text-muted mb-0">{{ $agent->nom_admin }} {{ $agent->prenom_admin }}</p>
                                    <p class="text-muted">{{ $agent->telephone_agence }}</p>
                                </div>
                            </div>

                            {{-- Statistiques --}}
                            <div class="col-md-8">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h4 class="fw-bold text-success">{{ $agent->annee_experience }}</h4>
                                        <p class="text-muted small">Années d'expérience</p>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="fw-bold text-info">{{ $agent->nombre_bien_disponible }}</h4>
                                        <p class="text-muted small">Biens disponibles</p>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="fw-bold text-warning">{{ $Nlocataire }}</h4>
                                        <p class="text-muted small">Locataires</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Informations Personnelles --}}
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center"
                         style="background-color: #22B65A;">
                        <h5 class="text-white mb-0">Informations personnelles</h5>
                    </div>
                    <div class="card-body px-4 py-4">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Nom de l'agence :</strong> {{ $agent->nom_agence }}</p>
                                <p class="mb-2"><strong>Nom de l'administrateur :</strong> {{ $agent->nom_admin }} {{ $agent->prenom_admin }}</p>
                                <p class="mb-2"><strong>Adresse de l'agence :</strong> {{ $agent->adresse_agence }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Territoire couvert :</strong> {{ $agent->territoire_couvert }}</p>
                                <p class="mb-2"><strong>Biens disponibles :</strong> {{ $agent->nombre_bien_disponible }}</p>
                                <p class="mb-2"><strong>Téléphone :</strong> {{ $agent->telephone_agence }}</p>
                                <p class="mb-0"><strong>Années d'expérience :</strong> {{ $agent->annee_experience }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
