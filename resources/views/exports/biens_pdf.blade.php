<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Biens</title>
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
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        .badge-danger {
            background: #f8d7da;
            color: #d32f2f;
        }
        .badge-price {
            background: #d4f8e8;
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Liste des Biens</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>Photos</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Chambres</th>
                <th>Superficies</th>
                <th>Statut</th>
                <th>Prix(FCFA)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($biens as $bien)
                <tr>
                    <td>
                        <img src="{{ public_path($bien->photo_bien) }}" alt="Photo de {{ $bien->name_bien }}">
                    </td>
                    <td><span style="font-weight:700; color:#222;">{{ $bien->name_bien }}</span></td>
                    <td><span style="color:#666;">{{ $bien->adresse_bien }}</span></td>
                    <td>{{ $bien->nbr_chambres }}</td>
                    <td>{{ $bien->superficie }}</td>
                    <td>
                        <span class="badge {{ $bien->statut_bien == 'Disponible' ? 'badge-success' : ($bien->statut_bien == 'Loué' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $bien->statut_bien }}
                        </span>
                    </td>
                    <td><span class="badge badge-price">{{ number_format($bien->loyer_mensuel, 0, ',', ' ') }} FCFA</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
