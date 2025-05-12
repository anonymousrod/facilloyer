@extends('layouts.master_dash')
@section('title', 'Liste des locataires')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="mb-3 card-header d-flex justify-content-between align-items-center" style="background-color: #2E8B57; color: #F5F5F5; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 5px;">
                        <h4 class="card-title mb-0">Liste des Locataires</h4>
                        <a href="{{ route('export.pdf') }}" class="btn btn-light btn-sm" style="font-weight: bold;">
                            <i class="fas fa-file-pdf"></i> Exporter en PDF
                        </a>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table datatable" id="datatable_2">
                                <thead class="">
                                    <tr>
                                        <th>Photo</th>
                                        <th>Nom complet</th>
                                        <th>Téléphone</th>
                                        <th>Adresse</th>
                                        <th>Revenus mensuels</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locataires as $locataire)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($locataire->photo_profil) }}"
                                                    alt="profil de {{ $locataire->nom . ' ' . $locataire->prenom }}"
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">


                                            </td>
                                            <td>{{ $locataire->nom . ' ' . $locataire->prenom }}</td>
                                            <td>{{ $locataire->telephone }}</td>
                                            <td>{{ \Illuminate\Support\Str::words($locataire->adresse, 2, '...') }}</td>
                                            <td>{{ $locataire->revenu_mensuel }} FCFA</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input toggle-status" type="checkbox"
                                                        id="status_{{ $locataire->id }}" data-id="{{ $locataire->id }}"
                                                        {{ $locataire->user->statut ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="status_{{ $locataire->id }}">
                                                        {{ $locataire->user->statut ? 'Activé' : 'Désactivé' }}
                                                    </label>
                                                </div>
                                            </td>
                                            {{-- <td>
                                                {{ route('locataire.show', $locataire->id) }}
                                                <a href=""
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Voir Détails
                                                </a>
                                            </td> --}}
                                            <td class="text-center align-middle">
                                                <a href="{{ route('locataire.locashow', $locataire->user->id) }}" class="btn btn-outline-primary">
                                                    <span class="bi bi-info-circle-fill"></span>
                                                </a>
                                                <a href="{{ route('user', $locataire->user->id) }}" class="btn btn-outline-primary">
                                                    <span class="bi bi-chat-dots-fill"></span> <!-- Icône de chat -->
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div><!--end row-->


        {{-- voir le script equivalent dans layouts script... --}}

    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleStatusButtons = document.querySelectorAll('.toggle-status');

        toggleStatusButtons.forEach(button => {
            button.addEventListener('change', function () {
                const locataireId = this.dataset.id;
                const isChecked = this.checked;
                const statusLabel = this.nextElementSibling;

                // Confirmation message
                const confirmation = confirm(`Êtes-vous sûr de vouloir ${isChecked ? 'activer' : 'désactiver'} ce locataire ?`);

                if (confirmation) {
                    // Envoyer la requête au backend pour mettre à jour le statut
                    fetch(`/locataires/${locataireId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ statut: isChecked })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
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
