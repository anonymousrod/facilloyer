@extends('layouts.master_dash')
@section('title', 'Mon abonnement')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4 fw-bold">Mon abonnement actuel</h3>

        @if ($abonnement)
            <div class="card shadow rounded-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $abonnement->plan->nom }}</h5>
                    <p class="mb-1">
                        📅 Début : {{ \Carbon\Carbon::parse($abonnement->date_debut)->format('d/m/Y') }}
                    </p>
                    <p class="mb-1">
                        📅 Fin : {{ \Carbon\Carbon::parse($abonnement->date_fin)->format('d/m/Y') }}
                    </p>
                    {{-- <p class="mb-1">
                    ⏳ Durée : {{ $abonnement->plan->duree }} jours
                </p> --}}
                    <p class="mb-1">
                        💳 Montant : {{ number_format($abonnement->plan->prix, 0, ',', ' ') }} FCFA
                    </p>
                    <p class="mb-1">
                        📌 Statut :
                        @if ($abonnement->status === 'Actif')
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Expiré</span>
                        @endif
                    </p>
                    <a href="{{ route('plans_abonnement') }}" class="btn btn-primary mt-3">
                        Renouveler / Changer de plan
                    </a>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                Aucun abonnement actif pour le moment.
            </div>
            <a href="{{ route('plans.index') }}" class="btn btn-primary">
                Souscrire à un plan
            </a>
        @endif
    </div>
@endsection
