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

                        @if (Auth::user()->id_role == 3)

                            <!-- Actions -->
                            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
                                <a href="{{ route('biens.edit', $bien->id) }}" class="btn btn-link text-primary"
                                    title="Modifier">
                                    <i class="bi bi-pencil-square" style="font-size: 1.5rem;"></i>
                                </a>
                                @if (!$contrat)
                                    <form action="{{ route('biens.destroy', $bien->id) }}" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce bien ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger" title="Supprimer">
                                            <i class="bi bi-trash" style="font-size: 1.5rem;"></i>
                                        </button>
                                    </form>
                                @endif
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
                                    @if (!$contrat)
                                        {{-- <a href="{{ route('contrat.edit', $contrat->id) }}" class="btn btn-link text-warning" title="Modifier le contrat de bail">
                                        <i class="bi bi-pencil-square" style="font-size: 1.5rem;"></i> Modifier le contrat de bail
                                    </a> --}}
                                        <a href="{{ route('contrat.create', ['bien_id' => $bien->id, 'locataire_id' => $locataireAssigné->locataire->id ?? null]) }}"
                                            class="btn btn-link text-info" title="Créer un contrat de bail">
                                            <i class="bi bi-file-earmark-text" style="font-size: 1.5rem;"></i> Créer un
                                            contrat
                                            de bail
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
                        @endif



                    </div>
                </div>

                <!-- Carousel Card (déjà existant) -->

                <div class="card mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="card-title m-0">Contrat de Location et gestion de ses articles</h5>

                        @if ($contrat && Auth::user()->id_role === 3 && !$contrat->signature_locataire)
                            <div class="d-flex gap-3 flex-wrap">
                                <a href="{{ route('article.create_specifique', $contrat->id) }}"
                                    class="btn p-0 border-0 d-flex align-items-center text-primary">
                                    <i class="fas fa-plus me-1"></i> Article Spécifique
                                </a>

                                <form method="POST" action="{{ route('contrat.destroy', $contrat->id) }}" class="m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn p-0 border-0 d-flex align-items-center text-danger"
                                        onclick="return confirm('Confirmer la suppression du contrat ?')">
                                        <i class="fas fa-trash-alt me-1"></i> Supprimer ce Contrat
                                    </button>
                                </form>
                            </div>
                        @endif
                        @if (
                            $contrat?->signature_locataire &&
                                $contrat?->signature_agent_immobilier &&
                                !$contrat->modificationRequests->where('statut', 'en_attente')->count())
                            <div class="d-flex gap-3 flex-wrap">
                                <button type="button" class="btn p-0 border-0 d-flex align-items-center text-info"
                                    data-bs-toggle="modal" data-bs-target="#modificationModal">
                                    <i class="fas fa-edit me-1"></i> Faire une demande de modification
                                </button>
                            </div>
                        @endif
                        @if ($contrat?->modificationRequests?->where('statut', 'en_attente')->count())
                            <div class="d-flex gap-3 flex-wrap">
                                <button type="button" class="btn p-0 border-0 d-flex align-items-center text-info">
                                    <i class="fas fa-edit me-1"></i>Demande de modification en attente
                                </button>
                            </div>
                        @endif

                        {{-- Modal de demande de modification --}}
                        <div class="modal fade" id="modificationModal" tabindex="-1"
                            aria-labelledby="modificationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modificationModalLabel">Demander une modification de
                                            contrat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('modification.demander') }}">
                                            @csrf
                                            <input type="hidden" name="contrat_de_bail_id" value="{{ $contrat?->id }}">

                                            <div class="mb-3">
                                                <label for="motif" class="form-label">Motif de la modification</label>
                                                <textarea name="motif" class="form-control" id="motif" rows="4" required></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">Envoyer la demande</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="card-body">

                        @if ($contrat?->signature_agent_immobilier || (Auth::user()->id_role === 3 && $contrat))
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
                                <strong>{{ $locataireAssigné->locataire->nom }} {{ $locataireAssigné->locataire->prenom }}
                                    ,</strong> né(e) le
                                <strong>{{ $locataireAssigné->locataire->date_naissance->format('d/m/Y') }}</strong>,
                                </strong>, domicilié(e) à
                                <strong>{{ $locataireAssigné->locataire->adresse }}</strong>, ci-après désigné “Le
                                Locataire”,
                                D’AUTRE PART,
                            </p>

                            <div id="contrat-details" style="display: none;">
                                <p>IL A ÉTÉ CONVENU CE QUI SUIT :</p>

                                <h6><strong><u>ARTICLE 1</u> : OBJET DU CONTRAT</strong> </h6>

                                <p>
                                    L’Agent Immobilier met à disposition du Locataire, en son nom propre ou en qualité de
                                    mandataire du propriétaire, un bien immobilier situé à
                                    <strong>{{ $bien->adresse_bien }}</strong>. Ce bien est destiné à un usage
                                    exclusivement
                                    résidentiel et ne pourra être utilisé pour d’autres fins sans l’autorisation écrite de
                                    l’Agent Immobilier.
                                </p>

                                <h6><strong><u>ARTICLE 2</u> : DESCRIPTION DU BIEN</strong> </h6>

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
                                comportent sans qu'il ne soit nécessaire d'en faire une plus grand description, <strong>le
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



                                <h6><strong><u>ARTICLE 3</u> : DURÉE DU CONTRAT</strong> </h6>

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
                                    Chacune des parties aura la faculté de dénoncer le contrat, a charge pour elle de
                                    prévenire
                                    l'autre partie au moin <strong> trois (03) mois</strong> à l'avance par lettre
                                    recommandée
                                    avec accusé de réception, de son intention de mettre fin à la location

                                </p>

                                <h6><strong><u>ARTICLE 4</u> : LOYER ET MODALITÉS DE PAIEMENT</strong> </h6>

                                @php
                                    // Convertir la fréquence en jours si c'est une période (mois, bimestre, trimestre)
