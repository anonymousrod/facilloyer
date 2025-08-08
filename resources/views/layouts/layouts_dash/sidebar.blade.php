<!-- Sidebar avec style update by fhb patcher lol "rod" je blague , j'etait un peu ennuyé aujourd'hui -->

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
    }

    .startbar {
        background: linear-gradient(180deg, #012417, #015f3b);
        /* Vert Foncé Profond */
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
        max-width: 48px;
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
        color: #d0d0d0;
        /* Icône blanc atténué */
        min-width: 24px;
        text-align: center;
        transition: color 0.3s ease;
    }

    .startbar .nav-link:hover i {
        color: white;
        /* Icône devient blanche au survol */
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i
                                class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarGerer_user" data-bs-toggle="collapse">
                            <i class="fas fa-users-cog"></i><span>Gérer les utilisateurs</span>
                        </a>
                        <div class="collapse" id="sidebarGerer_user">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.agents.index') }}"><i
                                            class="fas fa-user-plus"></i><span>Valider les agences</span></a></li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('admin.locataires_par_agence', Auth::user()->id) }}"><i
                                            class="fas fa-users"></i><span>Liste des locataire</span></a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.paiements.index') }}"><i
                                class="fas fa-file-invoice-dollar"></i><span>Historiques des Paiements</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contrat.index') }}"><i
                                class="fas fa-book"></i><span>Voir tous les contrats de bail</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.demandes.grouped') }}"><i
                                class="fas fa-tools"></i><span>Gérer la maintenance</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="statistiques.html"><i
                                class="fas fa-chart-bar"></i><span>Voir les statistiques</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user', Auth::user()->id) }}"><i
                                class="iconoir-chat-bubble"></i><span>Assistance en ligne</span></a></li>
                @endif

                {{-- LOCATAIRE --}}
                @if (Auth::user()->id_role == 2)
                    @if (Auth::user()->statut)
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i
                                    class="iconoir-view-grid"></i><span>Dashboard</span></a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('locataire_bien', Auth::user()->id) }}"><i
                                    class="iconoir-book"></i><span>Bien loué / Contrat</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('locataire.demandes.index') }}"><i
                                    class="iconoir-wrench"></i><span>Demande maintenance</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('demandes.modification') }}"><i
                                    class="iconoir-stats-up-square"></i><span>Révision de Contract</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('periodes.show') }}"><i
                                    class="iconoir-credit-card"></i><span>Processus de paiement</span></a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('locataire.paiements.historique') }}"><i
                                    class="iconoir-list"></i><span>Historique des paiements</span></a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('locataire.agentinfo', Auth::user()->id) }}"><i
                                    class="iconoir-phone"></i><span>Infos de l’agence</span></a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('locataire.locashow', Auth::user()->id) }}"><i
                                    class="iconoir-user"></i><span>Profil</span></a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('profile.edit', Auth::user()->id) }}"><i
                                    class="iconoir-settings"></i><span>Paramètres</span></a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('user', Auth::user()->locataires->first()->agent_immobilier->user->id) }}"><i
                                    class="iconoir-chat-bubble"></i><span>Assistance en ligne</span></a></li>
                    @else
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('locataire.locashow', Auth::user()->id) }}"><i
                                    class="iconoir-user"></i><span>Profil</span></a></li>
                    @endif
                @endif

                {{-- AGENT IMMOBILIER --}}

                @php
                    $agent = Auth::user()->id_role == 3 ? Auth::user()->agent_immobiliers->first() : null;
                    $dernierAbonnement = $agent ? $agent->abonnement()->latest()->first() : null;
                @endphp
                @if (Auth::user()->id_role == 3 && Auth::user()->statut && $agent && $dernierAbonnement?->status === 'actif')

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                viewBox="0 0 16 16" style="border-radius:5px;">
                                <rect x="2" y="2" width="12" height="12" rx="3" fill="#f8f9fa"
                                    stroke="#ffc107" stroke-width="1.5" />
                                <rect x="5" y="5" width="2.5" height="2.5" rx="1" fill="#ffc107" />
                                <rect x="8.5" y="5" width="2.5" height="2.5" rx="1" fill="#ffc107" />
                                <rect x="5" y="8.5" width="2.5" height="2.5" rx="1" fill="#ffc107" />
                                <rect x="8.5" y="8.5" width="2.5" height="2.5" rx="1" fill="#ffc107" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarGerer_locataires" data-bs-toggle="collapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16" style="border-radius:5px;">
                                <circle cx="8" cy="6" r="3" fill="#f8f9fa" stroke="#0d6efd"
                                    stroke-width="1.5" />
                                <rect x="3" y="10" width="10" height="4" rx="2" fill="#0d6efd" />
                            </svg>
                            <span>Gérer les locataires</span>
                        </a>
                        <div class="collapse" id="sidebarGerer_locataires">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('locataire.create') }}">Enregistrer</a></li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('locataire.index') }}">Liste</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarGerer_bien" data-bs-toggle="collapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16" style="border-radius:5px;">
                                <rect x="2" y="7" width="12" height="7" rx="2" fill="#f8f9fa"
                                    stroke="#198754" stroke-width="1.5" />
                                <polygon points="8,2 2,7 14,7" fill="#198754" />
                            </svg>
                            <span>Gestion des biens</span>
                        </a>
                        <div class="collapse" id="sidebarGerer_bien">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('biens.create') }}">Enregistrer</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('biens.index') }}">Liste</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarGerer_contrat_bail" data-bs-toggle="collapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16" style="border-radius:5px;">
                                <rect x="3" y="2" width="10" height="12" rx="2" fill="#f8f9fa"
                                    stroke="#6f42c1" stroke-width="1.5" />
                                <rect x="5" y="5" width="6" height="1.2" rx="0.6" fill="#6f42c1" />
                                <rect x="5" y="8" width="6" height="1.2" rx="0.6" fill="#6f42c1" />
                            </svg>
                            <span>Gestion des Articles</span>
                        </a>
                        <div class="collapse" id="sidebarGerer_contrat_bail">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('article.create') }}">Enregistrer</a></li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('article.index') }}">Liste</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('demandes.modification') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16" style="border-radius:5px;">
                                <rect x="2" y="2" width="12" height="12" rx="3" fill="#f8f9fa"
                                    stroke="#fd7e14" stroke-width="1.5" />
                                <path d="M5 8h6M8 5v6" stroke="#fd7e14" stroke-width="1.2" stroke-linecap="round" />
                            </svg>
                            <span>Révision de Contract</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agent_immo_historique') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16" style="border-radius:5px;">
                                <ellipse cx="8" cy="8" rx="6" ry="4.5" fill="#f8f9fa"
                                    stroke="#20c997" stroke-width="1.5" />
                                <circle cx="8" cy="8" r="2" fill="#20c997" />
                            </svg>
                            <span>Suivi des paiements</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('information_gestion') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16" style="border-radius:5px;">
                                <rect x="2" y="2" width="12" height="12" rx="3" fill="#f8f9fa"
                                    stroke="#0dcaf0" stroke-width="1.5" />
                                <path d="M5 11V8M8 11V5M11 11V6.5" stroke="#0dcaf0" stroke-width="1.2"
                                    stroke-linecap="round" />
                            </svg>
                            <span>Auditer Loyer</span>
                        </a>
                    </li>

                    {{-- s'abonner temporaire --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('plans_abonnement') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16" style="border-radius:5px;">
                                <polygon points="8,2 10,6.5 15,6.5 11,10 12.5,15 8,12.5 3.5,15 5,10 1,6.5 6,6.5"
                                    fill="#f8f9fa" stroke="#ffc107" stroke-width="1.5" />
                                <polygon points="8,3.5 9,6 12,6 9.5,8 10.5,11 8,9.5 5.5,11 6.5,8 4,6 7,6"
                                    fill="#ffc107" />
                            </svg>
                            <span>Plan d'abonnement</span>
                        </a>
                    </li>
                    {{-- abonnement menu --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('abonnement.current') }}">
                            <i class="bi bi-star-fill"></i> <span>Mon abonnement</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('abonnement.historique') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                viewBox="0 0 20 20"
                                style="border-radius:5px; min-width:20px; min-height:20px; display:inline-block; vertical-align:middle;">
                                <circle cx="10" cy="10" r="8" fill="#f8f9fa" stroke="#6c757d"
                                    stroke-width="1.5" />
                                <path d="M10 5.5v4l3 2" stroke="#6c757d" stroke-width="1.3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>Historique des abonnements</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agent.demandes') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                fill="currentColor" viewBox="0 0 16 16"
                                style="border-radius:5px; min-width:22px; min-height:22px; display:inline-block; vertical-align:middle;">
                                <rect x="3" y="3" width="10" height="10" rx="2" fill="#f8f9fa"
                                    stroke="#dc3545" stroke-width="1.5" />
                                <path d="M6 10l4-4M10 10l-4-4" stroke="#dc3545" stroke-width="1.2"
                                    stroke-linecap="round" />
                            </svg>
                            <span>Liste maintenances</span>
                        </a>
                    </li>

                    @php
                        $user = App\Models\User::where('id_role', 1)->first();
                    @endphp

                    @if ($user)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user', $user->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                                    viewBox="0 0 20 20"
                                    style="border-radius:5px; min-width:22px; min-height:22px; display:inline-block; vertical-align:middle;">
                                    <rect x="2.5" y="3.5" width="15" height="13" rx="3"
                                        fill="#f8f9fa" stroke="#0d6efd" stroke-width="1.5" />
                                    <path d="M6 14.5l2.5-2h3L14 14.5" stroke="#0d6efd" stroke-width="1.1"
                                        stroke-linecap="round" />
                                    <circle cx="7.5" cy="9" r="1" fill="#0d6efd" />
                                    <circle cx="12.5" cy="9" r="1" fill="#0d6efd" />
                                </svg>
                                <span>Assistance en ligne</span>
                            </a>
                        </li>
                    @endif
                @elseif ((Auth::user()->id_role == 3 && !Auth::user()->statut) || ($agent && $dernierAbonnement?->status === 'expiré'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="iconoir-view-grid menu-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agent_immobilier.create') }}">
                            <i class="iconoir-view-grid menu-icon"></i>
                            <span>Informations de l'agence</span>
                        </a>
                    </li>

                    @if ($agent && $agent->abonnement?->status === 'expiré')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('plans_abonnement') }}">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Plan d'abonnement</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('abonnement.current') }}">
                                <i class="bi bi-star-fill"></i> <span>Mon abonnement</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('abonnement.historique') }}">
                                <i class="bi bi-clock-history"></i> <span>Historique des abonnements</span>
                            </a>
                        </li>
                    @endif

                @endif


            </ul>
        </div>
    </div>
</div>
