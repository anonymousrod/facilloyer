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
                        <li class="nav-item">
                            <a class="nav-link" href="lol.html">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Dashboard</span>
                            </a>

                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarGerer_bien" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarGerer_user">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Gérer les utilisateurs</span>
                            </a>
                            <div class="collapse " id="sidebarGerer_user">
                                <ul class="nav flex-column">


                                    <li class="nav-item">
                                        <a class="nav-link" href="apps-chat.html">AJOUTER UTILISATEURS</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="apps-contact-list.html">LISTE AGENT IMMOBILIER</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="apps-calendar.html">LISTE LOCATAIRES</a>
                                    </li><!--end nav-item-->

                                </ul><!--end nav-->
                            </div><!--end startbarGerer_user-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="lol.html">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Consulter les rapports financiers</span>
                            </a>

                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="lol.html">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Auditer les contrats de bail</span>
                            </a>

                        </li><!--end nav-item-->
                    @endif

                    <!-- ITEMS POUR LE LOCATAIRE -->
                    @if (Auth::user()->id_role == 2)
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="lol.html">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Dashboard</span>
                            </a>

                        </li><!--end nav-item-->


                        <li class="nav-item">
                            <a class="nav-link" href="lol.html">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Effectuer un paiement</span>
                            </a>

                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="lol.html">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Consulter son contrat de bail</span>
                            </a>

                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="lol.html">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Consulter l'historique des paiements</span>
                            </a>

                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="lol.html">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Discussion par chat</span>
                            </a>

                        </li><!--end nav-item-->
                    @endif

                    <!-- ITEMS POUR L'AGENT IMMOBILIER -->
                    @if (Auth::user()->id_role == 3)
                        @if (Auth::user()->statut)
                            <!-- Si l'agent est validé -->


                            <li class="nav-item">
                                <a class="nav-link" href="lol.html">
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
                                            <a class="nav-link" href="{{ route('liste_locataire')}}">Liste locataire</a>
                                        </li><!--end nav-item-->


                                    </ul><!--end nav-->
                                </div><!--end startbarGerer_bien-->
                            </li><!--end nav-item-->

                            <li class="nav-item">
                                <a class="nav-link" href="#sidebarGerer_bien" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarGerer_bien">
                                    <i class="iconoir-view-grid menu-icon"></i>
                                    <span>Gérer les biens immobiliers</span>
                                </a>
                                <div class="collapse " id="sidebarGerer_bien">
                                    <ul class="nav flex-column">


                                        <li class="nav-item">
                                            <a class="nav-link" href="apps-chat.html">Ajouter Bien</a>
                                        </li><!--end nav-item-->
                                        <li class="nav-item">
                                            <a class="nav-link" href="apps-contact-list.html">Liste BIEN</a>
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
