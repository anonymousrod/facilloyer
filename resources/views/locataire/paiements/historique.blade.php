@extends('layouts.master_dash') <!-- Vérifiez que ce layout existe -->
@section('title', 'Historique des Paiements')

@section('styles')
<style>
    /* Conteneur de la table avec scroll vertical */
    .table-container {
        max-height: 400px; /* Limite la hauteur pour activer le scroll */
        overflow-y: auto;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1rem;
        background-color: #f9fafb;
    }

    /* Style général de la table */
    .table {
        margin-bottom: 0;
        width: 100%;
        border-collapse: collapse;
    }

    /* Style des en-têtes de table */
    .table thead th {
        background-color: #f1f5f9;
        position: sticky;
        top: 0;
        z-index: 2;
        text-align: left;
        padding: 0.75rem;
    }

    /* Style des lignes paires de la table */
    .table tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }

    /* Style des lignes au survol */
    .table tbody tr:hover {
        background-color: #e5e7eb;
    }

    /* Icônes d'actions (vue, télécharger) */
    .action-icons i {
        font-size: 1.25rem;
        cursor: pointer;
        margin-right: 1rem;
    }

    /* Changement de couleur des icônes au survol */
    .action-icons i:hover {
        color: #007bff;
    }

    /* Responsivité : ajustements pour les petites tailles d'écran */
    @media (max-width: 768px) {
        .table thead th {
            font-size: 0.875rem; /* Réduit la taille de la police des entêtes sur petits écrans */
        }

        .table tbody td {
            font-size: 0.875rem; /* Réduit la taille de la police des cellules sur petits écrans */
        }

        .action-icons i {
            font-size: 1.1rem; /* Réduit la taille des icônes sur petits écrans */
        }
    }

    @media (max-width: 576px) {
        /* Cache certaines colonnes sur des écrans très petits pour économiser de l'espace */
        .table td:nth-child(3), .table td:nth-child(4) {
            display: none;
        }

        /* Ajuste la taille des icônes sur très petits écrans */
        .action-icons i {
            font-size: 1rem;
        }

        /* Ajoute un scroll horizontal pour les petites tailles */
        .table-container {
            overflow-x: auto;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h4 class="card-title mb-0">Historique des Paiements Effectués</h4>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Référence</th>
                                    <th>Montant</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paiements as $paiement)
                                <tr>
                                    <td>{{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : 'Date non disponible' }}</td>

                                    <td>#{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td><strong>{{ number_format($paiement->montant_paye, 2, ',', ' ') }} FCFA</strong></td>
                                    <td class="action-icons">
                                        <!-- Icône Vue (Détails) -->
                                        <a href="{{ route('locataire.paiements.detail', $paiement->id) }}">
                                            <i class="las la-eye fs-4"></i>
                                        </a>
                                        <!-- Icône Télécharger -->
                                        <a href="{{ route('locataire.paiements.quittance', $paiement->id) }}">
                                            <i class="las la-download fs-4"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun paiement effectué.</td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
