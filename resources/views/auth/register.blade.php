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
</head>

<!-- Top Bar Start -->
@php
    $agent = Auth::user()?->id_role == 3;
@endphp

<body>
    <div class="container-xxl">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                    <div class="text-center p-3">
                                        <a href="#" class="logo logo-admin">
                                            <img src=" {{ asset('assets/images/logo-sm.png') }} " height="50"
                                                alt="logo" class="auth-logo" />
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">
                                            {{ $agent ? 'Enregistrer un locataire' : 'Inscription à' . env('APP_NAME') }}
                                        </h4>
                                        <p class="text-muted fw-medium mb-0">
                                            {{ $agent
                                                ? 'Remplissez les informations pour enregistrer un locataire'
                                                : 'Remplissez les informations pour créer votre compte.' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="card-body pt-0">
                                    @if (session('success'))
                                        <div class="alert alert-success text-center">
                                            <h5 class="text-success"> {{ session('success') }}</h5>
                                        </div>
                                    @endif

                                    @error('errors')
                                        <div class="alert alert-danger text-center">
                                            <h5 class="text-primary">Erreur</h5>
                                        </div>
                                    @enderror

                                    <!-- Erreur email -->
                                    @error('email')
                                        <div class="col-12">
                                            <div class="alert alert-danger text-center" role="alert">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror

                                    <!-- Erreur mot de passe -->
                                    @error('password')
                                        <div class="col-12">
                                            <div class="alert alert-danger text-center" role="alert">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror

                                    <!-- Erreur confirmation de mot de passe -->
                                    @error('password_confirmation')
                                        <div class="col-12">
                                            <div class="alert alert-danger text-center" role="alert">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror

                                    @error('id_role')
                                        <div class="alert alert-danger text-center">{{ $message }}</div>
                                    @enderror

                                    <form class="my-4" method="POST" action=" {{ ($agent) ? route('locataire.store') : route('register')   }}">
                                        @csrf

                                        <!-- Email -->
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Entrez votre adresse email" value="{{ old('email') }}"
                                                required />
                                        </div>
                                        @if ($agent)
                                            <div>
                                                <p class=" text-info fw-medium mb-0">
                                                    Un mot de passe sécurisé sera envoyé au locataire via l'adresse
                                                    e-mail renseignée. </p>
                                            </div>
                                        @endif

                                        @if (!$agent)
                                            <!-- Mot de passe -->
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="password">Mot de passe</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="Entrez votre mot de passe" required />
                                            </div>

                                            <!-- Confirmation du mot de passe -->
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="password_confirmation">Confirmez le mot
                                                    de
                                                    passe</label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation"
                                                    placeholder="Confirmez votre mot de passe" required />
                                            </div>
                                            <!-- Type d'utilisateur -->

                                            {{-- code a ameliorer pour l'enregistrement des locataire par l'admin --}}

                                            {{-- <div class="form-group mb-2">
                                                <label class="form-label" for="role">Type d'utilisateur</label>
                                                <select class="form-control" id="role" name="id_role" required>
                                                    <option value="" disabled selected>-- Sélectionnez un rôle --</option>
                                                    @foreach (getRoles() as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ old('id_role') == $role->id ? 'selected' : '' }}>
                                                            {{ $role->libelle }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div> --}}

                                            {{-- suite du code pour register agent immobilier --}}

                                            @foreach (getRoles() as $role)
                                                @if ($role->libelle == 'Agent immobilier')
                                                    <input type="number" name="id_role" value="{{ $role->id }}"
                                                        hidden>
                                                @endif
                                            @endforeach
                                            <!-- Checkbox pour accepter les conditions -->
                                            <div class="form-group row mt-3">
                                                <div class="col-12">
                                                    <div class="form-check form-switch form-switch-success">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="terms_conditions" required />
                                                        <label class="form-check-label" for="terms_conditions">
                                                            En m'inscrivant, j'accepte les <a href="#"
                                                                class="text-primary">Conditions d'utilisation</a>.
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif






                                        <!-- Bouton soumettre -->
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-primary" type="submit">
                                                        {{ $agent ? 'Enregistrer' : 'Créer mon compte' }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    @if (!$agent)
                                        <!-- Lien pour se connecter -->
                                        <div class="text-center">
                                            <p class="text-muted">
                                                Vous avez déjà un compte ?
                                                <a href="{{ route('login') }}" class="text-primary ms-2">Se
                                                    connecter</a>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>



<!--end body-->

<!-- Mirrored from mannatthemes.com/rizz/default/auth-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Nov 2024 21:52:10 GMT -->

{{-- </html> --}}
