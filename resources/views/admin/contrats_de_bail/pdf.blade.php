<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contrat de Bail - {{ $contratDeBailLocataire->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            font-size: 12px;
        }

        /* Filigrane du drapeau du Bénin */
        .filigrane-drapeau {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            width: 80%;  /* Ajuster la taille du drapeau */
            height: auto;
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/4/4f/Flag_of_Benin.svg'); /* URL du drapeau */
            background-size: cover;
            background-position: center;
            opacity: 0.1; /* Réduire l'opacité pour un effet de filigrane */
            z-index: -2;
        }

        /* Filigrane "FACILOYER" dans l'autre sens */
        .filigrane-faciloyer {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(15deg);
            font-size: 150px; /* Taille du texte */
            color: rgba(0, 0, 0, 0.15); /* Couleur et transparence */
            font-weight: bold;
            font-style: italic;
            z-index: -1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            background-color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f4f4f4;
            color: #555;
            font-size: 14px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .signature-section {
            margin-top: 40px;
            text-align: center;
        }

        .signature-line {
            margin-top: 20px;
            border-top: 1px solid #333;
            width: 40%;
            margin-left: auto;
            margin-right: auto;
        }

        .signature-left, .signature-right {
            display: inline-block;
            width: 45%;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #888;
            margin-top: 30px;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            position: relative;
        }
    </style>
</head>
<body>

    <!-- Filigrane Drapeau du Bénin -->
    <div class="filigrane-drapeau"></div>

    <!-- Filigrane "FACILOYER" -->
    <div class="filigrane-faciloyer">{{ config('app.name') }}</div>

    <div class="container">
        <!-- En-tête du contrat -->
        <div class="header">République du Bénin</div>
        <h2 style="text-align:center; margin-top: 20px;">Contrat de Bail - N°{{ $contratDeBailLocataire->id }}</h2>

        <!-- Tableau avec les informations du contrat -->
        <table>
            <tr>
                <th>Locataire</th>
                <td>{{ $contratDeBailLocataire->locataire->nom }} {{ $contratDeBailLocataire->locataire->prenom }}</td>
            </tr>
            <tr>
                <th>Bien</th>
                <td>{{ $contratDeBailLocataire->contrats_de_bail->bien->adresse_bien }}</td>
            </tr>
            <tr>
                <th>Date de Début</th>
                <td>{{ \Carbon\Carbon::parse($contratDeBailLocataire->date_debut)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Date de Fin</th>
                <td>{{ \Carbon\Carbon::parse($contratDeBailLocataire->date_fin)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Complément au Loyer</th>
                <td>{{ $contratDeBailLocataire->complement_au_loyer }} XOF</td>
            </tr>
            <tr>
                <th>Montant Restant</th>
                <td>{{ $contratDeBailLocataire->montant_restant }} XOF</td>
            </tr>
            <tr>
                <th>Montant Total pour la Période</th>
                <td>{{ $contratDeBailLocataire->montant_total_periode }} XOF</td>
            </tr>
            <tr>
                <th>Période de Paiement</th>
                <td>{{ $contratDeBailLocataire->periode_paiement }}</td>
            </tr>
            <tr>
                <th>Statut du Paiement</th>
                <td>{{ $contratDeBailLocataire->statut_paiement }}</td>
            </tr>
            <tr>
                <th>Échéance de Paiement</th>
                <td>{{ \Carbon\Carbon::parse($contratDeBailLocataire->echeance_paiement)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Nom de l'Agence</th>
                <td>{{ $contratDeBailLocataire->contrats_de_bail->bien->agent_immobilier->nom_agence }}</td>
            </tr>
        </table>

        <!-- Section Signatures -->
        <div class="signature-section">
            <div class="signature-left">
                <p><strong>Signature du Locataire :</strong></p>
                <div class="signature-line"></div>
                <p>Nom et Prénom</p>
            </div>

            <div class="signature-right">
                <p><strong>Signature de l'Agent Immobilière :</strong></p>
                <div class="signature-line"></div>
                <p>Nom de l'Agent</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ config('app.name') }} - Tous droits réservés</p>
        </div>
    </div>

</body>
</html>
