@extends('layouts.master_dash')

@section('title', 'Gestion des Locataires')

@section('content')

@if(session('success'))
    <div class="alert alert-success my-4">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-4">
    @foreach($agences as $agence)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-2">
                    <div>
                        <h5 class="mb-1 text-success">{{ $agence->nom_agence }}</h5>
                        <small class="text-muted">📞 Téléphone : {{ $agence->telephone_agence }}</small>
                    </div>
                    <div class="text-md-end">
                        <small class="text-muted d-block">👤 Admin : {{ $agence->nom_admin }} {{ $agence->prenom_admin }}</small>
                        <small class="text-muted d-block">👥 {{ $agence->locataires->count() }} locataire{{ $agence->locataires->count() > 1 ? 's' : '' }}</small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if($agence->locataires->isEmpty())
                    <p class="text-center text-muted mb-0">Aucun locataire enregistré pour cette agence.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-success text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Téléphone</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agence->locataires as $locataire)
                                    <tr>
                                        <td>{{ $locataire->id }}</td>
                                        <td>{{ $locataire->nom }}</td>
                                        <td>{{ $locataire->prenom }}</td>
                                        <td>{{ $locataire->telephone }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $locataire->user->statut ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $locataire->user->statut ? 'Activé' : 'Désactivé' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                                <form action="{{ route('admin.locataires.changer.etat', $locataire->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $locataire->user->statut ? 'btn-danger' : 'btn-success' }}">
                                                        {{ $locataire->user->statut ? 'Désactiver' : 'Activer' }}
                                                    </button>
                                                </form>

                                                <a href="{{ route('admin.locataires.profil', $locataire) }}" class="btn btn-sm btn-info text-white">
                                                    Profil
                                                </a>

                                                <form action="{{ route('admin.locataires.supprimer', $locataire->id) }}" method="POST" onsubmit="return confirm('Supprimer ce locataire ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

@endsection
