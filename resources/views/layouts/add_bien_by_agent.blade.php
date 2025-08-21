@extends('layouts.master_dash')
@section('title', isset($bien) ? 'Modifier un Bien' : 'Enregistrer un Bien')
@section('content')
    <div class="card container-xxl py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header py-4 d-flex flex-column flex-md-row align-items-center justify-content-between"
                        style="background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%); color: #fff; border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem;">
                        <div>
                            <h3 class="mb-0 fw-bold">{{ isset($bien) ? 'Modifier' : 'Ajouter' }} un Bien</h3>
                            <p class="mb-0 small opacity-75">Veuillez remplir tous les champs pour
                                {{ isset($bien) ? 'mettre à jour' : 'enregistrer' }} le bien immobilier.</p>
                        </div>
                        @if (session('success'))
                            <div
                                class="alert alert-success text-center mb-0 ms-md-4 mt-3 mt-md-0 px-4 py-2 rounded-pill shadow-sm">
                                <span class="fw-semibold">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if (session('error'))
                            <div
                                class="alert alert-danger text-center mb-0 ms-md-4 mt-3 mt-md-0 px-4 py-2 rounded-pill shadow-sm">
                                <span class="fw-semibold">{{ session('error') }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-4 p-md-5 bg-light rounded-bottom-4">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST"
                            action="{{ isset($bien) ? route('biens.update', $bien->id) : route('biens.store') }}"
                            enctype="multipart/form-data" class="needs-validation">
                            @csrf
                            @if (isset($bien))
                                @method('PATCH')
                            @endif
                            <div class="row g-4">
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:0.1s;">
                                    <label for="name_bien" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-home me-2 text-primary animate__animated animate__fadeInLeft"></i>Nom
                                        du Bien
                                    </label>
                                    <input type="text" name="name_bien"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="name_bien" placeholder="Nom du bien" required
                                        value="{{ old('name_bien', $bien->name_bien ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:0.2s;">
                                    <label for="statut_bien" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-clipboard-check me-2 text-success animate__animated animate__fadeInLeft"></i>Statut
                                        du Bien
                                    </label>
                                    <select name="statut_bien" id="statut_bien"
                                        class="form-select form-select-lg rounded-3 animate__animated animate__fadeIn"
                                        required>
                                        <option value="Disponible"
                                            {{ old('statut_bien', $bien->statut_bien ?? '') == 'Disponible' ? 'selected' : '' }}>
                                            Disponible</option>
                                        <option value="Loué"
                                            {{ old('statut_bien', $bien->statut_bien ?? '') == 'Loué' ? 'selected' : '' }}>
                                            Loué</option>
                                        <option value="Vendu"
                                            {{ old('statut_bien', $bien->statut_bien ?? '') == 'Vendu' ? 'selected' : '' }}>
                                            Vendu</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:0.3s;">
                                    <label for="name_proprietaire" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-user-tie me-2 text-info animate__animated animate__fadeInLeft"></i>Nom
                                        du Propriétaire
                                    </label>
                                    <input type="text" name="name_proprietaire"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="name_proprietaire" placeholder="Nom et prénom du propriétaire" required
                                        value="{{ old('name_proprietaire', $bien->name_proprietaire ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:0.4s;">
                                    <label for="proprietaire_numéro" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-phone-alt me-2 text-warning animate__animated animate__fadeInLeft"></i>Numéro
                                        du Propriétaire
                                    </label>
                                    <input type="number" name="proprietaire_numéro"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="proprietaire_numéro" placeholder="Numéro de téléphone du propriétaire" required
                                        value="{{ old('proprietaire_numéro', $bien->proprietaire_numéro ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:0.5s;">
                                    <label for="nombre_de_piece" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-door-open me-2 text-secondary animate__animated animate__fadeInLeft"></i>Nombre
                                        Maximum de Pièces
                                    </label>
                                    <input type="number" name="nombre_de_piece"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="nombre_de_piece" placeholder="Nombre de pièces" required
                                        value="{{ old('nombre_de_piece', $bien->nombre_de_piece ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:0.6s;">
                                    <label for="nombre_de_salon" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-couch me-2 text-danger animate__animated animate__fadeInLeft"></i>Nombre
                                        Maximum de Salons
                                    </label>
                                    <input type="number" name="nombre_de_salon"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="nombre_de_salon" placeholder="Nombre de salons" required
                                        value="{{ old('nombre_de_salon', $bien->nombre_de_salon ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:0.7s;">
                                    <label for="nombre_de_cuisine" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-utensils me-2 text-success animate__animated animate__fadeInLeft"></i>Nombre
                                        Maximum de Cuisines
                                    </label>
                                    <input type="number" name="nombre_de_cuisine"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="nombre_de_cuisine" placeholder="Nombre de cuisines" required
                                        value="{{ old('nombre_de_cuisine', $bien->nombre_de_cuisine ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:0.8s;">
                                    <label for="nbr_chambres" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-bed me-2 text-primary animate__animated animate__fadeInLeft"></i>Nombre
                                        de Chambres
                                    </label>
                                    <input type="number" name="nbr_chambres"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="nbr_chambres" placeholder="Nombre de chambres"
                                        value="{{ old('nbr_chambres', $bien->nbr_chambres ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:0.9s;">
                                    <label for="nbr_salles_de_bain" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-bath me-2 text-info animate__animated animate__fadeInLeft"></i>Nombre
                                        de Salles de Bain
                                    </label>
                                    <input type="number" name="nbr_salles_de_bain"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="nbr_salles_de_bain" placeholder="Nombre de salles de bain"
                                        value="{{ old('nbr_salles_de_bain', $bien->nbr_salles_de_bain ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:1.0s;">
                                    <label for="superficie" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-ruler-combined me-2 text-secondary animate__animated animate__fadeInLeft"></i>Superficie
                                        (m²)
                                    </label>
                                    <input type="number" name="superficie"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="superficie" placeholder="Superficie en m²" required
                                        value="{{ old('superficie', $bien->superficie ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:1.1s;">
                                    <label for="loyer_mensuel" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-money-bill-wave me-2 text-success animate__animated animate__fadeInLeft"></i>Prix
                                        (Loyer Mensuel)
                                    </label>
                                    <input type="number" name="loyer_mensuel"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="loyer_mensuel" placeholder="Prix en FCFA" required
                                        value="{{ old('loyer_mensuel', $bien->loyer_mensuel ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                                    style="animation-delay:1.2s;">
                                    <label for="type_bien" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-building me-2 text-primary animate__animated animate__fadeInLeft"></i>Type
                                        de Bien
                                    </label>
                                    <input type="text" name="type_bien"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="type_bien" placeholder="Type du bien"
                                        value="{{ old('type_bien', $bien->type_bien ?? '') }}">
                                </div>
                                <div class="col-12 animate__animated animate__fadeInUp" style="animation-delay:1.3s;">
                                    <label for="description" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-align-left me-2 text-secondary animate__animated animate__fadeInLeft"></i>Description
                                    </label>
                                    <textarea name="description" id="description"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn" rows="3"
                                        placeholder="Entrez une description du bien">{{ old('description', $bien->description ?? '') }}</textarea>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 animate__animated animate__fadeInUp"
                                    style="animation-delay:1.4s;">
                                    <label for="adresse_bien" class="form-label fw-semibold">
                                        <i
                                            class="fas fa-map-marker-alt me-2 text-danger animate__animated animate__fadeInLeft"></i>Adresse
                                    </label>
                                    <input type="text" name="adresse_bien"
                                        class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                        id="adresse_bien" placeholder="Adresse complète" required
                                        value="{{ old('adresse_bien', $bien->adresse_bien ?? '') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-6 animate__animated animate__fadeInUp"
                                    style="animation-delay:1.5s;">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <label for="photo_bien" class="form-label fw-semibold">Photo N°1</label>
                                            <input type="file" name="photo_bien"
                                                class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                                id="photo_bien" {{ isset($bien) ? '' : 'required' }}>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="photo2_bien" class="form-label fw-semibold">Photo N°2</label>
                                            <input type="file" name="photo2_bien"
                                                class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                                id="photo2_bien" {{ isset($bien) ? '' : 'required' }}>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="photo3_bien" class="form-label fw-semibold">Photo N°3</label>
                                            <input type="file" name="photo3_bien"
                                                class="form-control form-control-lg rounded-3 animate__animated animate__fadeIn"
                                                id="photo3_bien" {{ isset($bien) ? '' : 'required' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 text-center animate__animated animate__fadeInUp"
                                style="animation-delay:1.6s;">
                                <button type="submit" class="btn btn-success btn-lg px-5 py-2 rounded-pill shadow"
                                    style="background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%); border: none; font-weight: 600; letter-spacing: 1px;">
                                    {{ isset($bien) ? 'Mettre à jour le Bien' : 'Soumettre le Bien' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

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
