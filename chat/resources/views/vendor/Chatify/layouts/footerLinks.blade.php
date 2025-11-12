<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script >
    // Gloabl Chatify variables from PHP to JS
    window.chatify = {
        name: "{{ config('chatify.name') }}",
        sounds: {!! json_encode(config('chatify.sounds')) !!},
        allowedImages: {!! json_encode(config('chatify.attachments.allowed_images')) !!},
        allowedFiles: {!! json_encode(config('chatify.attachments.allowed_files')) !!},
        maxUploadSize: {{ Chatify::getMaxUploadSize() }},
        pusher: {!! json_encode(config('chatify.pusher')) !!},
        pusherAuthEndpoint: '{{route("pusher.auth")}}'
    };
    window.chatify.allAllowedExtensions = chatify.allowedImages.concat(chatify.allowedFiles);
</script>
<script src="{{ asset('js/chatify/utils.js') }}"></script>
<script src="{{ asset('js/chatify/code.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/chatify/laravel-echo-config.js') }}"></script>
<script src="https://simplewebrtc.com/latest-v3.js"></script>
<script src="https://cdn.socket.io/4.1.2/socket.io.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ config("broadcasting.connections.pusher.key") }}',
            cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
            encrypted: true,
            forceTLS: true,
        });

        var webrtc;

        // Event listeners for call buttons
        document.getElementById('initiate-call').addEventListener('click', function() {
            initiateCall();
        });

        document.getElementById('answer-call').addEventListener('click', function() {
            answerCall();
        });

        document.getElementById('end-call').addEventListener('click', function() {
            endCall();
        });

       // ... (your existing code)

document.addEventListener('DOMContentLoaded', function() {
    var echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ config("broadcasting.connections.pusher.key") }}',
        cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
        encrypted: true,
        forceTLS: true,
    });

    var webrtc;

    // Event listeners for call buttons
    document.getElementById('initiate-call').addEventListener('click', function() {
        initiateCall();
    });

    document.getElementById('answer-call').addEventListener('click', function() {
        answerCall();
    });

    document.getElementById('end-call').addEventListener('click', function() {
        endCall();
    });

    // Laravel Echo event listeners
    echo.channel('your-call-channel')
        .listen('CallInitiated', function (event) {
            // Handle call initiated event
            console.log('Call initiated:', event);

            // Update UI
            document.getElementById('initiate-call').style.display = 'none';
            document.getElementById('answer-call').style.display = 'block';
            document.getElementById('call-status').innerHTML = 'Incoming call...';
        })
        .listen('CallAnswered', function (event) {
            // Handle call answered event
            console.log('Call answered:', event);

            // Update UI
            document.getElementById('answer-call').style.display = 'none';
            document.getElementById('end-call').style.display = 'block';
            document.getElementById('call-status').innerHTML = 'Call in progress...';
        })
        .listen('CallEnded', function (event) {
            // Handle call ended event
            console.log('Call ended:', event);

            // Update UI
            document.getElementById('initiate-call').style.display = 'block';
            document.getElementById('answer-call').style.display = 'none';
            document.getElementById('end-call').style.display = 'none';
            document.getElementById('call-status').innerHTML = 'Call ended';

            // Stop SimpleWebRTC
            if (webrtc) {
                webrtc.stopLocalVideo();
                webrtc.leaveRoom();
            }
        });

    function initiateCall() {
        // Broadcast an event to Laravel Echo
        echo.channel('your-call-channel')
            .whisper('call-initiated', {
                // Additional data if needed
            });
        
        // Update UI
        document.getElementById('initiate-call').style.display = 'none';
        document.getElementById('answer-call').style.display = 'block';
        document.getElementById('call-status').innerHTML = 'Calling...';
    }

    function answerCall() {
        // Broadcast an event to Laravel Echo
        echo.channel('your-call-channel')
            .whisper('call-answered', {
                // Additional data if needed
            });
        
        // Update UI
        document.getElementById('answer-call').style.display = 'none';
        document.getElementById('end-call').style.display = 'block';
        document.getElementById('call-status').innerHTML = 'Call in progress...';
    }

    function endCall() {
        // Broadcast an event to Laravel Echo
        echo.channel('your-call-channel')
            .whisper('call-ended', {
                // Additional data if needed
            });
        
        // Update UI
        document.getElementById('initiate-call').style.display = 'block';
        document.getElementById('answer-call').style.display = 'none';
        document.getElementById('end-call').style.display = 'none';
        document.getElementById('call-status').innerHTML = 'Call ended';
    }
});

</script>
