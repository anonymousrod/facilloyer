@extends('layouts.master_dash')
@section('title', isset($articles) ? "Modifier l'Article" : 'Créer un article')
@section('content')
    {{-- Animate.css & Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <div class="card container-xxl py-5 animate__animated animate__fadeIn">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header py-4 d-flex flex-column flex-md-row align-items-center justify-content-between"
                        style="background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%); color: #fff; border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem;">
                        <div>
                            <h3 class="mb-0 fw-bold">
                                <i class="fa-solid fa-file-signature me-2"></i>
                                {{ isset($articles) ? 'Modifier' : 'Ajouter' }} un Article
                            </h3>
                            <p class="mb-0 small opacity-75">Veuillez remplir tous les champs pour
                                {{ isset($articles) ? 'mettre à jour' : 'créer' }} l'article du contrat de bail.</p>
                        </div>
                        @if (session('success'))
                            <div
                                class="alert alert-success text-center mb-0 ms-md-4 mt-3 mt-md-0 px-4 py-2 rounded-pill shadow-sm animate__animated animate__fadeInRight">
                                <span class="fw-semibold"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                                </span>
                            </div>
                        @endif
                        @if (session('error'))
                            <div
                                class="alert alert-danger text-center mb-0 ms-md-4 mt-3 mt-md-0 px-4 py-2 rounded-pill shadow-sm animate__animated animate__fadeInRight">
                                <span class="fw-semibold"><i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-4 p-md-5 bg-light rounded-bottom-4">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4 animate__animated animate__fadeInDown">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ isset($articles) ? route('article.update', $articles->id) : route('article.store') }}"
                            method="POST" class="needs-validation">
                            @csrf
                            @if (isset($articles))
                                @method('PUT')
                            @endif
                            <div class="row g-4">
                                <div class="col-12 animate__animated animate__fadeInUp" style="animation-delay:0.1s;">
                                    <label for="titre_article" class="form-label fw-semibold">
                                        <i class="fa-solid fa-heading me-2 text-primary animate__animated animate__fadeInLeft"></i>Titre
                                        de l'Article
                                    </label>
                                    <input type="text" name="titre_article" id="titre_article"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        placeholder="Ex : Conformité des lieux loués" required
                                        value="{{ old('titre_article', isset($articles) ? $articles->titre_article : '') }}">
                                </div>
                                <div class="col-12 animate__animated animate__fadeInUp" style="animation-delay:0.2s;">
                                    <label for="contenu_article" class="form-label fw-semibold">
                                        <i class="fa-solid fa-align-left me-2 text-success animate__animated animate__fadeInLeft"></i>Contenu
                                        de l'Article
                                    </label>
                                    <textarea name="contenu_article" id="contenu_article" rows="4"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        placeholder="Décrivez ici le contenu de l’article en détails..." required>{{ old('contenu_article', isset($articles) ? $articles->contenu_article : '') }}</textarea>
                                </div>
                                @php
                                    $isUsedInContracts = isset($articles)
                                        ? DB::table('contrat_de_bail_article')->where('article_source_id', $articles->id)->exists()
                                        : false;
                                @endphp
                                @if ($isUsedInContracts)
                                    <div class="col-12 animate__animated animate__fadeInUp" style="animation-delay:0.3s;">
                                        <div class="alert alert-warning text-center rounded-3 fw-semibold">
                                            <i class="fa-solid fa-lock me-2"></i>⚠️ Cet article est utilisé dans un ou plusieurs
                                            contrats. Il ne peut pas être modifié.
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-5 text-center animate__animated animate__fadeInUp" style="animation-delay:0.4s;">
                                <button type="submit"
                                    class="btn btn-success btn-lg px-5 py-2 rounded-pill shadow"
                                    style="background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%); border: none; font-weight: 600; letter-spacing: 1px;"
                                    {{ $isUsedInContracts ? 'disabled' : '' }}>
                                    <i class="fa-solid {{ isset($articles) ? 'fa-pen-to-square' : 'fa-plus' }} me-2"></i>
                                    {{ isset($articles) ? 'Mettre à jour l’article' : 'Créer l’article' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .form-label {
            color: #185a9d;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #43cea2;
            box-shadow: 0 0 0 0.2rem rgba(67, 206, 162, 0.15);
            transition: box-shadow 0.3s;
        }

        .card {
            border-radius: 1.5rem;
            transition: box-shadow 0.4s cubic-bezier(.4, 2, .6, 1);
        }

        .card:hover {
            box-shadow: 0 8px 32px 0 rgba(24, 90, 157, 0.18);
        }

        .btn-lg {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-lg:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 16px 0 rgba(67, 206, 162, 0.18);
        }

        @media (max-width: 767.98px) {
            .card-header,
            .card-body {
                padding: 1.5rem !important;
            }

            .btn-lg {
                font-size: 1rem;
                padding: 0.75rem 2rem;
            }
        }
    </style>
@endsection
