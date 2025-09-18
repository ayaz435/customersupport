<?php

namespace App\Events;

use App\Models\VoiceMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoiceMessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $voiceMessage;

    public function __construct(VoiceMessage $voiceMessage)
    {
        $this->voiceMessage = $voiceMessage;
    }

    public function broadcastOn()
    {
        return ['chat'];
    }
}
