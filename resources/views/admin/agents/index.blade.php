@extends('layouts.master_dash')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Liste des Agents Immobiliers</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table datatable" id="datatable_agents">
                                <thead>
                                    <tr>
                                        <th>Nom de l'agence</th>
                                        <th>Nom Admin</th>
                                        <th>Téléphone</th>
                                        <th>Adresse</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agents as $agent)
                                        <tr>
                                            <td>{{ $agent->nom_agence }}</td>
                                            <td>{{ $agent->nom_admin }} {{ $agent->prenom_admin }}</td>
                                            <td>{{ $agent->telephone_agence }}</td>
                                            <td>{{ $agent->adresse_agence }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input 
                                                        class="form-check-input toggle-status" 
                                                        type="checkbox" 
                                                        id="status_{{ $agent->user->id }}" 
                                                        data-id="{{ $agent->user->id }}"
                                                        {{ $agent->user->statut ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="status_{{ $agent->user->id }}">
                                                        {{ $agent->user->statut ? 'Activé' : 'Désactivé' }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                            <a href="{{ route('admin.agents.show', $agent->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Voir plus
                                            </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ajout du jeton CSRF dans une balise meta --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        // Lorsque la page est chargée
        document.addEventListener('DOMContentLoaded', () => {
            const toggleStatusButtons = document.querySelectorAll('.toggle-status');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content; // Récupération du jeton CSRF

            toggleStatusButtons.forEach(button => {
                button.addEventListener('change', function () {
                    const agentId = this.dataset.id; // ID de l'agent
                    const isChecked = this.checked; // Statut activé/désactivé
                    const statusLabel = this.nextElementSibling;

                    // Demander confirmation
                    const confirmation = confirm(`Êtes-vous sûr de vouloir ${isChecked ? 'activer' : 'désactiver'} cet agent ?`);

                    if (confirmation) {
                        // Envoyer la requête au backend pour mettre à jour le statut
                        fetch(`/admin/agents/toggle-status/${agentId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken // Inclure le token CSRF
                            },
                            body: JSON.stringify({ statut: isChecked })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Mise à jour du label de statut
                                    statusLabel.textContent = isChecked ? 'Activé' : 'Désactivé';
                                } else {
                                    alert('Une erreur s\'est produite. Veuillez réessayer.');
                                    this.checked = !isChecked; // Rétablir l'ancien état
                                }
                            })
                            .catch(error => {
                                console.error('Erreur :', error);
                                alert('Une erreur s\'est produite. Veuillez réessayer.');
                                this.checked = !isChecked; // Rétablir l'ancien état
                            });
                    } else {
                        this.checked = !isChecked; // Rétablir l'ancien état si annulation
                    }
                });
            });
        });
    </script>
@endsection
