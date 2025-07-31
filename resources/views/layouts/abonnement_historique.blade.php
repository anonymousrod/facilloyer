

@extends('layouts.master_dash')
@section('title', 'Historique des abonnements')

@section('content')
<div class="container-xxl">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">

                <div class="mb-3 card-header d-flex justify-content-between align-items-center animate__animated animate__fadeInDown"
                    style="background: linear-gradient(90deg, #28a745 60%, #43e97b 100%); color: #fff; box-shadow: 0 4px 16px rgba(40,167,69,0.15); border-radius: 18px 18px 0 0; border: none;">
                    <h4 class="card-title mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-history"></i>
                        <span>Historique de mes abonnements</span>
                    </h4>
                </div>

                <div class="card-body pt-0 animate__animated animate__fadeInUp" style="border-radius: 0 0 18px 18px;">
                    @if ($abonnements->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle datatable" id="datatable_abonnements" style="border-radius: 12px; overflow: hidden;">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-layer-group"></i> Plan</th>
                                        <th><i class="fas fa-calendar-plus"></i> Début</th>
                                        <th><i class="fas fa-calendar-times"></i> Fin</th>
                                        <th><i class="fas fa-money-bill-wave"></i> Montant</th>
                                        <th><i class="fas fa-info-circle"></i> Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($abonnements as $abonnement)
                                        <tr class="animate__animated animate__fadeIn animate__faster">
                                            <td><span class="fw-bold text-dark">{{ $abonnement->plan->nom }}</span></td>
                                            <td>{{ \Carbon\Carbon::parse($abonnement->date_debut)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($abonnement->date_fin)->format('d/m/Y') }}</td>
                                            <td>{{ number_format($abonnement->plan->prix, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                @if ($abonnement->status === 'actif')
                                                    <span class="badge bg-success">Actif</span>
                                                @elseif ($abonnement->status === 'expiré')
                                                    <span class="badge bg-danger">Expiré</span>
                                                @else
                                                    <span class="badge bg-secondary">Inconnu</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning text-center mt-4">
                            Aucun historique d’abonnement disponible.
                        </div>
                    @endif
                </div> <!--end card-body-->
            </div> <!--end card-->
        </div> <!--end col-->
    </div> <!--end row-->
</div>

<!-- Animation CSS (Animate.css CDN) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<!-- FontAwesome CDN (si pas déjà inclus) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
<style>
    .table thead th {
        border: none;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .table-hover tbody tr:hover {
        background: #374151;
        color: #fff;
        box-shadow: 0 2px 12px rgba(55,65,81,0.10);
        transition: background 0.2s, box-shadow 0.2s, color 0.2s;
    }
    .badge {
        font-size: 1em;
        padding: 0.5em 0.8em;
        border-radius: 12px;
    }
</style>
@endsection
