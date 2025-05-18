<!-- Sidebar avec style professionnel -->

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
    }

    .startbar {
        background: linear-gradient(180deg, #012417, #015f3b); /* Vert Foncé Profond */
        color: white;
        width: 270px;
        height: 100vh;
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.4);
        overflow: hidden;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    .startbar .brand {
        padding: 25px;
        text-align: center;
        flex-shrink: 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .startbar .brand img {
        max-width: 65px;
        border-radius: 50%;
        background: #fff;
        padding: 6px;
    }

    .startbar-menu {
        flex-grow: 1;
        overflow-y: auto;
        padding: 20px 0;
    }

    .startbar-menu::-webkit-scrollbar {
        width: 6px;
    }

    .startbar-menu::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 5px;
    }

    .startbar .nav-link {
        color: white;
        padding: 14px 22px;
        margin: 6px 18px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 16px;
        text-decoration: none;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: all 0.3s ease;
    }

    .startbar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.15);
        transform: translateX(6px);
    }

    .startbar .nav-link i {
        font-size: 20px;
        color: #d0d0d0; /* Icône blanc atténué */
        min-width: 24px;
        text-align: center;
        transition: color 0.3s ease;
    }

    .startbar .nav-link:hover i {
        color: white; /* Icône devient blanche au survol */
    }

    .startbar .collapse .nav-link {
        padding-left: 44px;
        font-size: 15px;
    }

    .startbar .nav-item {
        margin-bottom: 6px;
    }

    .startbar a.nav-link span {
        flex: 1;
        color: white;
    }

    /* DARK MODE */
    body.dark-mode .startbar {
        background: linear-gradient(180deg, #0c0f0e, #1c2e27);
    }

    body.dark-mode .startbar .nav-link {
        color: #e0e0e0;
    }

    body.dark-mode .startbar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.08);
    }

    body.dark-mode .startbar .nav-link i {
        color: #bbbbbb;
    }

    body.dark-mode .startbar .nav-link:hover i {
        color: #ffffff;
    }

    body.dark-mode .startbar .brand {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
</style>

<!-- HTML complet de la sidebar -->
<div class="startbar d-print-none">
    <!-- Start brand -->
    <div class="brand">
        <a href="#" class="logo">
            <span style="display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('assets/images/gbsolux-remouve.png') }}" alt="logo-small" />
            </span>
        </a>
    </div>

    <!-- Start startbar-menu -->
    <div class="startbar-menu" data-simplebar>
        <div class="d-flex align-items-start flex-column w-100">
            <ul class="navbar-nav mb-auto w-100">

                {{-- SUPER ADMIN --}}
                @if (Auth::user()->id_role == 1)
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarGerer_user" data-bs-toggle="collapse">
                            <i class="fas fa-users-cog"></i><span>Gérer les utilisateurs</span>
                        </a>
                        <div class="collapse" id="sidebarGerer_user">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.agents.index') }}"><i class="fas fa-user-plus"></i><span>Valider les agences</span></a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.locataires_par_agence', Auth::user()->id) }}"><i class="fas fa-users"></i><span>Liste des locataire</span></a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="rapports-financiers.html"><i class="fas fa-file-invoice-dollar"></i><span>Consulter les rapports financiers</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.paiements.index') }}"><i class="fas fa-file-invoice-dollar"></i><span>Historiques des Paiements</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.contrats_de_bail.index') }}"><i class="fas fa-book"></i><span>Auditer les contrats de bail</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contrat.index') }}"><i class="fas fa-book"></i><span>Voir tous les contrats de bail</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.demandes.grouped') }}"><i class="fas fa-tools"></i><span>Gérer la maintenance</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="statistiques.html"><i class="fas fa-chart-bar"></i><span>Voir les statistiques</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user', Auth::user()->id) }}"><i class="iconoir-chat-bubble"></i><span>Assistance en ligne</span></a></li>
                @endif

                {{-- LOCATAIRE --}}
                @if (Auth::user()->id_role == 2)
                    @if (Auth::user()->statut)
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i class="iconoir-view-grid"></i><span>Dashboard</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('locataire_bien', Auth::user()->id) }}"><i class="iconoir-book"></i><span>Bien loué / Contrat</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('locataire.demandes.index') }}"><i class="iconoir-wrench"></i><span>Demande maintenance</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('demandes.modification') }}"><i class="iconoir-stats-up-square"></i><span>Demande de modification</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('periodes.show') }}"><i class="iconoir-credit-card"></i><span>Processus de paiement</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('locataire.paiements.historique') }}"><i class="iconoir-list"></i><span>Historique des paiements</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('locataire.agentinfo', Auth::user()->id) }}"><i class="iconoir-phone"></i><span>Infos de l’agence</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('locataire.locashow', Auth::user()->id) }}"><i class="iconoir-user"></i><span>Profil</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit', Auth::user()->id) }}"><i class="iconoir-settings"></i><span>Paramètres</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('user', Auth::user()->locataires->first()->agent_immobilier->user->id) }}"><i class="iconoir-chat-bubble"></i><span>Assistance en ligne</span></a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('locataire.locashow', Auth::user()->id) }}"><i class="iconoir-user"></i><span>Profil</span></a></li>
                    @endif
                @endif

                {{-- AGENT IMMOBILIER --}}
                @if (Auth::user()->id_role == 3 && Auth::user()->statut)
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i class="iconoir-view-grid"></i><span>Dashboard</span></a></li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarGerer_locataires" data-bs-toggle="collapse">
                            <i class="iconoir-user"></i><span>Gérer les locataires</span>
                        </a>
                        <div class="collapse" id="sidebarGerer_locataires">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="{{ route('locataire.create') }}">Enregistrer</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('locataire.index') }}">Liste</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarGerer_bien" data-bs-toggle="collapse">
                            <i class="iconoir-home"></i><span>Gestion des biens</span>
                        </a>
                        <div class="collapse" id="sidebarGerer_bien">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="{{ route('biens.create') }}">Enregistrer</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('biens.index') }}">Liste</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarGerer_contrat_bail" data-bs-toggle="collapse">
                            <i class="fas fa-indent"></i><span>Gestion des Articles</span>
                        </a>
                        <div class="collapse" id="sidebarGerer_contrat_bail">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="{{ route('article.create') }}">Enregistrer</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('article.index') }}">Liste</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('demandes.modification') }}"><i class="iconoir-stats-up-square"></i><span>Demandes de modification</span></a></li>
                @endif

            </ul>
        </div>
    </div>
</div>
