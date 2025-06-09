<style>
.topbar-custom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  flex-wrap: nowrap;
}

/* Conteneur gauche, milieu, droite */
.topbar-left,
.topbar-center,
.topbar-right {
  display: flex;
  align-items: center;
  gap: 1rem;
}

/* Le centre prend toute la place disponible */
.topbar-center {
  flex-grow: 1;
  justify-content: center;
}

/* Recherche prend toute la largeur possible dans le centre */
.topbar-center .app-search {
  width: 100%;
  max-width: 500px;
}

/* Recherche et bouton dans la même ligne */
.app-search form {
  display: flex;
  width: 100%;
}

.app-search input.top-search {
  flex-grow: 1;
  border-radius: 30px 0 0 30px;
  border: none;
  padding: 0.4rem 1rem;
  outline: none;
}

.app-search button {
  border-radius: 0 30px 30px 0;
  border: none;
  background-color: #012C1C;
  color: white;
  padding: 0 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.app-search button:hover {
  background-color: #034d2a;
}


</style>

<!-- Top Bar Start -->
<div class="topbar d-print-none">
    <div class="container-xxl">
        <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">
            <!-- PARTIE GAUCHE -->
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li>
                    <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                        <i class="iconoir-menu-scale"></i>
                    </button>
                </li>
                <li class="mx-3 welcome-text">
                    <h3 class="mb-0 fw-bold text-truncate">Mon Tableaux de Bord!</h3>
                </li>
            </ul>

            <!-- PARTIE DROITE -->
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li class="hide-phone app-search">
                    <form role="search" action="o.p" method="get">
                        <input type="search" name="search" class="form-control top-search mb-0"
                            placeholder="Rechercher ici..." value="{{ request('search') }}">
                        <button type="submit"><i class="iconoir-search"></i></button>
                    </form>
                </li>

                <!-- LANGUE -->
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button">
                        <img src="{{ asset('assets/images/flags/us_flag.jpg') }}" alt="" class="thumb-sm rounded-circle">
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('change.language', 'en') }}">
                            <img src="{{ asset('assets/images/flags/us_flag.jpg') }}" alt="" height="15" class="me-2">English
                        </a>
                        <a class="dropdown-item" href="{{ route('change.language', 'fr') }}">
                            <img src="{{ asset('assets/images/flags/french_flag.jpg') }}" alt="" height="15" class="me-2">Français
                        </a>
                    </div>
                </li>

                <!-- MODE SOMBRE -->
                <li class="topbar-item">
                    <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                        <i class="icofont-moon dark-mode"></i>
                        <i class="icofont-sun light-mode"></i>
                    </a>
                </li>

                <!-- NOTIFICATIONS -->
                <li class="dropdown topbar-item">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon position-relative" data-bs-toggle="dropdown" href="#">
                        <i class="iconoir-bell"></i>
                        <span id="notif-badge" class="alert-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0">
                        <div class="d-flex align-items-center dropdown-item py-1 bg-secondary-subtle">
                            <h3 class="mb-0">Notifications non lues</h3>
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <div id="notif-list">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <a href="{{ $notification->data['url'] }}?notification_id={{ $notification->id }}" class="dropdown-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="notify-icon bg-light-{{ $notification->data['type'] ?? 'primary' }} text-{{ $notification->data['type'] ?? 'primary' }}">
                                                <i class="{{ $notification->data['icon'] ?? 'iconoir-bell' }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="msg-info mb-0">{{ \Illuminate\Support\Str::words($notification->data['message'], 14, '...') }}</p>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                            @empty
                                <div class="dropdown-item text-center py-3">
                                    <i class="iconoir-bell-off fs-24 text-muted"></i>
                                    <p class="text-muted mb-0">Aucune nouvelle notification</p>
                                </div>
                            @endforelse
                            <a class="dropdown-item text-info" href="{{ route('all_notification') }}">
                                <i class="las la-eye fs-18 me-1 align-text-bottom"></i> Voir toutes les notifications
                            </a>
                        </div>
                    </div>
                </li>

                <!-- PROFIL UTILISATEUR -->
                <li class="dropdown topbar-item">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#">
                        @php $user = Auth::user(); @endphp
                        @if ($user->id_role == 2 && $user->locataires->first()->photo_profil)
                            <img src="{{ asset($user->locataires->first()->photo_profil) }}" alt="Avatar" class="thumb-lg rounded-circle" width="40">
                        @elseif ($user->id_role == 3 && $user->agent_immobiliers->first()?->photo_profil)
                            <img src="{{ asset($user->agent_immobiliers->first()?->photo_profil) }}" alt="Avatar" class="thumb-lg rounded-circle" width="40">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="Avatar" class="thumb-lg rounded-circle" width="40">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0">
                        <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                            <div class="flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="Avatar" class="thumb-md rounded-circle">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                <h6 class="my-0 fw-medium text-dark fs-13">{{ \Illuminate\Support\Str::words($user->name, 2, '...') }}</h6>
                                <small class="text-muted mb-0">
                                    @if ($user->id_role == 1) Administrateur
                                    @elseif ($user->id_role == 2) Locataire
                                    @elseif ($user->id_role == 3) Agence immobilière
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <small class="text-muted px-2 pb-1 d-block">Compte</small>
                        @if ($user->id_role == 2)
                            <a class="dropdown-item" href="{{ route('locataire.locashow', $user->id) }}"><i class="las la-user fs-18 me-1 align-text-bottom"></i> Profil</a>
                        @elseif ($user->id_role == 3 && $user->statut)
                            <a class="dropdown-item" href="{{ route('profil_agent') }}"><i class="las la-user fs-18 me-1 align-text-bottom"></i> Profil</a>
                        @endif
                        <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="las la-cog fs-18 me-1 align-text-bottom"></i> Paramètres</a>
                        <div class="dropdown-divider mb-0"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item d-flex align-items-center" type="submit">
                                <i class="text-danger las la-power-off fs-18 me-1 align-text-bottom"></i> <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- Top Bar End -->
