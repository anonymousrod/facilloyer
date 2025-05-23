@extends('layouts.master_dash')

@section('content')

<!-- Mode Toggle Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mode = localStorage.getItem('mode') || 'light';
        document.body.classList.add(`${mode}-mode`);

        document.getElementById('toggle-mode')?.addEventListener('click', function () {
            const isDark = document.body.classList.toggle('dark-mode');
            document.body.classList.toggle('light-mode', !isDark);
            localStorage.setItem('mode', isDark ? 'dark' : 'light');
        });
    });
</script>

<!-- Bouton Toggle -->
<div class="position-fixed bottom-0 end-0 m-4 z-3">
    <button id="toggle-mode" class="btn btn-toggle px-4 py-2 rounded-pill fw-bold">
        🌗 Thème
    </button>
</div>

<div class="container py-5 section-fond-custom">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card-main shadow-lg p-0 rounded-4">
                <div class="card-header-custom text-white text-center py-4">
                    <h2 class="fw-bold mb-0">🔧 Statut demandes</h2>
                </div>

                <div class="p-4 bg-body-custom">

                    @if (session('success'))
                        <div class="alert alert-success fw-medium">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger fw-medium">{{ session('error') }}</div>
                    @endif

                    @if ($demandes->isEmpty())
                        <div class="text-center text-muted py-5">💡 Aucune demande enregistrée.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle text-center">
                                <thead class="text-uppercase small text-muted">
                                    <tr>
                                        <th class="text-start ps-4">🏠 Bien</th>
                                        <th>Description</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($demandes as $demande)
                                        @php
                                            $statut = strtolower($demande->statut);
                                            $couleur = match($statut) {
                                                'en attente' => '#ffc107',
                                                'en cours' => '#17a2b8',
                                                'validée', 'terminée' => '#28a745',
                                                default => '#6c757d'
                                            };

                                            $icone = match($statut) {
                                                'en attente' => '⏳',
                                                'en cours' => '🔧',
                                                'validée' => '✅',
                                                'terminée' => '✔️',
                                                default => '❔'
                                            };
                                        @endphp
                                        <tr class="ligne-demande" style="--ligne-color: {{ $couleur }};">
                                            <td class="text-start ps-4 fw-semibold">
                                                {{ $demande->bien->name_bien }}
                                            </td>
                                            <td class="text-muted">
                                                {{ $demande->description }}
                                            </td>
                                            <td>
                                                <span class="badge statut">
                                                    {{ $icone }} {{ ucfirst($demande->statut) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('locataire.demandes.create') }}" class="btn btn-add px-4 py-2">
                            ➕ Nouvelle demande
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles Modernes -->
<style>
    :root {
        --main: #012B1B;
        --accent: #e60000;
        --bg-dark: #0C0C0C;
        --bg-light: #f8f9fa;
        --text-dark: #f1f1f1;
        --text-light: #1a1a1a;
    }

    body.light-mode {
        background-color: var(--bg-light);
        color: var(--text-light);
    }

    body.dark-mode {
        background-color: var(--bg-dark);
        color: var(--text-dark);
    }

    .card-main {
        border-radius: 1.5rem;
        overflow: hidden;
    }

    .card-header-custom {
        background: linear-gradient(135deg, var(--main), #026b4d);
        font-size: 1.5rem;
    }

    .bg-body-custom {
        background-color: rgba(255, 255, 255, 0.03);
    }

    .btn-toggle {
        background-color: rgba(0, 0, 0, 0.05);
        color: var(--main);
        border: 1px solid var(--main);
        backdrop-filter: blur(6px);
        transition: all 0.3s ease;
    }

    .btn-toggle:hover {
        background-color: var(--main);
        color: white;
    }

    .btn-add {
        background: var(--main);
        color: white;
        border-radius: 30px;
        border: none;
        transition: 0.3s;
        font-weight: 500;
    }

    .btn-add:hover {
        background: #026b4d;
    }

    .badge {
        padding: 0.45rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .status-en.attente {
        background-color: #ffc107;
        color: #333;
    }

    .status-en.cours {
        background-color: #17a2b8;
        color: #fff;
    }

    .status-validée,
    .status-terminée {
        background-color: #28a745;
        color: #fff;
    }

    /* Mode sombre adaptation */
    body.dark-mode .card-main {
        background-color: rgba(255, 255, 255, 0.05);
    }

    body.dark-mode .table thead th {
        color: #ccc;
    }

    body.dark-mode .text-muted {
        color: #aaa !important;
    }

    body.dark-mode .alert {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    .ligne-demande {
    background: rgba(255, 255, 255, 0.03);
    border-left: 6px solid var(--ligne-color);
    transition: all 0.3s ease;
}

.ligne-demande:hover {
    background: rgba(255, 255, 255, 0.08);
    transform: scale(1.01);
}

body.dark-mode .ligne-demande {
    background: rgba(255, 255, 255, 0.02);
}

body.dark-mode .ligne-demande:hover {
    background: rgba(255, 255, 255, 0.05);
}

.badge.statut {
    background-color: var(--ligne-color);
    color: #fff;
    padding: 0.45rem 1.1rem;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(0,0,0,0.15);
}

</style>

@endsection
