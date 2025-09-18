<?php

namespace App\Services;

use Chatify\Facades\ChatifyMessenger as Chatify;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\ChatExportMailable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ChatExportService
{
    public function exportChatToAdmin($userId, $adminEmail, $participantId = null)
    {
        $user = User::find($userId);
        
        if (!$user) {
            throw new \Exception('User not found');
        }

        // Get chat messages
        $messages = $this->getChatMessages($userId, $participantId);
        
        // Format messages for export and collect attachments
        $result = $this->formatChatMessagesWithAttachments($messages, $user);
        $formattedChat = $result['content'];
        $attachments = $result['attachments'];
        
        // Send email to admin with attachments
        $this->sendChatEmailWithAttachments($adminEmail, $formattedChat, $user, $attachments);
        
        return true;
    }

    private function getChatMessages($userId, $participantId = null)
    {
        $query = \DB::table('ch_messages')
            ->where(function($q) use ($userId, $participantId) {
                if ($participantId) {
                    $q->where(function($subQ) use ($userId, $participantId) {
                        $subQ->where('from_id', $userId)
                             ->where('to_id', $participantId);
                    })->orWhere(function($subQ) use ($userId, $participantId) {
                        $subQ->where('from_id', $participantId)
                             ->where('to_id', $userId);
                    });
                } else {
                    $q->where('from_id', $userId)
                      ->orWhere('to_id', $userId);
                }
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return $query;
    }

    private function formatChatMessagesWithAttachments($messages, $user)
    {
        $formatted = [];
        $attachments = [];
        
        $formatted[] = "Chat Export for User: {$user->name} ({$user->email})";
        $formatted[] = "Export Date: " . Carbon::now()->format('Y-m-d H:i:s');
        $formatted[] = str_repeat('=', 50);
        $formatted[] = "";

        foreach ($messages as $message) {
            $sender = User::find($message->from_id);
            $receiver = User::find($message->to_id);
            
            $senderName = $sender ? $sender->name : 'Unknown User';
            $receiverName = $receiver ? $receiver->name : 'Unknown User';
            
            $timestamp = Carbon::parse($message->created_at)->format('Y-m-d H:i:s');
            
            $formatted[] = "[{$timestamp}] {$senderName} → {$receiverName}";
            
            if (!empty($message->body)) {
                $formatted[] = "Message: " . $message->body;
            }
            
            if ($message->attachment) {
                $attachmentData = json_decode($message->attachment, true);
                
                if ($attachmentData && isset($attachmentData['new_name'])) {
                    $originalName = $attachmentData['old_name'] ?? $attachmentData['new_name'];
                    $newName = $attachmentData['new_name'];
                    
                    // Look for the file in Chatify's storage paths
                    $possiblePaths = [
                        storage_path("app/public/chatify/images/{$newName}"),
                        storage_path("app/chatify/images/{$newName}"),
                        public_path("storage/chatify/images/{$newName}"),
                        storage_path("app/public/chatify/files/{$newName}"),
                        storage_path("app/chatify/files/{$newName}"),
                        public_path("storage/chatify/files/{$newName}"),
                    ];
                    
                    $filePath = null;
                    foreach ($possiblePaths as $path) {
                        if (file_exists($path)) {
                            $filePath = $path;
                            break;
                        }
                    }
                    
                    if ($filePath) {
                        $attachments[] = [
                            'path' => $filePath,
                            'name' => $originalName,
                            'mime' => $this->getMimeType($filePath)
                        ];
                        $formatted[] = "Attachment: {$originalName} (included in email)";
                    } else {
                        $formatted[] = "Attachment: {$originalName} (file not found)";
                    }
                } else {
                    $formatted[] = "Attachment: " . $message->attachment;
                }
            }
            
            $formatted[] = str_repeat('-', 30);
        }

        return [
            'content' => implode("\n", $formatted),
            'attachments' => $attachments
        ];
    }

    private function getMimeType($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'txt' => 'text/plain',
            'mp4' => 'video/mp4',
            'mp3' => 'audio/mpeg',
            'zip' => 'application/zip',
        ];
        
        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    private function sendChatEmailWithAttachments($adminEmail, $chatContent, $user, $attachments = [])
    {
        Mail::to($adminEmail)->send(new ChatExportMailable($user, $chatContent, $attachments));
    }

    private function sendChatEmail($adminEmail, $chatContent, $user)
    {
        // Keep the original method for backward compatibility
        $this->sendChatEmailWithAttachments($adminEmail, $chatContent, $user, []);
    }

    public function exportChatToAdminWithZip($userId, $adminEmail, $participantId = null)
    {
        $user = User::find($userId);
        
        if (!$user) {
            throw new \Exception('User not found');
        }

        // Get chat messages
        $messages = $this->getChatMessages($userId, $participantId);
        
        // Format messages for export and collect attachments
        $result = $this->formatChatMessagesWithAttachments($messages, $user);
        $formattedChat = $result['content'];
        $attachments = $result['attachments'];
        
        // Create ZIP file if there are attachments
        $zipPath = null;
        if (!empty($attachments)) {
            $zipPath = $this->createAttachmentsZip($attachments, $user);
        }
        
        // Send email to admin
        $this->sendChatEmailWithZip($adminEmail, $formattedChat, $user, $zipPath);
        
        // Clean up ZIP file
        if ($zipPath && file_exists($zipPath)) {
            unlink($zipPath);
        }
        
        return true;
    }

    private function createAttachmentsZip($attachments, $user)
    {
        $zipFileName = "chat_attachments_{$user->id}_" . date('Y-m-d_H-i-s') . ".zip";
        $zipPath = storage_path("app/temp/{$zipFileName}");
        
        // Create temp directory if it doesn't exist
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }
        
        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE) !== TRUE) {
            throw new \Exception('Cannot create ZIP file');
        }
        
        foreach ($attachments as $attachment) {
            if (file_exists($attachment['path'])) {
                $zip->addFile($attachment['path'], $attachment['name']);
            }
        }
        
        $zip->close();
        
        return $zipPath;
    }

    private function sendChatEmailWithZip($adminEmail, $chatContent, $user, $zipPath = null)
    {
        Mail::to($adminEmail)->send(new ChatExportMailable($user, $chatContent, [], $zipPath));
    }
}