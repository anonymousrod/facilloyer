@extends('layouts.master_dash')
@section('title', 'Détail du bien')
@section('content')
<div class="container-fluid">
    <!-- Row principal -->
    <div class="row clearfix">
        <!-- Colonne principale (carousel et informations) -->
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Carousel Section -->
                    <div id="bienCarousel" class="carousel slide mb-2 shadow" data-bs-ride="carousel" style="border-radius: 5px;">
                        <div class="carousel-inner">
                            <div class="carousel-item active position-relative">
                                <img src="{{ asset($bien->photo_bien) }}" class="d-block w-100" alt="Photo principale de {{ $bien->name_bien }}" style="max-height: 500px; object-fit: cover; border-radius: 10px;">
                                <div class="carousel-caption d-none d-md-block bg-opacity-50 p-2 rounded">
                                    <h3 class="text-white">{{ $bien->name_bien }}</h3>
                                </div>
                            </div>
                            @if ($bien->photo2_bien)
                                <div class="carousel-item position-relative">
                                    <img src="{{ asset($bien->photo2_bien) }}" class="d-block w-100" alt="Photo secondaire de {{ $bien->name_bien }}" style="max-height: 500px; object-fit: cover; border-radius: 10px;">
                                </div>
                            @endif
                            @if ($bien->photo3_bien)
                                <div class="carousel-item position-relative">
                                    <img src="{{ asset($bien->photo3_bien) }}" class="d-block w-100" alt="Troisième photo de {{ $bien->name_bien }}" style="max-height: 500px; object-fit: cover; border-radius: 10px;">
                                </div>
                            @endif
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#bienCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#bienCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                    </div>

                    <!-- Bien Details -->
                    <p class="text-success"><strong>{{ number_format($bien->loyer_mensuel, 0, ',', ' ') }} FCFA</strong></p>

                    <!-- Adresse -->
                    @if ($bien->adresse_bien)
                        <p class="text-dark" style="font-size: 1.1rem; margin-top: 10px;">{{ $bien->adresse_bien }}</p>
                    @endif

                    @if ($bien->description)
                        <p class="text-muted">{{ $bien->description }}</p>
                    @endif


                    <!-- Actions -->
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <a href="{{ route('biens.edit', $bien->id)}}" class="btn btn-link text-primary" title="Modifier">
                            <i class="bi bi-pencil-square" style="font-size: 1.5rem;"></i>
                        </a>
                        <form action="" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce bien ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger" title="Supprimer">
                                <i class="bi bi-trash" style="font-size: 1.5rem;"></i>
                            </button>
                        </form>
                        <a href="" class="btn btn-link text-success" title="Assigner à un locataire">
                            <i class="bi bi-person-plus" style="font-size: 1.5rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne secondaire -->
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-muted">Informations supplémentaires</h4>
                    <p class="text-muted">Cette section peut être utilisée pour ajouter des informations complémentaires, comme les caractéristiques du bien, les coordonnées de l'agent immobilier, ou d'autres détails.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Ajout de CSS pour l'effet de survol -->
<style>
    .btn-link:hover {
        opacity: 1 !important;
    }
</style>
