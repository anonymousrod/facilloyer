@extends('layouts.master_dash')
@section('title', 'Gestion Agent Immobilier')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                <h5 class="text-success"> {{ session('success') }}</h5>
                            </div>
                        @endif
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">
                                    {{ isset($agentImmobilier) ? "Modification des information de l'argence " : "Information de l'agence immobiliere" }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form
                            action="{{ isset($agentImmobilier) ? route('agent_immobilier.update', $agentImmobilier->id) : route('agent_immobilier.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($agentImmobilier))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <!-- Partie gauche -->
                                <div class="col-lg-6">
                                    <!-- Nom de l'agence -->
                                    <div class="mb-3 row">
                                        <label for="nom_agence" class="col-sm-3 col-form-label text-end">Nom de
                                            l'agence</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text"
                                                value="{{ isset($agentImmobilier) ? $agentImmobilier->nom_agence : '' }}"
                                                id="nom_agence" name="nom_agence" required>
                                        </div>
                                    </div>
                                    <!-- Nom de l'admin -->
                                    <div class="mb-3 row">
                                        <label for="nom_admin" class="col-sm-3 col-form-label text-end">Nom de
                                            l'admin</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text"
                                                value="{{ isset($agentImmobilier) ? $agentImmobilier->nom_admin : '' }}"
                                                id="nom_admin" name="nom_admin" required>
                                        </div>
                                    </div>
                                    <!-- Prénom de l'admin -->
                                    <div class="mb-3 row">
                                        <label for="prenom_admin" class="col-sm-3 col-form-label text-end">Prénom de
                                            l'admin</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text"
                                                value="{{ isset($agentImmobilier) ? $agentImmobilier->prenom_admin : '' }}"
                                                id="prenom_admin" name="prenom_admin" required>
                                        </div>
                                    </div>
                                    <!-- Téléphone de l'agence -->
                                    <div class="mb-3 row">
                                        <label for="telephone_agence"
                                            class="col-sm-3 col-form-label text-end">Téléphone</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="tel"
                                                value="{{ isset($agentImmobilier) ? $agentImmobilier->telephone_agence : '' }}"id="telephone_agence"
                                                name="telephone_agence" required>
                                        </div>
                                    </div>
                                    <!-- Fichier PDF Carte d'identité ou IFU -->
                                    <div class="mb-3 row">
                                        <label for="carte_identite_pdf" class="col-sm-3 col-form-label text-end">Carte
                                            d'identité </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" id="carte_identite_pdf"
                                                name="carte_identite_pdf" accept="application/pdf" {{ isset($agentImmobilier) ? '' : 'required' }}>
                                        </div>
                                    </div>

                                </div>
                                <!-- Partie droite -->
                                <div class="col-lg-6">
                                    <!-- Adresse de l'agence -->
                                    <div class="mb-3 row">
                                        <label for="adresse_agence" class="col-sm-3 col-form-label text-end">Adresse</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text"
                                                value="{{ isset($agentImmobilier) ? $agentImmobilier->adresse_agence : '' }}"
                                                id="adresse_agence" name="adresse_agence" required>
                                        </div>
                                    </div>
                                    <!-- Territoire couvert -->
                                    <div class="mb-3 row">
                                        <label for="territoire_couvert" class="col-sm-3 col-form-label text-end">Territoire
                                            couvert</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="territoire_couvert" name="territoire_couvert" rows="1" required>{{ isset($agentImmobilier) ? $agentImmobilier->territoire_couvert : '' }}</textarea>
                                        </div>
                                    </div>
                                    <!-- Nombre de biens disponibles -->
                                    <div class="mb-3 row">
                                        <label for="nombre_bien_disponible" class="col-sm-3 col-form-label text-end">Biens
                                            disponibles</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="number"
                                                value="{{ isset($agentImmobilier) ? $agentImmobilier->nombre_bien_disponible : '' }}"
                                                id="nombre_bien_disponible" name="nombre_bien_disponible" min="0"
                                                required>
                                        </div>
                                    </div>
                                    <!-- Année d'expérience -->
                                    <div class="mb-3 row">
                                        <label for="annee_experience" class="col-sm-3 col-form-label text-end">Année
                                            Expérience</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="number"
                                                value="{{ isset($agentImmobilier) ? $agentImmobilier->annee_experience : '' }}"
                                                id="annee_experience" name="annee_experience" min="0" required>
                                        </div>
                                    </div>
                                    <!-- Fichier PDF RCCM -->
                                    <div class="mb-3 row">
                                        <label for="rccm_pdf" class="col-sm-3 col-form-label text-end">IFU / Titre de propriété</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" id="rccm_pdf" name="rccm_pdf"
                                                accept="application/pdf" {{ isset($agentImmobilier) ? '' : 'required' }}>
                                        </div>
                                    </div>

                                </div>
                                <!-- Photo de profil centrée -->
                                <div class="mb-3 row justify-content-center">
                                    <div class="col-6 text-center">
                                        <label for="photo_profil" class="form-label">Photo de profil</label>
                                        <input class="form-control" type="file" id="photo_profil" name="photo_profil"
                                            accept="image/*" {{ isset($agentImmobilier) ? '' : 'required' }}  >
                                    </div>
                                </div>
                                <!-- Bouton de soumission -->
                                <div class="mb-3 row">
                                    <div class="col-sm-12  text-center">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($agentImmobilier) ? 'Modifier' : 'Enregistrer' }} </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
