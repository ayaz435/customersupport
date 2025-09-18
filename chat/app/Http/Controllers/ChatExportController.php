<?php

namespace App\Http\Controllers;

use App\Services\ChatExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatExportController extends Controller
{
    protected $chatExportService;

    public function __construct(ChatExportService $chatExportService)
    {
        $this->chatExportService = $chatExportService;
    }

    public function exportToEmail(Request $request)
    {
        $request->validate([
            'client_id' => 'nullable'
        ]);
        
        $user_id=Auth::user()->id;

        try {
            $this->chatExportService->exportChatToAdminWithZip(
                 $user_id,
                'a.rauf.bscs@gmail.com',
                $request->client_id
            );

            return response()->json([
                'success' => true,
                'message' => 'Chat exported and sent to admin successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export chat: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadChat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'participant_id' => 'nullable|exists:users,id'
        ]);

        try {
            $filepath = $this->chatExportService->exportChatAsFile(
                $request->user_id,
                $request->participant_id
            );

            return Response::download($filepath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to download chat: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportAllChatsToEmail(Request $request)
    {
        $request->validate([
            'admin_email' => 'required|email'
        ]);

        // Get all users who have sent or received messages
        $userIds = \DB::table('ch_messages')
            ->select('from_id')
            ->union(\DB::table('ch_messages')->select('to_id'))
            ->distinct()
            ->pluck('from_id');

        try {
            foreach ($userIds as $userId) {
                $this->chatExportService->exportChatToAdmin(
                    $userId,
                    $request->admin_email
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'All chats exported and sent to admin successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export chats: ' . $e->getMessage()
            ], 500);
        }
    }
}