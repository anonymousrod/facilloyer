{{-- @extends('layouts.master_dash')

@section('title', '📢 Mes Notifications')

@section('content')
    <div class="container py-4">
        <!-- Titre -->
        <div>
            <h2 class="fw-bold">📢 Mes Notifications</h2>
        </div>

        <!-- Boutons et Actions -->
        <div class="d-flex flex-wrap align-items-center mb-4 gap-2">
            <button id="filter-all" class="btn btn-outline-primary btn-sm active">Tout</button>
            <button id="filter-unread" class="btn btn-outline-secondary btn-sm">Non lu</button>

            <form action="{{ route('notifications.read-all') }}" method="POST" id="mark-all-read">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm mt-2">
                    <i class="fas fa-check-double"></i> Tout marquer comme lu
                </button>
            </form>

            <button id="delete-all" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i> Tout supprimer
            </button>
        </div>

        <!-- Liste des notifications -->
        <div class="list-group" id="notifications-container">
            @include('layouts.notification_liste', ['notifications' => $notifications])
        </div>
    </div>
@endsection --}}

@extends('layouts.master_dash')

@section('title', '📢 Mes Notifications')

@section('content')
    <div class="container py-4">
        <!-- Titre -->
        <div>
            <h2 class="fw-bold">📢 Mes Notifications</h2>
        </div>

        <!-- Boutons et Actions -->
        <div class="d-flex flex-wrap align-items-center mb-4 gap-2">
            <button id="filter-all" class="btn btn-outline-primary btn-sm active">Tout</button>
            <button id="filter-unread" class="btn btn-outline-secondary btn-sm">Non lu</button>

            @if ($notifications->count() > 0)
                <!-- Afficher le bouton "Marquer tout comme lu" si au moins une notification est non lue -->
                @if ($notifications->where('is_read', false)->count() > 0)
                    <form action="{{ route('notifications.read-all') }}" method="POST" id="mark-all-read">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-check-double"></i> Tout marquer comme lu
                        </button>
                    </form>
                @endif

                <!-- Afficher le bouton "Tout supprimer" -->
                <button id="delete-all" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Tout supprimer
                </button>
            @endif
        </div>

        <!-- Liste des notifications -->
        <div class="list-group" id="notifications-container">
            @include('layouts.notification_liste', ['notifications' => $notifications])
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function fetchNotifications(filter) {
            fetch("{{ route('notifications.fetch') }}?filter=" + filter)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('notifications-container').innerHTML = data.html;
                    attachEventListeners(); // Réattacher les événements après mise à jour
                })
                .catch(error => console.error("Erreur lors du chargement des notifications :", error));
        }

        // Appliquer le filtre "Tout"
        document.getElementById('filter-all').addEventListener('click', function() {
            fetchNotifications('all');
            this.classList.add('active');
            document.getElementById('filter-unread').classList.remove('active');
        });

        // Appliquer le filtre "Non lu"
        document.getElementById('filter-unread').addEventListener('click', function() {
            fetchNotifications('unread');
            this.classList.add('active');
            document.getElementById('filter-all').classList.remove('active');
        });

        // Marquer toutes les notifications comme lues
        document.getElementById('mark-all-read').addEventListener('submit', function(event) {
            event.preventDefault();
            fetch("{{ route('notifications.read-all') }}", {
                method: "POST",
                body: new FormData(this)
            }).then(() => fetchNotifications('all'));
        });

        // Supprimer toutes les notifications
        document.getElementById('delete-all').addEventListener('click', function() {
            if (confirm("Êtes-vous sûr de vouloir supprimer toutes les notifications ?")) {
                fetch("{{ route('notifications.delete-all') }}", {
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json'
                    }
                }).then(() => fetchNotifications('all'));
            }
        });

        // Attacher les événements aux boutons après mise à jour AJAX
        function attachEventListeners() {
            document.querySelectorAll('.delete-notification').forEach(button => {
                button.addEventListener('click', function() {
                    let notificationId = this.dataset.id;
                    if (confirm("Voulez-vous vraiment supprimer cette notification ?")) {
                        fetch("/notifications/" + notificationId, {
                            method: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Content-Type': 'application/json'
                            }
                        }).then(() => fetchNotifications('all'));
                    }
                });
            });

            document.querySelectorAll('.mark-read-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    fetch(this.action, {
                        method: "POST",
                        body: new FormData(this)
                    }).then(() => fetchNotifications('all'));
                });
            });
        }

        attachEventListeners(); // Appliquer au chargement initial
    });
</script>
