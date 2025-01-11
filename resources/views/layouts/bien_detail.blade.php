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
                                <!-- Nouveau bouton Contrat de Bail -->

                                @if ($contrat)
                                    <a href="{{ route('contrat.edit', $contrat->id) }}" class="btn btn-link text-warning"
                                        title="Modifier le contrat de bail">
                                        <i class="bi bi-pencil-square" style="font-size: 1.5rem;"></i>
                                        Modifier le contrat de bail
                                    </a>
                                @else
                                    <!-- Si aucun contrat n'existe -->
                                    <a href="{{ route('contrat.create', ['bien_id' => $bien->id, 'locataire_id' => $locataireAssigné->locataire->id ?? null]) }}"
                                        class="btn btn-link text-info" title="Créer un contrat de bail">
                                        <i class="bi bi-file-earmark-text" style="font-size: 1.5rem;"></i>
                                        Créer un contrat de bail
                                    </a>
                                @endif
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

                <!-- Carousel Card (déjà existant) -->

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Contrat de Location</h5>
                    </div>
                    <div class="card-body">
                        @if ($contrat)
                            <h6 class="card-subtitle mb-2 text-muted">Contrat de Location entre l’Agent Immobilier et le
                                Locataire</h6>
                            <p>ENTRE LES SOUSSIGNÉS :</p>

                            <p>
                                <strong>{{ $bien->agent_immobilier->nom_agence }},</strong> représentée par
                                <strong>{{ $bien->agent_immobilier->nom_admin }}
                                    {{ $bien->agent_immobilier->prenom_admin }},</strong> ayant son siège social à
                                <strong>{{ $bien->agent_immobilier->adresse_agence }}</strong>, ci-après désignée “L’Agent
                                Immobilier”,
                                D’UNE PART,
                            </p>

                            <p>
                                ET
                            </p>

                            <p>
                                <strong>{{ $locataireAssigné->locataire->prenom }}
                                    {{ $locataireAssigné->locataire->nom }},</strong> né(e) le
                                <strong>{{ $locataireAssigné->locataire->date_naissance->format('d/m/Y') }}</strong>,
                                </strong>, domicilié(e) à
                                <strong>{{ $locataireAssigné->locataire->adresse }}</strong>, ci-après désigné “Le
                                Locataire”,
                                D’AUTRE PART,
                            </p>

                            <p>IL A ÉTÉ CONVENU CE QUI SUIT :</p>

                            <h6>ARTICLE 1 : OBJET DU CONTRAT</h6>
                            <p>
                                L’Agent Immobilier met à disposition du Locataire, en son nom propre ou en qualité de
                                mandataire du propriétaire, un bien immobilier situé à
                                <strong>{{ $bien->adresse_bien }}</strong>. Ce bien est destiné à un usage exclusivement
                                résidentiel et ne pourra être utilisé pour d’autres fins sans l’autorisation écrite de
                                l’Agent Immobilier.
                            </p>

                            <h6>ARTICLE 2 : DESCRIPTION DU BIEN</h6>
                            <p>
                                Le bien loué est décrit comme suit :
                            <ul>
                                <li>Superficie : {{ $bien->superficie }} m²</li>
                                <li>Nombre de pièces totale : {{ $bien->nombre_de_piece }} (incluant
                                    {{ $bien->nbr_chambres }} chambres, {{ $bien->nombre_de_salon }} salons,
                                    {{ $bien->nombre_de_cuisine }} cuisine, {{ $bien->nbr_salles_de_bain }} salles de
                                    bains )</li>
                                <li>Équipements : {{ $bien->description }}</li>
                            </ul>
                            L'ensemble faisant l'objet d'un titre de propriété, tel que ces locaux existent et se
                            comportentsans qu'il ne soit nécessaire d'en faire une plus grand description, <strong>le
                                Preneur déclarant bien connaître les lieux et locaux pour les avoir visités</strong>.
                            </p>

                            @php
                                $nombreAnnees = str_pad(
                                    floor($contrat->date_debut->diffInMonths($contrat->date_fin) / 12),
                                    2,
                                    '0',
                                    STR_PAD_LEFT,
                                );
                                $renouvelable = $contrat->renouvellement_automatique
                                    ? 'Renouvelable'
                                    : 'Non renouvelable';
                            @endphp



                            <h6>ARTICLE 3 : DURÉE DU CONTRAT</h6>
                            <p>
                                Le présent contrat est consenti et accepté pour une durée de
                                {{ $contrat->date_debut->diffInMonths($contrat->date_fin) }} mois
                                <strong> ({{ $nombreAnnees }} an(s)) {{ $renouvelable }}</strong>,
                                débutant le
                                <strong>{{ $contrat->date_debut->format('d/m/Y') }}</strong> et se terminant le
                                <strong>{{ $contrat->date_fin->format('d/m/Y') }}</strong>.
                                @if ($renouvelable == 'Renouvelable')
                                    À son expiration, le contrat pourra être renouvelé automatiquement pour une durée
                                    identique,
                                    sauf dénonciation par l’une des parties .
                                @endif
                                Chacune des parties aura la faculté de dénoncer le contrat, a charge pour elle de prévenire
                                l'autre partie au moin <strong> trois (03) mois</strong> à l'avance par lettre recommandée
                                avec accusé de réception, de son intention de mettre fin à la location

                            </p>

                            <h6>ARTICLE 4 : LOYER ET MODALITÉS DE PAIEMENT</h6>
                            @php
                                // Calculer le montant en fonction de la fréquence de paiement
                                $frequences = [
                                    'mois' => 1,
                                    'bimestre' => 2,
                                    'trimestre' => 3,
                                ];
                                $multiplicateur = $frequences[$contrat->frequence_paiement] ?? 1; // Par défaut, 1 si la fréquence n'est pas reconnue
                                $montant = $bien->loyer_mensuel * $multiplicateur;

                            @endphp
                            @php
                                // Convertir la fréquence en jours si c'est une période (mois, bimestre, trimestre)
                                $frequences = [
                                    'mois' => 30,
                                    'bimestre' => 60,
                                    'trimestre' => 90,
                                ];
                                $delai_retard =
                                    $frequences[$contrat->frequence_paiement] ?? $contrat->frequence_paiement; // Par défaut, la valeur brute si non reconnue

                                // Formater la pénalité (ajouter un symbole si nécessaire)
                                $penalite = is_numeric($contrat->penalite_retard)
                                    ? $contrat->penalite_retard .
                                        (strpos($contrat->penalite_retard, '%') !== false ? '' : ' Francs CFA')
                                                                    : $contrat->penalite_retard;
                            @endphp

                            <p>
                                1. Le présent contrat est consenti et accepté pour un loyer mensuel de
                                <strong>{{ number_format($bien->loyer_mensuel, 2) }} Francs CFA</strong> Payable par
                                <strong>{{ $contrat->frequence_paiement }}</strong> et d'avance
                                soit <strong>{{ number_format($montant, 2) }}</strong> Francs CFA.
                                Ce loyer est payable au plus tard le
                                <strong>{{ $contrat->date_debut->addMonth(1)->day }}ème
                                    jour</strong> de chaque mois.
                                <br> <br>

                                2. Le preneur doit verser une caution (Dépôt de garantie) de trois (03) mois
                                qui lui sera restitué à la fin du contrat, déduction faite des éventuelles
                                réparations ou charges dues, soit <strong> {{ $contrat->caution }} Francs CFA </strong> et
                                un
                                loyer de trois (03) mois, soit <strong>{{ $bien->loyer_mensuel * 3 }}</strong> Francs CFA,
                                correspondant au trois
                                premier mois, avant son entrée en jouissance des lieux.
                                Une caution d'eau
                                de <strong> {{ $contrat->caution_eau }} </strong> Francs CFA doit également être versée.

                                Le mode de paiement retenu est le paiement mobile.
                                En cas de retard de paiement supérieur à
                                <strong>{{ $delai_retard }}</strong> jours, une pénalité de
                                <strong>{{ $penalite }}</strong> sera appliquée.
                            </p>



                            <h6>ARTICLE 5 : OBLIGATIONS DU LOCATAIRE</h6>
                            <p> {{$contrat->clauses_specifiques1}} </p>
                            <h6>ARTICLE 6 : OBLIGATIONS DE L'AGENT IMMOBILIER</h6>
                            <p> {{$contrat->clauses_specifiques2}} </p>
                            <h6>ARTICLE 7 : RENOUVELLEMENT DU CONTRAT</h6>
                            <p> {{$contrat->clauses_specifiques3}} </p>
                            <h6>ARTICLE 8 : RESILIATION DU CONTRAT</h6>
                            <p> {{$contrat->clauses_specifiques4}} </p>
                            <h6>ARTICLE 9 : CONFORMITE DES LIEUX LOUES</h6>
                            <p> {{$contrat->clauses_specifiques5}} </p>
                            <h6>ARTICLE 10 : REGLEMENT DES LITIGES</h6>
                            <p> {{$contrat->clauses_specifiques6}} </p>


                            <h6>ARTICLE 8 : SIGNATURES</h6>
                            <p>
                                Le présent contrat est établi en deux exemplaires originaux, remis à chaque partie.
                            </p>

                            <p>Fait à <strong>{{ $bien->adresse_bien }}</strong>, le
                                <strong>{{ \Carbon\Carbon::parse($contrat->date_signature)->format('d/m/Y') }}</strong>.

                            <p><strong>Signatures :</strong></p>
                            <p>
                                L’Agent Immobilier : <strong>{{ $bien->agent_immobilier->nom_agent }}
                                    {{ $bien->agent_immobilier->prenom_agent }}</strong><br>
                                Le Locataire : <strong>{{ $locataireAssigné->locataire->prenom }}
                                    {{ $locataireAssigné->locataire->nom }}</strong>
                            </p>
                        @else
                            <p>Aucun contrat trouvé pour ce bien et ce locataire.</p>
                        @endif
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
                                <h5 class="text-primary">{{ $locataireAssigné->locataire->nom }}
                                    {{ $locataireAssigné->locataire->prenom }}</h5>
                            </div>
                            <table class="table table-borderless ">
                                <tbody>

                                    <tr>
                                        <th class="fw-bold text-muted">Email</th>
                                        <td>{{ $locataireAssigné->locataire->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bold text-muted">Statut</th>
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
                                    <th class="fw-bold">Propriétaire :</th>
                                    <td>{{ $bien->name_proprietaire }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Num_Propriétaire:</th>
                                    <td>{{ $bien->proprietaire_numéro }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Pièces :</th>
                                    <td>{{ $bien->nombre_de_piece }}</td>
                                </tr>
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
                                    <th class="fw-bold">Salon :</th>
                                    <td>{{ $bien->nombre_de_salon }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Cuisine :</th>
                                    <td>{{ $bien->nombre_de_cuisine }}</td>
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
