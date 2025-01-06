<!DOCTYPE html>
<html>
<head>
    <title>Quittance de Paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header, .footer {
            text-align: center;
        }
        .content {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Quittance de Paiement</h2>
        <p>{{ $paiement->bien->agent_immobilier->nom_agence }}</p>
    </div>

    <div class="content">
        <p><strong>Locataire : </strong>{{ $paiement->locataire->nom }} {{ $paiement->locataire->prenom }}</p>
        <p><strong>Bien : </strong>{{ $paiement->bien->name_bien }}</p>
        <p><strong>Montant : </strong>{{ number_format($paiement->montant, 2) }} €</p>
        <p><strong>Date : </strong>{{ $paiement->date->format('d/m/Y') }}</p>
        <p><strong>Status : </strong>{{ $paiement->status }}</p>
    </div>

    <div class="footer">
        <p>Merci pour votre paiement !</p>
    </div>
</body>
</html>
