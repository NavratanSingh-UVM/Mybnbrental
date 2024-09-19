/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
//window.Pusher = Pusher;
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    // key: 'd0a91336f1bdc2aeaac6',
    key:'05c1d7b28caa907a92e6',
     wsHost: 'mybnbrentals.com',
     wssHost: 'mybnbrentals.com',
     wsPort: 6002,
     wssPort: 6002,
     forceTLS: true,
     disableStats: false,
     enabledTransports: ['ws', 'wss'],
    disableStats: true,
    forceTLS: false, 
    //<<<<=====CHANGE THIS
    enabledTransports: ['ws', 'wss']
});

window.Echo.channel('Chat-message').listen('NewMessage',(e)=>{
    console.log(e)
})

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'ap2',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 6001,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });


// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'd0a91336f1bdc2aeaac6',
//     //cluster: 'ap1',
//     //encrypted: false,
//     wsHost: window.location.hostname,
//     wsPort: 6001,
//     wssPort: 6001,
//     disableStats: true,
//     enabledTransports: ['ws', 'wss']
//     //cluster: 'ap1'
//     //encrypted: true
// });
var channel = Echo.channel("APPL");
channel.listen("new-price", (data) => {
    console.log('hello');
  // add new price into the APPL widget
});
