<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChatSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    public $filePath;

    /**
     * Create a new message instance.
     *
     * @param array $emailData
     * @param string $filePath
     */
    public function __construct($emailData, $filePath)
    {
        $this->emailData = $emailData;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.chat_summary')
            ->subject('Chat Summary')
            ->attach(storage_path('app/' . $this->filePath))
            ->with('emailData', $this->emailData);
    }
}
