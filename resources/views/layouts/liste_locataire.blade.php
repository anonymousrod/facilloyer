@extends('layouts.master_dash')
@section('title', 'Liste des locataires')
@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="mb-3 card-header d-flex justify-content-between align-items-center animate__animated animate__fadeInDown"
                        style="background: linear-gradient(90deg, #28a745 60%, #43e97b 100%); color: #fff; box-shadow: 0 4px 16px rgba(40,167,69,0.15); border-radius: 18px 18px 0 0; border: none;">
                        <h4 class="card-title mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-users"></i>
                            <span>Liste des Locataires</span>
                        </h4>
                        <a href="{{ route('export.pdf') }}" class="btn btn-light btn-sm shadow-sm animate__animated animate__pulse animate__infinite" style="font-weight: bold; border-radius: 20px;">
                            <i class="fas fa-file-pdf text-danger"></i> Exporter en PDF
                        </a>
                    </div>
                    <div class="card-body pt-0 animate__animated animate__fadeInUp" style=" border-radius: 0 0 18px 18px;">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle datatable" id="datatable_2" style="border-radius: 12px; overflow: hidden;">
                                <thead >
                                    <tr>
                                        <th><i class="fas fa-image"></i> Photo</th>
                                        <th><i class="fas fa-user"></i> Nom complet</th>
                                        <th><i class="fas fa-phone"></i> Téléphone</th>
                                        <th><i class="fas fa-map-marker-alt"></i> Adresse</th>
                                        <th><i class="fas fa-money-bill-wave"></i> Revenus mensuels</th>
                                        <th><i class="fas fa-toggle-on"></i> Statut</th>
                                        <th><i class="fas fa-cogs"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locataires as $locataire)
                                        <tr class="animate__animated animate__fadeIn animate__faster" style="transition: box-shadow 0.2s;">
                                            <td>
                                                @if ($locataire->photo_profil == null)
                                                    <img src="{{ asset('assets/images/users/image.png') }}"
                                                        alt="profil de {{ $locataire->nom . ' ' . $locataire->prenom }}"
                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #28a745; box-shadow: 0 2px 8px rgba(40,167,69,0.08); transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                                                @else
                                                    <img src="{{ asset($locataire->photo_profil) }}"
                                                        alt="profil de {{ $locataire->nom . ' ' . $locataire->prenom }}"
                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #28a745; box-shadow: 0 2px 8px rgba(40,167,69,0.08); transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">

                                                @endif
                                            </td>
                                            <td><span class="fw-bold text-dark">{{ ($locataire->nom ?? '') . ' ' . ($locataire->prenom ?? '') }}</span></td>
                                            <td>
                                                @if (!empty($locataire->telephone))
                                                    <span class="badge bg-light text-success shadow-sm"><i class="fas fa-phone-alt"></i> {{ $locataire->telephone }}</span>
                                                @else
                                                    <span class="badge bg-light text-danger shadow-sm"><i class="fas fa-phone-slash"></i> Non renseigné</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($locataire->adresse))
                                                    <span class="text-muted">{{ \Illuminate\Support\Str::words($locataire->adresse, 2, '...') }}</span>
                                                @else
                                                    <span class="text-danger">Non renseignée</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($locataire->revenu_mensuel))
                                                    <span class="badge bg-success bg-opacity-10 text-success fw-semibold">{{ $locataire->revenu_mensuel }} FCFA</span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger fw-semibold">Non renseigné</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <label class="switch-custom mb-0">
                                                        <input class="toggle-status" type="checkbox"
                                                            id="status_{{ $locataire->id }}" data-id="{{ $locataire->id }}"
                                                            {{ $locataire->user->statut ? 'checked' : '' }}>
                                                        <span class="slider-custom"></span>
                                                    </label>
                                                    <span class="status-indicator ms-2" id="status_label_{{ $locataire->id }}">
                                                        @if($locataire->user->statut)
                                                            <i class="fas fa-check-circle text-success"></i>
                                                        @else
                                                            <i class="fas fa-times-circle text-danger"></i>
                                                        @endif
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('locataire.locashow', $locataire->user->id) }}" class="btn btn-link p-0 me-2 btn-circle-eye" title="Voir détails">
                                                    <i class="fas fa-eye icon-voir-details-custom"></i>
                                                </a>
                                                <a href="{{ route('user', $locataire->user->id) }}" class="btn btn-outline-success btn-circle" title="Chat" style="border-radius: 50%; width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 2px 8px rgba(40,167,69,0.08);">
                                                    <i class="fas fa-comments"></i>
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
                            // Mise à jour de l'icône et de la couleur
                            const indicator = document.getElementById('status_label_' + locataireId);
                            if (isChecked) {
                                indicator.innerHTML = '<i class="fas fa-check-circle text-success"></i>';
                            } else {
                                indicator.innerHTML = '<i class="fas fa-times-circle text-danger"></i>';
                            }
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

<!-- Animation CSS (Animate.css CDN) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<!-- FontAwesome CDN (si pas déjà inclus) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
<style>
    .table thead th {
        border: none;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .table-hover tbody tr:hover {
        background: #374151; /* gris foncé neutre, lisible en dark mode */
        color: #fff;
        box-shadow: 0 2px 12px rgba(55,65,81,0.10);
        transition: background 0.2s, box-shadow 0.2s, color 0.2s;
    }
    .btn-circle {
        border-radius: 50% !important;
        width: 38px;
        height: 38px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .btn-circle-eye {
        border-radius: 50% !important;
        width: 38px;
        height: 38px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent; /* cercle transparent */
        border: 2px solid #28a745;
        box-shadow: 0 2px 8px rgba(40,167,69,0.08);
        transition: background 0.2s, border 0.2s;
    }
    .btn-circle-eye:hover {
        background: #28a745;
        border-color: #43e97b;
    }
    .badge {
        font-size: 1em;
        padding: 0.5em 0.8em;
        border-radius: 12px;
    }

    /* Nouveau switch custom */
    .switch-custom {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
    .switch-custom input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider-custom {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background: #e4e4e4;
        border-radius: 24px;
        transition: background 0.3s;
    }
    .switch-custom input:checked + .slider-custom {
        background: linear-gradient(90deg, #28a745 60%, #43e97b 100%);
    }
    .slider-custom:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(40,167,69,0.10);
        transition: transform 0.3s;
    }
    .switch-custom input:checked + .slider-custom:before {
        transform: translateX(20px);
    }
    .status-indicator {
        font-size: 1.3em;
        display: flex;
        align-items: center;
        min-width: 28px;
        justify-content: center;
    }
    .icon-voir-details-custom {
        color: #28a745;
        font-size: 1.2rem;
        transition: color 0.2s;
        font-weight: bold;
    }
    .btn-circle-eye:hover .icon-voir-details-custom {
        color: #fff;
    }
    @media (prefers-color-scheme: dark) {
        .btn-circle-eye {
            background: transparent; /* reste transparent même en dark mode */
            border: 2px solid #43e97b;
        }
        .icon-voir-details-custom {
            color: #43e97b !important;
        }
        .btn-circle-eye:hover {
            background: #43e97b;
            border-color: #28a745;
        }
        .btn-circle-eye:hover .icon-voir-details-custom {
            color: #212529 !important;
        }
    }
</style>

@endsection
