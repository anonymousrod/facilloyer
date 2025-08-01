@extends('layouts.master_dash')

@section('title', 'Détails du paiement')

@section('content')
<style>
    /* Bouton de téléchargement flottant */
.btn-primary {
    font-size: 16px;
    padding: 10px;
}

/* Cartes avec une ombre et bordures légères */
.card {
    border-radius: 12px;
    border: 1px solid #f1f1f1;
}

.card-title {
    font-size: 18px;
    font-weight: bold;
}

.font-16 {
    font-size: 16px;
}

.font-14 {
    font-size: 14px;
}

.text-success {
    color: #28a745 !important;
}

</style>

<div class="container-fluid">
    <!-- Titre de la page avec bouton de téléchargement -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="page-title-box">
                <h4 class="page-title">Détails du paiement #{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</h4>
            </div>
            <a href="{{ route('locataire.paiements.quittance', $paiement->id) }}" class="btn btn-primary rounded-circle shadow-sm">
                <i class="fas fa-download"></i>
            </a>
        </div>
    </div>
    

    <!-- Informations du paiement -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-lg border-light mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informations du paiement</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label text-muted">Montant payé</label>
                                <p class="font-16 text-success fw-bold">{{ number_format($montantPaye, 2, ',', ' ') }} FCFA</p>
                            </div>
                            <div class="details">
                                <p><span class="badge badge-success">Paiement réussi</span></p>
                                <p><span class="bold">Locataire :</span> {{ $paiement->locataire->nom }} {{ $paiement->locataire->prenom }}</p>
                                <p><span class="bold">Montant payé :</span> {{ number_format($paiement->montant_paye, 2, ',', ' ') }} FCFA</p>
                                <p><span class="bold">Date de paiement :</span> {{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : 'Date non disponible' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations sur le logement -->
        <div class="col-lg-4">
            <div class="card shadow-lg border-light mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informations sur le logement</h5>
                    <div class="mb-3">
                        <label class="form-label text-muted">Adresse</label>
                        <p class="font-14">{{ $paiement->bien->adresse_bien ?? 'Non défini' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Type</label>
                        <p class="font-14">{{ $paiement->bien->type_bien ?? 'Non défini' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Superficie</label>
                        <p class="font-14">{{ $paiement->bien->superficie ?? 'Non défini' }} m²</p>
                    </div>
                    <a href="{{ route('locataire.paiements.quittance', $paiement->id) }}" class="btn btn-primary rounded-circle shadow-sm">
                        <i class="fas fa-download"></i>
                    </a>
                    <p>Quittance générée le {{ now()->format('d/m/Y') }}.</p>
                      <p>Merci pour votre confiance !</p>
                    
                </div>
            </div>
        </div>
    </div>
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
        }

        h2 {
            font-size: 20px;
            color: #27ae60;
            font-weight: bold;
        }

        .details, .agency-info {
            margin-bottom: 20px;
        }

        .details p, .agency-info p {
            font-size: 14px;
            line-height: 1.8;
            color: #555;
        }

        .details span.bold, .agency-info span.bold {
            font-weight: bold;
            color: #2c3e50;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 30px;
        }

        .line {
            border-top: 2px dashed #ddd;
            margin: 25px 0;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            color: white;
            margin-bottom: 10px;
        }

        .badge-success {
            background-color: #27ae60;
        }

        .badge-warning {
            background-color: #f39c12;
        }

        .badge-danger {
            background-color: #c0392b;
        }

        .agency-header {
            text-align: center;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #3498db;
        }

        .agency-name {
            font-size: 18px;
            font-weight: bold;
            color: #2980b9;
        }

        .btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            margin-top: 15px;
        }

        .btn:hover {
            background-color: #1f78b4;
        }

        .highlight {
            background-color: #eafaf1;
            border-left: 5px solid #27ae60;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .info-group {
            background-color: #f9f9f9;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>

</div>
@endsection
