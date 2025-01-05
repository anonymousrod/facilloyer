@extends('layouts.master_dash')

@section('content')

<style>
    /* Styles généraux */
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f0f2f5;
    color: #333;
}

/* Container principal */
.container {
    max-width: 100%;
    margin-top: 50px;
    padding: 20px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Titre principal */
h1 {
    font-size: 26px;
    font-weight: 600;
    color: #2d2d2d;
    margin-bottom: 20px;
}

/* Bouton principal */
.btn-lg {
    font-size: 16px;
    padding: 8px 12px;
    border-radius: 50%;
    font-weight: bold;
    text-transform: uppercase;
    transition: background-color 0.3s ease;
}

.btn-success {
    background-color: #00b5ad;
    border: none;
}

.btn-success:hover {
    background-color: #008c7a;
}

/* Table */
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

th {
    font-size: 14px;
    color: #777;
    background-color: #f8f9fa;
}

/* Lignes survolées */
tr:hover {
    background-color: #f1f1f1;
}

/* Statut badge */
.badge {
    padding: 5px 15px;
    font-size: 13px;
    font-weight: bold;
    border-radius: 25px;
    text-transform: uppercase;
    color: #fff;
}

.badge-info { background-color: #17a2b8; }
.badge-primary { background-color: #007bff; }
.badge-success { background-color: #28a745; }
.badge-secondary { background-color: #6c757d; }

/* Alerte si vide */
.alert {
    padding: 20px;
    background-color: #f7c3c4;
    border: 1px solid #f7a3a6;
    color: #721c24;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.alert button {
    background: transparent;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #721c24;
}

.alert button:hover {
    color: #f1c6c7;
}

/* Animation de fade-in */
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

.table-responsive {
    animation: fadeIn 1s ease-out;
}

/* Responsivité */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    table {
        font-size: 12px;
    }

    th, td {
        padding: 8px 10px;
    }

    h1 {
        font-size: 22px;
    }

    .btn-lg {
        font-size: 14px;
        padding: 6px 8px;
    }
}
</style>

<div class="container mt-5">
    <h1 class="mb-2">Statut Demandes</h1>

    <!-- Bouton pour ajouter une nouvelle demande -->
    <div class="mb-4">
        <a href="{{ route('demandes.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus-circle"></i>
        </a>
    </div>

    <!-- Affichage des demandes -->
    @if($demandes->isEmpty())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Attention!</strong> Vous n'avez pas encore soumis de demande de maintenance.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th>Description</th>
                        <th>Statut</th>
                        <th>Date de soumission</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($demandes as $demande)
                        <tr>
                            <td>{{ $demande->libelle }}</td>
                            <td>{{ $demande->description }}</td>
                            <td>
                                <span class="badge 
                                    @if($demande->statut == 'En attente') badge-info
                                    @elseif($demande->statut == 'En cours') badge-primary
                                    @elseif($demande->statut == 'Résolu') badge-success
                                    @else badge-secondary
                                    @endif">
                                    {{ $demande->statut }}
                                </span>
                            </td>
                            <td>{{ $demande->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
