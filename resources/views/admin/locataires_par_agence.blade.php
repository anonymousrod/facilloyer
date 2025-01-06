@extends('layouts.master_dash')

@section('content')
@if(session('success'))
    <div class="alert alert-success mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-5">    
    @foreach($agences as $agence)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light text-dark">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $agence->nom_agence }}</h4>
                    <small class="text-muted">Admin : {{ $agence->nom_admin }} {{ $agence->prenom_admin }}</small>
                </div>
                <p class="mb-0 text-muted">Téléphone : {{ $agence->telephone_agence }}</p>
            </div>
            <div class="card-body">
                @if($agence->locataires->isEmpty())
                    <p class="text-center text-muted">Aucun locataire enregistré pour cette agence.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
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
                                        <td>
                                            <span class="badge {{ $locataire->user->statut ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $locataire->user->statut ? 'Activé' : 'Désactivé' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <!-- Bouton Activer/Désactiver -->
                                                <form action="{{ route('admin.locataires.changer.etat', $locataire->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $locataire->user->statut ? 'btn-danger' : 'btn-success' }}">
                                                        {{ $locataire->user->statut ? 'Désactiver' : 'Activer' }}
                                                    </button>
                                                </form>

                                                <!-- Bouton Profil -->
                                                <a href="{{ route('admin.locataires.profil', $locataire->id) }}" class="btn btn-sm btn-info">
                                                     Profil
                                                </a>

                                                <!-- Bouton Supprimer -->
                                                <form action="{{ route('admin.locataires.supprimer', $locataire->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
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
