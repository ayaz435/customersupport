<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\MessageSent;
use App\Models\ChMessage;
use App\Models\User;

class TestWebSocket extends Command
{
    protected $signature = 'test:websocket {from_id} {to_id} {message}';
    protected $description = 'Test WebSocket broadcasting';

    public function handle()
    {
        $fromId = $this->argument('from_id');
        $toId = $this->argument('to_id');
        $messageText = $this->argument('message');

        $message = new ChMessage([
            'from_id' => $fromId,
            'to_id' => $toId,
            'body' => $messageText,
            'seen' => 0
        ]);
        $message->save();

        broadcast(new MessageSent($message))->toOthers();
        
        $this->info('Message broadcasted successfully!');
    }
}