@extends('layouts.master_dash')
@section('title', 'Liste des Articles')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Liste des Biens - Exportations Disponibles</h4>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table datatable" id="datatable_2">
                                <thead>
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
                                            <!-- Titre de l'Article -->
                                            <td>{{ $article->titre_article }}</td>

                                            <!-- Résumé du Contenu -->
                                            <td>{{ \Illuminate\Support\Str::limit($article->contenu_article, 50, '...') }}
                                            </td>

                                            <!-- Date de Création -->
                                            <td>{{ $article->created_at->format('d/m/Y') }}</td>

                                            <!-- Actions -->

                                            <td class="text-center align-middle">
                                                {{-- <!-- Voir l'article -->
                                                <a href="{{ route('article.show', $article->id) }}"
                                                    class="btn btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a> --}}

                                                <a href="{{ route('article.show', $article->id )}}" class="btn btn-outline-primary">
                                                    <span class="bi bi-info-circle-fill"></span>
                                                </a>

                                                <!-- Modifier l'article -->
                                                {{-- <a href="{{ route('article.edit', $article->id) }}"
                                                    class="btn btn-outline-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a> --}}

                                                <!-- Supprimer l'article -->
                                                <form action="{{ route('article.destroy', $article->id) }}" method="POST"
                                                    style="display: inline-block;"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer cet article ?');">
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
                            <a href="" class="btn btn-sm btn-primary pdf">
                                <i class="fas fa-file-pdf"></i> Exporter en PDF
                            </a>
                            {{-- <button type="button" class="btn btn-sm btn-primary csv">Export PDF</button> --}}
                            {{-- <button type="button" class="btn btn-sm btn-primary sql">Export SQL</button>
                    <button type="button" class="btn btn-sm btn-primary txt">Export TXT</button>
                    <button type="button" class="btn btn-sm btn-primary json">Export JSON</button> --}}
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div><!--end row-->


        {{-- voir le script equivalent dans layouts script... --}}

    </div>

@endsection
