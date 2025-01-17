@extends('layouts.master_dash')

@section('content')
<div class="container">
    <!-- Titre de la page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Liste des demandes de Maintenance</h4>
    </div>

    <!-- Tableau des demandes -->
    <div class="card shadow-sm">
        <div class="card-body position-relative">
            <!-- Tableau des demandes -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Description</th>
                            <th>Locataire</th>
                            <th>Bien</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($demandes as $demande)
                        <tr>
                            <td>{{ $demande->description }}</td>
                            <td>{{ $demande->locataire->nom ?? 'N/A' }}</td>
                            <td>{{ $demande->bien->name_bien ?? 'N/A' }}</td>
                            <td>
                                <span class="badge 
                                    {{ $demande->statut == 'en attente' ? 'bg-warning text-dark' : 
                                       ($demande->statut == 'en cours' ? 'bg-info' : 'bg-success') }}">
                                    {{ ucfirst($demande->statut) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('agent.demandes.update', $demande->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group input-group-sm">
                                        <select name="statut" class="form-select">
                                            <option value="en attente" {{ $demande->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                                            <option value="en cours" {{ $demande->statut == 'en cours' ? 'selected' : '' }}>En cours</option>
                                            <option value="terminée" {{ $demande->statut == 'terminée' ? 'selected' : '' }}>Terminée</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucune demande de maintenance trouvée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Icône flottante pour ouvrir le chat -->
            <a href="chat.lien" class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center shadow"
               style="position: absolute; top: 50%; left: -50px; transform: translateY(-50%); width: 60px; height: 60px;">
                <i class="fas fa-comments fs-3"></i>
            </a>
        </div>
    </div>
</div>
@endsection
