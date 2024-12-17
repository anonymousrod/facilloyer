@extends('layouts.master_dash')
@section('title', 'Modifier vos informations')
@section('content')

    <div class="container-xxl mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="card-title">Modifier vos informations</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('locataire.update', $locataire->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <!-- Nom -->
                            <div class="form-group mb-3">
                                <label for="nom">Nom <span class="text-danger">*</span></label>
                                <input type="text" id="nom" name="nom" class="form-control"
                                    value="{{ old('nom', $locataire->nom) }}" placeholder="Entrez votre nom" required>
                            </div>

                            <!-- Prénom -->
                            <div class="form-group mb-3">
                                <label for="prenom">Prénom <span class="text-danger">*</span></label>
                                <input type="text" id="prenom" name="prenom" class="form-control"
                                    value="{{ old('prenom', $locataire->prenom) }}" placeholder="Entrez votre prénom"
                                    required>
                            </div>

                            <!-- Adresse -->
                            <div class="form-group mb-3">
                                <label for="adresse">Adresse <span class="text-danger">*</span></label>
                                <textarea id="adresse" name="adresse" class="form-control" rows="2" placeholder="Entrez votre adresse" required>{{ old('adresse', $locataire->adresse) }}</textarea>
                            </div>

                            <!-- Téléphone -->
                            <div class="form-group mb-3">
                                <label for="telephone">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" id="telephone" name="telephone" class="form-control"
                                    value="{{ old('telephone', $locataire->telephone) }}"
                                    placeholder="Entrez votre numéro de téléphone" required>
                            </div>

                            <!-- Date de naissance -->
                            <div class="form-group mb-3">
                                <label for="date_naissance">Date de naissance <span class="text-danger">*</span></label>
                                <input type="date" id="date_naissance" name="date_naissance" class="form-control"
                                    value="{{ old('date_naissance', \Carbon\Carbon::parse($locataire->date_naissance)->format('Y-m-d')) }}"
                                    required>

                            </div>

                            <!-- Genre -->
                            <div class="form-group mb-3">
                                <label for="genre">Genre <span class="text-danger">*</span></label>
                                <select id="genre" name="genre" class="form-control" required>
                                    <option value="" disabled {{ old('genre', $locataire->genre) ? '' : 'selected' }}>
                                        Sélectionnez votre genre</option>
                                    <option value="Masculin"
                                        {{ old('genre', $locataire->genre) == 'Masculin' ? 'selected' : '' }}>Masculin
                                    </option>
                                    <option value="Féminin"
                                        {{ old('genre', $locataire->genre) == 'Féminin' ? 'selected' : '' }}>Féminin
                                    </option>
                                </select>
                            </div>

                            <!-- Revenu mensuel -->
                            <div class="form-group mb-3">
                                <label for="revenu_mensuel">Revenu mensuel (€) <span class="text-danger">*</span></label>
                                <input type="number" id="revenu_mensuel" name="revenu_mensuel" class="form-control"
                                    value="{{ old('revenu_mensuel', $locataire->revenu_mensuel) }}"
                                    placeholder="Entrez votre revenu mensuel" required>
                            </div>

                            <!-- Nombre de personnes au foyer -->
                            <div class="form-group mb-3">
                                <label for="nombre_personne_foyer">Nombre de personnes au foyer <span
                                        class="text-danger">*</span></label>
                                <input type="number" id="nombre_personne_foyer" name="nombre_personne_foyer"
                                    class="form-control"
                                    value="{{ old('nombre_personne_foyer', $locataire->nombre_personne_foyer) }}"
                                    placeholder="Entrez le nombre de personnes au foyer" required>
                            </div>

                            <!-- Statut matrimonial -->
                            <div class="form-group mb-3">
                                <label for="statut_matrimoniale">Statut matrimonial <span
                                        class="text-danger">*</span></label>
                                <select id="statut_matrimoniale" name="statut_matrimoniale" class="form-control" required>
                                    <option value="" disabled
                                        {{ old('statut_matrimoniale', $locataire->statut_matrimoniale) ? '' : 'selected' }}>
                                        Sélectionnez votre statut matrimonial</option>
                                    <option value="Célibataire"
                                        {{ old('statut_matrimoniale', $locataire->statut_matrimoniale) == 'Célibataire' ? 'selected' : '' }}>
                                        Célibataire</option>
                                    <option value="Marié(e)"
                                        {{ old('statut_matrimoniale', $locataire->statut_matrimoniale) == 'Marié(e)' ? 'selected' : '' }}>
                                        Marié(e)</option>
                                    <option value="Divorcé(e)"
                                        {{ old('statut_matrimoniale', $locataire->statut_matrimoniale) == 'Divorcé(e)' ? 'selected' : '' }}>
                                        Divorcé(e)</option>
                                    <option value="Veuf(ve)"
                                        {{ old('statut_matrimoniale', $locataire->statut_matrimoniale) == 'Veuf(ve)' ? 'selected' : '' }}>
                                        Veuf(ve)</option>
                                </select>
                            </div>

                            <!-- Statut professionnel -->
                            <div class="form-group mb-3">
                                <label for="statut_professionnel">Statut professionnel <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="statut_professionnel" name="statut_professionnel"
                                    class="form-control"
                                    value="{{ old('statut_professionnel', $locataire->statut_professionnel) }}"
                                    placeholder="Entrez votre statut professionnel" required>
                            </div>

                            <!-- Garant -->
                            <div class="form-group mb-3">
                                <label for="garant">Garant</label>
                                <input type="text" id="garant" name="garant" class="form-control"
                                    value="{{ old('garant', $locataire->garant) }}"
                                    placeholder="Entrez les informations du garant">
                            </div>

                            <!-- Photo de profil -->
                            <div class="form-group mb-3">
                                <label for="photo_profil">Photo de profil</label>
                                <input type="file" id="photo_profil" name="photo_profil" class="form-control">
                            </div>

                            <!-- Boutons -->
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-primary px-5">Enregistrer</button>
                                <a href="{{ route('profile.edit') }}" class="btn btn-secondary px-4">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
