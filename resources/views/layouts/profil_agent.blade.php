@extends('layouts.master_dash')
@section('title', 'Mon profil')
@section('content')
    <div class="container-xxl">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                <div class="d-flex align-items-center flex-row flex-wrap">
                                    <div class="position-relative me-3">
                                        <img src="{{asset($agent->photo_profil)}}" alt="Photo de profil" height="120" class="rounded-circle">
                                    </div>
                                    <div class="">
                                        <h5 class="fw-semibold fs-22 mb-1">{{ \Illuminate\Support\Str::words($agent->nom_agence, 2, '...') }}</h5>
                                        <p class="mb-0 text-muted fw-medium">{{ $agent->nom_admin }} {{ $agent->prenom_admin }}</p>
                                        <p class="text-muted mb-0 fw-medium">{{ $agent->telephone_agence }}</p>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="col-lg-4 ms-auto align-self-center">
                                <div class="d-flex justify-content-center">
                                    <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                        <h5 class="fw-semibold fs-22 mb-1">{{ $agent->annee_experience }}</h5>
                                        <p class="text-muted mb-0 fw-medium">Années d'expérience</p>
                                    </div>
                                    <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                        <h5 class="fw-semibold fs-22 mb-1">{{ $agent->nombre_bien_disponible }}</h5>
                                        <p class="text-muted mb-0 fw-medium">Biens disponibles</p>
                                    </div>
                                    <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                        <h5 class="fw-semibold fs-22 mb-1">{{ $Nlocataire }}</h5>
                                        <p class="text-muted mb-0 fw-medium">locataires</p>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div><!--end row-->

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Informations personnelles</h4>
                            </div><!--end col-->
                            <div class="col-auto">
                                <a href="{{ route('agent_immobilier.create') }}" class="float-end text-muted d-inline-flex text-decoration-underline"><i class="iconoir-edit-pencil fs-18 me-1"></i>Modifier</a>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <p><strong>Nom de l'agence:</strong> {{ $agent->nom_agence }}</p>
                        <p><strong>Nom de l'administrateur:</strong> {{ $agent->nom_admin }} {{ $agent->prenom_admin }}</p>
                        <p><strong>Adresse de l'agence:</strong> {{ $agent->adresse_agence }}</p>
                        <p><strong>Territoire couvert:</strong> {{ $agent->territoire_couvert }}</p>
                        <p><strong>Nombre de biens disponibles:</strong> {{ $agent->nombre_bien_disponible }}</p>
                        <p><strong>Numéro de téléphone:</strong> {{ $agent->telephone_agence }}</p>
                        <p><strong>Années d'expérience:</strong> {{ $agent->annee_experience }}</p>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div><!--end row-->
    </div><!-- container -->
@endsection
