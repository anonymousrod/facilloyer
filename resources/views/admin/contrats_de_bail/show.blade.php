<!-- resources/views/admin/contrats_de_bail/show.blade.php -->

@extends('layouts.master_dash')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Détails du Contrat de Bail</h1>
            <a href="{{ route('admin.contrats_de_bail.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <a href="{{ route('admin.contrats_de_bail.export_pdf', $contratDeBailLocataire->id) }}" class="btn btn-success">
                <i class="fas fa-download"></i> Exporter en PDF
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Contrat de Bail N°{{ $contratDeBailLocataire->id }}</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Locataire</th>
                        <td>{{ $contratDeBailLocataire->locataire->nom }} {{ $contratDeBailLocataire->locataire->prenom }}</td>
                    </tr>
                    <tr>
                        <th>Bien</th>
                        <td>{{ $contratDeBailLocataire->contrats_de_bail->bien->adresse_bien }}</td>
                    </tr>
                    <tr>
                        <th>Date de Début</th>
                        <td>{{ \Carbon\Carbon::parse($contratDeBailLocataire->date_debut)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Date de Fin</th>
                        <td>{{ \Carbon\Carbon::parse($contratDeBailLocataire->date_fin)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Complément au Loyer</th>
                        <td>{{ $contratDeBailLocataire->complement_au_loyer }} XOF</td>
                    </tr>
                    <tr>
                        <th>Montant Restant</th>
                        <td>{{ $contratDeBailLocataire->montant_restant }} XOF</td>
                    </tr>
                    <tr>
                        <th>Montant Total pour la Période</th>
                        <td>{{ $contratDeBailLocataire->montant_total_periode }} XOF</td>
                    </tr>
                    <tr>
                        <th>Période de Paiement</th>
                        <td>{{ $contratDeBailLocataire->periode_paiement }}</td>
                    </tr>
                    <tr>
                        <th>Statut du Paiement</th>
                        <td>{{ $contratDeBailLocataire->statut_paiement }}</td>
                    </tr>
                    <tr>
                        <th>Échéance de Paiement</th>
                        <td>{{ \Carbon\Carbon::parse($contratDeBailLocataire->echeance_paiement)->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
