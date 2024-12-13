@extends('layouts.master_dash')
@section('title', 'Modifier vos informations')
@section('content')

<div class="container-xxl mt-5">
    <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Modifier vos informations</h4>
                </div>
                <div class="card-body">
                <form method="post" action="{{ route('locataire.update', $locataire->id) }}" enctype="multipart/form-data">
                @csrf
                        @method('patch')

                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="nom">Nom</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="nom" name="nom" type="text" value="{{ old('nom', $locataire->nom) }}" placeholder="Nom">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="prenom">Prénom</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="prenom" name="prenom" type="text" value="{{ old('prenom', $locataire->prenom) }}" placeholder="Prénom">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="adresse">Adresse</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="adresse" name="adresse" type="text" value="{{ old('adresse', $locataire->adresse) }}" placeholder="Adresse">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="telephone">Téléphone</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="telephone" name="telephone" type="text" value="{{ old('telephone', $locataire->telephone) }}" placeholder="Téléphone">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="date_naissance">Date de naissance</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="date_naissance" name="date_naissance" type="date" value="{{ old('date_naissance', $locataire->date_naissance) }}">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="genre">Genre</label>
                            <div class="col-lg-9 col-xl-8">
                                <select class="form-select" id="genre" name="genre">
                                    <option value="Homme" {{ old('genre', $locataire->genre) == 'Homme' ? 'selected' : '' }}>Homme</option>
                                    <option value="Femme" {{ old('genre', $locataire->genre) == 'Femme' ? 'selected' : '' }}>Femme</option>
                                    <option value="Autre" {{ old('genre', $locataire->genre) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nouveau champ : Revenu Mensuel -->
                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="revenu_mensuel">Revenu Mensuel</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="revenu_mensuel" name="revenu_mensuel" type="number" value="{{ old('revenu_mensuel', $locataire->revenu_mensuel) }}" placeholder="Revenu Mensuel">
                            </div>
                        </div>

                        <!-- Nouveau champ : Nombre de personnes dans le foyer -->
                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="nombre_personne_foyer">Nombre de personnes dans le foyer</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="nombre_personne_foyer" name="nombre_personne_foyer" type="number" value="{{ old('nombre_personne_foyer', $locataire->nombre_personne_foyer) }}" placeholder="Nombre de personnes">
                            </div>
                        </div>

                        <!-- Nouveau champ : Statut matrimonial -->
                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="statut_matrimoniale">Statut matrimonial</label>
                            <div class="col-lg-9 col-xl-8">
                                <select class="form-select" id="statut_matrimoniale" name="statut_matrimoniale">
                                    <option value="Célibataire" {{ old('statut_matrimoniale', $locataire->statut_matrimoniale) == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                                    <option value="Marié" {{ old('statut_matrimoniale', $locataire->statut_matrimoniale) == 'Marié' ? 'selected' : '' }}>Marié</option>
                                    <option value="Divorcé" {{ old('statut_matrimoniale', $locataire->statut_matrimoniale) == 'Divorcé' ? 'selected' : '' }}>Divorcé</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nouveau champ : Statut professionnel -->
                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="statut_professionnel">Statut professionnel</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="statut_professionnel" name="statut_professionnel" type="text" value="{{ old('statut_professionnel', $locataire->statut_professionnel) }}" placeholder="Statut professionnel">
                            </div>
                        </div>

                        <!-- Nouveau champ : Garant -->
                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="garant">Garant</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="garant" name="garant" type="text" value="{{ old('garant', $locataire->garant) }}" placeholder="Garant">
                            </div>
                        </div>

                        <!-- Nouveau champ : Photo de profil -->
                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end form-label" for="photo_profil">Photo de profil</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="photo_profil" name="photo_profil" type="file">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-9 col-xl-8 offset-lg-3">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        
    </div>
</div>

@endsection
