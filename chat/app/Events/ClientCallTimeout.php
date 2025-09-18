<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientCallTimeout implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $callData;

    public function __construct($userId, $callData)
    {
        $this->userId = $userId;
        $this->callData = $callData;
    }

    /**
     * Get the channels the event should broadcast on.
     * Using Chatify's channel format: private-chatify.{userId}
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chatify.' . $this->userId);
    }

    /**
     * The event's broadcast name - this will be the event name in frontend
     */
    public function broadcastAs()
    {
        return 'client-call-timeout';
    }

    /**
     * Get the data to broadcast
     */
    public function broadcastWith()
    {
        return [
            'channel' => $this->callData['channel_id'],
            'name'=>$this->callData['name'],
            'type' =>$this->callData['type'],
            'from_id' => $this->callData['from_id'],
            'to_id' => $this->callData['to_id'],
            'from_name' => $this->callData['from_name'],
            'message' => $this->callData['message'],
            'timestamp' => $this->callData['timestamp'] ?? now()->toISOString(),
            'channel_id' => $this->callData['channel_id'],
        ];
    }
}