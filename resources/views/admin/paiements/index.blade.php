
@extends('layouts.master_dash')

@section('content')
<div class="container mt-4">
    <!-- Formulaire de recherche avec design amélioré -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <form action="{{ route('admin.paiements.index') }}" method="GET" class="input-group input-group-lg">
                <input type="text" name="search" class="form-control form-control-lg" placeholder="Rechercher par nom de locataire ou agence" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-warning btn-lg" type="submit">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <h2 class="text-center mb-4">Historique des Paiements</h2>

    @foreach ($paiements as $agence => $paiementsAgence)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <strong>{{ $agence }}</strong>
                <span class="badge badge-light">{{ $paiementsAgence->count() }} Paiements</span>
            </div>
            <div class="card-body">
                @foreach ($paiementsAgence->take(5) as $paiement)
                    <div class="mb-3">
                        <h5 class="text-secondary">Locataire : {{ $paiement->locataire->nom ?? 'Inconnu' }} {{ $paiement->locataire->prenom ?? '' }}</h5>
                        <p><strong>Bien : </strong>{{ $paiement->bien->name_bien ?? 'Bien inconnu' }}</p>
                        <p><strong>Montant payé : </strong>{{ number_format($paiement->montant_paye, 2) }} FCFA</p>
                        <p><strong>Statut : </strong>{{ $paiement->statut_paiement }}</p>
                        <a href="{{ route('admin.paiements.details', $paiement->id) }}" class="btn btn-info btn-sm">Voir détails</a>
                    </div>
                    <hr>
                @endforeach

                <!-- Voir plus pour afficher tous les paiements de l'agence -->
                @if ($paiementsAgence->count() > 5)
                    <div class="text-center">
                        <a href="#" class="btn btn-outline-primary voir-plus">Voir plus</a>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

<!-- Script pour afficher plus de paiements -->
<script>
    document.querySelectorAll('.voir-plus').forEach(button => {
        button.addEventListener('click', function() {
            const agenceCard = button.closest('.card-body');
            agenceCard.querySelectorAll('.mb-3').forEach((paiement, index) => {
                if (index >= 5) {
                    paiement.style.display = 'block';  // Afficher les paiements supplémentaires
                }
            });
            button.style.display = 'none'; // Masquer le bouton "Voir plus"
        });
    });
</script>

@endsection


<style>



.card {
    border-radius: 12px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

/* Header styling */
.card-header {
    border-radius: 12px 12px 0 0;
    font-size: 1.2rem;
}

/* Button styling */
.btn-outline-primary {
    transition: background-color 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    color: white;
}

/* Search box */
.input-group {
    border-radius: 50px;
    overflow: hidden;
}

.input-group input {
    border-radius: 50px 0 0 50px;
}

.input-group .btn {
    border-radius: 0 50px 50px 0;
}

/* Voir plus animation */
.voir-plus {
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.voir-plus:hover {
    transform: scale(1.05);
    opacity: 0.9;
}
</style>