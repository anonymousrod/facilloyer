@extends('layouts.master_dash')

@section('content')

<div class="container mt-5">
    <h2 class="text-center mb-4 text-light">Paiement pour ce mois</h2>

    <!-- Informations de la période -->
    <div class="card mb-4 shadow-lg border-0 bg-dark text-light">
        <div class="card-header bg-gradient-to-r from-blue-500 to-purple-700 text-white d-flex justify-content-between align-items-center">
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
                    <p><strong>Montant total de la période (correspondant au loyer mensuel avec les compléments "eau, électricité, ...") :</strong> 
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
            <strong>Important :</strong> Le montant total de la période à payer n'a pas encore été déterminé.
            <p class="mt-3">Veuillez indiquer un complément dans le champ ci-dessous pour calculer le montant total à payer :</p>
            <ul>
                <li>Si aucun frais supplémentaire ne s'applique, entrez "0" dans le champ complément.</li>
                <li>Ajoutez la somme de tout montant correspondant à des charges comme l'électricité, l'eau, etc.</li>
            </ul>
        </div>

        <!-- Formulaire pour saisir un complément -->
        <div class="card shadow-lg border-0 mb-4 bg-dark text-light">
            <div class="card-body">
                <form action="{{ route('paiement.partiepaiement') }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label for="complement_periode" class="form-label">Complément de période (en FCFA)</label>
                        <input type="number" step="0" class="form-control bg-secondary text-light border-0" id="complement_periode" name="complement_periode" 
                               value="{{ old('complement_periode') }}" placeholder="Entrez un montant">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block w-100">Envoyer</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info shadow-sm">
            <strong>Note :</strong> Le montant total de la période a été déterminé.
            <br>Vous pouvez vérifier les informations ci-dessus et payer maintenant.
            <br>En cas de souci, contactez votre agence par le menu "Assistance".
        </div>
    @endif

    <!-- Bouton "Payer maintenant" -->
    @if (!$complementRequis)
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('payments.form') }}" 
               class="btn btn-gradient text-white btn-lg shadow" 
               style="background: linear-gradient(90deg, #56ab2f, #a8e063); border: none;">
                <i class="fas fa-credit-card"></i> Payer maintenant
            </a>
        </div>
    @endif
</div>
@endsection
