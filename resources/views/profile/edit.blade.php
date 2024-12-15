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
                                height="80" 
                                class="rounded-circle shadow">
                            <a href="a.fr" class="thumb-md d-flex justify-content-center align-items-center bg-primary text-white rounded-circle position-absolute end-0 bottom-0 border border-3 border-white">
                                <i class="fas fa-camera"></i>
                            </a>
                        </div>
                        <div class="mt-2">
                             @if(Auth::check())
                                @php
                                    $locataire = Auth::user()->locataires()->first();
                                @endphp
                                @if($locataire)
                                    <h6 class="fw-bold mb-0">{{ $locataire->nom }} {{ $locataire->prenom }}</h6>
                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                @else
                                    <h6 class="fw-bold mb-0">Nom non défini</h6>
                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                @endif
                            @endif

                        </div>
                    </div><!--end col-->

                    <!-- Section Message d'Accueil -->
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="bonhomme-tableau">
                            <div class="bonhomme">
                                <div class="head"></div>
                                <div class="body"></div>
                                <div class="legs"></div>
                            </div>
                            <div class="tableau">
                                <h5 class="fw-bold" id="welcomeMessage">Tout vos raccourcis au meme endroit</h5>
                                <p class="text-muted">   <=-=>  </p>
                                <small id="monthName" class="text-muted"></small>
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
/* Bonhomme avec tableau */
.bonhomme-tableau {
    position: relative;
    display: inline-block;
    text-align: center;
    margin-top: 10px; /* Réduit l'espace au-dessus */
}

.bonhomme {
    width: 40px; /* Réduit la largeur du bonhomme */
    height: 70px; /* Réduit la hauteur du bonhomme */
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

.head {
    width: 20px; /* Réduit la taille de la tête */
    height: 20px; /* Réduit la taille de la tête */
    background-color: #f1c40f;
    border-radius: 50%;
    margin-bottom: 5px; /* Réduit l'espace entre la tête et le corps */
    margin-left: 5px;
}

.body {
    width: 20px; /* Réduit la largeur du corps */
    height: 30px; /* Réduit la hauteur du corps */
    background-color: #3498db;
    margin-left: 5px;
}

.legs {
    width: 40px; /* Réduit la largeur des jambes */
    height: 8px; /* Réduit la hauteur des jambes */
    background-color: #e74c3c;
    position: absolute;
    bottom: -8px;
    left: 0;
    transform: translateX(0);
}

.tableau {
    background-color: #ecf0f1;
    padding: 10px; /* Réduit l'espace intérieur du tableau */
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-top: 40px; /* Réduit l'espace au-dessus du tableau */
    position: relative;
}

.tableau h5 {
    font-size: 1.1rem; /* Réduit la taille du titre */
    color: #0d6efd;
    font-weight: bold;
}

.tableau p {
    font-size: 10px; /* Réduit la taille du texte */
    color: #6c757d;
}

.tableau small {
    font-size: 10px; /* Réduit la taille du mois */
    color: #495057;
}

/* Menu Icon Style */
.menu-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
}

.menu-icon i {
    font-size: 20px;
}

.menu-icon:hover {
    transform: translateY(-8px) scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Affichage du nom du mois actuel
        const today = new Date();
        const monthName = today.toLocaleString('default', { month: 'long' });  // Nom du mois (ex : janvier)
        
        // Mise à jour du texte pour afficher le mois
        const monthNameText = document.getElementById("monthName");
        monthNameText.innerText = `Mois de ${monthName}`;
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
