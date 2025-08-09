@extends('layouts.master_dash')

@section('content')
<div class="container py-3">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-success">
            🛠️ Suivi des Demandes de Maintenance
        </h2>
        <p class="text-muted">Regroupe toutes les interventions classées par agence</p>
    </div>

    @forelse ($demandes as $agence => $demandesAgence)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $agence }}</h5>
                <span class="badge bg-light text-dark">{{ $demandesAgence->count() }} demande(s)</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>👤 Locataire</th>
                                <th>🏠 Bien</th>
                                <th class="text-start">📝 Description</th>
                                <th>📌 Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($demandesAgence as $demande)
                                <tr class="text-center">
                                    <td>{{ $demande->locataire->nom ?? 'N/A' }} {{ $demande->locataire->prenom ?? '' }}</td>
                                    <td>{{ $demande->bien->name_bien ?? 'N/A' }}</td>
                                    <td class="text-start">{{ Str::limit($demande->description, 80) }}</td>
                                    <td>
                                        @switch($demande->statut)
                                            @case('en attente')
                                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">⏳ En attente</span>
                                                @break
                                            @case('en cours')
                                                <span class="badge bg-info text-white px-3 py-2 rounded-pill">🔧 En cours</span>
                                                @break
                                            @case('terminée')
                                                <span class="badge bg-success text-white px-3 py-2 rounded-pill">✅ Terminée</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill">Inconnu</span>
                                        @endswitch
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">Aucune demande de maintenance trouvée.</div>
    @endforelse
</div>
@endsection
