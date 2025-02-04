@extends('layouts.master_dash')
@section('title', 'Historique des Paiements')

@section('styles')
    <style>
        .table-container {
            max-height: 400px;
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

        @media (max-width: 768px) {
            .table thead th, .table tbody td {
                font-size: 0.875rem;
            }

            .action-icons i {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            .table td:nth-child(3),
            .table td:nth-child(5) {
                display: none;
            }

            .action-icons i {
                font-size: 1rem;
            }

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
                                        <th>Locataire</th>
                                        <th>Montant</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paiements as $paiement)
                                        <tr>
                                            <td>{{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : 'Date non disponible' }}</td>
                                            <td>#{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $paiement->locataire->prenom }} {{ $paiement->locataire->nom }}</td>
                                            <td><strong>{{ number_format($paiement->montant_paye, 2, ',', ' ') }} FCFA</strong></td>
                                            <td class="action-icons">
                                                <a href="{{ route('locataire.paiements.detail', $paiement->id) }}">
                                                    <i class="las la-eye fs-4"></i>
                                                </a>
                                                <a href="{{ route('locataire.paiements.quittance', $paiement->id) }}">
                                                    <i class="las la-download fs-4"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Aucun paiement effectué.</td>
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
