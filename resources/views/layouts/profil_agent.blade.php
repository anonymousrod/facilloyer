@extends('layouts.master_dash')
@section('title', 'Mon profil')
@section('content')
    {{-- @if ($message)
        <div class="alert alert-warning text-center fade show" role="alert">
            <h5 class="text-warning mb-0">{{ $message }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}
    <div class="container-xxl py-4">
        {{-- Section Profil --}}
        <div class="row justify-content-center mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            {{-- Photo de profil et informations principales --}}
                            <div class="col-lg-4 text-center text-lg-start mb-3 mb-lg-0">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset($agent->photo_profil) }}" alt="Photo de profil" height="120"
                                        class="rounded-circle shadow-sm">
                                </div>
                                <div class="mt-3">
                                    <h5 class="fw-bold fs-4 mb-1 text-primary">
                                        {{ \Illuminate\Support\Str::words($agent->nom_agence, 2, '...') }}
                                    </h5>
                                    <p class="mb-0 text-muted">{{ $agent->nom_admin }} {{ $agent->prenom_admin }}</p>
                                    <p class="text-muted mb-0">{{ $agent->telephone_agence }}</p>
                                </div>
                            </div>
                            {{-- Statistiques principales --}}
                            <div class="col-lg-8">
                                <div class="d-flex justify-content-around text-center">
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-3 text-success">{{ $agent->annee_experience }}</h5>
                                        <p class="text-muted mb-0">Années d'expérience</p>
                                    </div>
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-3 text-info">{{ $agent->nombre_bien_disponible }}</h5>
                                        <p class="text-muted mb-0">Biens disponibles</p>
                                    </div>
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-3 text-warning">{{ $Nlocataire }}</h5>
                                        <p class="text-muted mb-0">Locataires</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Informations personnelles --}}
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #28a745, #85e085);">
                        <h4 class="card-title mb-0 text-white">Informations personnelles</h4>
                        <a href="http://127.0.0.1:8000/agent-immobilier/create" class="btn btn-light btn-sm shadow-sm">
                            <i class="iconoir-edit-pencil me-1"></i> Modifier
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p><strong class="fs-5" style="color: #212121;">Nom de l'agence:</strong> {{ $agent->nom_agence }}</p>
                                <p><strong class="fs-5" style="color: #212121;">Nom de l'administrateur:</strong> {{ $agent->nom_admin }} {{ $agent->prenom_admin }}</p>
                                <p><strong class="fs-5" style="color: #212121;">Adresse de l'agence:</strong> {{ $agent->adresse_agence }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p><strong class="fs-5" style="color: #212121;">Territoire couvert:</strong> {{ $agent->territoire_couvert }}</p>
                                <p><strong class="fs-5" style="color: #212121;">Nombre de biens disponibles:</strong> {{ $agent->nombre_bien_disponible }}</p>
                                <p><strong class="fs-5" style="color: #212121;">Numéro de téléphone:</strong> {{ $agent->telephone_agence }}</p>
                                <p><strong class="fs-5" style="color: #212121;">Années d'expérience:</strong> {{ $agent->annee_experience }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
