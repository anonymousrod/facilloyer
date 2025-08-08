@extends('layouts.master_dash')

@section('content')
<div class="container-xxl py-4">

    <!-- Titre + Bouton -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold m-0 text-dark">🔧 Maintenance & Suivi</h2>
    </div>

    <!-- Filtres -->
    <div class="mb-4 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
        <button class="btn btn-outline-secondary">🔄 Tout</button>
        <button class="btn btn-outline-warning">⏳ En attente</button>
        <button class="btn btn-outline-info">🔧 En cours</button>
        <button class="btn btn-outline-success">✅ Validée</button>
        <button class="btn btn-outline-secondary">✔️ Terminée</button>
    </div>

    <!-- Tableau -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-3 position-relative">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #22B65A;" class="text-white">
                        <tr>
                            <th>Description</th>
                            <th>Locataire</th>
                            <th>Bien</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($demandes as $demande)
                            <tr>
                                <td>{{ $demande->description }}</td>
                                <td>
                                    {{ $demande->locataire->nom ?? 'N/A' }}
                                    {{ $demande->locataire->prenom ?? '' }}
                                </td>
                                <td>{{ $demande->bien->name_bien ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $statut = strtolower($demande->statut);
                                        $badgeClass = match($statut) {
                                            'en attente' => 'bg-warning text-dark',
                                            'en cours' => 'bg-info text-white',
                                            'validée', 'terminée' => 'bg-success',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-1 fs-6 {{ $badgeClass }}">
                                        {{ ucfirst($demande->statut) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('agent.demandes.update', $demande->id) }}"
                                          method="POST" class="d-flex align-items-center gap-2 flex-wrap">
                                        @csrf
                                        @method('PATCH')
                                        <select name="statut" class="form-select form-select-sm w-auto">
                                            <option value="en attente" {{ $demande->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                                            <option value="en cours" {{ $demande->statut == 'en cours' ? 'selected' : '' }}>En cours</option>
                                            <option value="terminée" {{ $demande->statut == 'terminée' ? 'selected' : '' }}>Terminée</option>
                                        </select>
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    💡 Aucune demande de maintenance trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Icône flottante de chat -->
            <a href="chat.lien"
               class="btn btn-success shadow rounded-circle position-absolute d-flex justify-content-center align-items-center"
               style="top: 50%; left: -35px; transform: translateY(-50%); width: 55px; height: 55px;">
                <i class="fas fa-comments fs-4 text-white"></i>
            </a>
        </div>
    </div>
</div>
@endsection
