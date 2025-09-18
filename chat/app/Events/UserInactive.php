<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserInactive implements ShouldBroadcast
{
    use SerializesModels;

    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('presence-activeStatus');
    }

    public function broadcastAs()
    {
        // Custom event name
        return 'member_removed';
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->userId
        ];
    }
}
