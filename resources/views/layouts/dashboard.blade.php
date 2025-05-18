@extends('layouts.master_dash')

@section('title', 'Dashboard')

@section('content')
    @if ($message)
        <div class="alert alert-warning text-center fade show" role="alert">
            <h5 class="text-warning mb-0">{{ $message }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (isset($statut))
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="card-title mb-0">Calendrier des événements</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-9">
                            <div id='calendar' class="mb-4"></div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-calendar-plus"></i> Nouvel Événement</h5>
                                </div>
                                <div class="card-body">
                                    <form id="eventForm">
                                        <div class="mb-3">
                                            <label for="eventTitle" class="form-label fw-bold">Titre de l'événement</label>
                                            <input type="text" class="form-control form-control-lg" id="eventTitle"
                                                   placeholder="Ex: Réunion importante" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="eventDate" class="form-label fw-bold">Date</label>
                                            <input type="date" class="form-control form-control-lg" id="eventDate" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="eventDescription" class="form-label fw-bold">Description</label>
                                            <textarea class="form-control" id="eventDescription" rows="4"
                                                      placeholder="Détails de l'événement..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="fas fa-save"></i> Enregistrer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: [], // Liste initiale vide

            // Affichage des détails lors du clic sur un événement
            eventClick: function (info) {
                alert(
                    `Titre : ${info.event.title}\n` +
                    `Date : ${info.event.start.toLocaleDateString()}\n` +
                    `Description : ${info.event.extendedProps.description}`
                );
            },
        });

        calendar.render();

        // Formulaire d'ajout d'événements
        const eventForm = document.getElementById('eventForm');
        eventForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Empêcher le rechargement de la page

            // Récupération des données du formulaire
            const title = document.getElementById('eventTitle').value.trim();
            const date = document.getElementById('eventDate').value;
            const description = document.getElementById('eventDescription').value.trim();

            // Vérification des champs
            if (!title || !date) {
                alert("Veuillez remplir tous les champs obligatoires.");
                return;
            }

            // Ajout de l'événement au calendrier
            calendar.addEvent({
                title: title,
                start: date,
                description: description,
            });

            // Réinitialisation du formulaire
            eventForm.reset();

            // Message de confirmation
            alert('L\'événement a été ajouté au calendrier avec succès !');
        });
    });
</script>
@endsection
