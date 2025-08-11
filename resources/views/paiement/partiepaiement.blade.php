@extends('layouts.master_dash')

@section('content')
<div class="container my-5">
   
    <!-- Carte principale avec ombre légère et bord arrondi -->
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body">
            <h4 class="mb-4 fw-semibold border-bottom pb-2 text-primary">Détails de la période - ETAPE 2/3</h4>
            <div class="row gx-5 gy-3 text-dark fs-6">

                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-light">
                        <span>Date de début</span>
                        <strong>{{ \Carbon\Carbon::parse($gestionPeriode->date_debut_periode)->format('d/m/Y') }}</strong>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-light">
                        <span>Date de fin</span>
                        <strong>{{ \Carbon\Carbon::parse($gestionPeriode->date_fin_periode)->format('d/m/Y') }}</strong>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-light">
                        <span>Montant total</span>
                        <strong>{{ number_format($gestionPeriode->montant_total_periode ?? 0, 0, ',', ' ') }} FCFA</strong>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-light">
                        <span>Montant restant</span>
                        <strong>{{ number_format($gestionPeriode->montant_restant_periode ?? 0, 0, ',', ' ') }} FCFA</strong>
                    </div>
                </div>

                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-light">
                        <span>Complément période</span>
                        <strong>{{ number_format($gestionPeriode->complement_periode ?? 0, 0, ',', ' ') }} FCFA</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section complément requis -->
    @if($complementRequis)
        <div class="alert alert-warning rounded-4 mt-5 shadow-sm">
            <h5 class="fw-bold"><i class="fas fa-exclamation-circle me-2"></i> Action requise</h5>
            <p>Le montant total à payer n'est pas encore défini.</p>
            <p>Merci d’indiquer un complément ci-dessous pour calculer le total :</p>
            <ul class="mb-0 ps-4">
                <li>Entrez "0" si aucun frais supplémentaire n’est applicable.</li>
                <li>Incluez toutes charges supplémentaires (électricité, eau, etc.).</li>
            </ul>
        </div>

        <div class="card shadow-sm border-0 rounded-4 mt-4">
            <div class="card-body">
                <form action="{{ route('paiement.partiepaiement') }}" method="GET" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="complement_periode" class="form-label fw-semibold">Complément de période (FCFA)</label>
                        <input type="number" min="0" step="1" class="form-control rounded-pill" id="complement_periode" name="complement_periode" value="{{ old('complement_periode') }}" placeholder="Entrez un montant" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold py-2">
                        Envoyer
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info rounded-4 shadow-sm mt-5">
            <h5 class="fw-semibold"><i class="fas fa-info-circle me-2"></i> Informations</h5>
            <p>Le montant total est défini.</p>
            <p>Vérifiez les détails ci-dessus puis procédez au paiement.</p>
            <p>Pour toute question, contactez votre agence via "Assistance en ligne".</p>
        </div>
    @endif

    <!-- Bouton Payer -->
    @if(!$complementRequis)
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('paiement.form') }}" class="btn btn-success btn-lg rounded-pill shadow fw-semibold px-5 d-flex align-items-center gap-2">
                <i class="fas fa-credit-card fa-lg"></i> Payer maintenant
            </a>
        </div>
    @endif
</div>
@endsection
