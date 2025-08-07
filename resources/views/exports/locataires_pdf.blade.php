<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Locataires</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: #F5F5F5;
            color: #222;
        }
        .header {
            background: #28a745;
            color: #fff;
            padding: 18px 0 14px 0;
            text-align: center;
            margin-bottom: 0;
        }
        .header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 0;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background: #F5F5F5;
            color: #222;
            font-weight: 700;
            border-bottom: 2px solid #28a745;
        }
        tr:not(:last-child) td {
            border-bottom: 1px solid #e0e0e0;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #28a745;
        }
        .badge {
            display: inline-block;
            font-size: 0.98em;
            padding: 0.35em 0.9em;
            border-radius: 8px;
            font-weight: 600;
        }
        .badge-success {
            background: #d4f8e8;
            color: #28a745;
        }
        .badge-danger {
            background: #f8d7da;
            color: #d32f2f;
        }
        .badge-light {
            background: #f4f4f4;
            color: #222;
        }
        .text-success {
            color: #28a745;
        }
        .text-danger {
            color: #d32f2f;
        }
        .text-muted {
            color: #888;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Liste des Locataires</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Nom complet</th>
                <th>Téléphone</th>
                <th>Adresse</th>
                <th>Revenus mensuels</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($locataires as $locataire)
                <tr>
                    <td>
                        @if ($locataire->photo_profil == null)
                            <img src="{{ public_path('assets/images/users/image.png') }}" alt="profil de {{ ($locataire->nom ?? '') . ' ' . ($locataire->prenom ?? '') }}">
                        @else
                            <img src="{{ public_path($locataire->photo_profil) }}" alt="profil de {{ ($locataire->nom ?? '') . ' ' . ($locataire->prenom ?? '') }}">
                        @endif
                    </td>
                    <td><span style="font-weight:700; color:#222;">{{ ($locataire->nom ?? '') . ' ' . ($locataire->prenom ?? '') }}</span></td>
                    <td>
                        @if (!empty($locataire->telephone))
                            <span class="badge badge-light text-success">{{ $locataire->telephone }}</span>
                        @else
                            <span class="badge badge-light text-danger">Non renseigné</span>
                        @endif
                    </td>
                    <td>
                        @if (!empty($locataire->adresse))
                            <span class="text-muted">{{ $locataire->adresse }}</span>
                        @else
                            <span class="text-danger">Non renseignée</span>
                        @endif
                    </td>
                    <td>
                        @if (!empty($locataire->revenu_mensuel))
                            <span class="badge badge-success">{{ number_format($locataire->revenu_mensuel, 0, ',', ' ') }} FCFA</span>
                        @else
                            <span class="badge badge-danger">Non renseigné</span>
                        @endif
                    </td>
                    <td>
                        @if(isset($locataire->user) && $locataire->user->statut)
                            <span class="badge badge-success">Activé</span>
                        @else
                            <span class="badge badge-danger">Désactivé</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
