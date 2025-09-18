// laravel-echo-config.js

import Echo from "laravel-echo";

window.Pusher = require("pusher-js");

const echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
    forceTLS: true,
});

export default echo;
