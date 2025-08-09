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

    {{-- <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #e6f4ea;
            margin: 0;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e6f4ea;
        }

        .auth-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(22, 101, 52, 0.10);
            overflow: hidden;
            width: 100%;
            max-width: 700px;
            min-height: 340px;
            display: flex;
            flex-direction: row;
            animation: fadeInUp 0.8s cubic-bezier(.4, 2, .6, 1);
        }

        .auth-card-left {
            background: #166534;
            color: #fff;
            flex: 1 1 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.2rem 1.2rem;
            min-width: 220px;
        }

        .auth-card-left img {
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

        .auth-card-left img:hover {
            transform: scale(1.08) rotate(-2deg);
        }

        .auth-logo-text {
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 0.2rem;
        }

        .auth-card-left p {
            font-size: 1.05rem;
            opacity: 0.92;
        }

        .form-label {
            color: #166534;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border-radius: 0.8rem;
            border: 1px solid #bbf7d0;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            background: #f6fef9;
        }

        .form-control:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 0.15rem rgba(34, 197, 94, 0.12);
            background: #fff;
        }

        .input-icon {
            display: none;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.3rem;
        }

        .btn-primary {
            background: #22c55e;
            border: none;
            padding: 0.8rem 0;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px 0 rgba(34, 197, 94, 0.10);
            transition: background 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background: #166534;
            transform: translateY(-2px) scale(1.03);
        }

        .alert {
            font-size: 0.98rem;
            border-radius: 0.7rem;
            padding: 0.7rem 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .alert-danger {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .alert-danger i {
            color: #b91c1c;
        }

        .form-check-input:checked {
            background-color: #22c55e;
            border-color: #22c55e;
        }

        .form-check-label {
            color: #166534;
            font-size: 0.97rem;
        }

        .text-link {
            color: #22c55e;
            text-decoration: underline;
            font-weight: 600;
            transition: color 0.2s;
        }

        .text-link:hover {
            color: #166534;
        }

        .auth-footer-text {
            font-size: 1rem;
            color: #166534;
            margin-top: 1.5rem;
        }

        @media (max-width: 600px) {
            .auth-card {
                max-width: 98vw;
                border-radius: 1rem;
            }

            .auth-header-box {
                .card-body.p-4 {
                    flex: 2 1 0;
                    padding: 2rem 2rem;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }

                padding: 1.5rem 0.5rem 1rem 0.5rem;

                .auth-card {
                    flex-direction: column;
                    max-width: 98vw;
                    border-radius: 1rem;
                }

                .auth-card-left {
                    padding: 1.5rem 0.5rem 1rem 0.5rem;
                }

                background: #1a2e22;
                box-shadow: 0 8px 32px 0 rgba(34, 197, 94, 0.10);
            }

            .auth-header-box {
                background: #166534;
                color: #fff;
            }

            .auth-logo-text,
            .form-label,
            .form-check-label,
            .auth-footer-text {
                color: #bbf7d0;
            }

            .form-control {
                background: #052e16;
                color: #bbf7d0;
                border: 1px solid #166534;
            }

            .form-control:focus {
                border-color: #22c55e;
                background: #1a2e22;
            }

            .btn-primary {
                background: #22c55e;
                color: #052e16;
            }

            .btn-primary:hover {
                background: #bbf7d0;
                color: #166534;
            }

            .text-link {
                color: #bbf7d0;
            }

            .text-link:hover {
                color: #22c55e;
            }
        }

        .auth-card {
            max-width: 98vw;
            border-radius: 1rem;
        }

        .auth-header-box {
            padding: 1.5rem 0.5rem 1rem 0.5rem;
        }
        }
    </style> --}}

