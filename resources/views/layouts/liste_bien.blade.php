@extends('layouts.master_dash')
@section('title', 'Liste des Biens')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Liste des Biens - Exportations Disponibles</h4>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table datatable" id="datatable_2">
                                <thead class="">
                                    <tr>
                                        <th>Photo</th>
                                        <th>Nom du Bien</th>
                                        <th>Adresse</th>
                                        <th>Chambres</th>
                                        <th>m²</th>
                                        <th>Statut</th>
                                        <th>Prix (FCFA)</th>
                                        <th class="text-center align-middle">Action</th>                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biens as $bien)
                                        <tr>
                                            <!-- Photo du Bien -->
                                            <td>
                                                <img src="{{ asset($bien->photo_bien) }}"
                                                    alt="Photo de {{ $bien->name_bien }}"
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                            </td>

                                            <!-- Nom du Bien -->
                                            <td>{{ $bien->name_bien }}</td>

                                            <!-- Adresse -->
                                            <td>{{ \Illuminate\Support\Str::words($bien->adresse_bien, 2, '...') }}</td>

                                            <!-- Nombre de Chambres -->
                                            <td>{{ $bien->nbr_chambres }}</td>

                                            <!-- Superficie -->
                                            <td>{{ $bien->superficie }}</td>

                                            <!-- Statut -->
                                            <td>
                                                <span class="badge
                                                    {{ $bien->statut_bien == 'Disponible' ? 'bg-success' : ($bien->statut_bien == 'Loué' ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $bien->statut_bien }}
                                                </span>
                                            </td>

                                            <!-- Prix -->
                                            <td>{{ number_format($bien->loyer_mensuel, 0, ',', ' ') }}</td>

                                            <!-- Actions -->
                                            {{-- {{ route('locataire.show', $locataire->id) }} --}}
                                            {{-- <td>
                                                <a href="{{ route('bien_detail')}}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Voir Détails
                                                </a>
                                            </td> --}}

                                            <td class="text-center align-middle">
                                                <a href="{{ route('biens.show', ['bien_id' =>$bien->id]  )}}" class="btn btn-outline-primary">
                                                    <span class="bi bi-info-circle-fill"></span>
                                                </a>
                                                <!-- Button supprimer modal -->
                                                {{-- <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="">
                                                    <span class="text-danger bi bi-trash"></span>
                                                </button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="" class="btn btn-sm btn-primary pdf">
                                <i class="fas fa-file-pdf"></i> Exporter en PDF
                            </a>
                            {{-- <button type="button" class="btn btn-sm btn-primary csv">Export PDF</button> --}}
                            {{-- <button type="button" class="btn btn-sm btn-primary sql">Export SQL</button>
                        <button type="button" class="btn btn-sm btn-primary txt">Export TXT</button>
                        <button type="button" class="btn btn-sm btn-primary json">Export JSON</button> --}}
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div><!--end row-->


        {{-- voir le script equivalent dans layouts script... --}}

    </div>

@endsection

