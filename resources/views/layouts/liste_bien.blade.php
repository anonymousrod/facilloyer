@extends('layouts.master_dash')
@section('title', 'Liste des Biens')
@section('content')
    <div class="container-xxl py-5" style="background-color: #F5F5F5;">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header" style="background-color: #212121; color: #FFFFFF;">
                        <div class="row align-items-center justify-content-between">
                            <div class="col">
                                <h4 class="card-title mb-0">Liste des Biens</h4>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="btn btn-success">
                                    <i class="fas fa-file-pdf"></i> Exporter en PDF
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle" id="datatable_2">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Photo</th>
                                        <th>Nom du Bien</th>
                                        <th>Adresse</th>
                                        <th>Chambres</th>
                                        <th>m²</th>
                                        <th>Statut</th>
                                        <th>Prix (FCFA)</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biens as $bien)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($bien->photo_bien) }}" alt="Photo de {{ $bien->name_bien }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td>{{ $bien->name_bien }}</td>
                                            <td>{{ \Illuminate\Support\Str::words($bien->adresse_bien, 2, '...') }}</td>
                                            <td>{{ $bien->nbr_chambres }}</td>
                                            <td>{{ $bien->superficie }}</td>
                                            <td>
                                                <span class="badge {{ $bien->statut_bien == 'Disponible' ? 'bg-success' : ($bien->statut_bien == 'Loué' ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $bien->statut_bien }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($bien->loyer_mensuel, 0, ',', ' ') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('biens.show', ['bien_id' => $bien->id]) }}" class="btn btn-outline-primary">
                                                    <i class="bi bi-info-circle-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

