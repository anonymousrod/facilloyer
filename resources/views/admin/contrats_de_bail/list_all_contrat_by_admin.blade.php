@extends('layouts.master_dash')
@section('title', 'Liste des Contrat de bail')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Liste des Contrats de bail </h4>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table datatable" id="datatable_2">
                                <thead class="">
                                    <tr>
                                        <th>Référence</th>
                                        <th>Nom du bien</th>
                                        <th>Nom du locataire</th>
                                        <th>Statut</th>
                                        <th class="text-center align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contrats as $contrat)
                                        <tr>


                                            <!-- Référence -->
                                            <td>{{ $contrat->reference }}</td>

                                            <!-- Nom du bien -->
                                            <td>{{ $contrat->bien->name_bien }}</td>

                                            <!-- Nom du locataire -->
                                            <td>{{ $contrat->locataire->nom }} {{ $contrat->locataire->prenom }}</td>

                                            <!-- Statut -->
                                            <td>
                                                <span
                                                    class="badge
                                                    {{ $contrat->statut_contrat == 'Actif' ? 'bg-success' : ($contrat->statut_contrat == 'Terminé' ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $contrat->statut_contrat }}
                                                </span>
                                            </td>
                                            {{-- Action --}}
                                            <td class="text-center align-middle">
                                                {{-- on vas envoyer l'id du contrat et non l'id du bien --}}
                                                <a href="{{ route('biens.show', ['bien_id' => $contrat->id]) }}"
                                                    class="btn btn-outline-primary">
                                                    <span class="bi bi-info-circle-fill"></span>
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


        {{-- voir le script equivalent dans layouts script... --}}

    </div>

@endsection
