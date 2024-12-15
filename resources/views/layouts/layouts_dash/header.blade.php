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
                        <h3 class="mb-0 fw-bold text-truncate">Espace De Gestion!</h3>
                        <!-- <h6 class="mb-0 fw-normal text-muted text-truncate fs-14">Here's your overview this week.</h6> -->
                    </li>
                </ul>
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li class="hide-phone app-search">
                        <form role="search" action="#" method="get">
                            <input type="search" name="search" class="form-control top-search mb-0"
                                placeholder="Search here...">
                            <button type="submit"><i class="iconoir-search"></i></button>
                        </form>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{asset('assets/images/flags/us_flag.jpg')}} " alt="" class="thumb-sm rounded-circle">
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('change.language', 'en') }}">
                                <img src="{{ asset('assets/images/flags/us_flag.jpg') }}" alt="" height="15" class="me-2">English
                            </a>
                            <a class="dropdown-item" href="{{ route('change.language', 'fr') }}">
                                <img src="{{ asset('assets/images/flags/french_flag.jpg') }}" alt="" height="15" class="me-2">French
                            </a>
                        </div>

                    </li><!--end topbar-language-->

                    <li class="topbar-item">
                        <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                            <i class="icofont-moon dark-mode"></i>
                            <i class="icofont-sun light-mode"></i>
                        </a>
                    </li>

                    <li class="dropdown topbar-item">
                      @if(Auth::check())
                        @php
                            $user = Auth::user();
                            $role = $user->id_role; // Récupération du rôle de l'utilisateur
                            $imageUrl = 'assets/images/default-avatar.png'; // Image par défaut si aucune image n'est définie

                            // Vérifie le rôle pour récupérer la photo de profil
                            if ($role == 1) { // Admin
                                $imageUrl = $user->photo_profil ?? 'assets/images/default-admin.png';
                            } elseif ($role == 2) { // Locataire
                                $locataire = $user->locataires()->first();
                                if ($locataire && $locataire->photo_profil) {
                                    $imageUrl = asset('storage/' . $locataire->photo_profil); // Si l'image est stockée dans "storage"
                                }
                            } elseif ($role == 3) { // Agent immobilier
                                $agent = $user->agent_immobiliers()->first();
                                if ($agent && $agent->photo_profil) {
                                    $imageUrl = asset('storage/' . $agent->photo_profil); // Si l'image est stockée dans "storage"
                                }
                            }
                        @endphp

                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" 
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ $imageUrl }}" alt="Profil utilisateur" class="thumb-lg rounded-circle" height="150">
                        </a>
                    @endif

                        
                        <div class="dropdown-menu dropdown-menu-end py-0">
                            <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                                <div class="flex-shrink-0">
                                    <img src="assets/images/users/avatar-1.png " alt=""
                                        class="thumb-md rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                @if(Auth::check())
                                    @php
                                        $user = Auth::user();
                                        $role = $user->id_role; // Récupère le rôle de l'utilisateur
                                        $nomComplet = '';
                                        $suite ='';

                                        // Vérifie le rôle pour afficher le nom approprié
                                        if ($role == 1) { // Admin
                                            $nomComplet = 'Administrateur'; // Nom générique pour l'admin
                                        } elseif ($role == 2) { // Locataire
                                            $locataire = $user->locataires()->first();
                                            if ($locataire) {
                                                $nomComplet = $locataire->nom . ' ' . $locataire->prenom;
                                            } else {
                                                $nomComplet = 'Nom non défini'; // Si aucun locataire n'est lié
                                            }
                                        } elseif ($role == 3) { // Agent immobilier
                                            $agent = $user->agent_immobiliers()->first();
                                            if ($agent) {
                                                $nomComplet = $agent->nom_admin . '  :' . $agent->prenom_admin; // Remplacez `nom` et `prenom` par les bons champs du modèle `AgentImmobilier`
                                                $suite=$agent->nom_agence;
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
                            <small class="text-muted px-2 pb-1 d-block">Account</small>
                            <a class="dropdown-item" href="{{route('profile.edit')}}"><i
                                    class="las la-user fs-18 me-1 align-text-bottom"></i> Profile</a>
                            <small class="text-muted px-2 py-1 d-block">Settings</small>
                             <!-- POUR LE LOCATAIRE -->
                             @if (Auth::user()->id_role == 2)

                            <a class="dropdown-item" href="{{route('locataire.edit')}}"><i
                                    class="las la-cog fs-18 me-1 align-text-bottom"></i>Completez Mon Profil</a>
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


                                      <i
                                    class="text-danger  las la-power-off fs-18 me-1 align-text-bottom"></i>
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
