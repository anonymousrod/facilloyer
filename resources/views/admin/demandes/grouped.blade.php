@extends('layouts.master_dash')

@section('content')
<div class="container">
    <h1 class="mb-4">Demandes de Maintenance Groupées</h1>

    @forelse ($demandes as $agence => $demandesAgence)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $agence }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Locataire</th>
                            <th>Bien</th>
                            <th>Description</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demandesAgence as $demande)
                        <tr>
                            <td>{{ $demande->locataire->nom ?? 'N/A' }} {{ $demande->locataire->prenom ?? '' }}</td>
                            <td>{{ $demande->bien->name_bien ?? 'N/A' }}</td>
                            <td>{{ $demande->description }}</td>
                            <td>
                                <span class="badge 
                                    {{ $demande->statut == 'en attente' ? 'bg-warning text-dark' : 
                                       ($demande->statut == 'en cours' ? 'bg-info' : 'bg-success') }}">
                                    {{ ucfirst($demande->statut) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Aucune demande de maintenance trouvée.</div>
    @endforelse
</div>
@endsection
