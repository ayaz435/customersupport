<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\ChMessage;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $sender;

    public function __construct(ChMessage $message)
    {
        $this->message = $message;
        $this->sender = $message->fromUser;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('chat.' . $this->message->to_id),
            new PrivateChannel('chat.' . $this->message->from_id)
        ];
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'body' => $this->message->body,
                'attachment' => $this->message->attachment,
                'created_at' => $this->message->created_at,
                'from_id' => $this->message->from_id,
                'to_id' => $this->message->to_id,
            ],
            'sender' => [
                'id' => $this->sender->id,
                'name' => $this->sender->name,
                'avatar' => $this->sender->avatar,
            ]
        ];
    }
}