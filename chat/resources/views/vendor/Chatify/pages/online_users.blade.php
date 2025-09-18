@include('Chatify::layouts.headLinks')
<h1>Online Users</h1>
<ul id="online-users-list">

</ul>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch online users when the page loads
            fetchOnlineUsers();

            // Function to fetch online users and update the view
            function fetchOnlineUsers() {
                $.ajax({
                    url: '/api/online-users', // Use the correct API endpoint
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        displayOnlineUsers(response);
                    },
                    error: function(error) {
                        console.error('Error fetching online users:', error);
                    }
                });
            }

            // Function to display online users
            function displayOnlineUsers(onlineUsers) {
                var onlineUsersList = $('#online-users-list');
                onlineUsersList.empty();

                onlineUsers.forEach(function(user) {
                    onlineUsersList.append('<li>' + user.name + ' - ' + user.status + '</li>');
                });
            }

            // Update online users every 30 seconds (adjust as needed)
            setInterval(fetchOnlineUsers, 30000);
        });
    </script>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')
