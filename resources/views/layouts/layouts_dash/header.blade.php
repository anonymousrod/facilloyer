<style>
    .alert-count {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 10px;
        font-weight: 500;
        color: #fff;
        background: #f62718;
        border: 2px solid var(--header-color);
    }

    .notify-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header-notifications-list .dropdown-item {
        padding: 12px 16px;
        transition: all 0.2s;
    }

    .header-notifications-list .dropdown-item:hover {
        background-color: #f8f9fa;
    }
</style>
<!-- Top Bar Start -->
<div class="topbar d-print-none">
    <div class="container-xxl">
        <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">


            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li>
                    <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                        <i class="iconoir-menu-scale"></i>
                    </button>
                </li>
                <li class="mx-3 welcome-text">
                    <h3 class="mb-0 fw-bold text-truncate">Mon Tableau de Bord!</h3>
                    <!-- <h6 class="mb-0 fw-normal text-muted text-truncate fs-14">Here's your overview this week.</h6> -->
                </li>
            </ul>
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li class="hide-phone app-search">
                    <form role="search" action="o.p" method="get">
                        <input type="search" name="search" class="form-control top-search mb-0"
                            placeholder="Search here..." value="{{ request('search') }}">
                        <button type="submit"><i class="iconoir-search"></i></button>
                    </form>
                </li>

                <li class="dropdown">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('assets/images/flags/us_flag.jpg') }} " alt=""
                            class="thumb-sm rounded-circle">
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('change.language', 'en') }}">
                            <img src="{{ asset('assets/images/flags/us_flag.jpg') }}" alt="" height="15"
                                class="me-2">English
                        </a>
                        <a class="dropdown-item" href="{{ route('change.language', 'fr') }}">
                            <img src="{{ asset('assets/images/flags/french_flag.jpg') }}" alt="" height="15"
                                class="me-2">French
                        </a>
                    </div>

                </li><!--end topbar-language-->

                <li class="topbar-item">
                    <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                        <i class="icofont-moon dark-mode"></i>
                        <i class="icofont-sun light-mode"></i>
                    </a>
                </li>

                {{-- pour la notification par defaux suite --}}
                <li class="dropdown topbar-item">

                    <a class="nav-link dropdown-toggle arrow-none nav-icon position-relative" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="iconoir-bell"></i>
                        <span id="notif-badge" class="alert-count">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span> </a>

                    <div class="dropdown-menu dropdown-menu-end py-0">
                        <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                            <div class="flex-shrink-0">
                                <h1>Notifications </h1>
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                            </div><!--end media-body-->
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <div id="notif-list">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <a href="{{ $notification->data['url'] }}?notification_id={{ $notification->id }}"
                                    class="dropdown-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="notify-icon bg-light-{{ $notification->data['type'] ?? 'primary' }} text-{{ $notification->data['type'] ?? 'primary' }}">
                                                <i class="{{ $notification->data['icon'] ?? 'iconoir-bell' }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="msg-info mb-0">{{ $notification->data['message'] }}</p>
                                            <small
                                                class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                            @empty
                                {{-- <div class="dropdown-item text-center py-3">
                                        <i class="iconoir-bell-off fs-24 text-muted"></i>
                                        <p class="text-muted mb-0">Aucune nouvelle notification</p>
                                    </div> --}}
                                <div id="empty-notif" class="dropdown-item text-center py-3">
                                    <i class="iconoir-bell-off fs-24 text-muted"></i>
                                    <p class="text-muted mb-0">Aucune nouvelle notification</p>
                                </div>
                            @endforelse
                            <a class="dropdown-item text-info" href="#"><i
                                    class="las la-eye fs-18 me-1 align-text-bottom"></i> Voir toutes les
                                notifications</a>

                        </div>

                    </div>
                </li>





                <li class="dropdown topbar-item">
                    @if (Auth::check())
                        @php
                            $user = Auth::user();
                            $role = $user->id_role; // Récupération du rôle de l'utilisateur
