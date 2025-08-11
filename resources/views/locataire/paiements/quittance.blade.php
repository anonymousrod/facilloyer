<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quittance de Paiement #{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #212529;
            padding: 20px;
        }
        .invoice {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
            font-size: 0.9rem;
        }
        .invoice-header {
            border-bottom: 3px solid #0d6efd;
            margin-bottom: 20px;
            padding-bottom: 8px;
        }
        .invoice-header h1 {
            font-weight: 700;
            font-size: 1.8rem;
            color: #0d6efd;
        }
        .section-title {
            color: #0d6efd;
            font-weight: 600;
            font-size: 1.05rem;
            margin-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 4px;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            width: 130px;
            display: inline-block;
        }
        .badge-paid {
            background-color: #198754;
            font-size: 0.95rem;
            padding: 4px 10px;
            border-radius: 5px;
        }
        .small-text {
            color: #6c757d;
        }
        .mb-2-5 {
            margin-bottom: 0.625rem;
        }
        @media (max-width: 575.98px) {
            .info-label {
                width: auto;
                display: block;
                margin-bottom: 2px;
            }
        }
    </style>
</head>
<body>

<div class="invoice">

    <div class="invoice-header text-center mb-4">
        <h1>Quittance de Paiement</h1>
        <div>#{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>

    <div class="text-center mb-3">
        <span class="badge badge-paid">Paiement réussi</span>
    </div>

    <div class="row gy-3">
        <!-- Agence -->
        <div class="col-md-6">
            <div class="section-title">Agence</div>
            <p class="mb-2-5"><span class="info-label">Nom :</span> {{ $bien->agent_immobilier->nom_agence ?? 'N/D' }}</p>
            <p class="mb-2-5"><span class="info-label">Admin :</span> {{ $bien->agent_immobilier->nom_admin ?? 'N/D' }}</p>
            <p class="mb-2-5"><span class="info-label">Adresse :</span> {{ $bien->agent_immobilier->adresse_agence ?? 'N/D' }}</p>
            <p class="mb-2-5"><span class="info-label">Téléphone :</span> {{ $bien->agent_immobilier->telephone_agence ?? 'N/D' }}</p>
        </div>

        <!-- Locataire -->
        <div class="col-md-6">
            <div class="section-title">Locataire</div>
            <p class="mb-2-5"><span class="info-label">Nom :</span> {{ $paiement->locataire->nom ?? 'N/D' }}</p>
            <p class="mb-2-5"><span class="info-label">Prénom :</span> {{ $paiement->locataire->prenom ?? 'N/D' }}</p>
            <p class="mb-2-5"><span class="info-label">Email :</span> {{ $paiement->locataire->email ?? 'N/D' }}</p>
        </div>

        <!-- Paiement -->
        <div class="col-md-6">
            <div class="section-title">Paiement</div>
            <p class="mb-2-5"><span class="info-label">Montant payé :</span> {{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</p>
            <p class="mb-2-5"><span class="info-label">Date :</span> {{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : 'N/D' }}</p>
            <p class="mb-2-5"><span class="info-label">Montant total période :</span> {{ number_format($paiement->locataire->gestionPeriode->montant_total_periode ?? 0, 0, ',', ' ') }} FCFA</p>
            <p class="mb-2-5"><span class="info-label">Montant restant :</span> {{ number_format($paiement->locataire->gestionPeriode->montant_restant_periode ?? 0, 0, ',', ' ') }} FCFA</p>
        </div>

        <!-- Logement -->
        <div class="col-md-6">
            <div class="section-title">Logement</div>
            <p class="mb-2-5"><span class="info-label">Adresse :</span> {{ $bien->adresse_bien ?? 'N/D' }}</p>
            <p class="mb-2-5"><span class="info-label">Type :</span> {{ $bien->type_bien ?? 'N/D' }}</p>
            <p class="mb-2-5"><span class="info-label">Superficie :</span> {{ $bien->superficie ?? 'N/D' }} m²</p>
        </div>
    </div>

    <div class="text-center small-text mt-4">
        <p>Quittance générée le {{ now()->format('d/m/Y') }}.</p>
        <p>Merci pour votre confiance !</p>
    </div>

</div>

</body>
</html>
