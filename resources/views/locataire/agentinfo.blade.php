@extends('layouts.master_dash')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Informations de l\'agent immobilier') }}
                    </div>

                    <div class="card-body">
                        @if ($agent)
                            <ul>
                                <li><strong>Nom de l'agence:</strong> {{ $agent->nom_agence }}</li>
                                <li><strong>Nom de l'administrateur:</strong> {{ $agent->nom_admin }} {{ $agent->prenom_admin }}</li>
                                <li><strong>Téléphone:</strong> {{ $agent->telephone_agence }}</li>
                                <li><strong>Adresse:</strong> {{ $agent->adresse_agence }}</li>
                                <li><strong>Territoire couvert:</strong> {{ $agent->territoire_couvert }}</li>
                                <li><strong>Années d'expérience:</strong> {{ $agent->annee_experience }} ans</li>
                                <li><strong>Nombre de biens disponibles:</strong> {{ $agent->nombre_bien_disponible }}</li>
                            </ul>
                        @else
                            <p>Aucun agent immobilier associé à ce locataire.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection