<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Locataires</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
        .title {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1 class="title">Liste des Locataires</h1>
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
                        <img src="{{ public_path($locataire->photo_profil) }}"
                             alt="Photo de {{ $locataire->nom . ' ' . $locataire->prenom }}">
                    </td>
                    <td>{{ $locataire->nom . ' ' . $locataire->prenom }}</td>
                    <td>{{ $locataire->telephone }}</td>
                    <td>{{ $locataire->adresse }}</td>
                    <td>{{ number_format($locataire->revenu_mensuel, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $locataire->user->statut ? 'Activé' : 'Désactivé' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
