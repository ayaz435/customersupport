<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckResponseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $recipientId;
    protected $senderId;
    protected $message;

    public function __construct($recipientId, $senderId, $message)
    {
        $this->recipientId = $recipientId;
        $this->senderId = $senderId;
        $this->message = $message;
    }

    public function handle()
    {
        // Simulate a check for a response within 10 seconds
        sleep(10);

        // Check if the team member responded within 10 seconds
        $responseWithinTime = // Implement your logic to check for a response

        if (!$responseWithinTime) {
            // If no response, notify both the user and the team member
            $recipient = User::find($this->recipientId);
            Notification::send($recipient, new NoResponseNotification($this->message));
            Notification::send(User::find($this->senderId), new NoResponseNotification($this->message));
        }
    }
}
