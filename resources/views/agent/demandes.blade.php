@extends('layouts.master_dash')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top">
                    <h3 class="card-title mb-0">Demandes de maintenance</h3>
                </div>
                <div class="card-body p-4">
                    @if ($demandes->isEmpty())
                        <div class="alert alert-info text-center">
                            <strong>Aucune demande de maintenance trouvée.</strong>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-bordered text-center shadow">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Bien</th>
                                        <th>Description</th>
                                        <th>Statut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($demandes as $demande)
                                        <tr>
                                            <td>{{ $demande->id }}</td>
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
                                            <td>
                                                <a href="{{ route('agent.demandes.show', $demande->id) }}" class="btn btn-info btn-sm">
                                                    Voir
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Design similaire au précédent avec des effets 4D */
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

    .btn-info {
        border: none;
        border-radius: 25px;
        box-shadow: 5px 5px 15px #b0b0b0, -5px -5px 15px #ffffff;
        transition: all 0.3s ease-in-out;
    }

    .btn-info:hover {
        box-shadow: 5px 5px 15px #9d9d9d, -5px -5px 15px #ffffff;
        background-color: #007bff;
    }

    .badge {
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 20px;
        box-shadow: 2px 2px 6px #d1d1d1, -2px -2px 6px #ffffff;
    }
</style>
@endsection
