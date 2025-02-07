<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }} "></script>

<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }} "></script>
<script src="{{ asset('assets/data/stock-prices.js') }} "></script>
<script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }} "></script>
<script src="{{ asset('assets/libs/jsvectormap/maps/world.js') }} "></script>
<script src="{{ asset('assets/js/pages/index.init.js') }} "></script>
<script src="{{ asset('assets/js/app.js') }} "></script>

{{-- script pour tables --}}

<script src="{{ asset('assets/libs/simple-datatables/umd/simple-datatables.js') }} "></script>
<script src="{{ asset('assets/js/pages/datatable.init.js') }} "></script>
<!-- script pour page edit -->

<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/tobii/js/tobii.min.js"></script>
<script src="assets/js/pages/profile.init.js"></script>

{{-- script pour l'activation du statu par l'agent immobilier --}}

<script>
    toggleStatusButtons.forEach(button => {
        button.addEventListener('change', function() {
            const locataireId = this.dataset.id;
            const isChecked = this.checked;
            const statusLabel = this.nextElementSibling;

            // Confirmation message
            const confirmation = confirm(
                `Êtes-vous sûr de vouloir ${isChecked ? 'activer' : 'désactiver'} ce locataire ?`
            );

            if (confirmation) {
                // Envoyer la requête au backend pour mettre à jour le statut
                fetch(`/locataires/${locataireId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            statut: isChecked
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            statusLabel.textContent = isChecked ? 'Activé' :
                                'Désactivé';
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

{{-- script pour voir plus de la page bien_detail --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var seeMoreBtn = document.getElementById("see-more-btn");
        var contratDetails = document.getElementById("contrat-details");

        seeMoreBtn.addEventListener("click", function() {
            if (contratDetails.style.display === "none") {
                contratDetails.style.display = "block";
                seeMoreBtn.textContent = "Voir moins";
            } else {
                contratDetails.style.display = "none";
                seeMoreBtn.textContent = "Voir plus";
            }
        });
    });
</script>

{{-- script pour js signature_pad --}}
{{-- <script src=" {{ asset('node_modules/signature_pad/dist/signature_pad.umd.min.js')}} "></script> --}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/signature_pad"></script> --}}


{{--
<script>
    // Fonction d'initialisation pour SignaturePad Agent Immobilier
    var signatureAgentCanvas = document.getElementById('signature-pad');

    if (signatureAgentCanvas) {
        var signatureAgentPad = new SignaturePad(signatureAgentCanvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)', // Fond transparent
            penColor: 'black'
        });

        document.getElementById('clearAgent').addEventListener('click', function() {
            signatureAgentPad.clear();
        });
    }

    // Fonction d'initialisation pour SignaturePad Locataire
    var signatureLocataireCanvas = document.getElementById('signatureLocataire');
    if (signatureLocataireCanvas) {
        var signatureLocatairePad = new SignaturePad(signatureLocataireCanvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'black'
        });

        document.getElementById('clearLocataire').addEventListener('click', function() {
            signatureLocatairePad.clear();
        });
    }
</script>
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        // Capture la signature de l'agent immobilier
        if (signatureAgentPad && !signatureAgentPad.isEmpty()) {
            document.getElementById('signatureAgentInput').value = signatureAgentPad.toDataURL('image/png');
        }

        // Capture la signature du locataire
        if (signatureLocatairePad && !signatureLocatairePad.isEmpty()) {
            document.getElementById('signatureLocataireInput').value = signatureLocatairePad.toDataURL(
                'image/png');
        }

        // Vérification dans la console des valeurs des champs cachés
        console.log(document.getElementById('signatureAgentInput').value);
        console.log(document.getElementById('signatureLocataireInput').value);
    });
</script> --}}

<!-- Définir userID pour le script -->
<script>
    window.userID = {{ auth()->user()->id }};
</script>



<!-- Scripts pour les notifications en temps réel -->
@vite(['resources/js/app.js'])
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher-js/7.0.3/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script> --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (!window.userID) {
            window.userID = "{{ auth()->id() }}";
        }

        if (window.userID) {
            // // Initialiser Laravel Echo et Pusher
            // window.Echo = new Echo({
            //     broadcaster: 'pusher',
            //     key: "{{ env('PUSHER_APP_KEY') }}",
            //     cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            //     forceTLS: true,
            //     encrypted: true
            // });

            // Écouter les notifications en temps réel
            window.Echo.private(`App.Models.User.${window.userID}`)
                .notification((notification) => {
                    console.log("🔔 Nouvelle notification reçue :", notification);

                    // Jouer le son de notification
                    let audio = new Audio('/notification.mp3');
                    audio.play().catch(error => console.log("🎵 Erreur de lecture audio :", error));

                    // Mettre à jour le badge de notification
                    let badge = document.getElementById("notif-badge");
                    if (badge) {
                        let count = parseInt(badge.innerText) || 0;
                        badge.innerText = count + 1;
                        badge.classList.remove('hidden');
                    }

                    // Ajouter la notification dans la liste
                    let notifList = document.getElementById("notif-list");
                    if (notifList) {
                        let notifItem = document.createElement("a");
                        notifItem.href = notification.url;
                        notifItem.classList.add("block", "p-4", "hover:bg-gray-100");
                        notifItem.innerText = notification.message;
                        notifList.prepend(notifItem);
                    }
                });
        }
    });
</script>
