<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusher WebSocket Test Client</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.4.0-rc2/pusher.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success { background-color: #28a745; }
        .danger { background-color: #dc3545; }
        .warning { background-color: #ffc107; color: #333; }
        
        .log-container {
            background-color: #1e1e1e;
            color: #00ff00;
            padding: 15px;
            border-radius: 5px;
            height: 300px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin-top: 20px;
        }
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .connected { background-color: #28a745; }
        .disconnected { background-color: #dc3545; }
        .connection-status {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .test-section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
        .test-section h3 {
            margin-top: 0;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Pusher WebSocket Test Client</h1>
        
        <div id="connectionStatus" class="connection-status">
            <span class="status-indicator disconnected"></span>
            Status: Disconnected
        </div>

        <div class="test-section">
            <h3>⚙️ Configuration</h3>
            <div class="form-group">
                <label for="pusherKey">Pusher App Key:</label>
                <input type="text" id="pusherKey" placeholder="Enter your Pusher app key">
            </div>
            <div class="form-group">
                <label for="pusherCluster">Pusher Cluster:</label>
                <input type="text" id="pusherCluster" value="mt1" placeholder="e.g., mt1, us2, eu">
            </div>
            <div class="form-group">
                <label for="authToken">Auth Token (Bearer):</label>
                <input type="text" id="authToken" placeholder="Your Laravel Sanctum token">
            </div>
            <button onclick="connectPusher()">Connect to Pusher</button>
            <button onclick="disconnectPusher()" class="danger">Disconnect</button>
        </div>

        <div class="test-section">
            <h3>📡 Channel Subscriptions</h3>
            <div class="form-group">
                <label for="userId">User ID (for private channels):</label>
                <input type="number" id="userId" placeholder="Enter user ID">
            </div>
            <button onclick="subscribeToChannels()">Subscribe to All Channels</button>
            <button onclick="unsubscribeFromChannels()" class="warning">Unsubscribe All</button>
        </div>

        <div class="test-section">
            <h3>💬 Test Message Sending</h3>
            <div class="form-group">
                <label for="recipientId">Recipient User ID:</label>
                <input type="number" id="recipientId" placeholder="Enter recipient ID">
            </div>
            <div class="form-group">
                <label for="testMessage">Test Message:</label>
                <textarea id="testMessage" rows="3" placeholder="Enter your test message"></textarea>
            </div>
            <button onclick="sendTestMessage()">Send Message via API</button>
        </div>

        <div class="test-section">
            <h3>⌨️ Test Typing Indicator</h3>
            <button onclick="sendTyping(true)" class="success">Start Typing</button>
            <button onclick="sendTyping(false)" class="warning">Stop Typing</button>
        </div>

        <div class="test-section">
            <h3>👥 Test User Status</h3>
            <button onclick="setUserStatus('online')" class="success">Set Online</button>
            <button onclick="setUserStatus('offline')" class="danger">Set Offline</button>
        </div>

        <div class="form-group">
            <label>📊 Real-time Event Log:</label>
            <div id="logContainer" class="log-container">
                <div>WebSocket Test Client Ready...</div>
                <div>Configure your Pusher credentials above and click Connect.</div>
            </div>
        </div>

        <button onclick="clearLog()" class="warning">Clear Log</button>
    </div>

    <script>
        let pusher = null;
        let channels = {};
        
        function log(message, type = 'info') {
            const logContainer = document.getElementById('logContainer');
            const timestamp = new Date().toLocaleTimeString();
            const logEntry = document.createElement('div');
            logEntry.innerHTML = `[${timestamp}] ${message}`;
            logEntry.style.color = type === 'error' ? '#ff6b6b' : 
                                 type === 'success' ? '#51cf66' : 
                                 type === 'warning' ? '#ffd43b' : '#00ff00';
            logContainer.appendChild(logEntry);
            logContainer.scrollTop = logContainer.scrollHeight;
        }

        function updateConnectionStatus(connected) {
            const statusEl = document.getElementById('connectionStatus');
            const indicator = statusEl.querySelector('.status-indicator');
            
            if (connected) {
                statusEl.innerHTML = '<span class="status-indicator connected"></span>Status: Connected';
                statusEl.className = 'connection-status success';
            } else {
                statusEl.innerHTML = '<span class="status-indicator disconnected"></span>Status: Disconnected';
                statusEl.className = 'connection-status danger';
            }
        }

        function connectPusher() {
            const key = document.getElementById('pusherKey').value;
            const cluster = document.getElementById('pusherCluster').value;
            const token = document.getElementById('authToken').value;

            if (!key || !cluster) {
                log('Please enter Pusher key and cluster', 'error');
                return;
            }

            log('Connecting to Pusher...', 'warning');

            pusher = new Pusher(key, {
                cluster: cluster,
                encrypted: true,
                authEndpoint: '/api/broadcasting/auth',
                auth: {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }
            });

            pusher.connection.bind('connected', () => {
                log('Successfully connected to Pusher!', 'success');
                updateConnectionStatus(true);
            });

            pusher.connection.bind('disconnected', () => {
                log('Disconnected from Pusher', 'warning');
                updateConnectionStatus(false);
            });

            pusher.connection.bind('error', (error) => {
                log(`Connection error: ${JSON.stringify(error)}`, 'error');
            });
        }

        function disconnectPusher() {
            if (pusher) {
                pusher.disconnect();
                pusher = null;
                channels = {};
                log('Disconnected from Pusher', 'warning');
                updateConnectionStatus(false);
            }
        }

        function subscribeToChannels() {
            if (!pusher) {
                log('Connect to Pusher first!', 'error');
                return;
            }

            const userId = document.getElementById('userId').value;
            if (!userId) {
                log('Enter User ID first!', 'error');
                return;
            }

            // Subscribe to private chat channel
            channels.chat = pusher.subscribe(`private-chat.${userId}`);
            channels.chat.bind('message.sent', (data) => {
                log(`📨 New message from User ${data.message.from_id}: ${data.message.body}`, 'success');
            });
            channels.chat.bind('message.deleted', (data) => {
                log(`🗑️ Message deleted: ${data.message.id}`, 'warning');
            });
            channels.chat.bind('user.typing', (data) => {
                log(`⌨️ User ${data.user.name} is ${data.is_typing ? 'typing' : 'stopped typing'}`, 'info');
            });

            // Subscribe to user status channel
            channels.userStatus = pusher.subscribe('user-status');
            channels.userStatus.bind('user.online', (data) => {
                log(`🟢 User ${data.user.name} came online`, 'success');
            });
            channels.userStatus.bind('user.offline', (data) => {
                log(`🔴 User ${data.user.name} went offline`, 'warning');
            });

            // Subscribe to online users presence channel
            channels.onlineUsers = pusher.subscribe('presence-online-users');
            channels.onlineUsers.bind('pusher:subscription_succeeded', (members) => {
                log(`👥 Joined online users channel. ${members.count} users online`, 'success');
            });
            channels.onlineUsers.bind('pusher:member_added', (member) => {
                log(`➕ ${member.info.name} joined online users`, 'success');
            });
            channels.onlineUsers.bind('pusher:member_removed', (member) => {
                log(`➖ ${member.info.name} left online users`, 'warning');
            });

            log('Subscribed to all channels!', 'success');
        }

        function unsubscribeFromChannels() {
            Object.keys(channels).forEach(channelName => {
                if (channels[channelName]) {
                    pusher.unsubscribe(channels[channelName].name);
                    delete channels[channelName];
                }
            });
            log('Unsubscribed from all channels', 'warning');
        }

        async function sendTestMessage() {
            const recipientId = document.getElementById('recipientId').value;
            const message = document.getElementById('testMessage').value;
            const token = document.getElementById('authToken').value;

            if (!recipientId || !message || !token) {
                log('Please fill in recipient ID, message, and auth token', 'error');
                return;
            }

            try {
                const response = await fetch(`https://xlserp.com/customersupport/api/chat/conversations/${recipientId}/messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({
                        message: message
                    })
                });

                const result = await response.json();
                if (response.ok) {
                    log(`✅ Message sent successfully! ID: ${result.data.id}`, 'success');
                    document.getElementById('testMessage').value = '';
                } else {
                    log(`❌ Failed to send message: ${result.message}`, 'error');
                }
            } catch (error) {
                log(`❌ Network error: ${error.message}`, 'error');
            }
        }

        async function sendTyping(isTyping) {
            const recipientId = document.getElementById('recipientId').value;
            const token = document.getElementById('authToken').value;

            if (!recipientId || !token) {
                log('Please fill in recipient ID and auth token', 'error');
                return;
            }

            try {
                const response = await fetch(`https://xlserp.com/customersupport/api/chat/conversations/${recipientId}/typing`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({
                        is_typing: isTyping
                    })
                });

                const result = await response.json();
                if (response.ok) {
                    log(`⌨️ Typing status sent: ${isTyping ? 'typing' : 'stopped'}`, 'success');
                } else {
                    log(`❌ Failed to send typing status: ${result.message}`, 'error');
                }
            } catch (error) {
                log(`❌ Network error: ${error.message}`, 'error');
            }
        }

        async function setUserStatus(status) {
            const token = document.getElementById('authToken').value;

            if (!token) {
                log('Please enter auth token', 'error');
                return;
            }

            try {
                const response = await fetch(`https://xlserp.com/customersupport/api/chat/status/online`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const result = await response.json();
                if (response.ok) {
                    log(`🔄 User status set to: ${status}`, 'success');
                } else {
                    log(`❌ Failed to set status: ${result.message}`, 'error');
                }
            } catch (error) {
                log(`❌ Network error: ${error.message}`, 'error');
            }
        }

        function clearLog() {
            document.getElementById('logContainer').innerHTML = '<div>Log cleared...</div>';
        }
    </script>
</body>
</html>