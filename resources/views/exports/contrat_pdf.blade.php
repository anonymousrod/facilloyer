<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Contrat de Bail</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        {{-- <style>
            body {
                font-family: 'Montserrat', sans-serif;
                background-color: #f8f9fa;
            }
            .card {
                border: none;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                margin: 20px;
            }
            .card-header {
                background-color: #007bff;
                color: white;
                font-size: 1.25rem;
                font-weight: bold;
                text-align: center;
                padding: 15px;
                border-radius: 8px 8px 0 0;
            }
            .card-body {
                padding: 20px;
            }
            .card-subtitle {
                font-size: 1.1rem;
                margin-bottom: 15px;
            }
            p {
                line-height: 1.6;
            }
            ul {
                list-style-type: none;
                padding-left: 0;
            }
            ul li {
                margin-bottom: 5px;
            }
            h6 {
                font-weight: bold;
                margin-top: 20px;
            }
            .text-end {
                text-align: end;
            }
            .text-center {
                text-align: center;
            }
            .font-weight-bold {
                font-weight: 700;
            }
            .m-5 {
                margin: 3rem;
            }
            .mt-1 {
                margin-top: 1rem;
            }
            .mb-1 {
                margin-bottom: 1rem;
            }
            .mb-3 {
                margin-bottom: 1rem;
            }
            .signature-pad {
                border: 2px solid #007bff;
                padding: 10px;
                border-radius: 8px;
                background-color: #fff;
            }
            canvas {
                border: 1px solid #ccc;
            }
            button {
                width: 100%;
                padding: 10px;
                font-size: 1rem;
                margin-top: 10px;
            }
            .btn-primary {
                background-color: #007bff;
                border: none;
            }
            .btn-secondary {
                background-color: #6c757d;
                border: none;
            }
            .row {
                margin-top: 20px;
            }
            .col-12 {
                margin-bottom: 20px;
            }
            .col-md-6 {
                padding-left: 10px;
                padding-right: 10px;
            }
            .text-start {
                text-align: start;
            }
            .text-end {
                text-align: end;
            }
            .img-fluid {
                max-width: 150px;
                margin-bottom: 15px;
            }
            .p-4 {
                padding: 1.5rem;
            }
        </style> --}}
    </head>
    <body>
        <div class="card" style="border: none">
            <div class="card-header">
                <h5 class="card-title">Contrat de Location</h5>
            </div>
            <div class="card-body">
                @if ($contrat)

                    <p>Entre les sousignés :</p>

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

                    <div >
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
                        comportent sans qu'il ne soit nécessaire d'en faire une plus grande description, <strong>le
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
                            Chacune des parties aura la faculté de dénoncer le contrat, à charge pour elle de
                            prévenir
                            l'autre partie au moins <strong> trois (03) mois</strong> à l'avance par lettre
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
                            correspondant aux trois
                            premiers mois, avant son entrée en jouissance des lieux.
                            Une caution d'eau
                            de <strong> {{ $contrat->caution_eau }} </strong> Francs CFA doit également être
                            versée.

                            Le mode de paiement retenu est le paiement mobile.
                            En cas de retard de paiement supérieur à
                            <strong>{{ $delai_retard }}</strong> jours, une pénalité de
                            <strong>{{ $contrat->penalite_retard }}</strong> Francs CFA sera appliquée.
                        </p>

                    @php
                        // Initialisation du compteur d'articles à 5
                        $articleCounter = 4;
                    @endphp

                    <!-- Affichage des articles de la table Article -->
                    @if ($articles->count() > 0)
                        @foreach ($articles as $article)
                            @php $articleCounter++; @endphp
                            <h6><strong><u>ARTICLE {{ $articleCounter }}</u> :
                                    {{ $article->titre_article }}</strong> </h6>

                            <p> {{ $article->contenu_article }} </p>
                        @endforeach
                    @endif

                    <!-- Continuation des articles numérotés dynamiquement -->
                    @php $articleCounter++; @endphp

                    <h6><strong><u>ARTICLE {{ $articleCounter }}</u> : DATE DE PRISE D'EFFET</strong> </h6>


                    <P>Le présent contrat commence à courir à compter du
                        <strong>{{ $contrat->date_debut->format('d/m/Y') }}</strong>
                    </P>
                    <br>
                    <p>En foi de quoi les parties contractantes ont opposé leurs noms, cachets et signatures
                    </p>
                    <p>
                        Fait en trois (03) exemplaires originaux, remis à chaque partie.
                    </p>

                    <p class="text-end m-5 mt-1 mb-1">À <strong>{{ $contrat->lieu_signature }}</strong>, le
                        <strong>{{ \Carbon\Carbon::parse($contrat->date_signature)->format('d/m/Y') }}</strong>.

                    <p class="text-center">( Signatures suivies de la mention manuscrite lue et approuvées)</p>

                    <div class="row d-flex align-items-center justify-content-between mt-3" style="display: flex; align-items: center;">
                        <!-- Colonne de gauche (Agent Immobilier) -->
                        <div class="col-6 text-start" style="padding: 1rem; display: flex; flex-direction: column; align-items: flex-start;">
                            <p class="font-weight-bold">Agent Immobilier</p>
                            @if ($contrat->signature_agent_immobilier)
                                <img class="img-fluid" src="{{ public_path($contrat->signature_agent_immobilier) }}"
                                    alt="Signature Agent Immobilier" width="150">
                                <strong>
                                    <u>
                                        <p>{{ $bien->agent_immobilier->nom_admin }}
                                            {{ $bien->agent_immobilier->prenom_admin }}</p>
                                    </u>
                                </strong>
                            @endif
                        </div>

                        <!-- Colonne de droite (Le Preneur) -->
                        <div class="col-6 text-end" style="padding: 1rem; display: flex; flex-direction: column; align-items: flex-end;">
                            <p class="font-weight-bold">Le preneur</p>
                            @if ($contrat->signature_locataire)
                                <img class="img-fluid" src="{{ public_path($contrat->signature_locataire) }}"
                                    alt="Signature Locataire" width="150">
                                <strong>
                                    <u>
                                        <p>{{ $locataireAssigné->locataire->nom }}
                                            {{ $locataireAssigné->locataire->prenom }}</p>
                                    </u>
                                </strong>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="row mt-3">

                        <!-- Colonne de gauche (Agent Immobilier) -->
                        <div class="col-12 col-md-6 p-4 text-start">
                            <p class="font-weight-bold">Agent Immobilier</p>
                            @if ($contrat->signature_agent_immobilier)
                                <img class="img-fluid" src="{{ public_path($contrat->signature_agent_immobilier) }}"
                                    alt="Signature Agent Immobilier" width="150">
                                <strong>
                                    <u>
                                        <p>{{ $bien->agent_immobilier->nom_admin }}
                                            {{ $bien->agent_immobilier->prenom_admin }}</p>
                                    </u>
                                </strong>

                            @endif
                        </div>

                        <!-- Colonne de droite (Le Preneur) -->
                        <div class="col-12 col-md-6 p-4 text-end">
                            <p class="font-weight-bold">Le preneur</p>
                            @if ($contrat->signature_locataire)
                                <img src="{{ public_path($contrat->signature_locataire) }}"
                                    alt="Signature Locataire" width="150">
                                <strong>
                                    <u>
                                        <p>{{ $locataireAssigné->locataire->nom }}
                                            {{ $locataireAssigné->locataire->prenom }}</p>
                                    </u>
                                </strong>

                            @endif
                        </div>
                    </div> --}}




                    @else
                        <p class="text-center">Aucun contrat trouvé.</p>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>

