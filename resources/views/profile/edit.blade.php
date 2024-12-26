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
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="row g-4 text-center">

                        <!-- Section Profil -->
                        <div class="col-lg-4 col-md-6">
                            <div class="position-relative">
                                <img src="{{ Auth::user()->profile_picture ?? asset('assets/images/users/avatar-1.png') }}" 
                                     alt="Avatar" 
                                     class="rounded-circle shadow mb-2" 
                                     width="80" height="80">
                                <a href="a.fr" 
                                   class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle d-flex align-items-center justify-content-center" 
                                   style="width: 30px; height: 30px;">
                                    <i class="fas fa-camera"></i>
                                </a>
                            </div>
                            <div>
                                @if(Auth::check())
                                    @php
                                        $locataire = Auth::user()->locataires()->first();
                                    @endphp
                                    @if($locataire)
                                        <h6 class="fw-bold">{{ $locataire->nom }} {{ $locataire->prenom }}</h6>
                                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                    @else
                                        <h6 class="fw-bold">Nom non défini</h6>
                                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Section Message d'Accueil -->
                        <div class="col-lg-4 col-md-6">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <h5 class="fw-bold text-primary" id="welcomeMessage">Vos raccourcis, simplifiés</h5>
                                <p class="text-muted mb-1">Accédez rapidement à vos actions principales</p>
                                <small id="monthName" class="text-muted"></small>
                            </div>
                        </div>

                        <!-- Section Actions -->
                        <div class="col-lg-4">
                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <div class="btn btn-info text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="btn btn-warning text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-money-check-alt"></i>
                                </div>
                                <div class="btn btn-success text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div class="btn btn-dark text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <div class="btn btn-primary text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="btn btn-danger text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="btn btn-secondary text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="btn btn-info text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();
            const monthName = today.toLocaleString('default', { month: 'long' });
            document.getElementById("monthName").innerText = `Mois de ${monthName}`;
        });
    </script>
  @endif
  @if (Auth::user()->id_role == 3)
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="row g-4 text-center">

                        <!-- Section Profil -->
                        <div class="col-lg-4 col-md-6">
                            <div class="position-relative">
                                <img src="{{ Auth::user()->profile_picture ?? asset('assets/images/users/avatar-1.png') }}" 
                                     alt="Avatar" 
                                     class="rounded-circle shadow mb-2" 
                                     width="80" height="80">
                                <a href="a.fr" 
                                   class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle d-flex align-items-center justify-content-center" 
                                   style="width: 30px; height: 30px;">
                                    <i class="fas fa-camera"></i>
                                </a>
                            </div>
                            <div>
                                @if(Auth::check())
                                    @php
                                        $locataire = Auth::user()->locataires()->first();
                                    @endphp
                                    @if($locataire)
                                        <h6 class="fw-bold">{{ $locataire->nom }} {{ $locataire->prenom }}</h6>
                                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                    @else
                                        <h6 class="fw-bold">Nom non défini</h6>
                                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Section Message d'Accueil -->
                        <div class="col-lg-4 col-md-6">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <h5 class="fw-bold text-primary" id="welcomeMessage">Vos raccourcis, simplifiés</h5>
                                <p class="text-muted mb-1">Accédez rapidement à vos actions principales</p>
                                <small id="monthName" class="text-muted"></small>
                            </div>
                        </div>

                        <!-- Section Actions -->
                        <div class="col-lg-4">
                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <div class="btn btn-info text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="btn btn-warning text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-money-check-alt"></i>
                                </div>
                                <div class="btn btn-success text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div class="btn btn-dark text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <div class="btn btn-primary text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="btn btn-danger text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="btn btn-secondary text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="btn btn-info text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();
            const monthName = today.toLocaleString('default', { month: 'long' });
            document.getElementById("monthName").innerText = `Mois de ${monthName}`;
        });
    </script>
  @endif
  @if (Auth::user()->id_role == 1)
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="row g-4 text-center">

                        <!-- Section Profil -->
                        <div class="col-lg-4 col-md-6">
                            <div class="position-relative">
                                <img src="{{ Auth::user()->profile_picture ?? asset('assets/images/users/avatar-1.png') }}" 
                                     alt="Avatar" 
                                     class="rounded-circle shadow mb-2" 
                                     width="80" height="80">
                                <a href="a.fr" 
                                   class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle d-flex align-items-center justify-content-center" 
                                   style="width: 30px; height: 30px;">
                                    <i class="fas fa-camera"></i>
                                </a>
                            </div>
                            <div>
                                @if(Auth::check())
                                    @php
                                        $locataire = Auth::user()->locataires()->first();
                                    @endphp
                                    @if($locataire)
                                        <h6 class="fw-bold">{{ $locataire->nom }} {{ $locataire->prenom }}</h6>
                                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                    @else
                                        <h6 class="fw-bold">Nom non défini</h6>
                                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Section Message d'Accueil -->
                        <div class="col-lg-4 col-md-6">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <h5 class="fw-bold text-primary" id="welcomeMessage">Vos raccourcis, simplifiés</h5>
                                <p class="text-muted mb-1">Accédez rapidement à vos actions principales</p>
                                <small id="monthName" class="text-muted"></small>
                            </div>
                        </div>

                        <!-- Section Actions -->
                        <div class="col-lg-4">
                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <div class="btn btn-info text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="btn btn-warning text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-money-check-alt"></i>
                                </div>
                                <div class="btn btn-success text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div class="btn btn-dark text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <div class="btn btn-primary text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="btn btn-danger text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="btn btn-secondary text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="btn btn-info text-white d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 60px; height: 60px;" 
                                     onclick="window.location.href='a.fr'">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();
            const monthName = today.toLocaleString('default', { month: 'long' });
            document.getElementById("monthName").innerText = `Mois de ${monthName}`;
        });
    </script>
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
