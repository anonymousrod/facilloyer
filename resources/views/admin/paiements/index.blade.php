@extends('layouts.master_dash')

@section('content')
<div class="container">
    <!-- En-tête avec champ de recherche -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6> <b>Historique des Paiements</b></h6>
        <!-- Champ de recherche amélioré -->
        <div class="search-box">
            <input type="text" id="searchPaiements" class="form-control" placeholder="🔍  Nom locataire ou date ">
        </div>
    </div>

    <!-- Liste des paiements -->
    <div class="row" id="paiementsContainer">
        @foreach($paiements as $paiement)
        <div class="col-md-6 col-lg-4 mb-4 paiement-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title locataire-nom">{{ $paiement->locataire->nom }} {{ $paiement->locataire->prenom }}</h5>
                    <p class="text-muted mb-2"><strong>Bien :</strong> {{ $paiement->bien->name_bien }}</p>
                    <p class="text-muted mb-2 montant"><strong>Montant :</strong> {{ number_format($paiement->montant, 2, ',', ' ') }} €</p>
                    <p class="text-muted mb-2 date"><strong>Date :</strong> {{ $paiement->date->format('d/m/Y') }}</p>
                    <p class="text-muted mb-2">
                        <strong>Agence :</strong> {{ $paiement->bien->agent_immobilier->nom_agence }} <br>
                        <small>{{ $paiement->bien->agent_immobilier->adresse_agence }}</small>
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <!-- Bouton pour voir plus -->
                        <a href="{{ route('admin.paiements.show', $paiement->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                        <!-- Bouton pour la quittance -->
                        <a href="{{ route('admin.paiements.quittance', $paiement->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-file-alt"></i> Quittance
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Script pour recherche -->
<script>
    document.getElementById('searchPaiements').addEventListener('keyup', function () {
        const searchValue = this.value.toLowerCase();
        const paiementCards = document.querySelectorAll('.paiement-card');

        paiementCards.forEach(function (card) {
            const locataireNom = card.querySelector('.locataire-nom').innerText.toLowerCase();
            const montant = card.querySelector('.montant').innerText.toLowerCase();
            const date = card.querySelector('.date').innerText.toLowerCase();

            // Recherche par préfixe : inclure si le texte saisi correspond au début des champs
            if (
                locataireNom.startsWith(searchValue) ||
                montant.startsWith(searchValue) ||
                date.startsWith(searchValue)
            ) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
<style>
    .search-box {
    position: relative;
    width: 300px;
}

.search-box input {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ced4da;
    border-radius: 50px;
    font-size: 14px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.search-box input:focus {
    border-color: #007bff;
    box-shadow: 0 3px 8px rgba(0, 123, 255, 0.5);
    outline: none;
}

.search-box input::placeholder {
    color: #adb5bd;
    font-size: 14px;
}

.search-box input:focus::placeholder {
    color: transparent;
}

.search-box::before {
    content: '🔍';
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    font-size: 16px;
    color: #adb5bd;
}

</style>
@endsection
