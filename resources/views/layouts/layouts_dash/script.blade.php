<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}} "></script>

<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}} "></script>
<script src="{{asset('assets/data/stock-prices.js')}} "></script>
<script src="{{asset('assets/libs/jsvectormap/js/jsvectormap.min.js')}} "></script>
<script src="{{asset('assets/libs/jsvectormap/maps/world.js')}} "></script>
<script src="{{asset('assets/js/pages/index.init.js')}} "></script>
<script src="{{asset('assets/js/app.js')}} "></script>

{{-- script pour tables --}}

<script src="{{asset('assets/libs/simple-datatables/umd/simple-datatables.js')}} "></script>
<script src="{{asset('assets/js/pages/datatable.init.js')}} "></script>
 <!-- script pour page edit -->

<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/tobii/js/tobii.min.js"></script>
<script src="assets/js/pages/profile.init.js"></script>

{{-- script pour l'activation du statu par l'agent immobilier --}}

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


{{-- script pour le calendrier --}}

<script src="assets/libs/fullcalendar/index.global.min.js"></script>
<script src="assets/js/pages/calendar.init.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> --}}



<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js'></script>

<!-- pour les icones -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