$frequences = [
    'mois' => 30,
    'bimestre' => 60,
    'trimestre' => 90,
    'semestriel' => 180, // Virgule ajoutée ici
    'annuel' => 360,
];

// Par défaut, la valeur brute est utilisée si la clé n'est pas reconnue
                                    $delai_retard =
                                        $frequences[$contrat->frequence_paiement] ?? $contrat->frequence_paiement;

                                @endphp


                                <p>
                                    1. Le présent contrat est consenti et accepté pour un loyer mensuel de
                                    <strong>{{ number_format($bien->loyer_mensuel, 2) }} Francs CFA</strong> Payable par
                                    <strong>{{ $contrat->frequence_paiement }}</strong> et d'avance
                                    soit <strong>{{ $contrat->montant_total_frequence }}</strong> Francs CFA.
                                    Ce loyer est payable au plus tard le
                                    <strong>{{ $contrat->date_debut->addMonth(1)->day }}ème
                                        jour</strong> de chaque mois.
                                    <br> <br>

                                    2. Le preneur doit verser une caution (Dépôt de garantie) de trois (03) mois
                                    qui lui sera restitué à la fin du contrat, déduction faite des éventuelles
                                    réparations ou charges dues, soit <strong> {{ $contrat->caution }} Francs CFA </strong>
                                    et
                                    un
                                    loyer de trois (03) mois, soit <strong>{{ $bien->loyer_mensuel * 3 }}</strong> Francs
                                    CFA,
                                    correspondant au trois
                                    premier mois, avant son entrée en jouissance des lieux.
                                    Une caution d'eau
                                    de <strong> {{ $contrat->caution_eau }} </strong> Francs CFA doit également être
                                    versée.

                                    Le mode de paiement retenu est le paiement mobile.
                                    En cas de retard de paiement supérieur à
                                    <strong>{{ $delai_retard }}</strong> jours, une pénalité de
                                    <strong>{{ $contrat->penalite_retard }}</strong> Francs CFA sera appliquée.
                                </p>



                                @php
                                    $articleCounter = 4;
                                @endphp

                                <!-- 🎯 Articles par défaut via la table pivot -->
                                @if ($articles->count() > 0)
                                    @foreach ($articles as $article)
                                        @php $articleCounter++; @endphp
                                        <h6><strong><u>ARTICLE {{ $articleCounter }}</u> :
                                                {{ $article->pivot->titre_article }}</strong></h6>
                                        <p>{{ $article->pivot->contenu_article }}</p>

                                        {{-- @if (Auth::user()->id_role === 3 && !$contrat->signature_locataire)
                                            <form
                                                action="{{ route('contrats.detachArticle', ['contratId' => $contrat->id, 'articleId' => $article->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Retirer</button>

                                            </form>
                                        @endif --}}
                                        @if (Auth::user()->id_role === 3 && !$contrat->signature_locataire)
                                            <form
                                                action="{{ route('contrats.detachArticle', ['contratId' => $contrat->id, 'articleId' => $article->id]) }}"
                                                method="POST" class="m-0 p-0 mb-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn p-0 border-0 d-flex align-items-center text-danger">
                                                    <i class="fas fa-times me-1"></i> Retirer
                                                </button>
                                            </form>
                                        @endif
                                    @endforeach
                                @endif

                                <!-- 🎯 Articles spécifiques (uniquement liés au contrat dans contrat_de_bail_article) -->
                                @if ($contrat && $contrat->articlesSpecifiques->count() > 0)
                                    @foreach ($contrat->articlesSpecifiques as $article)
                                        @php $articleCounter++; @endphp
                                        <h6><strong><u>ARTICLE {{ $articleCounter }}</u> :
                                                {{ $article->titre_article }}</strong></h6>
                                        <p>{{ $article->contenu_article }}</p>
                                        @if (Auth::user()->id_role === 3 && !$contrat->signature_locataire)
                                            <div class="d-flex gap-3 mb-3 align-items-center">
                                                <!-- 🟡 Bouton Modifier -->
                                                <button type="button"
                                                    class="btn p-0 border-0 d-flex align-items-center text-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $article->id }}">
                                                    <i class="fas fa-edit me-1"></i> Modifier
                                                </button>

                                                <!-- 🔴 Bouton Supprimer -->
                                                <form
                                                    action="{{ route('contrats.articlesSpecifiques.supprimer', $article->id) }}"
                                                    method="POST" class="m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn p-0 border-0 d-flex align-items-center text-danger">
                                                        <i class="fas fa-trash-alt me-1"></i> Supprimer
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- 🔽 Modal Bootstrap pour modification -->
                                            <div class="modal fade" id="editModal{{ $article->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $article->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('contrats.articlesSpecifiques.update', $article->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editModalLabel{{ $article->id }}">Modifier
                                                                    l’article</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="titre_article{{ $article->id }}"
                                                                        class="form-label">Titre de l’article</label>
                                                                    <input type="text" class="form-control"
                                                                        id="titre_article{{ $article->id }}"
                                                                        name="titre_article"
                                                                        value="{{ $article->titre_article }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="contenu_article{{ $article->id }}"
                                                                        class="form-label">Contenu de l’article</label>
                                                                    <textarea class="form-control" id="contenu_article{{ $article->id }}" name="contenu_article" rows="5"
                                                                        required>{{ $article->contenu_article }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit" class="btn btn-primary">💾
                                                                    Enregistrer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                                <!-- Exemple d'article fixe -->
                                @php $articleCounter++; @endphp
                                <h6><strong><u>ARTICLE {{ $articleCounter }}</u> : DATE DE PRISE D'EFFET</strong></h6>


                                <P>Le present contrat commence à courir à compter du
                                    <strong>{{ $contrat->date_debut->format('d/m/Y') }}</strong>
                                </P>
                                <br>
                                <p>En fois de quoi les parties contractantes ont opposé leurs noms, cachets et signatures
                                </p>
                                <p>
                                    Fait en trois (03) exemlaires originaux, remis à chaque partie.
                                </p>

                                <p class="text-end m-5 mt-1 mb-1">A <strong>{{ $contrat->lieu_signature }}</strong>, le
                                    <strong>{{ \Carbon\Carbon::parse($contrat->date_signature)->format('d/m/Y') }}</strong>.

                                <p class="text-center">( Signatures suivies de la mention manuscrite lue et approuvées )
                                </p>

                                <div class="row mt-3">

                                    <!-- Colonne de gauche (Agent Immobilier) -->
                                    <div class="col-12 col-md-6 p-4 text-start">
                                        <p class="font-weight-bold">Agent Immobilier</p>
                                        @if ($contrat->signature_agent_immobilier)
                                            <img class="img-fluid"
                                                src="{{ asset($contrat->signature_agent_immobilier) }}"
                                                alt="Signature Agent Immobilier" width="150">
                                            <strong>
                                                <u>
                                                    <p>{{ $bien->agent_immobilier->nom_admin }}
                                                        {{ $bien->agent_immobilier->prenom_admin }}</p>
                                                </u>
                                            </strong>
                                        @else
                                            <p>Aucune signature trouvée.</p>
                                            <strong>
                                                <u>
                                                    <p>{{ $bien->agent_immobilier->nom_admin }}
                                                        {{ $bien->agent_immobilier->prenom_admin }}</p>
                                                </u>
                                            </strong>
                                            @if (Auth::user()->id_role == 3)
                                                <div id="signature-pad-agent" class="signature-pad mb-3">
                                                    <canvas id="canvas-agent" width="290" height="150"></canvas>
                                                </div>
                                                <button type="button" id="save-signature-agent"
                                                    class="btn btn-primary btn-block">Sauvegarder la signature</button>
                                                <button type="button" id="effacer-agent"
                                                    class="btn btn-secondary btn-block ">Effacer</button>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Colonne de droite (Le Preneur) -->
                                    <div class="col-12 col-md-6 p-4 text-end">
                                        <p class="font-weight-bold">Le preneur</p>
                                        @if ($contrat->signature_locataire)
                                            <img src="{{ asset($contrat->signature_locataire) }}"
                                                alt="Signature Locataire" width="150">
                                            <strong>
                                                <u>
                                                    <p>{{ $locataireAssigné->locataire->nom }}
                                                        {{ $locataireAssigné->locataire->prenom }}</p>
                                                </u>
                                            </strong>
                                        @else
                                            <p>Aucune signature trouvée.</p>
                                            <strong>
                                                <u>
                                                    <p>{{ $locataireAssigné->locataire->nom }}
                                                        {{ $locataireAssigné->locataire->prenom }}</p>
                                                </u>
                                            </strong>
                                            @if (Auth::user()->id_role == 2)
                                                <div id="signature-pad-locataire" class="signature-pad mb-3">
                                                    <canvas id="canvas-locataire" width="290" height="150"></canvas>
                                                </div>
                                                <button type="button" id="save-signature-locataire"
                                                    class="btn btn-primary btn-block">Sauvegarder la signature</button>
                                                <button type="button" id="effacer-locataire"
                                                    class="btn btn-secondary btn-block ">Effacer</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>


                            </div>
                            <button id="see-more-btn" class="btn btn-primary ">Voir plus</button>
                            @if ($contrat->signature_agent_immobilier && $contrat->signature_locataire)
                                <a href="{{ route('contrat.export', ['bien_id' => $bien->id, 'agent_id' => $locataireAssigné->locataire->agent_immobilier->id]) }}"
                                    class="btn btn-success">
                                    Exporter en PDF
                                </a>
                            @endif
                        @else
                            <p>Aucun contrat trouvé pour ce bien et ce locataire.</p>
                        @endif
                    </div>
                </div>






            </div>


            <!-- Colonne secondaire -->
            <div class="col-lg-4 col-md-12">
                <!-- Première carte : Locataire Assigné -->
                <div class="card shadow-sm mb-3">
                    <div class="body text-center">
                        @if ($locataireAssigné)
                            <a href="#"><img src="{{ asset($locataireAssigné->locataire->photo_profil) }}"
                                    alt="Photo de {{ $locataireAssigné->locataire->nom }}"
                                    class=" only rounded-circle mb-3"
                                    style="width: 100px; height: 100px; object-fit: cover;"></a>
                            <h4 class="text-primary">{{ $locataireAssigné->locataire->nom }}
                                {{ $locataireAssigné->locataire->prenom }}</h4>
                            <p class="text-muted mb-3">{{ $locataireAssigné->locataire->user->email }}</p>
                            <span class="badge bg-success">Locataire Assigné</span>
                        @else
                            <h4 class="text-danger">Aucun locataire assigné</h4>
                            <p class="text-muted">Assignez un locataire pour voir ses informations ici.</p>
                        @endif
                    </div>
                </div>

                <!-- Deuxième carte : Informations du Bien -->
                <div class="card shadow-sm">
                    <div class="header">
                        <h5 class="card-title text-muted"><strong>Informations du Bien</strong></h5>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="fw-bold">Propriétaire :</th>
                                        <td>{{ $bien->name_proprietaire }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Numéro du Propriétaire :</th>
                                        <td>{{ $bien->proprietaire_numéro }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Loyer :</th>
                                        <td>{{ number_format($bien->loyer_mensuel, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Statut :</th>
                                        <td><span class="badge bg-success">{{ $bien->statut_bien }}</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Superficie :</th>
                                        <td>{{ $bien->superficie }} m²</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Type de Bien :</th>
                                        <td>{{ $bien->type_bien }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Adresse :</th>
                                        <td>{{ $bien->adresse_bien }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Chambres :</th>
                                        <td>{{ $bien->nbr_chambres }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Salles de Bain :</th>
                                        <td>{{ $bien->nbr_salles_de_bain }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Cuisine :</th>
                                        <td>{{ $bien->nombre_de_cuisine }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Salon :</th>
                                        <td>{{ $bien->nombre_de_salon }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="fw-bold">Pièces :</th>
                                        <td>{{ $bien->nombre_de_piece }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

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

    .card {
        border: none;
        border-radius: 10px;
    }

    .card .body {
        padding: 15px;
    }

    .card .header {
        background: #f7f7f7;
        border-bottom: 1px solid #e0e0e0;
        padding: 10px 15px;
        border-radius: 10px 10px 0 0;
    }

    .only {
        border: 3px solid #007bff;
    }

    .table th {
        font-weight: bold;
        color: #6c757d;
    }

    .table td {
        font-size: 14px;
    }
</style>
<style>
    .signature-pad {
        /* width: 100%;
        height: 150px; */
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }
</style>



<script>
    let signaturePadAgent;
    let signaturePadLocataire;
    let contratId = @json($contrat ? $contrat->id : null);

    // document.addEventListener('DOMContentLoaded', function() {
    //     // Vérifiez que les éléments existent avant de créer SignaturePad
    //     const canvasAgent = document.querySelector('#canvas-agent');
    //     if (canvasAgent) {
    //         signaturePadAgent = new SignaturePad(canvasAgent); // Initialisation avec un canvas correct
    //     } else {
    //         console.error('Canvas pour agent immobilier non trouvé!');
    //     }

    //     const canvasLocataire = document.querySelector('#canvas-locataire');
    //     if (canvasLocataire) {
    //         signaturePadLocataire = new SignaturePad(
    //             canvasLocataire); // Assurez-vous que le locataire est initialisé également
    //     }

    //     // Effacer la signature de l'agent immobilier
    //     document.getElementById('effacer-agent').addEventListener('click', function() {
    //         if (signaturePadAgent) {
    //             signaturePadAgent.clear(); // Efface la signature du canvas
    //         } else {
    //             console.error('signaturePadAgent n\'est pas défini.');
    //         }
    //     });
    //     // Effacer la signature de locataire
    //     document.getElementById('effacer-locataire').addEventListener('click', function() {
    //         if (signaturePadLocataire) {
    //             signaturePadLocataire.clear(); // Efface la signature du canvas
    //         } else {
    //             console.error('signaturePadLocataire n\'est pas défini.');
    //         }
    //     });


    //     document.querySelector('#save-signature-agent').addEventListener('click', function() {
    //         if (!signaturePadAgent.isEmpty()) {
    //             const signatureData = signaturePadAgent.toDataURL('image/png'); // Convertir en base64
    //             saveSignature('agent', signatureData, contratId);
    //         } else {
    //             alert('Veuillez signer avant de sauvegarder.');
    //         }
    //     });

    //     document.querySelector('#save-signature-locataire').addEventListener('click', function() {
    //         if (!signaturePadLocataire.isEmpty()) {
    //             const signatureData = signaturePadLocataire.toDataURL(
    //                 'image/png'); // Convertir en base64
    //             saveSignature('locataire', signatureData, contratId);
    //         } else {
    //             alert('Veuillez signer avant de sauvegarder.');
    //         }
    //     });


    // });
    document.addEventListener('DOMContentLoaded', function() {
        // Vérifie que les éléments existent avant de créer SignaturePad
        const canvasAgent = document.querySelector('#canvas-agent');
        if (canvasAgent) {
            signaturePadAgent = new SignaturePad(canvasAgent);
        } else {
            console.error('Canvas pour agent immobilier non trouvé!');
        }

        const canvasLocataire = document.querySelector('#canvas-locataire');
        if (canvasLocataire) {
            signaturePadLocataire = new SignaturePad(canvasLocataire);
        }

        // Effacer la signature de l'agent immobilier
        const effacerAgentBtn = document.getElementById('effacer-agent');
        if (effacerAgentBtn) {
            effacerAgentBtn.addEventListener('click', function() {
                if (signaturePadAgent) {
                    signaturePadAgent.clear();
                } else {
                    console.error('signaturePadAgent n\'est pas défini.');
                }
            });
        } else {
            console.error('Bouton effacer-agent non trouvé!');
        }

        // Effacer la signature de locataire
        const effacerLocataireBtn = document.getElementById('effacer-locataire');
        if (effacerLocataireBtn) {
            effacerLocataireBtn.addEventListener('click', function() {
                if (signaturePadLocataire) {
                    signaturePadLocataire.clear();
                } else {
                    console.error('signaturePadLocataire n\'est pas défini.');
                }
            });
        } else {
            console.error('Bouton effacer-locataire non trouvé!');
        }

        // Sauvegarder la signature de l'agent immobilier
        const saveSignatureAgentBtn = document.querySelector('#save-signature-agent');
        if (saveSignatureAgentBtn) {
            saveSignatureAgentBtn.addEventListener('click', function() {
                if (!signaturePadAgent.isEmpty()) {
                    const signatureData = signaturePadAgent.toDataURL('image/png');
                    saveSignature('agent', signatureData, contratId);
                } else {
                    alert('Veuillez signer avant de sauvegarder.');
                }
            });
        }

        // Sauvegarder la signature du locataire
        const saveSignatureLocataireBtn = document.querySelector('#save-signature-locataire');
        if (saveSignatureLocataireBtn) {
            saveSignatureLocataireBtn.addEventListener('click', function() {
                if (!signaturePadLocataire.isEmpty()) {
                    const signatureData = signaturePadLocataire.toDataURL('image/png');
                    saveSignature('locataire', signatureData, contratId);
                } else {
                    alert('Veuillez signer avant de sauvegarder.');
                }
            });
        }
    });

    function saveSignature(type, base64Image, contratId) {
        const formData = new FormData();
        formData.append('type', type);
        formData.append('signature', base64Image); // Envoyer base64
        formData.append('contrat_id', contratId);

        fetch('/save-signature', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Signature sauvegardée:', data);
                alert('Signature sauvegardée avec succès.');
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la sauvegarde.');
            });
    }
</script>


{{-- for agent --}}
{{-- <form method="POST"
    action="{{ route('contrats_de_bail.update_photo', $contrat->id) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="signature_agent_immobilier">Ajouter une signature
            :</label>
        <input type="file" class="form-control"
            id="signature_agent_immobilier"
            name="signature_agent_immobilier" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success mt-2">Enregistrer la
        signature</button>
</form> --}}
{{-- for locataire --}}
{{-- <form method="POST"
        action="{{ route('contrats_de_bail.update_photo', $contrat->id) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="signature_locataire">Ajouter une signature
                :</label>
            <input type="file" class="form-control"
                id="signature_locataire" name="signature_locataire"
                accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-success mt-2">Enregistrer la
            signature</button>
</form> --}}
