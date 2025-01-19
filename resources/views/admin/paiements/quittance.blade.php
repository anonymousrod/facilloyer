<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quittance du montant payé le {{ $paiement->date->format('d/m/Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.3;
            color: #2c3e50;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-bottom: 2px solid #4a90e2;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .reference {
            font-size: 13px;
            color: #4a90e2;
            font-weight: 600;
        }
        .section {
            margin-bottom: 12px;
            padding: 10px;
            background-color: #ffffff;
            border-left: 3px solid #4a90e2;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 8px;
            color: #2c3e50;
            font-size: 13px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 3px;
            text-transform: uppercase;
        }
        .info-text {
            margin: 0;
            color: #34495e;
            line-height: 1.4;
        }
        .highlight {
            background-color: #f8f9fa;
            padding: 2px 4px;
            border-radius: 3px;
            color: #2c3e50;
            font-weight: 600;
        }
        .payment-details {
            margin-top: 5px;
        }
        .payment-info {
            padding: 8px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .payment-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .payment-row:last-child {
            border-bottom: none;
        }
        .montant {
            color: #2c3e50;
            font-weight: bold;
            background: #e8f5e9;
            padding: 2px 6px;
            border-radius: 3px;
        }
        .footer {
            margin-top: 15px;
            text-align: right;
            padding: 10px;
            border-top: 1px solid #4a90e2;
        }
        .signature-section {
            margin-top: 10px;
            color: #2c3e50;
            font-size: 11px;
        }
        .contact-info {
            color: #666;
            font-size: 10px;
            margin-top: 2px;
        }
        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-top: 15px;
            font-size: 12px;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">Quittance du montant payé le {{ $paiement->date->format('d/m/Y') }}</div>
            <div class="reference">N° {{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>

        <div class="section">
            <div class="section-title">BAILLEUR</div>
            <p class="info-text">
                @if($paiement->bien && $paiement->bien->agent_immobilier)
                    <span class="highlight">{{ $paiement->bien->agent_immobilier->nom_agence }}</span>
                    - Représenté par : <span class="highlight">{{ $paiement->bien->agent_immobilier->nom_admin }} {{ $paiement->bien->agent_immobilier->prenom_admin }}</span><br>
                    {{ $paiement->bien->agent_immobilier->adresse_agence }}
                    <span class="contact-info">- Tél : {{ $paiement->bien->agent_immobilier->telephone_agence }}</span>
                @endif
            </p>
        </div>

        <div class="section">
            <div class="section-title">LOCATAIRE</div>
            <p class="info-text">
                <span class="highlight">{{ $paiement->locataire->nom }} {{ $paiement->locataire->prenom }}</span>
                - {{ $paiement->locataire->adresse }}
                <span class="contact-info">- Tél : {{ $paiement->locataire->telephone }}</span>
            </p>
        </div>

        <div class="section">
            <div class="section-title">LOGEMENT</div>
            <p class="info-text">
                {{ $paiement->bien->adresse_bien }}
                - Type : <span class="highlight">{{ $paiement->bien->type_bien }}</span>
                - Superficie : {{ $paiement->bien->superficie }} m²
            </p>
        </div>

        <div class="section">
            <div class="section-title">DÉTAILS DU PAIEMENT</div>
            <div class="payment-info">
                <div class="payment-row">
                    <strong>Date du paiement :</strong>
                    <span class="highlight">{{ $paiement->date->format('d/m/Y') }}</span>
                </div>
                <div class="payment-row">
                    <strong>Détails :</strong>
                    <span class="highlight">Paiement mobile par défaut</span>
                </div>
                <div class="payment-row">
                    <strong>Montant versé :</strong>
                    <span class="montant">{{ number_format($paiement->montant, 2, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p style="margin: 0;">Fait le {{ now()->format('d/m/Y') }}</p>
            <div class="signature-section">
                Signature du bailleur<br>
                _________________
            </div>
        </div>

        <div class="alert">
            Ce document ne représente en aucun cas le reçu du loyer, mais plutôt le justificatif d'un paiement réalisé.
        </div>
    </div>
</body>
</html>
