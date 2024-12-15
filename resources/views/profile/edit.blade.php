@extends('layouts.master_dash')
@section('title', 'Modifier le Profil')
@section('content')
<div class="container-xxl">
    <div class="row justify-content-center">
        <div class="col-12">
        <div class="page-wrapper">

<!-- Page Content-->
<!-- <div class="page-content"> -->
    <div class="container-xxl">
        <!-- la premiere bare avec le profil et tout ce qui est est haut  -->

        @if (Auth::user()->id_role == 2)

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                <div class="d-flex align-items-center flex-row flex-wrap">
                                    <div class="position-relative me-3">
                                        <img src="assets/images/users/avatar-1.png" alt="" height="120" class="rounded-circle">
                                        <a href="#" class="thumb-md justify-content-center d-flex align-items-center bg-primary text-white rounded-circle position-absolute end-0 bottom-0 border border-3 border-card-bg">
                                            <i class="fas fa-camera"></i>
                                        </a>
                                    </div>
                                    <div class="">
                                        @if(Auth::check())
                                            <h4><span>{{ Auth::user()->email }}</span>!</h4>
                                        @else
                                            <h6>Veuillez vous connecter pour accéder à votre Workflow.</h6>
                                        @endif
                                    </div>
                                </div>                                                
                            </div><!--end col-->
                            
                            <div class="col-lg-4 ms-auto align-self-center">
                                <div class="d-flex justify-content-center">
                                    <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                        <h5 class="fw-semibold fs-22 mb-1">75</h5>
                                        <p class="text-muted mb-0 fw-medium">Projects</p>
                                    </div>
                                    <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                        <h5 class="fw-semibold fs-22 mb-1">68%</h5>
                                        <p class="text-muted mb-0 fw-medium">Success Rate</p>
                                    </div>
                                    <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                        <h5 class="fw-semibold fs-22 mb-1">$8620</h5>
                                        <p class="text-muted mb-0 fw-medium">Earning</p>
                                    </div>
                                </div>                                          
                            </div><!--end col-->
                            <div class="col-lg-4 align-self-center">
                                <div class="row row-cols-2">
                                    <div class="col text-end">
                                        <div id="complete" class="apex-charts"></div>
                                    </div>  
                                    <div class="col align-self-center">
                                        <button type="button" class="btn btn-primary  d-inline-block">Follow</button> 
                                        <button type="button" class="btn btn-light  d-inline-block">Hire Me</button>  
                                    </div>
                                </div>                                   
                            </div><!--end col-->
                        </div><!--end row-->               
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->                                  
        </div><!--end row-->
        @endif
        

        

        <div class="row justify-content-center">

            <!-- section de la partie ou je veux mettre les infos de l'agence immo  -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <!-- <div class="row align-items-center"> -->
                                <h6 class="card-title">Information sur la connexion</h6>                      
                            
                    </div>
                    <div class="card-body pt-0">
                        <p class="text-muted fw-medium mb-3">.</p>
                        <ul class="list-unstyled mb-0">
                            <!-- Date actuelle -->
                            <li><i class="las la-calendar me-2 text-secondary fs-22 align-middle"></i> <b>Date</b> : {{ now()->format('d F Y') }}</li>

                            <!-- Heure actuelle -->
                            <li class="mt-2"><i class="las la-clock me-2 text-secondary fs-22 align-middle"></i> <b>Heure</b> : {{ now()->format('H:i') }}</li>

                            <!-- Jour de la semaine -->
                            <li class="mt-2"><i class="las la-calendar-week me-2 text-secondary fs-22 align-middle"></i> <b>Jour de la semaine</b> : {{ now()->format('l') }}</li>

                            <!-- Mois actuel -->
                            <li class="mt-2"><i class="las la-calendar-alt me-2 text-secondary fs-22 align-middle"></i> <b>Mois</b> : {{ now()->format('F') }}</li>

                            <!-- Année actuelle -->
                            <li class="mt-2"><i class="las la-calendar me-2 text-secondary fs-22 align-middle"></i> <b>Année</b> : {{ now()->format('Y') }}</li>


                            <!-- Adresse IP de l'utilisateur -->
                            <li class="mt-2"><i class="las la-laptop me-2 text-secondary fs-22 align-middle"></i> <b>Adresse IP</b> : {{ request()->ip() }}</li>

                            <!-- Fuseau horaire du serveur -->
                            <li class="mt-2"><i class="las la-clock me-2 text-secondary fs-22 align-middle"></i> <b>Fuseau Horaire </b> : {{ config('app.timezone') }}</li>
                        </ul>
                    </div><!--end card-body-->

                </div><!--end card--> 
            </div> <!--end col--> 
            <div class="col-md-8">
                <ul class="nav nav-tabs mb-3" role="tablist">                                   
                    <li class="nav-item">
                        <a class="nav-link fw-medium" data-bs-toggle="tab" href="#settings" role="tab" aria-selected="true">Modifier ton email ou ton mon mot de passe</a>
                    </li>
                </ul>
                <!-- Section pour le formulaire de modification des donnée -->
                <!-- <div class="tab-content">                                                -->
                    <div class="tab-pane p-1" id="settings" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">                      
                                        <h4 class="card-title">Adresse email</h4>                      
                                    </div><!--end col-->                                                       
                                </div>  <!--end row-->                                  
                            </div><!--end card-header-->
                            @include('profile.partials.update-profile-information-form')
                                            
                        </div><!--end card-->

                        <!-- section pour modifier le password -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Change Password</h4>
                            </div><!--end card-header-->
                             @include('profile.partials.update-password-form')
                        </div><!--end card-->
                       
                    </div>
                <!-- </div>  -->
            </div> <!--end col-->                                                       
        </div><!--end row-->

                          
    </div><!-- container -->
    


    <!--end footer-->
</div>

@endsection
