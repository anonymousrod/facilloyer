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
                <div class="row g-3 align-items-center">
                    <!-- Section Profil -->
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="position-relative d-inline-block">
                            <img src="{{ Auth::user()->profile_picture ?? asset('assets/images/users/avatar-1.png') }}" 
                                alt="Avatar" 
                                height="100" 
                                class="rounded-circle shadow">
                            <a href="a.fr" class="thumb-md d-flex justify-content-center align-items-center bg-primary text-white rounded-circle position-absolute end-0 bottom-0 border border-3 border-white">
                                <i class="fas fa-camera"></i>
                            </a>
                        </div>
                        <div class="mt-2">
                            @if(Auth::check())
                                <h5 class="fw-bold mb-0">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</h5>
                                <p class="text-muted">{{ Auth::user()->email }}</p>
                            @endif
                        </div>
                    </div><!--end col-->

                    <!-- Section Progress Circle -->
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="progress-container position-relative mx-auto" style="width: 120px; height: 120px;">
                            <div class="progress-ring">
                                <svg width="120" height="120">
                                    <circle class="progress-ring__background" cx="60" cy="60" r="54" />
                                    <circle class="progress-ring__circle" cx="60" cy="60" r="54" />
                                </svg>
                                <div class="progress-text">
                                    <span id="daysCount" class="fw-bold fs-4"></span>
                                    <small class="d-block text-uppercase text-muted" style="font-size: 11px;">Jours restants</small>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->

                    <!-- Section Actions -->
                    <div class="col-lg-4 col-md-12">
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <div class="menu-icon bg-info text-white" onclick="window.location.href='a.fr'">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="menu-icon bg-warning text-white" onclick="window.location.href='a.fr'">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                            <div class="menu-icon bg-success text-white" onclick="window.location.href='a.fr'">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div class="menu-icon bg-dark text-white" onclick="window.location.href='a.fr'">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="menu-icon bg-primary text-white" onclick="window.location.href='a.fr'">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="menu-icon bg-danger text-white" onclick="window.location.href='a.fr'">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <!-- New Icons -->
                            <div class="menu-icon bg-info text-white" onclick="window.location.href='a.fr'">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="menu-icon bg-secondary text-white" onclick="window.location.href='a.fr'">
                                <i class="fas fa-bell"></i>
                            </div>
                        </div>                                   
                    </div><!--end col-->
                </div><!--end row-->               
            </div><!--end card-body--> 
        </div><!--end card--> 
    </div> <!--end col-->                                  
</div><!--end row-->

<style>
/* Progress Circle Design */
.progress-container {
    position: relative;
}

.progress-ring svg {
    transform: rotate(-90deg);
    width: 100%;
    height: 100%;
}

.progress-ring__background {
    fill: none;
    stroke: #e9ecef;
    stroke-width: 10;
}

.progress-ring__circle {
    fill: none;
    stroke: #0d6efd;
    stroke-width: 10;
    stroke-dasharray: 339.2; /* 2 * Math.PI * r (54) */
    stroke-dashoffset: 339.2;
    transition: stroke-dashoffset 1s ease-in-out;
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

/* Menu Icon Style */
.menu-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
}

.menu-icon i {
    font-size: 24px;
}

.menu-icon:hover {
    transform: translateY(-8px) scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* Styling for the email */
.text-muted {
    font-size: 0.9rem;
    color: #6c757d;
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Calcul des jours restants dans le mois
        const daysInMonth = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate();
        const today = new Date().getDate();
        const remainingDays = daysInMonth - today;

        // Mise à jour du cercle de progression
        const progressCircle = document.querySelector(".progress-ring__circle");
        const radius = progressCircle.r.baseVal.value;
        const circumference = 2 * Math.PI * radius;
        const percentage = (remainingDays / daysInMonth) * 100;
        const offset = circumference - (percentage / 100) * circumference;

        progressCircle.style.strokeDasharray = `${circumference}`;
        progressCircle.style.strokeDashoffset = `${offset}`;

        // Mise à jour du compteur au centre
        document.getElementById("daysCount").innerText = remainingDays;
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