{{-- <head>
    @include('layouts.layouts_dash.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #e6f4ea;
            margin: 0;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e6f4ea;
            padding: 1rem;
        }

        .auth-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(22, 101, 52, 0.10);
            overflow: hidden;
            width: 100%;
            max-width: 700px;
            min-height: 340px;
            display: flex;
            flex-direction: column;
            /* Par défaut : mobile => gauche en haut, droite en bas */
            animation: fadeInUp 0.8s cubic-bezier(.4, 2, .6, 1);
        }

        .auth-card-left {
            background: #166534;
            color: #fff;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .auth-card-left img {
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

        .auth-card-left img:hover {
            transform: scale(1.08) rotate(-2deg);
        }

        .auth-logo-text {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 0.2rem;
        }

        .auth-card-left p {
            font-size: 1.05rem;
            opacity: 0.92;
        }

        .form-label {
            color: #166534;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border-radius: 0.8rem;
            border: 1px solid #bbf7d0;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            background: #f6fef9;
        }

        .form-control:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 0.15rem rgba(34, 197, 94, 0.12);
            background: #fff;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.3rem;
        }

        .btn-primary {
            background: #22c55e;
            border: none;
            padding: 0.8rem 0;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px 0 rgba(34, 197, 94, 0.10);
            transition: background 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background: #166534;
            transform: translateY(-2px) scale(1.03);
        }

        .alert {
            font-size: 0.98rem;
            border-radius: 0.7rem;
            padding: 0.7rem 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .alert-danger {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .form-check-input:checked {
            background-color: #22c55e;
            border-color: #22c55e;
        }

        .form-check-label {
            color: #166534;
            font-size: 0.97rem;
        }

        .text-link {
            color: #22c55e;
            text-decoration: underline;
            font-weight: 600;
            transition: color 0.2s;
        }

        .text-link:hover {
            color: #166534;
        }

        .auth-footer-text {
            font-size: 1rem;
            color: #166534;
            margin-top: 1.5rem;
        }

        /* Responsive - à partir de 768px : côte à côte */
        @media (min-width: 768px) {
            .auth-card {
                flex-direction: row;
                /* Desktop => gauche/droite */
            }

            .auth-card-left {
                min-width: 220px;
                border-radius: 1.5rem 0 0 1.5rem;
            }
        }
    </style>

</head> --}}
<head>
    @include('layouts.layouts_dash.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #e6f4ea, #d1fae5);
            margin: 0;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .auth-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 8px 30px rgba(22, 101, 52, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 780px;
            display: flex;
            flex-direction: column;
            animation: fadeInUp 0.7s ease-in-out;
        }

        /* Partie gauche */
        .auth-card-left {
            background: linear-gradient(135deg, #166534, #15803d);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
            text-align: center;
        }

        .auth-card-left img {
            height: 85px;
            margin-bottom: 1.2rem;
            background: #fff;
            border-radius: 50%;
            padding: 14px;
            box-shadow: 0 4px 12px rgba(22, 101, 52, 0.2);
            transition: transform 0.3s ease;
        }

        .auth-card-left img:hover {
            transform: scale(1.06);
        }

        .auth-logo-text {
            font-weight: 700;
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
        }

        .auth-card-left p {
            font-size: 1.05rem;
            opacity: 0.9;
        }

        /* Partie droite */
        .card-body {
            padding: 2rem;
            flex: 1;
        }

        .form-label {
            color: #166534;
            font-weight: 600;
            margin-bottom: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border-radius: 0.7rem;
            border: 1px solid #c7e9cc;
            padding: 0.7rem 1rem;
            font-size: 1rem;
            background: #f6fef9;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
            background: #fff;
            outline: none;
        }

        .form-group {
            margin-bottom: 1.3rem;
        }

        /* Bouton */
        .btn-primary {
            background: #22c55e;
            border: none;
            padding: 0.85rem 0;
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 0.7rem;
            box-shadow: 0 3px 10px rgba(34, 197, 94, 0.2);
            transition: all 0.25s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background: #166534;
            transform: translateY(-2px);
        }

        /* Liens et textes */
        .text-link {
            color: #22c55e;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .text-link:hover {
            color: #166534;
        }

        .auth-footer-text {
            font-size: 0.95rem;
            color: #166534;
            margin-top: 1.2rem;
        }

        /* Alertes */
        .alert {
            font-size: 0.95rem;
            border-radius: 0.6rem;
            padding: 0.65rem 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .alert-danger {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* Responsive */
        @media (min-width: 768px) {
            .auth-card {
                flex-direction: row;
            }
            .auth-card-left {
                flex: 1;
                max-width: 280px;
                border-radius: 1.25rem 0 0 1.25rem;
            }
            .card-body {
                flex: 2;
            }
        }
    </style>
</head>


<body>
    <div class="auth-container">
        <div
            class="auth-card animate__animated animate__fadeInUp flex flex-col md:flex-row w-full max-w-[700px] mx-auto">
            <div
                class="auth-card-left flex flex-col items-center justify-center md:rounded-l-2xl rounded-t-2xl md:rounded-t-none">
                <img src="{{ asset('assets/images/gbsolux-remouve.png') }}" alt="logo">
                <div class="auth-logo-text">Bienvenue sur {{ env('APP_NAME') }}</div>
                <p>Connectez-vous pour continuer</p>
            </div>
            <div class="card-body p-4 w-full md:w-auto">
                @if ($errors->has('status'))
                    <div class="alert alert-danger"><i
                            class="fas fa-exclamation-triangle"></i>{{ $errors->first('status') }}</div>
                @endif
                @error('email')
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                @enderror
                @error('password')
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                @enderror
                <form action="{{ route('login') }}" method="POST" class="mt-2 w-full">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Adresse
                            e-mail</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Entrez votre adresse e-mail" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Mot de passe</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Entrez votre mot de passe" required>
                    </div>
                    <div class="flex flex-col sm:flex-row mb-3 items-center justify-between gap-2">
                        <div class="w-full sm:w-1/2">
                            <div class="form-check flex items-center">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label ms-2" for="remember">Se souvenir de moi</label>
                            </div>
                        </div>
                        <div class="w-full sm:w-1/2 text-end">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-link">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="d-grid w-full">
                        <button type="submit"
                            class="btn btn-primary animate__animated animate__pulse animate__delay-1s w-full">
                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                        </button>
                    </div>
                </form>
                <div class="text-center auth-footer-text">
                    <span>Pas encore de compte ?
                        <a href="{{ route('register') }}" class="text-link">Créer un compte</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</body>
