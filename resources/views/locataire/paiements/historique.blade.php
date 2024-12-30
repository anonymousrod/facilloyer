@extends('layouts.master_dash')
@section('title', 'Historique des Paiements')

@section('styles')
<style>
    /* Container principal */
    .dataTables_wrapper {
        padding: 1rem;
        background: #f8fafc;
        border-radius: 16px;
        max-width: 100%;
        overflow-x: auto;
    }

    /* Table responsive */
    .table-responsive {
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .table {
        margin: 1rem 0 !important;
        border-spacing: 0 12px !important;
        border-collapse: separate !important;
        width: 100% !important;
        min-width: 800px; /* Largeur minimum pour éviter la déformation */
    }

    /* Colonnes responsives */
    .table th, .table td {
        white-space: nowrap; /* Évite le retour à la ligne du texte */
        min-width: 100px; /* Largeur minimum des colonnes */
    }

    .table th:first-child, 
    .table td:first-child {
        min-width: 120px; /* Date */
    }

    .table th:nth-child(2), 
    .table td:nth-child(2) {
        min-width: 100px; /* Référence */
    }

    .table th:nth-child(3), 
    .table td:nth-child(3) {
        min-width: 120px; /* Montant */
    }

    .table th:last-child, 
    .table td:last-child {
        min-width: 100px; /* Actions */
    }

    /* Style des en-têtes */
    .table thead th {
        border: none !important;
        background: transparent;
        padding: 0.75rem 1rem;
        color: #64748b;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Style des lignes */
    .table tbody tr {
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        transition: all 0.2s;
    }

    .table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.08);
    }

    .table tbody td {
        border: none !important;
        padding: 1rem;
        vertical-align: middle;
    }

    /* Pagination responsive */
    .dataTables_paginate {
        margin-top: 1rem !important;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: center;
    }

    @media (min-width: 768px) {
        .dataTables_paginate {
            justify-content: flex-end;
        }
    }

    .paginate_button {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    /* Recherche et longueur responsive */
    .dataTables_length,
    .dataTables_filter {
        margin-bottom: 1rem;
    }

    @media (max-width: 767px) {
        .dataTables_length,
        .dataTables_filter {
            text-align: left;
            width: 100%;
        }

        .dataTables_filter input {
            width: 100%;
            margin-left: 0 !important;
        }
    }

    /* Badges de statut */
    .status-badge {
        padding: 0.4rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.875rem;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Boutons d'action */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .action-btn {
        padding: 0.4rem;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
    }

    /* Message vide */
    .dataTables_empty {
        padding: 2rem !important;
        text-align: center;
        color: #64748b;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h4 class="card-title mb-0">Historique des Paiements</h4>
                    <a href="{{ route('locataire.paiements.create') }}" class="btn btn-primary">
                        <i class="las la-plus"></i>
                        <span class="d-none d-sm-inline">Nouveau Paiement</span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="payments-table" class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Réf.</th>
                                    <th>Montant</th>
                                    <th>Mode</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paiements as $paiement)
                                <tr>
                                    <td>{{ $paiement->date->format('d/m/Y') }}</td>
                                    <td>#{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        <strong>{{ number_format($paiement->montant, 2, ',', ' ') }} €</strong>
                                    </td>
                                    <td>
                                        <i class="las {{ $paiement->mode_paiement == 'Espèces' ? 'la-money-bill' : 'la-credit-card' }} me-1"></i>
                                        {{ $paiement->mode_paiement }}
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $paiement->montant_restant > 0 ? 'status-pending' : 'status-paid' }}">
                                            <i class="las {{ $paiement->montant_restant > 0 ? 'la-clock' : 'la-check' }}"></i>
                                            {{ $paiement->montant_restant > 0 ? 'En attente' : 'Payé' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('locataire.paiements.quittance', $paiement->id) }}" class="action-btn" title="Télécharger">
                                                <i class="las la-download fs-2"></i>
                                            </a>
                                            <a href="{{ route('locataire.paiements.show', $paiement->id) }}" class="action-btn" title="Détails">
                                                <i class="las la-eye fs-4"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#payments-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
            },
            pageLength: 10,
            order: [[0, 'desc']],
            responsive: true,
            dom: '<"top d-flex flex-wrap justify-content-between gap-3"lf>rt<"bottom"ip><"clear">',
            columnDefs: [
                { orderable: false, targets: 5 },
                { responsivePriority: 1, targets: [0, 2, 4] }, // Colonnes prioritaires
                { responsivePriority: 2, targets: 5 },
                { responsivePriority: 3, targets: [1, 3] }
            ]
        });
    });
</script>
@endsection
