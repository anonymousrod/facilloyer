@extends('layouts.master_dash')

@section('title', 'Assigner un locataire')
@section('content')
    <div class="container py-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">Assigner un locataire au bien : {{ $bien->name_bien }}</h1>
                <i class="fas fa-user-plus fa-lg"></i>
            </div>
            <div class="card-body bg-light">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('assign.locataire', $bien->id) }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="search-locataire" class="form-label">Rechercher un locataire :</label>
                        <div class="input-group">
                            <input type="text" id="search-locataire" class="form-control" placeholder="Tapez le nom ou le prénom...">
                            <span class="input-group-text bg-success text-white">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="hidden" name="locataire_id" id="locataire_id">
                        <div id="search-results" class="list-group mt-2"></div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2">Assigner</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-locataire');
            const resultsContainer = document.getElementById('search-results');
            const locataireIdInput = document.getElementById('locataire_id');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value.trim();
                if (query.length > 2) {
                    fetch(`/locataires/search?bien_id={{ $bien->id }}&query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            resultsContainer.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(locataire => {
                                    const resultItem = document.createElement('a');
                                    resultItem.href = '#';
                                    resultItem.className = 'list-group-item list-group-item-action';
                                    resultItem.textContent = `${locataire.nom} ${locataire.prenom}`;
                                    resultItem.dataset.id = locataire.id;

                                    resultItem.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        locataireIdInput.value = locataire.id;
                                        searchInput.value = `${locataire.nom} ${locataire.prenom}`;
                                        resultsContainer.innerHTML = '';
                                    });

                                    resultsContainer.appendChild(resultItem);
                                });
                            } else {
                                resultsContainer.innerHTML = '<p class="text-muted">Aucun locataire trouvé.</p>';
                            }
                        });
                } else {
                    resultsContainer.innerHTML = '';
                }
            });
        });
    </script>
@endsection

