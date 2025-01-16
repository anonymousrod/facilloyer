@extends('layouts.master_dash')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h5>Mes Demandes</h5>
        <!-- Icône pour accéder au formulaire de création -->
        <a href="{{ route('locataire.demandes.create',) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle demande
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($demandes->isEmpty())
        <!-- Message si aucune demande n'est présente -->
        <div class="alert alert-info mt-4">
            <p>Vous n'avez aucune demande de maintenance actuellement.</p>
            <a href="{{ route('locataire.demandes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer une demande
            </a>
        </div>
    @else
        <!-- Tableau des demandes -->
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Description</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($demandes as $demande)
                    <tr>
                        <td>{{ $demande->libelle }}</td>
                        <td>{{ $demande->description }}</td>
                        <td>{{ ucfirst($demande->statut) }}</td>
                        <td>
                            @if ($demande->statut != 'archivé')
                                <form action="{{ route('locataire.demandes.archive', $demande->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning btn-sm">Archiver</button>
                                </form>
                            @else
                                <form action="{{ route('locataire.demandes.unarchive', $demande->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Réafficher</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
