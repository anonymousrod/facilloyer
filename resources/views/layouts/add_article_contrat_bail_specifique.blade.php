{{-- @extends('layouts.master_dash')
@section('title', isset($articles) ? 'Modifier l\'Article' : 'Créer un article')
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success text-center">
                <h5 class="text-success">{{ session('success') }}</h5>
            </div>
        @endif
        <h1>{{ isset($articles) ? 'Modifier un Article' : 'Ajouter un Article' }}</h1>
        <form action="{{  route('article.ajouterArticleSpecifique', $contrat->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="titre_article" class="form-label">Titre de l'Article</label>
                <input type="text" name="titre_article" id="titre_article" class="form-control" value="{{ old('titre_article') }}" required>
            </div>
            <div class="mb-3">
                <label for="contenu_article" class="form-label">Contenu de l'Article</label>
                <textarea name="contenu_article" id="contenu_article" rows="5" class="form-control" required>{{ old('contenu_article') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{  'Ajouter' }}</button>
        </form>
    </div>
@endsection --}}

@extends('layouts.master_dash')

@section('title', isset($articles) ? 'Modifier l\'Article' : 'Créer un article')

@section('content')
    <style>
        body {
            background: linear-gradient(to right, #f0f4f8, #e8f5e9);
            background-attachment: fixed;
        }

        .form-wrapper {
            max-width: 750px;
            margin: 50px auto;
        }

        .card-modern {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 600;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2e7d32;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #4CAF50;
            border: none;
            font-weight: 600;
            padding: 10px 30px;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }
    </style>

    <div class="container form-wrapper">
        @if (session('success'))
            <div class="alert alert-success text-center">
                <h5 class="text-success">{{ session('success') }}</h5>
            </div>
        @endif

        <div class="card-modern">
            <h1>{{ isset($articles) ? 'Modifier un Article' : '' }}</h1>

            <form action="{{ route('article.ajouterArticleSpecifique', $contrat->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="titre_article" class="form-label">Titre de l'Article</label>
                    <input type="text" name="titre_article" id="titre_article"
                        placeholder="Ex : Conformité des lieux loués" class="form-control shadow-sm"
                        value="{{ old('titre_article') }}" required>
                </div>

                <div class="mb-4">
                    <label for="contenu_article" class="form-label">Contenu de l'Article</label>
                    <textarea name="contenu_article" id="contenu_article" rows="3"
                        placeholder="Décrivez ici le contenu de l’article en détails..." class="form-control shadow-sm" required>{{ old('contenu_article') }}</textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ 'Ajouter' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
