@extends('layouts.master_dash')
<style>
            /* locataire-profile.css */

        /* Styles généraux */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .profile-photo {
            transform: translateY(-50%);
            transition: transform 0.3s ease-in-out;
        }

        .profile-photo img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 4px solid white;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .profile-photo img:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .info-box {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .info-box:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .btn {
            border-radius: 30px;
            padding: 10px 20px;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-outline-primary {
            color: #007bff;
            border-color: #007bff;
        }

        .btn-outline-primary:hover {
            color: #ffffff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

</style>
@section('content')
<link rel="stylesheet" href="{{ asset('css/locataire-profile.css') }}">

<div class="container py-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <!-- En-tête avec image de fond -->
                <div class="card-header" style="background-image: url('{{ asset('images/header-bg.jpg') }}');">
                    <div class="profile-photo text-center">
                        @if($locataire->photo_profil)
                            <img src="{{ asset($locataire->photo_profil) }}" alt="Photo de Profil">
                        @else
                            <img src="https://via.placeholder.com/120" alt="Photo de Profil">
                        @endif
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="card-body pt-5">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">{{ $locataire->prenom }} {{ $locataire->nom }}</h4>
                        <p class="text-muted mb-0">
                            <i class="bi bi-calendar3"></i> Locataire depuis {{ $locataire->created_at->format('d/m/Y') }}
                        </p>
                    </div>

                    <!-- Section Informations -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <h6 class="fw-bold text-primary"><i class="bi bi-info-circle"></i> Informations Personnelles</h6>
                                <p><i class="bi bi-person"></i> <strong>Nom :</strong> {{ $locataire->prenom }} {{ $locataire->nom }}</p>
                                <p><i class="bi bi-calendar"></i> <strong>Date de naissance :</strong> {{ $locataire->date_naissance->format('d/m/Y') }}</p>
                                <p><i class="bi bi-gender-ambiguous"></i> <strong>Genre :</strong> {{ ucfirst($locataire->genre) }}</p>
                                <p><i class="bi bi-geo-alt"></i> <strong>Adresse :</strong> {{ $locataire->adresse }}</p>
                                <p><i class="bi bi-telephone"></i> <strong>Téléphone :</strong> {{ $locataire->telephone }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <h6 class="fw-bold text-primary"><i class="bi bi-briefcase"></i> Informations Professionnelles</h6>
                                <p><i class="bi bi-cash-coin"></i> <strong>Revenu Mensuel :</strong> {{ number_format($locataire->revenu_mensuel, 2, ',', ' ') }} FCFA</p>
                                <p><i class="bi bi-person-workspace"></i> <strong>Statut :</strong> {{ $locataire->statut_professionnel }}</p>
                                <p><i class="bi bi-people"></i> <strong>Matrimonial :</strong> {{ $locataire->statut_matrimoniale }}</p>
                                <p><i class="bi bi-person-check"></i> <strong>Garant :</strong> {{ $locataire->garant ?? 'Non renseigné' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Foyer -->
                    <div class="info-box">
                        <h6 class="fw-bold text-primary"><i class="bi bi-house-door"></i> Informations sur le Foyer</h6>
                        <p><i class="bi bi-people"></i> <strong>Nombre de personnes dans le foyer :</strong> {{ $locataire->nombre_personne_foyer }}</p>
                    </div>

                    <!-- Boutons Actions -->
                    <div class="text-center mt-4">
                        <a href="{{ route('admin.locataires_par_agence') }}" class="btn btn-outline-primary me-2">
                            <i class="bi bi-arrow-left"></i> Retour à la liste
                        </a>
                        <!-- <a href="#" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i> Modifier le Profil
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
