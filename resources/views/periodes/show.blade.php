@extends('layouts.master_dash')

@section('content')
    <style>
        /* Styles personnalisés */
        .card-header {
            background: linear-gradient(45deg, #1E88E5, #42A5F5);
            color: #fff;
            border-radius: 8px 8px 0 0;
        }

        .card {
            border-radius: 8px;
            overflow: hidden;
        }

        h3, h5 {
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
        }

        p {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            line-height: 1.6;
        }

        .btn-success {
            background: #66BB6A;
            border: none;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-success:hover {
            background: #43A047;
            transform: scale(1.05);
        }

        .btn-success i {
            margin-right: 5px;
        }

        hr {
            border: 0;
            border-top: 1px solid #E0E0E0;
            margin: 15px 0;
        }

        @media (max-width: 768px) {
            h3 {
                font-size: 20px;
            }

            h5 {
                font-size: 18px;
            }

            p {
                font-size: 14px;
            }

            .btn-success {
                font-size: 14px;
                padding: 10px 20px;
            }
        }
    </style>

    <div class="container my-4">
        <div class="card shadow-lg border-0">
            <div class="card-header text-center py-3">
                <h3 class="mb-0">Paiement De ce Mois</h3>
            </div>
            <div class="card-body p-4">
                {{-- Informations du locataire --}}
                <div class="mb-4">
                    <h5 class="text-primary">Informations du locataire</h5>
                    <p class="mb-1"><strong>Nom :</strong> {{ $periode->locataire->nom }} {{ $periode->locataire->prenom }}</p>
                </div>
                <hr>

                {{-- Informations sur le bien --}}
                <div class="mb-4">
                    <h5 class="text-primary">Détails du bien</h5>
                    <p class="mb-1"><strong>Adresse :</strong> {{ $periode->contratDeBail->bien->adresse_bien}}</p>
                    <p class="mb-1"><strong>Type :</strong> {{ $periode->contratDeBail->bien->type_bien}}</p>
                </div>
                <hr>

                {{-- Informations sur la période --}}
                <div class="mb-4">
                    <h5 class="text-primary">Période de facturation</h5>
                    <p class="mb-1"><strong>Du :</strong> {{ \Carbon\Carbon::parse($periode->date_debut_periode)->format('d/m/Y') }}</p>
                    <p class="mb-1"><strong>Au :</strong> {{ \Carbon\Carbon::parse($periode->date_fin_periode)->format('d/m/Y') }}</p>
                </div>
                <hr>

                {{-- Informations financières --}}
                <div class="mb-4">
                    <h5 class="text-primary">Avnt de continuer</h5>
                    <!-- <p class="mb-1"><strong>Montant total :</strong> {{ number_format($periode->montant_total_periode, 2) }} FCFA</p> -->
                    <!-- <p class="mb-1"><strong>Complément :</strong> {{ number_format($periode->complement_periode, 2) }} FCFA</p> -->
                    <p class="mb-1"><strong>IMPORTANT  :</strong> 
                        <span class="text-danger font-weight-bold">
                            Verifiez que le paiement a affectué est pour ce Bien et cette periode !!
                        </span>

                    </p>
                    <!-- <p class="mb-1"><strong>Montant restant :</strong>  -->
                        <!-- <span class="text-danger font-weight-bold">
                            {{ number_format($periode->montant_restant_periode, 2) }} FCFA
                        </span> -->
                    

                    <!-- </p> -->
                </div>
                <hr>

                {{-- Bouton pour effectuer un paiement --}}
                <div class="text-center">
                    <a href="o.p" class="btn btn-success btn-lg shadow">
                        <i class="fas fa-credit-card"></i> Effectuer un paiement
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
