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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #F5F5F5;
            margin: 0;
        }
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F5F5F5;
        }
        .auth-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(24,90,157,0.10);
            overflow: hidden;
            width: 100%;
            max-width: 410px;
            animation: fadeInUp 0.8s cubic-bezier(.4,2,.6,1);
        }
        .auth-header-box {
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            color: #fff;
            padding: 2.2rem 1.2rem 1.2rem 1.2rem;
            text-align: center;
        }
        .auth-header-box img {
            height: 80px;
            margin-bottom: 1rem;
            filter: drop-shadow(0 0 8px rgba(67,206,162,0.18));
            transition: transform 0.3s;
        }
        .auth-header-box img:hover {
            transform: scale(1.08) rotate(-2deg);
        }
        .auth-logo-text {
            font-weight: 700;
            font-size: 1.5rem;
            color: #222;
            margin-bottom: 0.2rem;
        }
        .auth-header-box p {
            font-size: 1.05rem;
            opacity: 0.92;
        }
        .form-label {
            color: #222;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-control {
            border-radius: 0.8rem;
            border: 1px solid #dcdfe6;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            background: #F5F5F5;
        }
        .form-control:focus {
            border-color: #43cea2;
            box-shadow: 0 0 0 0.15rem rgba(67,206,162,0.12);
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
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 0.8rem;
            padding: 0.8rem 0;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px 0 rgba(67,206,162,0.10);
            transition: background 0.3s, transform 0.2s;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
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
            background: #fff0f0;
            color: #d32f2f;
            border: 1px solid #f8d7da;
        }
        .alert-danger i {
            color: #d32f2f;
        }
        .form-check-input:checked {
            background-color: #43cea2;
            border-color: #43cea2;
        }
        .form-check-label {
            color: #222;
            font-size: 0.97rem;
        }
        .text-link {
            color: #43cea2;
            text-decoration: underline;
            font-weight: 600;
            transition: color 0.2s;
        }
        .text-link:hover {
            color: #185a9d;
        }
        .auth-footer-text {
            font-size: 1rem;
            color: #222;
            margin-top: 1.5rem;
        }
        @media (max-width: 600px) {
            .auth-card {
                max-width: 98vw;
                border-radius: 1rem;
            }
            .auth-header-box {
                padding: 1.5rem 0.5rem 1rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card animate__animated animate__fadeInUp">
            <div class="auth-header-box">
                <img src="assets/images/logo-sm.png" alt="logo">
                <div class="auth-logo-text">Bienvenue sur {{ env('APP_NAME') }}</div>
                <p>Connectez-vous pour continuer</p>
            </div>
            <div class="card-body p-4">
                @if ($errors->has('status'))
                    <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i>{{ $errors->first('status') }}</div>
                @endif
                @error('email')
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                @enderror
                @error('password')
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                @enderror
                <form action="{{ route('login') }}" method="POST" class="mt-2">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Adresse e-mail</label>
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
                    <div class="row mb-3 align-items-center">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Se souvenir de moi</label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-link">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary animate__animated animate__pulse animate__delay-1s">
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

