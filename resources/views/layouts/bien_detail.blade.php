@extends('layouts.master_dash')
@section('title', 'Détail du bien')
@section('content')
    <div class="container-fluid">
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


        <!-- Row principal -->
        <div class="row clearfix">
            <!-- Colonne principale (carousel et informations) -->
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Carousel Section -->
                        <div id="bienCarousel" class="carousel slide mb-2 shadow" data-bs-ride="carousel"
                            style="border-radius: 5px;">
                            <div class="carousel-inner">
                                <div class="carousel-item active position-relative">
                                    <img src="{{ asset($bien->photo_bien) }}" class="d-block w-100"
                                        alt="Photo principale de {{ $bien->name_bien }}"
                                        style="max-height: 500px; object-fit: cover; border-radius: 10px;">
                                    <div class="carousel-caption d-none d-md-block bg-opacity-50 p-2 rounded">
                                        <h3 class="text-white">{{ $bien->name_bien }}</h3>
                                    </div>
                                </div>
                                @if ($bien->photo2_bien)
                                    <div class="carousel-item position-relative">
                                        <img src="{{ asset($bien->photo2_bien) }}" class="d-block w-100"
                                            alt="Photo secondaire de {{ $bien->name_bien }}"
                                            style="max-height: 500px; object-fit: cover; border-radius: 10px;">
                                    </div>
                                @endif
                                @if ($bien->photo3_bien)
                                    <div class="carousel-item position-relative">
                                        <img src="{{ asset($bien->photo3_bien) }}" class="d-block w-100"
                                            alt="Troisième photo de {{ $bien->name_bien }}"
                                            style="max-height: 500px; object-fit: cover; border-radius: 10px;">
                                    </div>
                                @endif
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#bienCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Précédent</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#bienCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Suivant</span>
                            </button>
                        </div>

                        <!-- Bien Details -->
                        <p class="text-success"><strong>{{ number_format($bien->loyer_mensuel, 0, ',', ' ') }} FCFA</strong>
                        </p>

                        <!-- Adresse -->
                        @if ($bien->adresse_bien)
                            <p class="text-dark" style="font-size: 1.1rem; margin-top: 10px;">{{ $bien->adresse_bien }}</p>
                        @endif

                        @if ($bien->description)
                            <p class="text-muted">{{ $bien->description }}</p>
                        @endif


                        <!-- Actions -->
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="{{ route('biens.edit', $bien->id) }}" class="btn btn-link text-primary"
                                title="Modifier">
                                <i class="bi bi-pencil-square" style="font-size: 1.5rem;"></i>
                            </a>
                            <form action="{{ route('biens.destroy', $bien->id) }}" method="POST"
                                onsubmit="return confirm('Voulez-vous vraiment supprimer ce bien ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger" title="Supprimer">
                                    <i class="bi bi-trash" style="font-size: 1.5rem;"></i>
                                </button>
                            </form>

                            {{-- <a href="{{route('assign.locataire', $bien->id)}}" class="btn btn-link text-success" title="Assigner à un locataire">
                                <i class="bi bi-person-plus" style="font-size: 1.5rem;"></i>
                            </a> --}}
                            <!-- Bouton dynamique -->
                            @if ($locataireAssigné)
                                <!-- Si un locataire est déjà assigné -->
                                <form action="{{ route('unassign.locataire', $bien->id) }}" method="POST"
                                    onsubmit="return confirm('Voulez-vous vraiment désassigner ce locataire ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-warning"
                                        title="Désassigner le locataire">
                                        <i class="bi bi-person-dash" style="font-size: 1.5rem;"></i>
                                    </button>
                                </form>
                            @else
                                <!-- Si aucun locataire n'est assigné -->
                                <a href="{{ route('assign.locataire', $bien->id) }}" class="btn btn-link text-success"
                                    title="Assigner à un locataire">
                                    <i class="bi bi-person-plus" style="font-size: 1.5rem;"></i>
                                </a>
                            @endif

                        </div>


                    </div>
                </div>
            </div>

            <!-- Colonne secondaire -->
            <div class="col-lg-4 col-md-12">
                {{-- <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-muted">Informations supplémentaires</h4>
                        <p class="text-muted">Cette section peut être utilisée pour ajouter des informations
                            complémentaires, comme les caractéristiques du bien, les coordonnées de l'agent immobilier, ou
                            d'autres détails.</p>
                    </div>
                </div> --}}
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if ($locataireAssigné)
                            <div class="text-center">
                                <img src="{{ asset($locataireAssigné->locataire->photo_profil) }}"
                                    alt="Photo de {{ $locataireAssigné->locataire->nom }}" class="rounded-circle mb-3"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                                <h5 class="text-primary">{{ $locataireAssigné->locataire->nom }} {{ $locataireAssigné->locataire->prenom }}</h5>
                            </div>
                            <table class="table table-borderless ">
                                <tbody>

                                    <tr>
                                        <th class="fw-bold text-muted">Email :</th>
                                        <td>{{ $locataireAssigné->locataire->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bold text-muted">Statut :</th>
                                        <td><span class="badge bg-success">Locataire Assigné</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <div class="text-center">
                                <h5 class="text-danger">Aucun locataire assigné</h5>
                                <p class="text-muted">Assignez un locataire pour voir ses informations ici.</p>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="card shadow-sm">
                    <div class="card-header ">
                        <h5 class="card-title text-muted">Informations du Bien</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="fw-bold">Loyer :</th>
                                    <td>{{ number_format($bien->loyer_mensuel, 0, ',', ' ') }} FCFA</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Statut :</th>
                                    <td><span class="badge bg-success">{{ $bien->statut_bien }}</span></td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Pièces :</th>
                                    <td>{{ $bien->nombre_de_piece }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Chambres :</th>
                                    <td>{{ $bien->nbr_chambres }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Salles de Bain :</th>
                                    <td>{{ $bien->nbr_salles_de_bain }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Superficie :</th>
                                    <td>{{ $bien->superficie }} m²</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Type de Bien :</th>
                                    <td>{{ $bien->type_bien }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Adresse :</th>
                                    <td>{{ $bien->adresse_bien }}</td>
                                </tr>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Ajout de CSS pour l'effet de survol -->
<!-- Ajout de CSS personnalisé pour le style -->
<style>
    .container-fluid {
        font-family: 'Montserrat', sans-serif;
    }

    .btn-link:hover {
        opacity: 1 !important;
    }

    .card-title {
        font-family: 'Roboto', sans-serif;
        font-size: 1.25rem;
        font-weight: bold;
    }

    table th {
        width: 50%;
        background-color: #f8f9fa;
        font-weight: 500;
        font-size: 0.95rem;
    }

    table td {
        font-size: 0.95rem;
    }

    .card-body img {
        border: 1px solid #ddd;
        /* Optionnel : ajoute un contour léger */
    }
</style>
