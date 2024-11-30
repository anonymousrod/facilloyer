<div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="index.html" class="logo">
            <span>
                <img src="assets/images/logo-sm.png" alt="logo-small" class="logo-sm">
            </span>
            <span class="">
                <img src="assets/images/logo-light.png" alt="logo-large" class="logo-lg logo-light">
                <img src="assets/images/logo-dark.png" alt="logo-large" class="logo-lg logo-dark">
            </span>
        </a>
    </div>
    <!--end brand-->
    <!--start startbar-menu-->
    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <ul class="navbar-nav mb-auto w-100">
                <!-- MENU GÉNÉRAL ACCESSIBLE À TOUS LES UTILISATEURS -->
                <li class="menu-label pt-0 mt-0">
                    <span>Main Menu</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="iconoir-home-simple menu-icon"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- ITEMS POUR L'AGENT IMMOBILIER -->
                @if(Auth::user()->id_role == 3)
                    @if(Auth::user()->statut) <!-- Si l'agent est validé -->
                        <li class="nav-item">
                            <a class="nav-link" href="manage-properties.html">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Gérer les biens immobiliers</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage-tenants.html">
                                <i class="iconoir-users menu-icon"></i>
                                <span>Gérer les locataires</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="financial-reports.html">
                                <i class="iconoir-chart menu-icon"></i>
                                <span>Consulter les rapports financiers</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage-contracts.html">
                                <i class="iconoir-document menu-icon"></i>
                                <span>Gérer les contrats de bail</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="payment-tracking.html">
                                <i class="iconoir-receipt menu-icon"></i>
                                <span>Suivi des paiements</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="chat.html">
                                <i class="iconoir-chat menu-icon"></i>
                                <span>Discussion par chat</span>
                            </a>
                        </li>
                    @else <!-- Si l'agent n'est pas validé -->
                        <li class="nav-item">
                            <a class="nav-link" href="agency-info.html">
                                <i class="iconoir-building menu-icon"></i>
                                <span>Renseigner les informations de l'agence</span>
                            </a>
                        </li>
                    @endif
                @endif

                <!-- ITEMS POUR LE LOCATAIRE -->
                @if(Auth::user()->id_role == 2)
                    <li class="nav-item">
                        <a class="nav-link" href="make-payment.html">
                            <i class="iconoir-wallet menu-icon"></i>
                            <span>Effectuer un paiement fractionné</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view-contract.html">
                            <i class="iconoir-document menu-icon"></i>
                            <span>Consulter son contrat de bail</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="payment-history.html">
                            <i class="iconoir-time-passed menu-icon"></i>
                            <span>Consulter l'historique des paiements</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="chat.html">
                            <i class="iconoir-chat menu-icon"></i>
                            <span>Discussion par chat</span>
                        </a>
                    </li>
                @endif

                <!-- ITEMS POUR LE SUPER ADMINISTRATEUR -->
                @if(Auth::user()->id_role == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="user-management.html">
                            <i class="iconoir-user-circle menu-icon"></i>
                            <span>Gérer les comptes utilisateurs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="global-reports.html">
                            <i class="iconoir-chart menu-icon"></i>
                            <span>Consulter les rapports financiers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="audit-contracts.html">
                            <i class="iconoir-document menu-icon"></i>
                            <span>Auditer les contrats de bail</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
