<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


// Private channel for each user's chat
Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Public channel for user status updates
Broadcast::channel('user-status', function ($user) {
    return true; // Anyone can listen to user status updates
});

// Presence channel for online users
Broadcast::channel('online-users', function ($user) {
    return [
        'id' => $user->id,
        'name' => $user->name,
        'avatar' => $user->avatar,
        'last_seen' => $user->last_seen,
    ];
});

// Presence channel for specific conversation
Broadcast::channel('conversation.{userId1}.{userId2}', function ($user, $userId1, $userId2) {
    $canJoin = (int) $user->id === (int) $userId1 || (int) $user->id === (int) $userId2;
    
    return $canJoin ? [
        'id' => $user->id,
        'name' => $user->name,
        'avatar' => $user->avatar,
        'last_seen' => $user->last_seen,
    ] : null;
});