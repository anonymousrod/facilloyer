@extends('layouts.master_dash')

@section('title', isset($articles) ? 'Modifier l\'Article' : 'Créer un article')

@section('content')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* .form-wrapper {
            max-width: 750px;
            margin: auto;
        } */

        .card-modern {
            background: #fff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }

        .card-modern h2 {
            font-weight: 700;
            font-size: 1.8rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 12px;
            box-shadow: none !important;
            padding: 0.75rem 1rem;
            transition: border 0.2s ease;
        }

        .form-control:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .btn-gradient {
            background: linear-gradient(to right, #4CAF50, #388E3C);
            border: none;
            padding: 0.7rem 2.5rem;
            font-weight: bold;
            font-size: 1.1rem;
            border-radius: 30px;
            color: white;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-gradient:hover {
            transform: scale(1.02);
            background: linear-gradient(to right, #43A047, #2E7D32);
        }

        .alert {
            border-radius: 12px;
            padding: 1rem;
            font-weight: 600;
        }

        .disabled-message {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            border-radius: 10px;
            padding: 1rem;
        }

        .bg-dark-mode {
            background: #181a1b !important;
            color: #f3f4f6 !important;
        }

        .text-dark-mode {
            color: #f3f4f6 !important;
        }

        .input-dark-mode {
            background: #23272a !important;
            color: #f3f4f6 !important;
            border: 1.5px solid #333 !important;
        }

        .input-dark-mode:focus {
            border-color: #22c55e !important;
            box-shadow: 0 0 0 2px #22c55e33;
        }

        .btn-dark-mode {
            background: linear-gradient(90deg, #14532d 60%, #22c55e 100%) !important;
            color: #fff !important;
            border: none;
        }

        .btn-dark-mode:hover,
        .btn-dark-mode:focus {
            background: linear-gradient(90deg, #22c55e 60%, #14532d 100%) !important;
            color: #fff !important;
        }

        .bg-warning-mode {
            background: #2d2d1f !important;
            color: #ffe066 !important;
            border: 1.5px solid #ffe066 !important;
        }

        @media (prefers-color-scheme: dark) {
            .bg-white {
                background: #181a1b !important;
            }

            .text-dark {
                color: #f3f4f6 !important;
            }

            .form-control {
                background: #23272a !important;
                color: #f3f4f6 !important;
                border: 1.5px solid #333 !important;
            }

            .form-control:focus {
                border-color: #22c55e !important;
                box-shadow: 0 0 0 2px #22c55e33;
            }

            .btn-gradient {
                background: linear-gradient(90deg, #14532d 60%, #22c55e 100%) !important;
                color: #fff !important;
            }

            .btn-gradient:hover,
            .btn-gradient:focus {
                background: linear-gradient(90deg, #22c55e 60%, #14532d 100%) !important;
                color: #fff !important;
            }

            .disabled-message {
                background: #2d2d1f !important;
                color: #ffe066 !important;
                border: 1.5px solid #ffe066 !important;
            }
        }
    </style>
    <div class="card container py-5 form-wrapper">
        {{-- Messages --}}
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif
        <div class="card card-modern shadow border-0 bg-white bg-dark-mode">
            <h2 class="mb-4 text-center text-dark text-dark-mode">
                {{ isset($articles) ? '✏️ Modifier un Article' : '📝 Créer un Nouvel Article' }}
            </h2>
            <form action="{{ isset($articles) ? route('article.update', $articles->id) : route('article.store') }}"
                method="POST">
                @csrf
                @if (isset($articles))
                    @method('PUT')
                @endif
                {{-- Titre --}}
                <div class="mb-4">
                    <label for="titre_article" class="form-label text-dark text-dark-mode">Titre de l'Article</label>
                    <input type="text" name="titre_article" id="titre_article" class="form-control input-dark-mode"
                        value="{{ old('titre_article', isset($articles) ? $articles->titre_article : '') }}"
                        placeholder="Ex : Conformité des lieux loués" required>
                </div>
                {{-- Contenu --}}
                <div class="mb-4">
                    <label for="contenu_article" class="form-label text-dark text-dark-mode">Contenu de l'Article</label>
                    <textarea name="contenu_article" id="contenu_article" rows="3" class="form-control input-dark-mode"
                        placeholder="Décrivez ici le contenu de l’article en détails..." required>{{ old('contenu_article', isset($articles) ? $articles->contenu_article : '') }}</textarea>
                </div>
                {{-- Vérification de contrat --}}
                @php
                    $isUsedInContracts = isset($articles)
                        ? DB::table('contrat_de_bail_article')->where('article_source_id', $articles->id)->exists()
                        : false;
                @endphp
                @if ($isUsedInContracts)
                    <div class="disabled-message text-center mt-3 mb-4 bg-warning bg-warning-mode text-dark text-dark-mode">
                        ⚠️ Cet article est utilisé dans un ou plusieurs contrats. Il ne peut pas être modifié.
                    </div>
                @endif
                {{-- Bouton --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn-gradient btn-dark-mode" {{ $isUsedInContracts ? 'disabled' : '' }}>
                        {{ isset($articles) ? 'Mettre à jour l’article' : 'Créer l’article' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
