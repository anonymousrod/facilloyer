@extends('layouts.master_dash')
@section('title', 'Liste des Articles')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-lg">
                    @if (session('success'))
                        <div class="alert alert-success text-center m-3 mb-1">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-center m-3 mb-1">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card-header text-white m-3 mb-2" style="background-color: #212121;">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title mb-0">Liste des Articles</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable" id="datatable_2">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th>Titre</th>
                                        <th>Résumé</th>
                                        <th>Date de création</th>
                                        <th class="text-center align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td>{{ \Illuminate\Support\Str::words($article->titre_article, 1, '...') }}</td>
                                            <td>{{ \Illuminate\Support\Str::words($article->contenu_article, 1, '...') }}</td>
                                            <td>{{ $article->created_at->format('d/m/Y') }}</td>

                                            <!-- Actions -->

                                            <td class="text-center align-middle">
                                                <a href="{{ route('article.show', $article->id) }}" class="btn btn-outline-primary">
                                                    <span class="bi bi-info-circle-fill"></span>
                                                </a>

                                                <!-- Supprimer l'article -->
                                                <form action="{{ route('article.destroy', $article->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Voulez-vous vraiment supprimer cet article ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
