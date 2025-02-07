import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: window.PUSHER_APP_KEY,
//     cluster: window.PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

// Echo.private('App.Models.User.' + userID)
//     .listen('HouseAssigned', (event) => {
//         console.log(event);
//         // Mettre à jour l'interface utilisateur avec la notification
//     });
