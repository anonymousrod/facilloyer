<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quittance de Paiement</title>
    
</head>
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
<body>

    <div class="container">
        <!-- Titre principal -->
        <h1>Quittance de Paiement</h1>
        <h2>#{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</h2>

        <!-- Informations de l'agence -->
        <div class="agency-info highlight">
            <p class="agency-name">Nom de l'agence : {{ $bien->agent_immobilier->nom_agence ?? 'Non défini' }}</p>
            <p><span class="bold">Nom de l'administrateur :</span> {{ $bien->agent_immobilier->nom_admin ?? 'Non défini' }}</p>
            <p><span class="bold">Adresse :</span> {{ $bien->agent_immobilier->adresse_agence ?? 'Non définie' }}</p>
            <p><span class="bold">Téléphone :</span> {{ $bien->agent_immobilier->telephone_agence ?? 'Non défini' }}</p>
        </div>

        <div class="line"></div>

        <!-- Détails du paiement -->
        <div class="details">
            <p><span class="badge badge-success">Paiement réussi</span></p>
            <p><span class="bold">Locataire :</span> {{ $paiement->locataire->nom }} {{ $paiement->locataire->prenom }}</p>
            <p><span class="bold">Montant payé :</span> {{ number_format($paiement->montant_paye, 2, ',', ' ') }} FCFA</p>
            <p><span class="bold">Date de paiement :</span> {{ $paiement->created_at->format('d/m/Y') }}</p>
        </div>

        <div class="line"></div>

        <!-- Informations sur le logement -->
        <div class="details">
            <h3 class="text-center">Informations sur le Logement</h3>
            <div class="info-group">
                <p><span class="bold">Adresse :</span> {{ $bien->adresse_bien ?? 'Non défini' }}</p>
                <p><span class="bold">Type :</span> {{ $bien->type_bien ?? 'Non défini' }}</p>
                <p><span class="bold">Superficie :</span> {{ $bien->superficie ?? 'Non défini' }} m²</p>
            </div>
        </div>

        <div class="footer">
            <p>Quittance générée le {{ now()->format('d/m/Y') }}.</p>
            <p>Merci pour votre confiance !</p>
        </div>
    </div>

</body>
</html>
