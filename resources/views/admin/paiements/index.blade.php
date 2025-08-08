@extends('layouts.master_dash')

@section('content')
<div class="container mt-2">

    <!-- Barre de recherche globale -->
    <div class="row justify-content-center mb-3">
        <div class="col-lg-9 col-md-10">
            <form action="{{ route('admin.paiements.index') }}" method="GET" class="input-group shadow-sm">
                <input type="text" name="search" class="form-control form-control-lg border-0" placeholder="🔍 Rechercher un locataire ou une agence" value="{{ request('search') }}">
                <button class="btn text-white px-4" style="background-color: #22B65A;" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <h3 class="text-center text-success fw-bold mb-4">📄 Historique des Paiements</h3>

    <!-- Cartes par agence -->
    @foreach ($paiements as $agence => $paiementsAgence)
        <div class="card mb-4 shadow-sm">
            <div class="card-header text-white d-flex justify-content-between align-items-center py-2 px-3" style="background-color: #22B65A;">
                <span class="fw-semibold">{{ $agence }}</span>
                <span class="badge bg-light text-dark">{{ $paiementsAgence->count() }} Paiement(s)</span>
            </div>
            <div class="card-body py-3 px-3">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm table-striped datatable" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th>Locataire</th>
                                <th>Bien</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paiementsAgence as $paiement)
                                <tr>
                                    <td>{{ $paiement->locataire->nom ?? 'Inconnu' }} {{ $paiement->locataire->prenom ?? '' }}</td>
                                    <td>{{ $paiement->bien->name_bien ?? 'Bien inconnu' }}</td>
                                    <td>{{ number_format($paiement->montant_paye, 2) }} FCFA</td>
                                    <td>{{ $paiement->statut_paiement }}</td>
                                    <td>
                                        <a href="{{ route('admin.paiements.details', $paiement->id) }}" class="btn btn-outline-success btn-sm rounded-pill px-3">Voir</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    @endforeach

</div>
@endsection

@section('scripts')
<!-- DataTables JS + CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('.datatable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
            },
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            ordering: true,
            responsive: true
        });
    });
</script>
@endsection

<style>
/* Styles harmonisés */
.card {
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.2em 0.8em;
    margin: 0 2px;
    border-radius: 30px;
    background-color: #f2f2f2;
    border: none;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background-color: #22B65A !important;
    color: white !important;
}

.dataTables_filter input {
    border-radius: 30px;
    padding-left: 10px;
}

.dataTables_length select {
    border-radius: 30px;
}
</style>
