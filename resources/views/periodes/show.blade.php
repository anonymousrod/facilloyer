@extends('layouts.master_dash')

@section('content')
    <style>
        .card-header {
            background: linear-gradient(90deg, #4E54C8, #8F94FB);
            color: #fff;
            font-family: 'Roboto', sans-serif;
            font-size: 26px;
            font-weight: bold;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            background: #ffffff;
        }

        h5 {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            color: #4E54C8;
        }

        p {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            color: #555;
            line-height: 1.8;
        }

        .btn-success {
            background: linear-gradient(90deg, #FF9800, #FFC107);
            color: #fff;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: bold;
            padding: 12px 30px;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 4px 10px rgba(255, 152, 0, 0.4);
        }

        .btn-success:hover {
            background: linear-gradient(90deg, #F57C00, #FFA726);
            transform: translateY(-3px);
            box-shadow: 0px 6px 15px rgba(255, 152, 0, 0.6);
        }

        .important-warning {
            background: #F44336;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            font-weight: bold;
            animation: pulse 1.5s infinite;
            text-align: center;
            margin-top: 20px;
        }

        .info-empty {
            background-color: #f9f9f9;
            border: 2px dashed #ccc;
            padding: 40px;
            text-align: center;
            border-radius: 12px;
        }

        .info-empty h4 {
            color: #4E54C8;
            font-weight: bold;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 10px rgba(255, 87, 34, 0.5);
            }
            50% {
                box-shadow: 0 0 20px rgba(255, 87, 34, 1);
            }
        }

        @media (max-width: 768px) {
            h3, h5 {
                font-size: 18px;
            }

            p {
                font-size: 14px;
            }

            .btn-success {
                font-size: 16px;
                padding: 10px 25px;
            }
        }
    </style>

    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                Paiement - Mois En Cours
            </div>
            <div class="card-body p-4">
                {{-- Message en cas d'absence de contrat ou période --}}
                @if(isset($message))
                    <div class="info-empty">
                        <h4><i class="fas fa-exclamation-circle text-danger"></i> {{ $message }}</h4>
                        <p>Cette page est actuellement vide car aucun contrat de bail actif n’est associé à votre compte. Veuillez contacter l’agence si besoin.</p>
                    </div>
                @elseif($periode)
                    {{-- Informations du locataire --}}
                    <div class="mb-4">
                        <h5><i class="fas fa-user-circle"></i> Informations du locataire</h5>
                        <p><strong>Nom :</strong> {{ $periode->locataire->nom }} {{ $periode->locataire->prenom }}</p>
                    </div>

                    {{-- Informations sur le bien --}}
                    <div class="mb-4">
                        <h5><i class="fas fa-home"></i> Détails du bien</h5>
                        <p><strong>Nom :</strong> {{ $periode->contratDeBail->bien->name_bien }}</p>
                        <p><strong>Type :</strong> {{ $periode->contratDeBail->bien->type_bien }}</p>
                        <p><strong>Adresse :</strong> {{ $periode->contratDeBail->bien->adresse_bien }}</p>
                    </div>

                    {{-- Informations sur la période --}}
                    <div class="mb-4">
                        <h5><i class="fas fa-calendar-alt"></i> Période de facturation</h5>
                        <p><strong>Du :</strong> {{ \Carbon\Carbon::parse($periode->date_debut_periode)->format('d/m/Y') }}</p>
                        <p><strong>Au :</strong> {{ \Carbon\Carbon::parse($periode->date_fin_periode)->format('d/m/Y') }}</p>
                    </div>

                    {{-- Avertissement important --}}
                    <div class="important-warning">
                        <i class="fas fa-exclamation-circle"></i>
                        Vérifiez qu'il s'agit du bien pour lequel la période (mois actuel du loyer) est exacte et découvrez le restant à payer
                    </div>

                    {{-- Bouton de paiement --}}
                    <div class="text-center mt-4">
                        <a href="{{ route('paiement.partiepaiement') }}" class="btn btn-success">
                            <i class="fas fa-credit-card"></i> Continuer
                        </a>
                    </div>
                @else
                    <div class="info-empty">
                        <h4><i class="fas fa-exclamation-circle text-warning"></i> Aucune période trouvée</h4>
                        <p>Aucune période de gestion n’a encore été générée pour votre contrat. Veuillez réessayer plus tard.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
