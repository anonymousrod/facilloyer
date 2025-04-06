@extends('layouts.master_dash')
@section('title', 'Gestion Agent Immobilier')
@section('content')
    <div class="container">
        <h2 class="mb-4">Demandes de modification de contrat</h2>

        {{-- Messages Flash --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- DEMANDES REÇUES --}}
        <h4>Demandes reçues</h4>
        @if ($demandesRecues->isEmpty())
            <p>Aucune demande reçue.</p>
        @else
            <div class="table-responsive mb-5">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Réference du Contrat</th>
                            <th>Motif</th>
                            {{-- <th>Envoyé par</th> --}}
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demandesRecues as $demande)
                            <tr>
                                <td style="white-space: normal; word-break: break-word;">#{{ $demande->contrat->reference }}
                                </td>
                                <td style="white-space: normal; word-break: break-word;">{{ $demande->motif }}</td>
                                {{-- <td>{{ ucfirst($demande->demande_par) }}</td> --}}
                                <td>{{ $demande->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if ($demande->statut === 'en_attente')
                                        <span class="badge bg-warning text-dark">En attente</span>
                                    @elseif($demande->statut === 'acceptee')
                                        <span class="badge bg-success">Acceptée</span>
                                    @else
                                        <span class="badge bg-danger">Refusée</span>
                                    @endif
                                </td>
                                {{-- <td>
                                    @if ($demande->statut === 'en_attente')
                                        <form action="{{ route('modification.accepter', $demande->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-success">Accepter</button>
                                        </form>
                                        <form action="{{ route('modification.refuser', $demande->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-danger">Refuser</button>
                                        </form>
                                        <a href="{{ route('biens.show', ['bien_id' => $demande->contrat->bien->id]) }}"
                                            class="">
                                            <span class="badge bg-success">Voir le contrat</span>
                                        </a>
                                    @else
                                        <a href="{{ route('biens.show', ['bien_id' => $demande->contrat->bien->id]) }}"
                                            class="">
                                            <span class="badge bg-success">Voir le contrat</span>
                                        </a>
                                    @endif
                                </td> --}}
                                <td>
                                    @if ($demande->statut === 'en_attente')
                                        <div class="d-flex gap-3 flex-wrap align-items-center">

                                            {{-- Bouton stylisé "Accepter" --}}
                                            <a href="#"
                                                onclick="event.preventDefault(); document.getElementById('form-accepter-{{ $demande->id }}').submit();"
                                                class="btn p-0 border-0 d-flex align-items-center text-success text-decoration-none">
                                                <i class="fas fa-check-circle me-1"></i>Accepter
                                            </a>

                                            {{-- Bouton stylisé "Refuser" --}}
                                            <a href="#"
                                                onclick="event.preventDefault(); document.getElementById('form-refuser-{{ $demande->id }}').submit();"
                                                class="btn p-0 border-0 d-flex align-items-center text-danger text-decoration-none">
                                                <i class="fas fa-times-circle me-1"></i>Refuser
                                            </a>

                                            {{-- Bouton voir contrat --}}
                                            <a href="{{ route('biens.show', ['bien_id' => $demande->contrat->bien->id]) }}"
                                                class="btn p-0 border-0 d-flex align-items-center text-success text-decoration-none">
                                                <i class="fas fa-file-contract me-1"></i>Voir le contrat
                                            </a>

                                            {{-- Formulaires cachés --}}
                                            <form id="form-accepter-{{ $demande->id }}"
                                                action="{{ route('modification.accepter', $demande->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="form-refuser-{{ $demande->id }}"
                                                action="{{ route('modification.refuser', $demande->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                        </div>
                                    @else
                                        <a href="{{ route('biens.show', ['bien_id' => $demande->contrat->bien->id]) }}"
                                            class="btn p-0 border-0 d-flex align-items-center text-success text-decoration-none">
                                            <i class="fas fa-file-contract me-1"></i>Voir le contrat
                                        </a>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- DEMANDES ENVOYÉES --}}
        <h4>Vos demandes envoyées</h4>
        @if ($demandesEnvoyees->isEmpty())
            <p>Vous n’avez envoyé aucune demande.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Réference du Contrat</th>
                            <th>Motif</th>
                            {{-- <th>Envoyée à</th> --}}
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demandesEnvoyees as $demande)
                            <tr>
                                <td style="white-space: normal; word-break: break-word;">
                                    #{{ $demande->contrat->reference }}</td>
                                <td style="white-space: normal; word-break: break-word;">{{ $demande->motif }}</td>
                                {{-- <td>
                                    {{ $demande->demande_par === 'locataire' ? 'Agent immobilier' : 'Locataire' }}
                                </td> --}}
                                <td>{{ $demande->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if ($demande->statut === 'en_attente')
                                        <span class="badge bg-warning text-dark">En attente</span>
                                    @elseif($demande->statut === 'acceptee')
                                        <span class="badge bg-success">Acceptée</span>
                                    @else
                                        <span class="badge bg-danger">Refusée</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('biens.show', ['bien_id' => $demande->contrat->bien->id]) }}"
                                        class="">
                                        <span class="badge bg-success">Voir le contrat</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
