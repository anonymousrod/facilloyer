@extends('layouts.master_dash')

@section('title', 'Profil du Locataire')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                {{-- Header avec bannière et avatar --}}
                <div class="card-header p-0 position-relative" style="height: 180px; background-image: linear-gradient(rgba(34, 182, 90, 0.4), rgba(34, 182, 90, 0.4)), url('{{ asset('images/header-bg.jpg') }}'); background-size: cover; background-position: center;">
                    <div class="position-absolute start-50 translate-middle-x" style="bottom: -55px;">
                        <img src="{{ $locataire->photo_profil ? asset($locataire->photo_profil) : 'https://via.placeholder.com/120' }}" 
                             alt="Photo de Profil" 
                             class="rounded-circle border border-3 border-white shadow-lg" 
                             style="width: 110px; height: 110px; object-fit: cover;">
                    </div>
                </div>

                <div class="card-body pt-5">
                    
                    {{-- Nom et date --}}
                    <div class="text-center mb-3">
                        <h4 class="fw-bold text-dark mb-1">{{ $locataire->prenom }} {{ $locataire->nom }}</h4>
                        <small class="text-muted">
                            <i class="bi bi-calendar3"></i> Locataire depuis {{ $locataire->created_at->format('d/m/Y') }}
                        </small>
                    </div>

                    {{-- Infos principales --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <h6 class="fw-bold mb-3" style="color: #22B65A;">
                                    <i class="bi bi-info-circle me-1"></i> Informations Personnelles
                                </h6>
                                <ul class="list-unstyled small mb-0">
                                    <li><i class="bi bi-person me-1"></i> <strong>Nom :</strong> {{ $locataire->prenom }} {{ $locataire->nom }}</li>
                                    <li><i class="bi bi-calendar me-1"></i> <strong>Naissance :</strong> {{ $locataire->date_naissance->format('d/m/Y') }}</li>
                                    <li><i class="bi bi-gender-ambiguous me-1"></i> <strong>Genre :</strong> {{ ucfirst($locataire->genre) }}</li>
                                    <li><i class="bi bi-geo-alt me-1"></i> <strong>Adresse :</strong> {{ $locataire->adresse }}</li>
                                    <li><i class="bi bi-telephone me-1"></i> <strong>Téléphone :</strong> {{ $locataire->telephone }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <h6 class="fw-bold mb-3" style="color: #22B65A;">
                                    <i class="bi bi-briefcase me-1"></i> Informations Professionnelles
                                </h6>
                                <ul class="list-unstyled small mb-0">
                                    <li><i class="bi bi-cash-coin me-1"></i> <strong>Revenu :</strong> {{ number_format($locataire->revenu_mensuel, 0, ',', ' ') }} FCFA</li>
                                    <li><i class="bi bi-person-workspace me-1"></i> <strong>Statut :</strong> {{ $locataire->statut_professionnel }}</li>
                                    <li><i class="bi bi-people me-1"></i> <strong>Matrimonial :</strong> {{ $locataire->statut_matrimoniale }}</li>
                                    <li><i class="bi bi-person-check me-1"></i> <strong>Garant :</strong> {{ $locataire->garant ?? 'Non renseigné' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Foyer --}}
                    <div class="mt-3 border rounded-3 p-3">
                        <h6 class="fw-bold mb-2" style="color: #22B65A;">
                            <i class="bi bi-house-door me-1"></i> Foyer
                        </h6>
                        <p class="small mb-0">
                            <i class="bi bi-people me-1"></i> <strong>Personnes dans le foyer :</strong> {{ $locataire->nombre_personne_foyer }}
                        </p>
                    </div>

                    {{-- Bouton retour --}}
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.locataires_par_agence') }}" 
                           class="btn text-white px-4 rounded-pill" 
                           style="background-color: #22B65A;">
                            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
