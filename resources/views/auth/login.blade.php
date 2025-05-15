{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
<head>
    @include('layouts.layouts_dash.head')
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f9f9f9;
        }

        .auth-card {
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .auth-header-box {
            background-color: #2c3e50;
            color: white;
            padding: 2rem 1rem;
            text-align: center;
        }

        .auth-header-box img {
            height: 60px;
        }

        .auth-logo-text {
            margin-top: 1rem;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .form-control {
            border-radius: 1rem;
        }

        .btn-primary {
            border-radius: 1rem;
            font-weight: 600;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 0.5rem;
            font-size: 1.1rem;
        }

        .auth-footer-text {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="row vh-100 d-flex justify-content-center align-items-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="card auth-card">
                    <!-- Header -->
                    <div class="auth-header-box">
                        <img src="assets/images/logo-sm.png" alt="logo">
                        <h4 class="auth-logo-text">Bienvenue sur {{ env('APP_NAME') }}</h4>
                        <p class="text-light">Connectez-vous pour continuer</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body p-4">
                        {{-- statut non valide --}}
                        @if ($errors->has('status'))
                            <div class="alert alert-danger">{{ $errors->first('status') }}</div>
                        @endif

                        <!-- erreur email -->
                        @error('email')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        <!-- erreur password -->
                        @error('password')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        <form action="{{ route('login') }}" method="POST" class="mt-2">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse e-mail</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Entrez votre adresse e-mail" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Entrez votre mot de passe" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-muted">
                                            Mot de passe oublié ?
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Se connecter <i class="fas fa-sign-in-alt ms-2"></i></button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="auth-footer-text">Pas encore de compte ?
                                <a href="{{ route('register') }}" class="text-primary fw-semibold">Créer un compte</a>
                            </p>
                            <p class="text-muted">Ou connectez-vous avec</p>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="#" class="social-btn bg-primary text-white"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-btn bg-info text-white"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-btn bg-danger text-white"><i class="fab fa-google"></i></a>
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</body>

