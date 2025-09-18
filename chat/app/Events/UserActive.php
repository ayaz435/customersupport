<?php

namespace App\Events;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserActive implements ShouldBroadcast
{
    use SerializesModels;

    public $userId;
    public $userName;

    public function __construct($userId, $userName)
    {
        $this->userId   = $userId;
        $this->userName = $userName;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('presence-activeStatus');
    }

    public function broadcastAs()
    {
        // simulate member added
        return 'member_added';
    }

    public function broadcastWith()
    {
        return [
            'user_id'   => $this->userId,
            'user_info' => [
                'name' => $this->userName,
            ],
        ];
    }
}
