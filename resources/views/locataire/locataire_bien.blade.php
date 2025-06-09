@extends('layouts.master_dash')

@section('title', 'BIEN ET CONTRAT DE BAIL')

@section('content')
<!-- AOS animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script> AOS.init(); </script>

<style>
    :root {
        --gradient-green: linear-gradient(90deg, #0f9b0f,rgb(6, 71, 15));
        --text-muted: #6c757d;
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
        color:rgb(7, 36, 7);
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
        border-left: 5px solidrgb(4, 53, 4);
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
        <div class="card-header py-4 border-bottom d-flex justify-content-between align-items-center">
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
                        <thead class="table text-muted small text-uppercase">
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

    {{-- Script de mode sombre --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.querySelector('#light-dark-mode');

            toggleBtn?.addEventListener('click', function () {
                document.body.classList.toggle('dark');

                if (document.body.classList.contains('dark')) {
                    document.body.style.backgroundColor = '#000';
                    document.body.style.color = '#fff';

                    document.querySelectorAll('.card, .glass-effect, .bg-glass, .responsive-card, .table').forEach(el => {
                        el.style.backgroundColor = '#111';
                        el.style.color = '#fff';
                        el.style.borderColor = '#333';
                    });

                    document.querySelectorAll('.table th, .table td').forEach(el => {
                        el.style.color = '#eee';
                        el.style.borderColor = '#444';
                    });
                } else {
                    document.body.style.backgroundColor = '';
                    document.body.style.color = '';

                    document.querySelectorAll('.card, .glass-effect, .bg-glass, .responsive-card, .table').forEach(el => {
                        el.style.backgroundColor = '';
                        el.style.color = '';
                        el.style.borderColor = '';
                    });

                    document.querySelectorAll('.table th, .table td').forEach(el => {
                        el.style.color = '';
                        el.style.borderColor = '';
                    });
                }
            });
        });
    </script>
@endsection
