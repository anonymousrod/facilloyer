@extends('layouts.master_dash')

@section('title', 'Assigner un locataire')
@section('content')
    <div class="container">
        <h1>Assigner un locataire au bien : {{ $bien->name_bien }}</h1>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('assign.locataire', $bien->id) }}">
            @csrf
            <div class="form-group">
                <label for="search-locataire">Rechercher un locataire :</label>
                <!-- Champ de recherche -->
                <input type="text" id="search-locataire" class="form-control" placeholder="Tapez le nom ou le prénom...">
                <!-- Champ caché pour stocker l'ID du locataire sélectionné -->
                <input type="hidden" name="locataire_id" id="locataire_id">
                <!-- Conteneur pour afficher les résultats -->
                <div id="search-results" class="list-group mt-2"></div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Assigner</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-locataire');
            const resultsContainer = document.getElementById('search-results');
            const locataireIdInput = document.getElementById('locataire_id');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value.trim();
                if (query.length > 2) { // Lancer la recherche après 2 caractères
                    fetch(`/locataires/search?bien_id={{ $bien->id }}&query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            resultsContainer.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(locataire => {
                                    const resultItem = document.createElement('a');
                                    resultItem.href = '#';
                                    resultItem.className =
                                        'list-group-item list-group-item-action';
                                    resultItem.textContent =
                                        `${locataire.nom} ${locataire.prenom}`;
                                    resultItem.dataset.id = locataire.id;

                                    // Lorsqu'un locataire est cliqué, remplir les champs nécessaires
                                    resultItem.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        locataireIdInput.value = locataire
                                        .id; // Stocker l'ID
                                        searchInput.value =
                                            `${locataire.nom} ${locataire.prenom}`; // Afficher le nom
                                        resultsContainer.innerHTML =
                                        ''; // Vider les résultats
                                    });

                                    resultsContainer.appendChild(resultItem);
                                });
                            } else {
                                resultsContainer.innerHTML =
                                    '<p class="text-muted">Aucun locataire trouvé.</p>';
                            }
                        });
                } else {
                    resultsContainer.innerHTML = '';
                }
            });
        });
    </script>
@endsection
