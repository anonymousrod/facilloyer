{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
{{-- <!DOCTYPE html> --}}
{{-- <html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light"> --}}
<!-- Mirrored from mannatthemes.com/rizz/default/auth-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Nov 2024 21:52:10 GMT -->

<head>
    @include('layouts.layouts_dash.head')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            /* background-color: #f5f7fa; */
            margin: 0;
        }

        html,
        body {
            overflow-x: hidden;
            /* Empêche la barre de scroll horizontale temporaire */
        }

        .auth-wrapper {
            display: flex;
            min-height: 100vh;
            flex-wrap: wrap;
            /* background: #f5f7fa; */
        }


        .auth-left {
            flex: 1;
            background: #166534 !important;
            color: #fff !important;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .auth-left * {
            color: #fff !important;
        }
        .auth-logo-text {
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 0.2rem;
        }
        .auth-left img {
            height: 80px;
            margin-bottom: 1rem;
            filter: drop-shadow(0 0 8px rgba(34, 197, 94, 0.18));
            transition: transform 0.3s;
            background: #fff;
            border-radius: 50%;
            padding: 16px;
            box-shadow: 0 2px 8px 0 rgba(22, 101, 52, 0.08);
            display: inline-block;
        }
        .auth-left img:hover {
            transform: scale(1.08) rotate(-2deg);
        }
        .auth-left p {
            font-size: 1.05rem;
            opacity: 0.92;
        }

        .auth-form {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2.5rem;
        }
        /* Style sobre pour l'intérieur du formulaire (hors agent) */
        .auth-form:not(.agent-style) .form-container {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
        }
        .auth-form:not(.agent-style) .form-label,
        .auth-form:not(.agent-style) label {
            color: #222 !important;
            font-weight: 600;
        }
        .auth-form:not(.agent-style) .form-label i {
            color: #22c55e !important;
        }
        .auth-form:not(.agent-style) .form-control {
            background: #fff;
            color: #222;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .auth-form:not(.agent-style) .form-control:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 0.15rem rgba(34, 197, 94, 0.12);
            background: #fff;
        }
        .auth-form:not(.agent-style) .btn-success,
        .auth-form:not(.agent-style) .btn {
            background: linear-gradient(90deg, #22c55e 0%, #166534 100%) !important;
            border: none;
            color: #fff !important;
            font-weight: 600;
            transition: background 0.3s, color 0.3s;
        }
        .auth-form:not(.agent-style) .btn-success:hover,
        .auth-form:not(.agent-style) .btn:hover {
            background: #166534 !important;
            color: #fff !important;
        }
        .auth-form:not(.agent-style) .form-check-input:checked {
            background-color: #22c55e !important;
            border-color: #22c55e !important;
        }
        .auth-form:not(.agent-style) a {
            color: #22c55e !important;
            text-decoration: underline;
            font-weight: 500;
            transition: color 0.2s;
        }
        .auth-form:not(.agent-style) a:hover {
            color: #166534 !important;
        }
        .auth-form:not(.agent-style) .text-muted {
            color: #6c757d !important;
        }

        .form-container {
            background: #ffffff;
            border-radius: 18px;
            padding: 3rem 2.5rem;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 500px;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            /* color: #333; */
        }

        /* Suppression du bleu, tout est géré par la section ci-dessus */
        .form-control {
            border-radius: 10px;
            border: 1px solid #dcdfe6;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(90deg, #22c55e 0%, #166534 100%);
            border: none;
            padding: 0.75rem 1rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            color: #fff;
            transition: background 0.3s, color 0.3s;
        }
        .btn-primary:hover {
            background: #166534;
            color: #fff;
        }
        .form-check-label {
            font-size: 0.875rem;
            color: #166534;
        }
        .form-check-label a {
            color: #22c55e;
            text-decoration: underline;
            font-weight: 500;
            transition: color 0.2s;
        }
        .form-check-label a:hover {
            color: #166534;
        }
        .alert {
            font-size: 0.95rem;
            border-radius: 8px;
        }
        .text-info.small {
            color: #22c55e !important;
            font-size: 0.9rem;
            margin-top: -0.5rem;
            margin-bottom: 1rem;
        }
        .text-muted {
            color: #6c757d !important;
        }
        .text-primary {
            color: #22c55e !important;
        }

        .d-grid button {
            height: 50px;
        }

        @media screen and (max-width: 768px) {
            .auth-wrapper {
                flex-direction: column;
            }

            .auth-left,
            .auth-form {
                flex: unset;
                width: 100%;
                padding: 2rem;
            }

            .auth-left h4 {
                font-size: 1.8rem;
            }

            .auth-left p {
                font-size: 1rem;
            }

            .form-container {
                padding: 2rem;
            }
        }
    </style>
</head>

@php
    $agent = Auth::user()?->id_role == 3;
@endphp

<body>
    <div class="auth-wrapper">
        {{-- Partie gauche --}}
        @unless ($agent)
            <div class="auth-left" data-aos="fade-right">
                <img src="{{ asset('assets/images/gbsolux-remouve.png') }}" alt="logo">
                <div class="auth-logo-text">Bienvenue sur {{ env('APP_NAME') }}</div>
                <p>Créez votre compte gratuitement en quelques clics.</p>
            </div>
        @endunless

        {{-- Partie droite (formulaire) --}}
        @if($agent)
            <div class="container-xxl py-5 agent-style">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <div class="card shadow-lg border-0 rounded-4">
                            <div class="card-header py-4 d-flex flex-column flex-md-row align-items-center justify-content-between" style="background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%); color: #fff; border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem;">
                                <div>
                                    <h3 class="mb-0 fw-bold"><i class="fas fa-user-tie me-2 animate__animated animate__fadeInLeft"></i>Enregistrement d'un locataire</h3>
                                    <p class="mb-0 small opacity-75">Veuillez saisir l'email du locataire à enregistrer. Un mot de passe sécurisé sera généré et envoyé automatiquement.</p>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success text-center mb-0 ms-md-4 mt-3 mt-md-0 px-4 py-2 rounded-pill shadow-sm">
                                        <span class="fw-semibold">{{ session('success') }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body p-4 p-md-5 bg-light rounded-bottom-4">
                                @if ($errors->any())
                                    <div class="alert alert-danger mb-4">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('locataire.store') }}" class="needs-validation">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-12 animate__animated animate__fadeInUp" style="animation-delay:0.1s;">
                                            <label for="email" class="form-label fw-semibold">
                                                <i class="fas fa-envelope me-2 text-primary animate__animated animate__fadeInLeft"></i>Adresse Email
                                            </label>
                                            <input type="email" class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn" id="email" name="email" value="{{ old('email') }}" placeholder="ex: locataire@email.com" required>
                                        </div>
                                        @foreach (getRoles() as $role)
                                            @if ($role->libelle === 'Agent immobilier')
                                                <input type="hidden" name="id_role" value="{{ $role->id }}">
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="mt-5 text-center animate__animated animate__fadeInUp" style="animation-delay:0.3s;">
                                        <button class="btn btn-success btn-lg px-5 py-2 rounded-pill shadow" type="submit" style="background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%); border: none; font-weight: 600; letter-spacing: 1px;">
                                            <i class="fas fa-user-plus me-2"></i>Enregistrer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
                @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
                .form-label {
                    color: #185a9d;
                    font-size: 1.05rem;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                .form-control:focus, .form-select:focus {
                    border-color: #43cea2;
                    box-shadow: 0 0 0 0.2rem rgba(67, 206, 162, 0.15);
                    transition: box-shadow 0.3s;
                }
                .card {
                    border-radius: 1.5rem;
                    transition: box-shadow 0.4s cubic-bezier(.4,2,.6,1);
                }
                .card:hover {
                    box-shadow: 0 8px 32px 0 rgba(24,90,157,0.18);
                }
                .btn-lg {
                    transition: transform 0.2s, box-shadow 0.2s;
                }
                .btn-lg:hover {
                    transform: translateY(-2px) scale(1.03);
                    box-shadow: 0 4px 16px 0 rgba(67,206,162,0.18);
                }
                @media (max-width: 767.98px) {
                    .card-header, .card-body {
                        padding: 1.5rem !important;
                    }
                    .btn-lg {
                        font-size: 1rem;
                        padding: 0.75rem 2rem;
                    }
                }
            </style>
        @else
            <div class="card auth-form align-self-center my-auto w-100" data-aos="fade-left" style="min-height:unset;">
                <div class="form-container">
                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif
                    @error('errors')
                        <div class="alert alert-danger text-center">Erreur</div>
                    @enderror
                    @foreach (['email', 'password', 'password_confirmation', 'id_role'] as $field)
                        @error($field)
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror
                    @endforeach
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-primary animate__animated animate__fadeInLeft"></i>Adresse Email
                            </label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" placeholder="ex: utilisateur@email.com" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-success animate__animated animate__fadeInLeft"></i>Mot de passe
                            </label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Mot de passe sécurisé" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-info animate__animated animate__fadeInLeft"></i>Confirmation du mot de passe
                            </label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirmez le mot de passe" required>
                        </div>
                        @foreach (getRoles() as $role)
                            @if ($role->libelle === 'Agent immobilier')
                                <input type="hidden" name="id_role" value="{{ $role->id }}">
                            @endif
                        @endforeach
                        <div class="form-check form-switch form-switch-success mb-3">
                            <input class="form-check-input" type="checkbox" id="terms_conditions" required>
                            <label class="form-check-label" for="terms_conditions">
                                <i class="fas fa-check-circle me-2 text-success animate__animated animate__fadeInLeft"></i>
                                En m'inscrivant, j'accepte les
                                <a href="#" class="text-primary">Conditions d'utilisation</a>.
                            </label>
                        </div>
                        <div class="d-grid mt-4">
                            <button class="btn btn-success" type="submit" style="color:#fff !important;">
                                <i class="fas fa-user-plus me-2" style="color:#fff !important;"></i>Créer mon compte
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <p class="text-muted">
                            Vous avez déjà un compte ?
                            <a href="{{ route('login') }}" class="text-primary">Se connecter</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Script AOS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800,
        });
    </script>
</body>
