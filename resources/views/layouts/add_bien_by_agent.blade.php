@extends('layouts.master_dash')
@section('title', isset($bien) ? 'Modifier un Bien' : 'Enregistrer un Bien')
@section('content')
    <div class="container-xxl py-5" style="background-color: #F5F5F5;">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header" style="background-color: #4CAF50; color: #FFFFFF;">
                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                <h5 class="text-success">{{ session('success') }}</h5>
                            </div>
                        @endif
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title mb-0">{{ isset($bien) ? 'Modifier' : 'Ajouter' }} un Bien</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ isset($bien) ? route('biens.update', $bien->id) : route('biens.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if (isset($bien))
                                @method('PATCH')
                            @endif
                            <div class="row g-4">
                                <!-- Nom du Bien -->
                                <div class="col-md-6">
                                    <label for="name_bien" class="form-label fw-bold">Nom du Bien</label>
                                    <input type="text" name="name_bien" class="form-control" id="name_bien" placeholder="Nom du bien" required value="{{ old('name_bien', $bien->name_bien ?? '') }}">
                                </div>

                                <!-- Statut du Bien -->
                                <div class="col-md-6">
                                    <label for="statut_bien" class="form-label fw-bold">Statut du Bien</label>
                                    <select name="statut_bien" id="statut_bien" class="form-select" required>
                                        <option value="Disponible" {{ old('statut_bien', $bien->statut_bien ?? '') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                        <option value="Loué" {{ old('statut_bien', $bien->statut_bien ?? '') == 'Loué' ? 'selected' : '' }}>Loué</option>
                                        <option value="Vendu" {{ old('statut_bien', $bien->statut_bien ?? '') == 'Vendu' ? 'selected' : '' }}>Vendu</option>
                                    </select>
                                </div>

                                <!-- Nom du Propriétaire -->
                                <div class="col-md-6">
                                    <label for="name_proprietaire" class="form-label fw-bold">Nom du Propriétaire</label>
                                    <input type="text" name="name_proprietaire" class="form-control" id="name_proprietaire" placeholder="Nom et prénom du propriétaire" required value="{{ old('name_proprietaire', $bien->name_proprietaire ?? '') }}">
                                </div>

                                <!-- Numéro du Propriétaire -->
                                <div class="col-md-6">
                                    <label for="proprietaire_numéro" class="form-label fw-bold">Numéro du Propriétaire</label>
                                    <input type="number" name="proprietaire_numéro" class="form-control" id="proprietaire_numéro" placeholder="Numéro de téléphone du propriétaire" required value="{{ old('proprietaire_numéro', $bien->proprietaire_numéro ?? '') }}">
                                </div>

                                <!-- Nombre de Pièces -->
                                <div class="col-md-6">
                                    <label for="nombre_de_piece" class="form-label fw-bold">Nombre Maximum de Pièces</label>
                                    <input type="number" name="nombre_de_piece" class="form-control" id="nombre_de_piece" placeholder="Nombre de pièces" required value="{{ old('nombre_de_piece', $bien->nombre_de_piece ?? '') }}">
                                </div>

                                <!-- Nombre de Salons -->
                                <div class="col-md-6">
                                    <label for="nombre_de_salon" class="form-label fw-bold">Nombre Maximum de Salons</label>
                                    <input type="number" name="nombre_de_salon" class="form-control" id="nombre_de_salon" placeholder="Nombre de salons" required value="{{ old('nombre_de_salon', $bien->nombre_de_salon ?? '') }}">
                                </div>

                                <!-- Nombre de Cuisines -->
                                <div class="col-md-6">
                                    <label for="nombre_de_cuisine" class="form-label fw-bold">Nombre Maximum de Cuisines</label>
                                    <input type="number" name="nombre_de_cuisine" class="form-control" id="nombre_de_cuisine" placeholder="Nombre de cuisines" required value="{{ old('nombre_de_cuisine', $bien->nombre_de_cuisine ?? '') }}">
                                </div>

                                <!-- Chambres -->
                                <div class="col-md-6">
                                    <label for="nbr_chambres" class="form-label fw-bold">Nombre de Chambres</label>
                                    <input type="number" name="nbr_chambres" class="form-control" id="nbr_chambres" placeholder="Nombre de chambres" value="{{ old('nbr_chambres', $bien->nbr_chambres ?? '') }}">
                                </div>

                                <!-- Salles de Bain -->
                                <div class="col-md-6">
                                    <label for="nbr_salles_de_bain" class="form-label fw-bold">Nombre de Salles de Bain</label>
                                    <input type="number" name="nbr_salles_de_bain" class="form-control" id="nbr_salles_de_bain" placeholder="Nombre de salles de bain" value="{{ old('nbr_salles_de_bain', $bien->nbr_salles_de_bain ?? '') }}">
                                </div>

                                <!-- Superficie -->
                                <div class="col-md-6">
                                    <label for="superficie" class="form-label fw-bold">Superficie (m²)</label>
                                    <input type="number" name="superficie" class="form-control" id="superficie" placeholder="Superficie en m²" required value="{{ old('superficie', $bien->superficie ?? '') }}">
                                </div>

                                <!-- Prix -->
                                <div class="col-md-6">
                                    <label for="loyer_mensuel" class="form-label fw-bold">Prix (Loyer Mensuel)</label>
                                    <input type="number" name="loyer_mensuel" class="form-control" id="loyer_mensuel" placeholder="Prix en FCFA" required value="{{ old('loyer_mensuel', $bien->loyer_mensuel ?? '') }}">
                                </div>

                                <!-- Type de Bien -->
                                <div class="col-md-6">
                                    <label for="type_bien" class="form-label fw-bold">Type de Bien</label>
                                    <input type="text" name="type_bien" class="form-control" id="type_bien" placeholder="Type du bien" value="{{ old('type_bien', $bien->type_bien ?? '') }}">
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Entrez une description du bien">{{ old('description', $bien->description ?? '') }}</textarea>
                                </div>

                                <!-- Adresse -->
                                <div class="col-md-6">
                                    <label for="adresse_bien" class="form-label fw-bold">Adresse</label>
                                    <input type="text" name="adresse_bien" class="form-control" id="adresse_bien" placeholder="Adresse complète" required value="{{ old('adresse_bien', $bien->adresse_bien ?? '') }}">
                                </div>

                                <!-- Photos -->
                                <div class="col-md-6">
                                    <label for="photo_bien" class="form-label fw-bold">Photo N°1 du Bien</label>
                                    <input type="file" name="photo_bien" class="form-control" id="photo_bien" {{ isset($bien) ? '' : 'required' }}>
                                </div>
                                <div class="col-md-6">
                                    <label for="photo2_bien" class="form-label fw-bold">Photo N°2 du Bien</label>
                                    <input type="file" name="photo2_bien" class="form-control" id="photo2_bien" {{ isset($bien) ? '' : 'required' }}>
                                </div>
                                <div class="col-md-6">
                                    <label for="photo3_bien" class="form-label fw-bold">Photo N°3 du Bien</label>
                                    <input type="file" name="photo3_bien" class="form-control" id="photo3_bien" {{ isset($bien) ? '' : 'required' }}>
                                </div>
                            </div>

                            <!-- Bouton de soumission -->
                            <div class="mt-4 text-center">
                                <button type="submit" class="btn btn-success px-5 py-2" style="background-color: #4CAF50; border-color: #4CAF50;">
                                    {{ isset($bien) ? 'Mettre à jour le Bien' : 'Soumettre le Bien' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
