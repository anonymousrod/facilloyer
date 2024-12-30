@extends('layouts.master_dash')

@section('title', 'Détails du paiement')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('locataire.paiements.quittance', $paiement->id) }}" 
                       class="btn btn-primary">
                        <i class="las la-file-pdf"></i> Télécharger la quittance
                    </a>
                </div>
                <h4 class="page-title">Détails du paiement #{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informations du paiement</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Date du paiement</label>
                                <p class="font-14">{{ $paiement->date->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Mode de paiement</label>
                                <p class="font-14">{{ $paiement->mode_paiement ?? 'Paiement mobile' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted">Loyer mensuel</label>
                                <p class="font-14 text-primary">{{ number_format($loyerMensuel, 2, ',', ' ') }} €</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted">Montant versé</label>
                                <p class="font-14 text-success">{{ number_format($paiement->montant, 2, ',', ' ') }} €</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted">Reste à payer</label>
                                <p class="font-14 text-danger">{{ number_format($montantRestant, 2, ',', ' ') }} €</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informations du logement</h5>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label text-muted">Adresse</label>
                                <p class="font-14">{{ $paiement->bien->adresse_bien }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Type</label>
                                <p class="font-14">{{ $paiement->bien->type_bien }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Superficie</label>
                                <p class="font-14">{{ $paiement->bien->superficie }} m²</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informations du bailleur</h5>
                    
                    @if($paiement->bien && $paiement->bien->agent_immobilier)
                        <div class="mb-3">
                            <label class="form-label text-muted">Agence</label>
                            <p class="font-14">{{ $paiement->bien->agent_immobilier->nom_agence }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Représentant</label>
                            <p class="font-14">
                                {{ $paiement->bien->agent_immobilier->nom_admin }}
                                {{ $paiement->bien->agent_immobilier->prenom_admin }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Contact</label>
                            <p class="font-14">{{ $paiement->bien->agent_immobilier->telephone_agence }}</p>
                        </div>
                    @else
                        <p class="text-muted">Information non disponible</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 