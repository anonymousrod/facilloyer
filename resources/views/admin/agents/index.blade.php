@extends('layouts.master_dash')

@section('content')
<div class="container-xxl mt-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow border-0 rounded">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-users me-2"></i> Liste des Agents Immobiliers
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle" id="datatable_agents">
                            <thead class="table-dark">
                                <tr>
                                    <th>Agence</th>
                                    <th>Admin</th>
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
                                            <div class="form-check form-switch d-flex align-items-center">
                                                <input 
                                                    class="form-check-input toggle-status me-2" 
                                                    type="checkbox" 
                                                    id="status_{{ $agent->user->id }}" 
                                                    data-id="{{ $agent->user->id }}"
                                                    {{ $agent->user->statut ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status_{{ $agent->user->id }}">
                                                    <span class="badge {{ $agent->user->statut ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $agent->user->statut ? 'Activé' : 'Désactivé' }}
                                                    </span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.agents.show', $agent->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i> Détails
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- table-responsive -->
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div>
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- JS pour DataTables + Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<script>
    $(document).ready(function() {
        $('#datatable_agents').DataTable({
            language: {
                search: "🔍 Rechercher :",
                lengthMenu: "Afficher _MENU_ entrées",
                info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                paginate: {
                    first: "Premier",
                    last: "Dernier",
                    next: "Suivant",
                    previous: "Précédent"
                },
                zeroRecords: "Aucun agent trouvé"
            }
        });
    });

    // Script pour changement de statut
    document.addEventListener('DOMContentLoaded', () => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        document.querySelectorAll('.toggle-status').forEach(button => {
            button.addEventListener('change', function () {
                const agentId = this.dataset.id;
                const isChecked = this.checked;
                const label = this.closest('td').querySelector('.form-check-label .badge');

                if (confirm(`Êtes-vous sûr de vouloir ${isChecked ? 'activer' : 'désactiver'} cet agent ?`)) {
                    fetch(`/admin/agents/toggle-status/${agentId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ statut: isChecked })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            label.textContent = isChecked ? 'Activé' : 'Désactivé';
                            label.className = `badge ${isChecked ? 'bg-success' : 'bg-secondary'}`;
                        } else {
                            alert('Erreur lors de la mise à jour.');
                            this.checked = !isChecked;
                        }
                    })
                    .catch(() => {
                        alert('Erreur réseau.');
                        this.checked = !isChecked;
                    });
                } else {
                    this.checked = !isChecked;
                }
            });
        });
    });
</script>
@endsection
