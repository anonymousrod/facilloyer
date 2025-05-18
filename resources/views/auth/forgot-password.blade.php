<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[var(--gris-doux)] px-0" style="overflow:hidden;">
        <style>
            :root {
                --vert-fonce: #14532d;
                --vert-clair: #22c55e;
                --gris-doux: #f3f4f6;
                --noir-charbon: #23272a;
            }
            html, body, .min-h-screen {
                height: 100vh !important;
                min-height: 100vh !important;
                overflow: hidden !important;
            }
            body, .bg-[var(--gris-doux)] {
                background: linear-gradient(120deg, var(--gris-doux) 60%, #e8f5e9 100%) !important;
            }
            .reset-glass {
                background: rgba(255,255,255,0.92);
                border-radius: 2.5rem;
                box-shadow: 0 12px 48px 0 rgba(20,83,45,0.13);
                max-width: 410px;
                width: 100%;
                padding: 2.2rem 2rem 2rem 2rem;
                margin: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                overflow: visible;
                border: 1.5px solid #e0e7ef;
                backdrop-filter: blur(7px);
                min-height: 0;
            }
            .reset-glass .logo-top {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                background: linear-gradient(120deg, var(--vert-fonce) 60%, var(--vert-clair) 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.1rem;
                box-shadow: 0 4px 24px 0 rgba(20,83,45,0.13);
                z-index: 1;
            }
            .reset-glass .logo-top img {
                width: 44px;
                height: 44px;
                object-fit: contain;
                filter: drop-shadow(0 2px 8px rgba(20,83,45,0.10));
            }
            .reset-glass h1 {
                font-size: 1.5rem;
                font-weight: 900;
                color: var(--vert-fonce);
                margin-bottom: 0.7rem;
                letter-spacing: -1px;
                text-align: center;
                z-index: 1;
                position: relative;
            }
            .reset-glass p {
                color: var(--noir-charbon);
                font-size: 1rem;
                margin-bottom: 1.2rem;
                text-align: center;
                z-index: 1;
                position: relative;
            }
            .form-label {
                font-weight: 700;
                color: var(--vert-fonce);
                margin-bottom: 0.3rem;
                letter-spacing: 0.01em;
            }
            .form-control {
                border-radius: 0.8rem;
                border: 1.5px solid var(--gris-doux);
                background: #fff;
                color: var(--noir-charbon);
                font-size: 1rem;
                padding: 0.8rem 1rem;
                transition: border-color 0.2s, box-shadow 0.2s;
                box-shadow: 0 2px 8px 0 rgba(20,83,45,0.04);
            }
            .form-control:focus {
                border-color: var(--vert-clair);
                box-shadow: 0 0 0 2px #22c55e33;
                outline: none;
            }
            .btn-reset {
                background: linear-gradient(90deg, var(--vert-fonce) 60%, var(--vert-clair) 100%);
                border: none;
                padding: 0.8rem 2.2rem;
                font-weight: 800;
                font-size: 1.05rem;
                border-radius: 2rem;
                color: #fff;
                box-shadow: 0 6px 24px 0 rgba(34,197,94,0.13);
                transition: transform 0.18s, box-shadow 0.18s, background 0.3s;
                letter-spacing: 0.01em;
                display: flex;
                align-items: center;
                gap: 0.7rem;
                margin: auto 0 0 0;
            }
            .btn-reset:hover, .btn-reset:focus {
                transform: translateY(-2px) scale(1.04);
                background: linear-gradient(90deg, var(--vert-clair) 60%, var(--vert-fonce) 100%);
                box-shadow: 0 16px 48px 0 rgba(34,197,94,0.18);
            }
            .icon-mail {
                display: inline-block;
                width: 1.1em;
                height: 1.1em;
                vertical-align: middle;
                margin-right: 0.2em;
            }
            @media (max-width: 700px) {
                .reset-glass { border-radius: 1.2rem; padding: 1.2rem !important; }
                .reset-glass h1 { font-size: 1.1rem; }
            }
        </style>
        <div class="reset-glass">
            <div class="logo-top">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="Logo FacilLoyer" />
            </div>
            <h1>Mot de passe oublié ?</h1>
            <p>Pas de panique&nbsp;! Indiquez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" action="{{ route('password.email') }}" style="width:100%;">
                @csrf
                <div class="mb-3" style="width:100%;">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input id="email" class="form-control w-100" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="exemple@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="flex items-center justify-center mt-4">
                    <button class="btn-reset" type="submit">
                        <svg class="icon-mail" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Envoyer le lien de réinitialisation
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
