{{-- @extends('layouts.master_dash')
@section('title', isset($articles) ? 'Modifier l\'Article' : 'Créer un article')
@section('content')
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success text-center">
                <h5 class="text-success">{{ session('success') }}</h5>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center">
                <h5 class="text-danger">{{ session('error') }}</h5>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header text-white text-start" style="background-color: #4CAF50;">
                <h4 class="h4">{{ isset($articles) ? 'Modifier un Article' : 'Ajouter un Article' }}</h4>
            </div>
            <div class="card-body bg-light">
                <form action="{{ isset($articles) ? route('article.update', $articles->id) : route('article.store') }}" method="POST">
                    @csrf
                    @if (isset($articles))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="titre_article" class="form-label fw-bold">Titre de l'Article</label>
                        <input type="text" name="titre_article" id="titre_article" class="form-control border-0 shadow-sm"
                            value="{{ old('titre_article', isset($articles) ? $articles->titre_article : '') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="contenu_article" class="form-label fw-bold">Contenu de l'Article</label>
                        <textarea name="contenu_article" id="contenu_article" rows="5" class="form-control border-0 shadow-sm" required>{{ old('contenu_article', isset($articles) ? $articles->contenu_article : '') }}</textarea>
                    </div>

                    @php
                        $isUsedInContracts = isset($articles)
                            ? DB::table('contrat_de_bail_article')->where('article_source_id', $articles->id)->exists()
                            : false;
                    @endphp

                    @if ($isUsedInContracts)
                        <div class="alert alert-warning text-center">
                            <h5>Impossible de modifier cet article, il est utilisé dans des contrats existants.</h5>
                        </div>
                    @endif

                    <div class="text-center">
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" {{ $isUsedInContracts ? 'disabled' : '' }}>
                            {{ isset($articles) ? 'Mettre à jour' : 'Ajouter' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection --}}
@extends('layouts.master_dash')

@section('title', isset($articles) ? 'Modifier l\'Article' : 'Créer un article')

@section('content')
    <style>
        body {
            background-color: #F4F7FA;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-wrapper {
            max-width: 750px;
            margin: auto;
        }

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
            border: 1px solid #ddd;
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
    </style>

    <div class="container py-5 form-wrapper">
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

        <div class="card-modern">
            <h2 class="text-dark mb-4">{{ isset($articles) ? '✏️ Modifier un Article' : '📝 Créer un Nouvel Article' }}</h2>

            <form action="{{ isset($articles) ? route('article.update', $articles->id) : route('article.store') }}" method="POST">
                @csrf
                @if (isset($articles)) @method('PUT') @endif

                {{-- Titre --}}
                <div class="mb-4">
                    <label for="titre_article" class="form-label">Titre de l'Article</label>
                    <input type="text" name="titre_article" id="titre_article"
                        class="form-control"
                        value="{{ old('titre_article', isset($articles) ? $articles->titre_article : '') }}"
                        placeholder="Ex : Conformité des lieux loués"
                        required>
                </div>

                {{-- Contenu --}}
                <div class="mb-4">
                    <label for="contenu_article" class="form-label">Contenu de l'Article</label>
                    <textarea name="contenu_article" id="contenu_article" rows="3"
                        class="form-control"
                        placeholder="Décrivez ici le contenu de l’article en détails..."
                        required>{{ old('contenu_article', isset($articles) ? $articles->contenu_article : '') }}</textarea>
                </div>

                {{-- Vérification de contrat --}}
                @php
                    $isUsedInContracts = isset($articles)
                        ? DB::table('contrat_de_bail_article')->where('article_source_id', $articles->id)->exists()
                        : false;
                @endphp

                @if ($isUsedInContracts)
                    <div class="disabled-message text-center mt-3 mb-4">
                        ⚠️ Cet article est utilisé dans un ou plusieurs contrats. Il ne peut pas être modifié.
                    </div>
                @endif

                {{-- Bouton --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn-gradient" {{ $isUsedInContracts ? 'disabled' : '' }}>
                        {{ isset($articles) ? 'Mettre à jour l’article' : 'Créer l’article' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
<style>
    body {
        background: linear-gradient(to right, #f0f4f8, #e8f5e9);
        background-attachment: fixed;
    }

    .form-wrapper {
        max-width: 750px;
        margin: auto;
    }

    .card-modern {
        background: #ffffffd9; /* transparence douce */
        backdrop-filter: blur(5px);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
</style>
