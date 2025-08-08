@extends('layouts.master_dash')
@section('title', 'Historique des Paiements')



@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2"
                    style="background-color: #22B65A;">
                    <h4 class="mb-0 fw-bold text-white">
                        <i class="fas fa-history me-2"></i>
                        Historique des Paiements
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Référence</th>
                                    <th>Locataire</th>
                                    <th>Montant</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paiements as $paiement)
                                    <tr>
                                        <td>{{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : 'Date non disponible' }}</td>
                                        <td>#{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $paiement->locataire->prenom }} {{ $paiement->locataire->nom }}</td>
                                        <td class="fw-bold text-success">
                                            {{ number_format($paiement->montant_paye, 2, ',', ' ') }} FCFA
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('locataire.paiements.detail', $paiement->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('locataire.paiements.quittance', $paiement->id) }}" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-info-circle me-1"></i> Aucun paiement effectué.
                                        </td>
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

