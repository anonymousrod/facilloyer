@extends('layouts.master_dash')
@section('title', 'Information')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Information-detail</h4>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table datatable" id="datatable_2">
                                <thead>
                                    <tr>
                                        <th>Nom du Locataire</th>
                                        <th>Date Début</th>
                                        <th>Date Fin</th>
                                        <th>Montant Total (FCFA)</th>
                                        <th>Montant Restant (FCFA)</th>
                                        <th>Complément</th>
                                        {{-- <th class="text-center">Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gestionPeriodes as $periode)
                                        <tr>
                                            <td>{{ $periode->locataire->nom }} {{ $periode->locataire->prenom }}</td>
                                            <td>{{ \Carbon\Carbon::parse($periode->date_debut_periode)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($periode->date_fin_periode)->format('d/m/Y') }}</td>
                                            <td>{{ number_format($periode->montant_total_periode, 0, ',', ' ') }}</td>
                                            <td>{{ number_format($periode->montant_restant_periode, 0, ',', ' ') }}</td>
                                            <td>{{ $periode->complement_periode }}</td>
                                            {{-- <td class="text-center">
                                                <a href="{{ route('gestion_periode.show', $periode->id) }}" class="btn btn-outline-primary">
                                                    <span class="bi bi-info-circle-fill"></span>
                                                </a>
                                            </td> --}}
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

