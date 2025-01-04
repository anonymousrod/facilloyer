@extends('layouts.master_dash') <!-- Vérifiez que ce layout existe -->
@section('title', 'Historique des Paiements')

@section('styles')
<style>
    .table-container {
        max-height: 400px; /* Limite la hauteur pour activer le scroll */
        overflow-y: auto;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1rem;
        background-color: #f9fafb;
    }

    .table {
        margin-bottom: 0;
        width: 100%;
        border-collapse: collapse;
    }

    .table thead th {
        background-color: #f1f5f9;
        position: sticky;
        top: 0;
        z-index: 2;
        text-align: left;
        padding: 0.75rem;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }

    .table tbody tr:hover {
        background-color: #e5e7eb;
    }

    .action-icons i {
        font-size: 1.25rem;
        cursor: pointer;
        margin-right: 1rem;
    }

    .action-icons i:hover {
        color: #007bff;
    }

    /* Pour garantir la responsivité */
    @media (max-width: 576px) {
        .action-icons i {
            font-size: 1.1rem;
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
                                    <td>{{ $paiement->date->format('d/m/Y') }}</td>
                                    <td>#{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td><strong>{{ number_format($paiement->montant, 2, ',', ' ') }} €</strong></td>
                                    <td class="action-icons">
                                        <!-- Icône Vue (Détails) -->
                                        <a href="{{ route('locataire.paiements.show', $paiement->id) }}">
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
