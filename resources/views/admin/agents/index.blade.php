@extends('layouts.master_dash')

@section('content')
<div class="container-xxl">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Liste des Agents Immobiliers</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="datatable_agents">
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

<!-- Script de mise à jour du statut -->
<script>
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
                            alert('Erreur lors de la mise à jour. Veuillez réessayer.');
                            this.checked = !isChecked;
                        }
                    })
                    .catch(() => {
                        alert('Erreur réseau. Veuillez réessayer.');
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
