<!-- leftbar-tab-menu -->
<div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="index.html" class="logo">
            <span>
                <img src="{{ asset('assets/images/logo-sm.png') }} " alt="logo-small" class="logo-sm">
            </span>
            <span class="">
                <img src="{{ asset('assets/images/logo-light.png') }} " alt="logo-large" class="logo-lg logo-light">
                <img src="{{ asset('assets/images/logo-dark.png') }} " alt="logo-large" class="logo-lg logo-dark">
            </span>
        </a>
    </div>
    <!--end brand-->
    <!--start startbar-menu-->
    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <!-- Navigation -->
                <ul class="navbar-nav mb-auto w-100">

                    {{-- Administrateur --}}
                    <!-- ITEMS POUR LE SUPER ADMINISTRATEUR -->
                    @if (Auth::user()->id_role == 1)
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('dashboard')}}">
                                <i class="fas fa-tachometer-alt menu-icon"></i> <!-- Icône de tableau de bord -->
                                <span>Dashboard</span>
                            </a>
                        </li><!--end nav-item-->

                        <!-- Gérer les utilisateurs -->
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarGerer_user" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarGerer_user">
                                <i class="fas fa-users-cog menu-icon"></i> <!-- Icône pour gestion des utilisateurs -->
                                <span>Gérer les utilisateurs</span>
                            </a>
                            <div class="collapse" id="sidebarGerer_user">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="apps-chat.html">
                                            <i class="fas fa-user-plus menu-icon"></i> <!-- Icône pour ajouter utilisateur -->
                                            <span>Ajouter utilisateurs</span>
                                        </a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="apps-contact-list.html">
                                            <i class="fas fa-user-tie menu-icon"></i> <!-- Icône pour agents immobiliers -->
                                            <span>Liste agents immobiliers</span>
                                        </a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="apps-calendar.html">
                                            <i class="fas fa-users menu-icon"></i> <!-- Icône pour liste des locataires -->
                                            <span>Liste locataires</span>
                                        </a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarGerer_user-->
                        </li><!--end nav-item-->

                        <!-- Consulter les rapports financiers -->
                        <li class="nav-item">
                            <a class="nav-link" href="rapports-financiers.html">
                                <i class="fas fa-file-invoice-dollar menu-icon"></i> <!-- Icône pour rapports financiers -->
                                <span>Consulter les rapports financiers</span>
                            </a>
                        </li><!--end nav-item-->

                        <!-- Auditer les contrats de bail -->
                        <li class="nav-item">
                            <a class="nav-link" href="audit-contrats.html">
                                <i class="fas fa-file-contract menu-icon"></i> <!-- Icône pour audit contrats -->
                                <span>Auditer les contrats de bail</span>
                            </a>
                        </li><!--end nav-item-->

                        <!-- Nouveau menu 1 : Gestion de la maintenance -->
                        <li class="nav-item">
                            <a class="nav-link" href="gestion-maintenance.html">
                                <i class="fas fa-tools menu-icon"></i> <!-- Icône pour gestion de la maintenance -->
                                <span>Gérer la maintenance</span>
                            </a>
                        </li><!--end nav-item-->

                        <!-- Nouveau menu 2 : Statistiques -->
                        <li class="nav-item">
                            <a class="nav-link" href="statistiques.html">
                                <i class="fas fa-chart-bar menu-icon"></i> <!-- Icône pour statistiques -->
                                <span>Voir les statistiques</span>
                            </a>
                        </li><!--end nav-item-->
                    @endif


                    <!-- ITEMS POUR LE LOCATAIRE -->
                    @if (Auth::user()->id_role == 2)
                            <!-- Dashboard -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('dashboard')}}">
                                    <i class="iconoir-view-grid menu-icon"></i> <!-- Icône du Dashboard -->
                                    <span>Dashboard</span>
                                </a>
                            </li><!--end nav-item-->

                            <!-- Consulter son contrat de bail -->
                            <li class="nav-item">
                                <a class="nav-link" href="lol.html">
                                    <i class="iconoir-book menu-icon"></i> <!-- Icône pour contrat de bail -->
                                    <span>Consulter son contrat de bail</span>
                                </a>
                            </li><!--end nav-item-->

                            <!-- Demande de maintenance/réparations -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('demandes.index')}}">
                                    <i class="iconoir-wrench menu-icon"></i> <!-- Icône pour demande de maintenance -->
                                    <span>Demande de maintenance/réparations</span>
                                </a>
                            </li><!--end nav-item-->

                            <!-- Notifications d’échéances importantes -->
                            <li class="nav-item">
                                <a class="nav-link" href="lol.html">
                                    <i class="iconoir-bell menu-icon"></i> <!-- Icône pour notifications -->
                                    <span>Notifications d’échéances importantes</span>
                                </a>
                            </li><!--end nav-item-->

                            <!-- Effectuer un paiement -->
                            <li class="nav-item">
                                <a class="nav-link" href="r.r">
                                    <i class="iconoir-credit-card menu-icon"></i> <!-- Icône pour paiement -->
                                    <span>Effectuer un paiement</span>
                                </a>
                            </li><!--end nav-item-->

                            <!-- Historique des paiements -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('locataire.paiements.historique')}}">
                                    <i class="iconoir-list menu-icon"></i> <!-- Icône pour historique des paiements -->
                                    <span>Historique des paiements</span>
                                </a>
                            </li><!--end nav-item-->

                            <!-- Assistance en ligne -->
                            <li class="nav-item">
                                <a class="nav-link" href="lol.html">
                                    <i class="iconoir-chat-bubble menu-icon"></i> <!-- Icône pour assistance en ligne -->
                                    <span>Assistance en ligne</span>
                                </a>
                            </li><!--end nav-item-->

                            <!-- Informations de l’agence ou de l’agent -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('locataire.agentinfo', Auth::user()->id) }}">
                                    <i class="iconoir-phone menu-icon"></i> <!-- Icône pour infos de l'agent/agence -->
                                    <span>Informations de l’agence ou de l’agent</span>
                                </a>
                            </li><!--end nav-item-->

                            <!-- Modifier Mon Profil -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('locataire.locainformations', Auth::user()->id)}}">
                                    <i class="iconoir-user menu-icon"></i> <!-- Icône pour modification de profil -->
                                    <span>Modifier Mon Profil</span>
                                </a>
                            </li><!--end nav-item-->

                            <!-- Paramètres -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('profile.edit', Auth::user()->id)}}">
                                    <i class="iconoir-settings menu-icon"></i> <!-- Icône pour paramètres -->
                                    <span>Paramètres</span>
                                </a>
                            </li><!--end nav-item-->
                        @endif


                    <!-- ITEMS POUR L'AGENT IMMOBILIER -->
                    @if (Auth::user()->id_role == 3)
                        @if (Auth::user()->statut)
                            <!-- Si l'agent est validé -->


                            <li class="nav-item">
                                <a class="nav-link" href="{{route('dashboard')}}">
                                    <i class="iconoir-view-grid menu-icon"></i>
                                    <span>Dashboard</span>
                                </a>

                            </li><!--end nav-item-->

                            <li class="nav-item">
                                <a class="nav-link" href="#sidebarGerer_locataires" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="sidebarGerer_locataires">
                                    <i class="iconoir-view-grid menu-icon"></i>
                                    <span>Gérer les locataires</span>
                                </a>
                                <div class="collapse " id="sidebarGerer_locataires">
                                    <ul class="nav flex-column">


                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('locataire.create')}}">Ajouter locataire</a>
                                        </li><!--end nav-item-->
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('locataire.index')}}">Liste locataire</a>
                                        </li><!--end nav-item-->


                                    </ul><!--end nav-->
                                </div><!--end startbarGerer_bien-->
                            </li><!--end nav-item-->

                            <li class="nav-item">
                                <a class="nav-link" href="#sidebarGerer_bien" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarGerer_bien">
                                    <i class="iconoir-view-grid menu-icon"></i>
                                    <span>Gestion des biens</span>
                                </a>
                                <div class="collapse " id="sidebarGerer_bien">
                                    <ul class="nav flex-column">


                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('biens.create') }}">Ajouter </a>
                                        </li><!--end nav-item-->
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('biens.index') }}">Liste </a>
                                        </li><!--end nav-item-->


                                    </ul><!--end nav-->
                                </div><!--end startbarGerer_bien-->
                            </li><!--end nav-item-->

                            <li class="nav-item">
                                <a class="nav-link" href="#sidebarGerer_contrat_bail" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="sidebarGerer_contrat_bail">
                                    <i class="iconoir-view-grid menu-icon"></i>
                                    <span>Gérer les contrats de bail</span>
                                </a>
                                <div class="collapse " id="sidebarGerer_contrat_bail">
                                    <ul class="nav flex-column">


                                        <li class="nav-item">
                                            <a class="nav-link" href="apps-chat.html">Créer contrat de bail</a>
                                        </li><!--end nav-item-->
                                        <li class="nav-item">
                                            <a class="nav-link" href="apps-contact-list.html"> Lise des contrat de
                                                bail</a>
                                        </li><!--end nav-item-->


                                    </ul><!--end nav-->
                                </div><!--end startbarGerer_bien-->
                            </li><!--end nav-item-->

                            <li class="nav-item">
                                <a class="nav-link" href="lol.html">
                                    <i class="iconoir-view-grid menu-icon"></i>
                                    <span>Suivi des paiements</span>
                                </a>

                            </li><!--end nav-item-->

                            <li class="nav-item">
                                <a class="nav-link" href="lol.html">
                                    <i class="iconoir-view-grid menu-icon"></i>
                                    <span>Consulter les rapports financiers</span>
                                </a>

                            </li><!--end nav-item-->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('agent_demande')}}">
                                    <i class="iconoir-view-grid menu-icon"></i>
                                    <span>Voir les demande de maintenances</span>
                                </a>

                            </li><!--end nav-item-->


                            <li class="nav-item">
                                <a class="nav-link" href="lol.html">
                                    <i class="iconoir-view-grid menu-icon"></i>
                                    <span>Discussion par chat</span>
                                </a>

                            </li><!--end nav-item-->











                        @else
                            <!-- Si l'agent n'est pas validé -->

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('agent_immobilier.create') }}">
                                    <i class="iconoir-view-grid menu-icon"></i>
                                    <span>Informations de l'agence</span>
                                </a>

                            </li><!--end nav-item-->
                        @endif
                    @endif


                </ul><!--end navbar-nav--->

            </div>
        </div><!--end startbar-collapse-->
    </div><!--end startbar-menu-->
</div><!--end startbar-->
<div class="startbar-overlay d-print-none"></div>
<!-- end leftbar-tab-menu-->
