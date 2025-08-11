@extends('layouts.master_dash')

@section('content')
<div class="container my-5">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-gradient-primary text-center py-3 rounded-top-4">
            <h3 class="mb-0 fw-bold">
                Paiement - ETAPE 1/3
            </h3>
        </div>
        <div class="card-body p-4">
            {{-- Message absence contrat ou période --}}
            @if(isset($message))
                <div class="border border-danger rounded-3 p-4 text-center bg-light">
                    <h4 class="text-danger fw-bold mb-3">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ $message }}
                    </h4>
                    <p class="mb-0 text-muted">
                        Cette page est vide car aucun contrat de bail actif n’est associé à votre compte.<br>
                        Veuillez contacter l’agence si besoin.
                    </p>
                </div>
            @elseif($periode)
                {{-- Infos locataire --}}
                <section class="mb-4">
                    <h5 class="fw-bold text-primary border-start border-4 border-primary ps-3 mb-3">
                        <i class="fas fa-user-circle me-2"></i> Informations du locataire
                    </h5>
                    <p class="mb-1"><strong>Nom :</strong> {{ $periode->locataire->nom }} {{ $periode->locataire->prenom }}</p>
                </section>

                {{-- Infos bien --}}
                <section class="mb-4">
                    <h5 class="fw-bold text-primary border-start border-4 border-primary ps-3 mb-3">
                        <i class="fas fa-home me-2"></i> Détails du bien
                    </h5>
                    <p class="mb-1"><strong>Nom :</strong> {{ $periode->contratDeBail->bien->name_bien }}</p>
                    <p class="mb-1"><strong>Type :</strong> {{ $periode->contratDeBail->bien->type_bien }}</p>
                    <p><strong>Adresse :</strong> {{ $periode->contratDeBail->bien->adresse_bien }}</p>
                </section>

                {{-- Infos période --}}
                <section class="mb-4">
                    <h5 class="fw-bold text-primary border-start border-4 border-primary ps-3 mb-3">
                        <i class="fas fa-calendar-alt me-2"></i> Période de facturation
                    </h5>
                    <p class="mb-1"><strong>Du :</strong> {{ \Carbon\Carbon::parse($periode->date_debut_periode)->format('d/m/Y') }}</p>
                    <p><strong>Au :</strong> {{ \Carbon\Carbon::parse($periode->date_fin_periode)->format('d/m/Y') }}</p>
                </section>

                {{-- Avertissement --}}
                <div class="alert alert-warning d-flex align-items-center rounded-4" role="alert">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        Vérifiez qu'il s'agit du bien correspondant au mois actuel de la période de location et appuyez Continuez pour consulter le restant à payer.
                        <br>Si ce n'est pas le cas, contactez votre agence par le menu "Assistance en ligne".                        
                    </div>
                </div>

                {{-- Bouton paiement --}}
                <div class="text-center mt-4">
                    <a href="{{ route('paiement.partiepaiement') }}" class="btn btn-lg btn-primary px-5 rounded-pill shadow">
                        <i class="fas fa-credit-card me-2"></i> Continuer
                    </a>
                </div>
            @else
                <div class="border border-warning rounded-3 p-4 text-center bg-light">
                    <h4 class="text-warning fw-bold mb-3">
                        <i class="fas fa-exclamation-circle me-2"></i> Aucune période trouvée
                    </h4>
                    <p class="mb-0 text-muted">
                        Aucune période de gestion n’a encore été générée pour votre contrat.<br>
                        Veuillez réessayer plus tard.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
