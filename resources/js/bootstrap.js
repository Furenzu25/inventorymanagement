import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY || 'your-key-here',
    wsHost: window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT || 8080,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
    cluster: 'mt1',
    disableStats: true,
});

window.Echo.connector.pusher.connection.bind('error', (error) => {
    console.error('Echo connection error:', error);
});

window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('Successfully connected to Reverb!');
});

window.Echo.channel(`product.1`)  // Replace 1 with your test product ID
    .listen('ReviewSubmitted', (e) => {
        console.log('Received review:', e);
    }); 
    