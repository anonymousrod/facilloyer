@extends('layouts.master_dash')
@section('title', 'Auditer Loyer')

@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white m-3 mb-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title mb-0">Auditer Loyer</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable" id="datatable_2">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th>Nom du Locataire</th>
                                        <th>Date Début</th>
                                        <th>Date Fin</th>
                                        <th>Montant Total (FCFA)</th>
                                        <th>Montant Restant (FCFA)</th>
                                        <th>Complément</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($gestionPeriodes as $periode)
                                        <tr>
                                            <td>{{ $periode->locataire->nom }} {{ $periode->locataire->prenom }}</td>
                                            <td>{{ \Carbon\Carbon::parse($periode->date_debut_periode)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($periode->date_fin_periode)->format('d/m/Y') }}</td>
                                            <td class="text-success fw-bold">{{ number_format($periode->montant_total_periode, 0, ',', ' ') }}</td>
                                            <td class="text-danger fw-bold">{{ number_format($periode->montant_restant_periode, 0, ',', ' ') }}</td>
                                            <td>{{ $periode->complement_periode }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- <a href="" class="btn btn-primary btn-sm pdf mt-3">
                                <i class="fas fa-file-pdf"></i> Exporter en PDF
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

