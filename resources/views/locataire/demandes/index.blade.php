@extends('layouts.master_dash')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top">
                    <h3 class="card-title mb-0">Mes demandes de maintenance</h3>
                </div>
                <div class="card-body p-4">
                    <!-- Affichage des messages de succès ou d'erreur -->
                    @if (session('success'))
                        <div class="alert alert-success shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Table des demandes -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-bordered text-center shadow">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <!-- <th>N°</th> -->
                                    <th>Bien</th>
                                    <th>Description</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($demandes as $demande)
                                    <tr>
                                        <!-- <td><strong>{{ $demande->id }}</strong></td> -->
                                        <td>{{ $demande->bien->name_bien }}</td>
                                        <td>{{ $demande->description }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($demande->statut == 'en attente') bg-warning text-dark 
                                                @elseif($demande->statut == 'en cours') bg-info 
                                                @else bg-success @endif">
                                                {{ ucfirst($demande->statut) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Ajouter un bouton pour créer une nouvelle demande -->
                    <div class="text-center mt-4">
                        <a href="{{ route('locataire.demandes.create') }}" class="btn btn-primary btn-lg px-5 py-3 shadow">
                            Créer une demande
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Style CSS personnalisé -->
<style>
    body {
        background-color: #f5f5f5;
    }

    .card {
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
        border-radius: 15px;
        box-shadow: 10px 10px 30px #d9d9d9, -10px -10px 30px #ffffff;
    }

    .card-header {
        box-shadow: inset 5px 5px 10px #c8c8c8, inset -5px -5px 10px #ffffff;
    }

    table {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 15px;
        overflow: hidden;
    }

    th, td {
        vertical-align: middle;
        padding: 15px;
    }

    th {
        background-color: #f0f0f0;
        font-weight: bold;
        color: #333;
    }

    td {
        box-shadow: inset 3px 3px 6px #d1d1d1, inset -3px -3px 6px #ffffff;
        border: 1px solid #ddd;
    }

    .btn-primary {
        border: none;
        border-radius: 25px;
        box-shadow: 5px 5px 15px #b0b0b0, -5px -5px 15px #ffffff;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary:hover {
        box-shadow: 5px 5px 15px #9d9d9d, -5px -5px 15px #ffffff;
        background-color: #1565c0;
    }

    .badge {
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 20px;
        box-shadow: 2px 2px 6px #d1d1d1, -2px -2px 6px #ffffff;
    }
</style>
@endsection
