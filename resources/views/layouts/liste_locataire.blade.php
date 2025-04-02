@extends('layouts.master_dash')
@section('title', 'Liste des locataires')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Liste des Locataires - Exportations Disponibles</h4>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
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
                            <a href="{{ route('export.pdf') }}" class="btn btn-sm btn-primary pdf">
                                <i class="fas fa-file-pdf"></i> Exporter en PDF
                            </a>
                            {{-- <button type="button" class="btn btn-sm btn-primary csv">Export PDF</button> --}}
                            {{-- <button type="button" class="btn btn-sm btn-primary sql">Export SQL</button>
                            <button type="button" class="btn btn-sm btn-primary txt">Export TXT</button>
                            <button type="button" class="btn btn-sm btn-primary json">Export JSON</button> --}}
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div><!--end row-->


        {{-- voir le script equivalent dans layouts script... --}}

    </div>
    <!-- container -->
    <!--Start Rightbar-->
    <!--Start Rightbar/offcanvas-->
    {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="Appearance" aria-labelledby="AppearanceLabel">
        <div class="offcanvas-header border-bottom justify-content-between">
            <h5 class="m-0 font-14" id="AppearanceLabel">Appearance</h5>
            <button type="button" class="btn-close text-reset p-0 m-0 align-self-center" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <h6>Account Settings</h6>
            <div class="p-2 text-start mt-3">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="settings-switch1">
                    <label class="form-check-label" for="settings-switch1">Auto updates</label>
                </div><!--end form-switch-->
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="settings-switch2" checked>
                    <label class="form-check-label" for="settings-switch2">Location Permission</label>
                </div><!--end form-switch-->
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="settings-switch3">
                    <label class="form-check-label" for="settings-switch3">Show offline Contacts</label>
                </div><!--end form-switch-->
            </div><!--end /div-->
            <h6>General Settings</h6>
            <div class="p-2 text-start mt-3">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="settings-switch4">
                    <label class="form-check-label" for="settings-switch4">Show me Online</label>
                </div><!--end form-switch-->
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="settings-switch5" checked>
                    <label class="form-check-label" for="settings-switch5">Status visible to all</label>
                </div><!--end form-switch-->
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="settings-switch6">
                    <label class="form-check-label" for="settings-switch6">Notifications Popup</label>
                </div><!--end form-switch-->
            </div><!--end /div-->
        </div><!--end offcanvas-body-->
    </div> --}}
    <!--end Rightbar/offcanvas-->
    <!--end Rightbar-->
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
