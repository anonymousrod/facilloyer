@extends('layouts.master_dash')
@section('title', isset($articles) ? 'Modifier l\'Article' : 'Créer un article')
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success text-center">
                <h5 class="text-success">{{ session('success') }}</h5>
            </div>
        @endif
        <h1>{{ isset($articles) ? 'Modifier un Article' : 'Ajouter un Article' }}</h1>
        <form action="{{ isset($articles) ? route('article.update', $articles->id) : route('article.store') }}" method="POST">
            @csrf
            @if(isset($articles))
                @method('PUT') <!-- Pour les requêtes PUT lors de la mise à jour -->
            @endif
            <div class="mb-3">
                <label for="titre_article" class="form-label">Titre de l'Article</label>
                <input type="text" name="titre_article" id="titre_article" class="form-control" value="{{ old('titre_article', isset($articles) ? $articles->titre_article : '') }}" required>
            </div>
            <div class="mb-3">
                <label for="contenu_article" class="form-label">Contenu de l'Article</label>
                <textarea name="contenu_article" id="contenu_article" rows="5" class="form-control" required>{{ old('contenu_article', isset($articles) ? $articles->contenu_article : '') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($articles) ? 'Mettre à jour' : 'Ajouter' }}</button>
        </form>
    </div>
@endsection
