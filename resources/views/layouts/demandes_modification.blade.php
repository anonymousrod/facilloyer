@extends('layouts.master_dash')

@section('title', 'Gestion Agent Immobilier')

@section('content')
    <style>
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s cubic-bezier(0.4,0,0.2,1), transform 0.7s cubic-bezier(0.4,0,0.2,1);
        }
        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    <div class="card container-fluid py-5" style=" min-height: 100vh;">
        {{-- <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #212121;">Demandes de modification de contrat</h2>
        </div> --}}

        {{-- Flash message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-auto w-75" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class=" row justify-content-center gap-4">
            {{-- DEMANDES REÇUES --}}
            <div class="col-lg-5 col-md-6">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header text-center rounded-top-4" style="background-color: #2E7D32;">
                        <h4 class="text-white fw-semibold m-0 py-2">Demandes reçues</h4>
                    </div>
                    <div class="card-body ">
                        @if ($demandesRecues->isEmpty())
                            <p class="text-center text-muted fst-italic">Aucune demande reçue.</p>
                        @else
                            @foreach ($demandesRecues as $demande)
                                <div class="bg-light p-3 mb-3 rounded-4 shadow-sm border border-light-subtle fade-in-up">
                                    <h5 class="fw-bold mb-2">Référence : #{{ $demande->contrat->reference }}</h5>
                                    <p class="mb-1">Motif : {{ $demande->motif }}</p>
                                    <p class="mb-1">Date : {{ $demande->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="mb-1">
                                        Statut :
                                        @if ($demande->statut === 'en_attente')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                        @elseif($demande->statut === 'acceptee')
                                            <span class="badge bg-success">Acceptée</span>
                                        @else
                                            <span class="badge bg-danger">Refusée</span>
                                        @endif
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        @if ($demande->statut === 'en_attente')
                                            <a href="#"
                                               onclick="event.preventDefault(); document.getElementById('form-accepter-{{ $demande->id }}').submit();"
                                               class="btn btn-outline-success btn-sm rounded-pill">
                                                <i class="fas fa-check-circle"></i> Accepter
                                            </a>
                                            <a href="#"
                                               onclick="event.preventDefault(); document.getElementById('form-refuser-{{ $demande->id }}').submit();"
                                               class="btn btn-outline-danger btn-sm rounded-pill">
                                                <i class="fas fa-times-circle"></i> Refuser
                                            </a>
                                        @endif
                                        <a href="{{ route('biens.show', ['bien_id' => $demande->contrat->bien->id]) }}"
                                           class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="fas fa-file-contract"></i> Voir contrat
                                        </a>
                                        <form id="form-accepter-{{ $demande->id }}"
                                              action="{{ route('modification.accepter', $demande->id) }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                        <form id="form-refuser-{{ $demande->id }}"
                                              action="{{ route('modification.refuser', $demande->id) }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- DEMANDES ENVOYÉES --}}
            <div class="col-lg-5 col-md-6">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header text-center rounded-top-4" style="background-color: #2E7D32;">
                        <h4 class="text-white fw-semibold m-0 py-2">Vos demandes envoyées</h4>
                    </div>
                    <div class="card-body ">
                        @if ($demandesEnvoyees->isEmpty())
                            <p class="text-center text-muted fst-italic">Vous n’avez envoyé aucune demande.</p>
                        @else
                            @foreach ($demandesEnvoyees as $demande)
                                <div class="bg-light p-3 mb-3 rounded-4 shadow-sm border border-light-subtle fade-in-up">
                                    <h5 class="fw-bold mb-2">Référence : #{{ $demande->contrat->reference }}</h5>
                                    <p class="mb-1">Motif : {{ $demande->motif }}</p>
                                    <p class="mb-1">Date : {{ $demande->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="mb-1">
                                        Statut :
                                        @if ($demande->statut === 'en_attente')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                        @elseif($demande->statut === 'acceptee')
                                            <span class="badge bg-success">Acceptée</span>
                                        @else
                                            <span class="badge bg-danger">Refusée</span>
                                        @endif
                                    </p>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="{{ route('biens.show', ['bien_id' => $demande->contrat->bien->id]) }}"
                                           class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="fas fa-file-contract"></i> Voir contrat
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.fade-in-up');
            cards.forEach((card, i) => {
                setTimeout(() => {
                    card.classList.add('visible');
                }, 120 * i);
            });
        });
    </script>
@endsection
