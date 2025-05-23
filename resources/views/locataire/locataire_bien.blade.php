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
            --dark-color: #000000;
            --text-light: #f5f5f5;
            --text-muted: #b0b0b0;
            --success-green: #0f9b0f;
        }

        body {
            transition: background-color 0.5s, color 0.5s;
        }

        body.dark-mode {
            background-color: var(--dark-color) !important;
            color: var(--text-light);
        }

        body.dark-mode .card,
        body.dark-mode .responsive-card,
        body.dark-mode .glass-effect,
        body.dark-mode .bg-glass {
            background-color: var(--dark-color) !important;
            color: var(--text-light);
            border-color: #333;
        }

        body.dark-mode .table,
        body.dark-mode .table thead,
        body.dark-mode .table td,
        body.dark-mode .table th {
            background-color: transparent !important;
            color: var(--text-light);
            border-color: #333;
        }

        .gradient-title {
            background: var(--gradient-green);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .custom-btn {
            border-radius: 30px;
            border: 2px solid #0f9b0f;
            transition: 0.3s ease;
            font-weight: 500;
            color: #0f9b0f;
            background-color: transparent;
        }

        .custom-btn:hover {
            background: var(--gradient-green);
            color: white;
            border-color: transparent;
        }

        .bg-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 5px solid #0f9b0f;
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

    <div class="card shadow-lg mb-5 rounded-4 border-0 bg-glass" data-aos="fade-up">
        <div class="card-header bg-white py-4 border-bottom d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold gradient-title fs-3">
                <i class="bi bi-house-door-fill me-2 text-success"></i> Vos biens loués
            </h2>
        </div>

        <div class="card-body">
            @if ($biensLoues->isEmpty())
                <div class="text-center py-5" data-aos="zoom-in">
                    <i class="bi bi-exclamation-circle display-3 text-muted mb-3"></i>
                    <p class="text-muted fs-5">Aucun bien loué n'a encore été assigné.</p>
                </div>
            @else
                {{-- Table Desktop --}}
                <div class="table-responsive d-none d-md-block" data-aos="fade-up">
                    <table class="table align-middle table-hover shadow-sm">
                        <thead class="table-success text-muted small text-uppercase">
                            <tr>
                                <th>Bien</th>
                                <th>Adresse</th>
                                <th>Loyer mensuel</th>
                                <th class="text-center">Détails</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($biensLoues as $bien)
                                <tr>
                                    <td class="fw-semibold">{{ $bien->name_bien }}</td>
                                    <td>{{ \Illuminate\Support\Str::words($bien->adresse_bien, 3, '...') }}</td>
                                    <td class="text-success fw-bold">
                                        {{ number_format($bien->loyer_mensuel, 2, ',', ' ') }} €
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('biens.show', ['bien_id' => $bien->id, 'agent_id' => $locataire->agent_immobilier->id ?? null]) }}"
                                           class="btn custom-btn btn-sm px-3 py-1">
                                            <i class="bi bi-eye-fill me-1"></i> Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Version --}}
                <div class="d-md-none">
                    @foreach ($biensLoues as $bien)
                        <div class="responsive-card glass-effect" data-aos="fade-up">
                            <p><strong>Bien :</strong> {{ $bien->name_bien }}</p>
                            <p><strong>Adresse :</strong> {{ \Illuminate\Support\Str::words($bien->adresse_bien, 3, '...') }}</p>
                            <p><strong>Loyer :</strong>
                                <span class="text-success fw-bold">{{ number_format($bien->loyer_mensuel, 2, ',', ' ') }} €</span>
                            </p>
                            <div class="text-end">
                                <a href="{{ route('biens.show', ['bien_id' => $bien->id, 'agent_id' => $locataire->agent_immobilier->id ?? null]) }}"
                                   class="btn custom-btn btn-sm">
                                    <i class="bi bi-eye-fill me-1"></i> Voir
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Mode sombre toggle --}}
   
@endsection
