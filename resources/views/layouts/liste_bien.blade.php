@extends('layouts.master_dash')
@section('title', 'Liste des Biens')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="mb-3 card-header d-flex justify-content-between align-items-center animate__animated animate__fadeInDown"
                        style="background: linear-gradient(90deg, #28a745 60%, #43e97b 100%); color: #fff; box-shadow: 0 4px 16px rgba(40,167,69,0.15); border-radius: 18px 18px 0 0; border: none;">
                        <h4 class="card-title mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-home"></i>
                            <span>Liste des Biens</span>
                        </h4>
                        <a href="{{ route('export_biens.pdf')}}" class="btn btn-light btn-sm shadow-sm animate__animated animate__pulse animate__infinite" style="font-weight: bold; border-radius: 20px;">
                            <i class="fas fa-file-pdf text-danger"></i> Exporter en PDF
                        </a>
                    </div>
                    <div class="card-body pt-0 animate__animated animate__fadeInUp" style=" border-radius: 0 0 18px 18px;">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle datatable" id="datatable_2" style="border-radius: 12px; overflow: hidden;">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-image"></i> Photo</th>
                                        <th><i class="fas fa-home"></i> Nom du Bien</th>
                                        <th><i class="fas fa-map-marker-alt"></i> Adresse</th>
                                        <th><i class="fas fa-bed"></i> Chambres</th>
                                        <th><i class="fas fa-ruler-combined"></i> m²</th>
                                        <th><i class="fas fa-toggle-on"></i> Statut</th>
                                        <th><i class="fas fa-money-bill-wave"></i> Prix (FCFA)</th>
                                        <th class="text-center"><i class="fas fa-cogs"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biens as $bien)
                                        <tr class="animate__animated animate__fadeIn animate__faster" style="transition: box-shadow 0.2s;">
                                            <td>
                                                <img src="{{ asset($bien->photo_bien) }}" alt="Photo de {{ $bien->name_bien }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #28a745; box-shadow: 0 2px 8px rgba(40,167,69,0.08); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                                            </td>
                                            <td><span class="fw-bold text-dark">{{ $bien->name_bien }}</span></td>
                                            <td><span class="text-muted">{{ \Illuminate\Support\Str::words($bien->adresse_bien, 2, '...') }}</span></td>
                                            <td>{{ $bien->nbr_chambres }}</td>
                                            <td>{{ $bien->superficie }}</td>
                                            <td>
                                                <span class="badge {{ $bien->statut_bien == 'Disponible' ? 'bg-success' : ($bien->statut_bien == 'Loué' ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $bien->statut_bien }}
                                                </span>
                                            </td>
                                            <td><span class="badge bg-success bg-opacity-10 text-success fw-semibold">{{ number_format($bien->loyer_mensuel, 0, ',', ' ') }} FCFA</span></td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('biens.show', ['bien_id' => $bien->id]) }}" class="btn btn-link p-0 me-2 btn-circle-eye" title="Voir détails">
                                                    <i class="fas fa-eye icon-voir-details-custom"></i>
                                                </a>
                                            </td>
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

