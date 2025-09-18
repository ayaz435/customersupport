<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ChatExportMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $chatContent;
    public $attachments;
    public $zipPath;

    public function __construct(User $user, $chatContent, $attachments = [], $zipPath = null)
    {
        $this->user = $user;
        $this->chatContent = $chatContent;
        $this->attachments = $attachments;
        $this->zipPath = $zipPath;
    }

    public function build()
    {
        $totalAttachments = count($this->attachments) + ($this->zipPath ? 1 : 0);
        
        $mail = $this->subject("Chat Export - {$this->user->name}")
                     ->view('emails.chat-export')
                     ->with([
                         'user' => $this->user,
                         'chatContent' => $this->chatContent,
                         'attachmentCount' => $totalAttachments,
                         'hasZip' => !empty($this->zipPath)
                     ]);

        // Attach individual files (up to a reasonable limit)
        $maxIndividualAttachments = 5; // Limit to prevent email size issues
        $attachedCount = 0;
        
        foreach ($this->attachments as $attachment) {
            if ($attachedCount >= $maxIndividualAttachments) {
                break;
            }
            
            if (file_exists($attachment['path'])) {
                $fileSize = filesize($attachment['path']);
                // Skip files larger than 5MB
                if ($fileSize <= 5 * 1024 * 1024) {
                    $mail->attach($attachment['path'], [
                        'as' => $attachment['name'],
                        'mime' => $attachment['mime']
                    ]);
                    $attachedCount++;
                }
            }
        }

        // Attach ZIP file if provided
        if ($this->zipPath && file_exists($this->zipPath)) {
            $mail->attach($this->zipPath, [
                'as' => 'chat_attachments.zip',
                'mime' => 'application/zip'
            ]);
        }

        return $mail;
    }
}