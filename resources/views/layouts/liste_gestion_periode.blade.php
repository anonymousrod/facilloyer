@extends('layouts.master_dash')
@section('title', 'Auditer Loyer')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="mb-3 card-header d-flex justify-content-between align-items-center animate__animated animate__fadeInDown"
                        style="background: linear-gradient(90deg, #28a745 60%, #43e97b 100%); color: #fff; box-shadow: 0 4px 16px rgba(40,167,69,0.15); border-radius: 18px 18px 0 0; border: none;">
                        <h4 class="card-title mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Auditer Loyer</span>
                        </h4>
                    </div>
                    <div class="card-body pt-0 animate__animated animate__fadeInUp" style=" border-radius: 0 0 18px 18px;">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle datatable" id="datatable_2" style="border-radius: 12px; overflow: hidden;">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-user"></i> Nom du Locataire</th>
                                        <th><i class="fas fa-calendar-day"></i> Date Début</th>
                                        <th><i class="fas fa-calendar-check"></i> Date Fin</th>
                                        <th><i class="fas fa-money-bill-wave"></i> Montant Total (FCFA)</th>
                                        <th><i class="fas fa-coins"></i> Montant Restant (FCFA)</th>
                                        <th><i class="fas fa-info-circle"></i> Complément</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gestionPeriodes as $periode)
                                        <tr class="animate__animated animate__fadeIn animate__faster" style="transition: box-shadow 0.2s;">
                                            <td><span class="fw-bold text-dark">{{ $periode->locataire->nom }} {{ $periode->locataire->prenom }}</span></td>
                                            <td>{{ \Carbon\Carbon::parse($periode->date_debut_periode)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($periode->date_fin_periode)->format('d/m/Y') }}</td>
                                            <td class="text-success fw-bold">{{ number_format($periode->montant_total_periode, 0, ',', ' ') }}</td>
                                            <td class="text-danger fw-bold">{{ number_format($periode->montant_restant_periode, 0, ',', ' ') }}</td>
                                            <td>{{ $periode->complement_periode }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div><!--end row-->
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
    .btn-circle {
        border-radius: 50% !important;
        width: 38px;
        height: 38px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .btn-circle-eye {
        border-radius: 50% !important;
        width: 38px;
        height: 38px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 2px solid #28a745;
        box-shadow: 0 2px 8px rgba(40,167,69,0.08);
        transition: background 0.2s, border 0.2s;
    }
    .btn-circle-eye:hover {
        background: #28a745;
        border-color: #43e97b;
    }
    .badge {
        font-size: 1em;
        padding: 0.5em 0.8em;
        border-radius: 12px;
    }
    .icon-voir-details-custom {
        color: #28a745;
        font-size: 1.2rem;
        transition: color 0.2s;
        font-weight: bold;
    }
    .btn-circle-eye:hover .icon-voir-details-custom {
        color: #fff;
    }
    @media (prefers-color-scheme: dark) {
        .btn-circle-eye {
            background: transparent;
            border: 2px solid #43e97b;
        }
        .icon-voir-details-custom {
            color: #43e97b !important;
        }
        .btn-circle-eye:hover {
            background: #43e97b;
            border-color: #28a745;
        }
        .btn-circle-eye:hover .icon-voir-details-custom {
            color: #212529 !important;
        }
    }
</style>
@endsection