$imageUrl = 'assets/images/default-avatar.png'; // Image par défaut si aucune image n'est définie

                            // Vérifie le rôle pour récupérer la photo de profil
                            if ($role == 1) {
                                // Admin
                                $imageUrl = $user->photo_profil ?? 'assets/images/default-admin.png';
                            } elseif ($role == 2) {
                                // Locataire
                                $locataire = $user->locataires()->first();
                                if ($locataire && $locataire->photo_profil) {
                                    $imageUrl = asset('storage/' . $locataire->photo_profil); // Si l'image est stockée dans "storage"
    }
} elseif ($role == 3) {
    // Agent immobilier
    $agent = $user->agent_immobiliers()->first();
    if ($agent && $agent->photo_profil) {
        $imageUrl = asset('storage/' . $agent->photo_profil); // Si l'image est stockée dans "storage"
                                }
                            }
                        @endphp

                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ $imageUrl }}" alt="Profil utilisateur" class="thumb-lg rounded-circle"
                                height="150">
                        </a>
                    @endif


                    <div class="dropdown-menu dropdown-menu-end py-0">
                        <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                            <div class="flex-shrink-0">
                                <img src="assets/images/users/avatar-1.png " alt=""
                                    class="thumb-md rounded-circle">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                @if (Auth::check())
                                    @php
                                        $user = Auth::user();
                                        $role = $user->id_role; // Récupère le rôle de l'utilisateur
$nomComplet = '';
$suite = '';

// Vérifie le rôle pour afficher le nom approprié
if ($role == 1) {
    // Admin
    $nomComplet = 'Administrateur'; // Nom générique pour l'admin
                                        } elseif ($role == 2) {
                                            // Locataire
                                            $locataire = $user->locataires()->first();
                                            if ($locataire) {
                                                $nomComplet = $locataire->nom . ' ' . $locataire->prenom;
                                            } else {
                                                $nomComplet = 'Nom non défini'; // Si aucun locataire n'est lié
    }
} elseif ($role == 3) {
    // Agent immobilier
    $agent = $user->agent_immobiliers()->first();
    if ($agent) {
        $nomComplet = $agent->nom_admin . '  :' . $agent->prenom_admin; // Remplacez `nom` et `prenom` par les bons champs du modèle `AgentImmobilier`
        $suite = $agent->nom_agence;
    } else {
        $nomComplet = 'Nom non défini'; // Si aucun agent immobilier n'est lié
                                            }
                                        } else {
                                            $nomComplet = 'Sans statut'; // Si le rôle est inconnu
                                        }
                                    @endphp

                                    <h6 class="fw-bold mb-0">{{ $nomComplet }}</h6>
                                    <p class="text-muted">{{ $user->email }}</p>
                                    <h6 class="fw-bold mb-0">{{ $suite }}</h6>
                                @endif


                            </div><!--end media-body-->
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <small class="text-muted px-2 pb-1 d-block">Account </small>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                class="las la-cog fs-18 me-1 align-text-bottom"></i> Settings</a>
                        {{-- <small class="text-muted px-2 py-1 d-block">Settings</small> --}}
                        <!-- POUR LE LOCATAIRE -->
                        @if (Auth::user()->id_role == 2)
                            <a class="dropdown-item" href="{{ route('locataire.locashow', Auth::user()->id) }}"><i
                                    class="las la-user fs-18 me-1 align-text-bottom"></i>Completez Mon Profil</a>
                            <a class="dropdown-item" href="pages-faq.html"><i
                                    class="las la-question-circle fs-18 me-1 align-text-bottom"></i> Help Center</a>
                            <div class="dropdown-divider mb-0"></div>
                        @endif

                        {{-- <a class="dropdown-item text-danger" href="auth-login.html"><i
                                    class="las la-power-off fs-18 me-1 align-text-bottom"></i> Déconnexion</a> --}}
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">


                                <i class="text-danger  las la-power-off fs-18 me-1 align-text-bottom"></i>
                                <span>{{ __('Déconnexion') }}</span>
                            </x-dropdown-link>
                        </form>
                    </div>
                </li>

            </ul><!--end topbar-nav-->
        </nav>
        <!-- end navbar-->
    </div>
</div>
<!-- Top Bar End -->
