<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ChMessage as Message;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\ActiveChats;


class CheckIfUserRepliedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $from_id;
    protected $to_id;
    protected $last_message_id;
    protected $attempt_count;
    protected $new_message;
    protected $time_interval;

    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($from_id, $to_id, $last_message_id,$new_message, $attempt_count = 1, $time_interval)
    {
        $this->from_id = $from_id;
        $this->to_id = $to_id;
        $this->last_message_id = $last_message_id;
        $this->attempt_count = $attempt_count;
        $this->new_message = $new_message;
        $this->time_interval=$time_interval;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        try {
                
            $reply = Message::where('from_id', $this->to_id)
                ->where('to_id', $this->from_id)
                ->where('created_at', '>', now()->subMinutes($this->time_interval))
                ->first();
            $replyUser = Message::where('from_id', $this->from_id)
                ->where('to_id', $this->to_id)
                ->where('id','!=', $this->last_message_id)
                ->where('created_at', '>', now()->subMinutes($this->time_interval))
                ->first();
                
            if($reply || $replyUser){
                return;
            }
            
            if ($this->attempt_count === 1) {
                self::dispatch(
                    $this->from_id, 
                    $this->to_id, 
                    $this->last_message_id,
                    'We sincerely apologize for the delay. Our team is currently assisting other customers, but you’re important to us and we’ll respond as soon as possible. Thank you for waiting.',
                    $this->attempt_count + 1,
                    '3'
                )->delay(now()->addMinutes(3)); // Increasing delay between messages
                
            }else if($this->attempt_count === 2) {
                self::dispatch(
                    $this->from_id, 
                    $this->to_id, 
                    $this->last_message_id,
                    'We truly appreciate your patience. Our support team is still working to get to your query. If you’d prefer, you can leave your message and contact details — we’ll get back to you as soon as we can.',
                    $this->attempt_count + 1,
                    '5'
                )->delay(now()->addMinutes(5)); // Increasing delay between messages
            }
            else if($this->attempt_count === 3) {
                
                $ifChatExists = ActiveChats::where('user_id', $this->to_id)->where('team_id', $this->from_id)->where('chat_active_status', 1)->first();

                if ($ifChatExists) {
                    $ifChatExists->chat_active_status = 0;
                    $ifChatExists->save();
                }
                
            }else if($this->attempt_count === 4) {
                
                $ifChatExists = ActiveChats::where('user_id', $this->to_id)->where('team_id', $this->from_id)->where('chat_active_status', 1)->first();

                if ($ifChatExists) {
                    $ifChatExists->chat_active_status = 0;
                    $ifChatExists->save();
                }
                return ;
                
            }else {
                Log::info('Maximum follow-up attempts reached, stopping reminders', [
                    'total_attempts' => $this->attempt_count
                ]);
            }
            
            
            if (!$reply && !$replyUser && $this->attempt_count !== 4) {
                $message = Chatify::newMessage([
                    'from_id' => $this->to_id,
                    'to_id' => $this->from_id,
                    'body' => $this->new_message,
                    'team'=>"...",
                    'user'=>"...",
                    'attachment' =>  null,
                ]);
                
                // Basic message HTML format for sender
                $senderMessageHTML = $this->createMessageHTML($message, false);
                
                // Basic message HTML format for recipient
                $recipientMessageHTML = $this->createMessageHTML($message, true);
                
                try {
                    // Broadcast to the recipient (showing their outgoing message)
                    Chatify::push("private-chatify." . $this->to_id, 'messaging', [
                        'from_id' => $this->to_id,
                        'to_id' => $this->from_id,
                        'message' => $recipientMessageHTML
                    ]);
                    
                    // Broadcast to the sender (showing the incoming message)
                    Chatify::push("private-chatify." . $this->from_id, 'messaging', [
                        'from_id' => $this->to_id,
                        'to_id' => $this->from_id,
                        'message' => $senderMessageHTML
                    ]);
                    
                    
                } catch (\Exception $e) {
                    Log::error('Error broadcasting messages', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in CheckIfUserRepliedJob', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    /**
     * Create a custom HTML message string
     * 
     * @param Message $message
     * @param bool $isSender
     * @return string
     */
    private function createMessageHTML($message, $isSender)
    {
        $id = $message->id;
        $timeAgo = $message->time;
        $created_at = $message->created_at->format('Y-m-d H:i:s');
        $messageBody = nl2br($message->body);
        $senderClass = $isSender ? 'mc-sender' : '';
        $seenIcon = $isSender ? '<span class="fas fa-check" seen></span>' : '';
        
        // Basic HTML structure inspired by your messageCard.blade.php but simplified
        return <<<HTML
        <div class="message-card {$senderClass}" data-id="{$id}">
            <input id="uid" type="text" value="{$id}" hidden>
            <div class="message-card-content">
                <div class="message">
                    {$messageBody}
                    <span data-time="{$created_at}" class="message-time">
                        {$seenIcon} <span class="time">{$timeAgo}</span>
                    </span>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            var message = "{$message->body}";
            var messageContainer = document.querySelector(".message");
            
            if (message === 'Please wait, a team member is busy. You will receive a reply soon.') {
                // This will be handled by our CSS or specific logic for this message type
            }
        });
        </script>
        HTML;
    }
}