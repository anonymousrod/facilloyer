@extends('layouts.master_dash')

@section('title', 'BIEN ET CONTRAT DE BAIL')

@section('content')
    <!-- AOS animation init -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script> AOS.init(); </script>

    <style>
        :root {
            --gradient-green: linear-gradient(90deg, #0f9b0f, #a8e063);
            --light-green: #b9fbc0;
            --dark-color: #1b1b1b;
            --light-color: #ffffff;
        }

        body.light-mode {
            background-color: #f5f5f5;
            color: #2f2f2f;
        }

        body.dark-mode {
            background-color: var(--dark-color);
            color: #e0e0e0;
        }

        body.dark-mode .card {
            background-color: #2a2a2a;
            border-color: #3a3a3a;
        }

        body.dark-mode .table {
            color: #e0e0e0;
        }

        body.dark-mode .table thead {
            background-color: #3a3a3a;
        }

        .gradient-title {
            background: var(--gradient-green);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .custom-btn {
            border-radius: 30px;
            border: 2px solid #0f9b0f;
            transition: 0.3s ease-in-out;
        }

        .custom-btn:hover {
            background: var(--gradient-green);
            color: white;
            border-color: transparent;
        }

        .mode-toggle {
            position: absolute;
            top: 20px;
            right: 30px;
            z-index: 999;
        }

        @media (max-width: 768px) {
            .responsive-card {
                display: block;
                background: white;
                border-radius: 1rem;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
                margin-bottom: 1rem;
                padding: 1rem;
                border-left: 5px solid #0f9b0f;
            }

            body.dark-mode .responsive-card {
                background-color: #2a2a2a;
                border-left: 5px solid #a8e063;
            }

            .responsive-card .card-line {
                margin-bottom: 0.5rem;
            }

            .table {
                display: none;
            }
        }

        @media (min-width: 769px) {
            .responsive-card {
                display: none;
            }
        }
    </style>

    {{-- Mode toggle button --}}
    <div class="mode-toggle">
        <button id="toggleMode" class="btn btn-sm btn-outline-success">🌞 / 🌙</button>
    </div>

    <div class="card shadow-sm mb-4 rounded-4 border-0" data-aos="fade-up">
        <div class="card-header bg-white py-4 border-bottom d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold gradient-title">
                <i class="bi bi-house-door-fill me-2 text-success"></i> Biens Loués
            </h4>
        </div>

        <div class="card-body">
            @if ($biensLoues->isEmpty())
                <div class="text-center py-5" data-aos="fade-up">
                    <i class="bi bi-exclamation-circle display-4 text-muted mb-3"></i>
                    <p class="text-muted fs-5">Aucun bien loué n'a été assigné.</p>
                </div>
            @else
                {{-- TABLE VERSION --}}
                <div class="table-responsive" data-aos="fade-up">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-uppercase small text-muted">
                                <th scope="col">Bien</th>
                                <th scope="col">Adresse</th>
                                <th scope="col">Loyer mensuel</th>
                                <th scope="col" class="text-center">Détails</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($biensLoues as $bien)
                                <tr class="border-bottom">
                                    <td class="fw-semibold">{{ $bien->name_bien }}</td>
                                    <td class="text-muted">{{ \Illuminate\Support\Str::words($bien->adresse_bien, 1, '...') }}</td>
                                    <td class="text-success fw-semibold">
                                        {{ number_format($bien->loyer_mensuel, 2, ',', ' ') }} €
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('biens.show', ['bien_id' => $bien->id, 'agent_id' => $locataire->agent_immobilier->id ?? null]) }}"
                                           class="btn btn-sm custom-btn">
                                            <i class="bi bi-info-circle-fill me-1"></i> Voir
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE VERSION --}}
                <div class="d-md-none">
                    @foreach ($biensLoues as $bien)
                        <div class="responsive-card" data-aos="fade-up">
                            <div class="card-line"><strong>Bien :</strong> {{ $bien->name_bien }}</div>
                            <div class="card-line"><strong>Adresse :</strong> {{ \Illuminate\Support\Str::words($bien->adresse_bien, 1, '...') }}</div>
                            <div class="card-line"><strong>Loyer :</strong>
                                <span class="text-success fw-semibold">
                                    {{ number_format($bien->loyer_mensuel, 2, ',', ' ') }} €
                                </span>
                            </div>
                            <div class="text-end mt-2">
                                <a href="{{ route('biens.show', ['bien_id' => $bien->id, 'agent_id' => $locataire->agent_immobilier->id ?? null]) }}"
                                   class="btn btn-sm custom-btn">
                                    <i class="bi bi-info-circle-fill me-1"></i> Voir
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Dark mode script --}}
    <script>
        const toggleBtn = document.getElementById('toggleMode');
        const currentMode = localStorage.getItem('theme');

        if (currentMode === 'dark') {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.add('light-mode');
        }

        toggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            document.body.classList.toggle('light-mode');

            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });
    </script>
@endsection
