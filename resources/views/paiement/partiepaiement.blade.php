@extends('layouts.master_dash')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Paiement pour ce mois</h2>

    <!-- Informations de la période -->
    <div class="card mb-4 shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Période de Gestion</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6 col-12 mb-3">
                    <p><strong>Date de début :</strong> {{ $gestionPeriode->date_debut_periode }}</p>
                </div>
                <div class="col-sm-6 col-12 mb-3">
                    <p><strong>Date de fin :</strong> {{ $gestionPeriode->date_fin_periode }}</p>
                </div>
                <div class="col-sm-6 col-12 mb-3">
                     <p><strong>Montant total de la période (loyer_mensuel du Bien loué avec si nécessaire <br> frais (eau,electricité,,)) :</strong> 
                        {{ $gestionPeriode->montant_total_periode ?? 'Non défini' }} FCFA
                    </p>
                </div>
                <div class="col-sm-6 col-12 mb-3">
                    <p><strong>Montant restant :</strong> 
                        {{ $gestionPeriode->montant_restant_periode ?? 'Non défini' }} FCFA
                    </p>
                </div>
                <div class="col-12">
                    <p><strong>Complément période :</strong> 
                        {{ $gestionPeriode->complement_periode ?? 'Non défini' }} FCFA
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Explications pour l'utilisateur -->
    @if ($complementRequis)
        <div class="alert alert-warning shadow-sm">
            <strong>Important :</strong> 
            Le montant total de la période à payer n'a pas encore été déterminé. Cela peut être dû au fait que certains frais comme les charges d'électricité ou d'autres frais supplémentaires ne sont pas encore inclus. 
            
            <p class="mt-3">Veuillez indiquer un complément dans le champ ci-dessous pour calculer le montant total à payer :</p>
            <ul>
                <li>Si aucun frais supplémentaire ne s'applique, entrez "0" dans le champ complément.</li>
                <li>Ajoutez tout montant correspondant à des charges comme l'électricité, l'eau, etc.</li>
            </ul>
        </div>

        <!-- Formulaire pour saisir un complément -->
        <div class="card shadow border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('paiement.partiepaiement') }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label for="complement_periode" class="form-label">Complément de période (en FCFA)</label>
                        <input type="number" step="0" class="form-control" id="complement_periode" name="complement_periode" 
                               value="{{ old('complement_periode') }}" placeholder="Entrez un montant">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block w-100">Envoyer</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info shadow-sm">
            <strong>Note :</strong> Le montant total de la période a été déterminé. 
            <br>Vous pouvez vérifier les informations ci-dessus et  payer maintenant
            <br> En cas de souci contacter votre agence par le "assistance"
        </div>
    @endif

    <!-- Bouton "Payer maintenant" -->
    @if (!$complementRequis)
        <div class="d-flex justify-content-center mt-4">
            <a href="j.m" class="btn btn-success btn-lg shadow">
                <i class="fas fa-credit-card"></i> Payer maintenant
            </a>
        </div>
    @endif
</div>
@endsection
