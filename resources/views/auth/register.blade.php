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
            background: linear-gradient(135deg, rgba(30, 30, 60, 0.8), rgba(15, 15, 35, 0.8)),
                url('{{ asset('assets/images/bg-auth.jpg') }}') center/cover no-repeat;
            color: #fff;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .auth-left img {
            max-height: 70px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.4));
        }

        .auth-left h4 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
            color: #ffffff;
        }

        .auth-left p {
            font-size: 1.1rem;
            max-width: 420px;
            opacity: 0.95;
            color: #e0e0e0;
        }

        .auth-form {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2.5rem;
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

        .form-control {
            border-radius: 10px;
            border: 1px solid #dcdfe6;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4c8bf5;
            box-shadow: 0 0 0 3px rgba(76, 139, 245, 0.15);
            outline: none;
        }

        .btn-primary {
            background-color: #4c8bf5;
            border: none;
            padding: 0.75rem 1rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #356ad8;
        }

        .form-check-label {
            font-size: 0.875rem;
            color: #555;
        }

        .form-check-label a {
            color: #4c8bf5;
            text-decoration: underline;
            font-weight: 500;
        }

        .alert {
            font-size: 0.95rem;
            border-radius: 8px;
        }

        .text-info.small {
            color: #4c8bf5 !important;
            font-size: 0.9rem;
            margin-top: -0.5rem;
            margin-bottom: 1rem;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .text-primary {
            color: #4c8bf5 !important;
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
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="Logo">
                <h4>{{ $agent ? 'Enregistrer un locataire' : 'Inscription à ' . env('APP_NAME') }}</h4>
                <p>
                    {{ $agent ? 'Remplissez les informations pour enregistrer un locataire.' : 'Créez votre compte gratuitement en quelques clics.' }}
                </p>
            </div>
        @endunless

        {{-- Partie droite (formulaire) --}}
        <div class="card auth-form" data-aos="fade-left">
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

                <form method="POST" action="{{ $agent ? route('locataire.store') : route('register') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="email">Adresse Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" placeholder="ex: utilisateur@email.com" required>
                    </div>

                    @if ($agent)
                        <p class="text-info small">
                            Un mot de passe sécurisé sera généré et envoyé automatiquement au locataire.
                        </p>
                    @endif

                    @unless ($agent)
                        <div class="form-group mb-3">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Mot de passe sécurisé" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirmation du mot de passe</label>
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
                                En m'inscrivant, j'accepte les
                                <a href="#" class="text-primary">Conditions d'utilisation</a>.
                            </label>
                        </div>
                    @endunless

                    <div class="d-grid mt-4">
                        <button class="btn btn-success" type="submit">
                            {{ $agent ? 'Enregistrer' : 'Créer mon compte' }}
                        </button>
                    </div>
                </form>

                @unless ($agent)
                    <div class="text-center mt-3">
                        <p class="text-muted">
                            Vous avez déjà un compte ?
                            <a href="{{ route('login') }}" class="text-primary">Se connecter</a>
                        </p>
                    </div>
                @endunless
            </div>
        </div>
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
