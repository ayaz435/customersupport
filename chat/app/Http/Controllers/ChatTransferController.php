<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ChMessage as Message;
use App\Models\ChFavorite as Favorite;
use App\Models\User;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Illuminate\Support\Facades\Auth;
// use App\Notifications\ChatTransferred;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Str;
use App\Models\OtherProjectUser;
use App\Models\ActiveChats;
use Chatify\Http\Controllers\MessagesController as ChatifyMessagesController;

class ChatTransferController extends ChatifyMessagesController
{
    /**
     * Transfer a chat conversation to another support agent
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transferChat(Request $request)
    {
        // Validate the request
        $request->validate([
            'current_conversation_id' => 'required',
            'customer_id' => 'required',
            'target_agent_id' => 'required',
            'transfer_note' => 'nullable|string',
        ]);
        
        // Get the required parameters
        $currentConversationId = $request->current_conversation_id;
        $customerId = $request->customer_id;
        $targetAgentId = $request->target_agent_id;
        $transferNote = $request->transfer_note;
        $currentAgentId = Auth::user()->id;
        
        // Get the target agent and customer details
        $targetAgent = User::find($targetAgentId);
        $customer = User::find($customerId);
        $currentAgent = User::find($currentAgentId);
        
        if (!$targetAgent) {
            return response()->json([
                'status' => false,
                'message' => 'Target agent not found!'
            ], 404);
        }
        
        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found!'
            ], 404);
        }
        
        try {
            // Start database transaction
            DB::beginTransaction();
            
            // 1. Get all existing messages between current agent and customer
            $existingMessages = Message::where(function($query) use ($customerId, $currentAgentId) {
                $query->where(function($q) use ($customerId, $currentAgentId) {
                    $q->where('from_id', $customerId)
                      ->where('to_id', $currentAgentId);
                })->orWhere(function($q) use ($customerId, $currentAgentId) {
                    $q->where('from_id', $currentAgentId)
                      ->where('to_id', $customerId);
                });
            })->orderBy('created_at', 'asc')->get();
            
            // 2. Create a system message to notify the customer about the transfer
            $transferMessage = "Chat transferred to agent {$targetAgent->name}";
            
            
            $messageData = [
                'from_id' => $currentAgentId,
                'to_id' => $customerId,
                'body' => $transferMessage,
                'team' => "",
                'user' => "",
                'attachment' => null,
            ];
            
            $newMessage = Chatify::newMessage($messageData);
            

            
            // Mark the message as transferred
            if ($newMessage) {
                Message::where('id', $newMessage->id)->update([
                    'transferred' => true,
                    'original_agent_id' => $currentAgentId
                ]);
            }
            
            // 3. Copy all messages to create a thread between target agent and customer
            foreach ($existingMessages as $message) {
                // Skip system messages if needed
                if ($message->type == 'system') {
                    continue;
                }
                
                // Determine the direction of the message (from customer or from agent)
                if ($message->from_id == $customerId) {
                    // This is a message from customer - keep it as is
                    $newMessageData = [
                        'from_id' => $customerId,
                        'to_id' => $targetAgentId, // Now to target agent
                        'body' => $message->body,
                        'team' => $message->team ?? "",
                        'user' => $message->user ?? "",
                        'attachment' => $message->attachment,
                        'created_at' => $message->created_at, // Preserve original timestamp
                        'updated_at' => $message->updated_at  // Preserve original timestamp
                    ];
                } else {
                    // This was a message from current agent - now mark as from target agent
                    $newMessageData = [
                        'from_id' => $targetAgentId, // From target agent
                        'to_id' => $customerId,
                        'body' => $message->body . "\n\n (from previous agent($message->team))",
                        'team' => $message->team ?? "",
                        'user' => $message->user ?? "",
                        'attachment' => $message->attachment,
                        'created_at' => $message->created_at, // Preserve original timestamp
                        'updated_at' => $message->updated_at  // Preserve original timestamp
                    ];
                }
                
                // Create the new message directly in DB to preserve timestamps
                Message::create($newMessageData);
                
                                        // dd($newMessageData);

            }
            
            // 4. Create a transfer notification message for the target agent
            $notificationMessageData = [
                'from_id' => $customerId, // Make it appear as if from customer
                'to_id' => $targetAgentId,
                'body' => "This chat was transferred to you from agent {$currentAgent->name}",
                'team' => "",
                'user' => "",
                'attachment' => null,
                'type' => 'system'
            ];
            
            $notificationMessage = Chatify::newMessage($notificationMessageData);
            
            if ($notificationMessage) {
                Message::where('id', $notificationMessage->id)->update([
                    'transferred' => true,
                    'original_agent_id' => $currentAgentId
                ]);
            }
            
            // 5. Create contacts (favorites) entries if they don't exist
            // For target agent
            $favorite = Favorite::where('user_id', $targetAgentId)
                ->where('favorite_id', $customerId)
                ->first();
                
            if (!$favorite) {
                Favorite::create([
                    'user_id' => $targetAgentId,
                    'favorite_id' => $customerId,
                ]);
            }
            
            // For customer
            $customerFavorite = Favorite::where('user_id', $customerId)
                ->where('favorite_id', $targetAgentId)
                ->first();
                
            if (!$customerFavorite) {
                Favorite::create([
                    'user_id' => $customerId,
                    'favorite_id' => $targetAgentId,
                ]);
            }
            
            // 6. Create a private note for the target agent if a transfer note was provided
            if ($transferNote) {
                $noteMessageData = [
                    'from_id' => $currentAgentId,
                    'to_id' => $targetAgentId,
                    'body' => "Transfer note: {$transferNote}",
                    'team' => "",
                    'user' => "",
                    'attachment' => null,
                ];
                
                Chatify::newMessage($noteMessageData);
            }
            
            // 8. Add a metadata flag to prevent the current agent from messaging further
            // Message::where('id', $newMessage->id)->update(['metadata' => json_encode(['chat_ended' => true])]);
            
            // 9. Send a notification to customer
            $customerNotificationData = [
                'from_id' => $targetAgentId,
                'to_id' => $customerId,
                'body' => "You are now chatting with {$targetAgent->name}",
                'team' => "",
                'user' => "",
                'attachment' => null,
                'type' => 'system'
            ];
            
            Chatify::newMessage($customerNotificationData);
            
            // Commit the transaction
            DB::commit();
            
            // Return success response with target agent details
            return response()->json([
                'status' => true,
                'message' => 'Chat transferred successfully to ' . $targetAgent->name,
                'target_agent' => [
                    'id' => $targetAgent->id,
                    'name' => $targetAgent->name
                ]
            ], 200);
            
        } catch (\Exception $e) {
            // Rollback in case of error
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => 'Failed to transfer chat: ' . $e->getMessage()
            ], 500);
        }
   }
    
    /**
     * Get chat history for a specific conversation
     * This will be used when an agent receives a transferred chat
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChatHistory(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
        ]);
        
        $customerId = $request->customer_id;
        $agentId = Auth::id();
        
        // Get messages between this agent and the customer specifically
        $messages = Message::where(function($query) use ($customerId, $agentId) {
            $query->where(function($q1) use ($customerId, $agentId) {
                $q1->where('from_id', $customerId)
                   ->where('to_id', $agentId);
            })->orWhere(function($q2) use ($customerId, $agentId) {
                $q2->where('from_id', $agentId)
                   ->where('to_id', $customerId);
            });
        })->orderBy('created_at', 'asc')->get();
        
        // Check if any transfers occurred in this conversation
        $transferMessages = $messages->where('transferred', true);
        
        $hasBeenTransferred = $transferMessages->count() > 0;
        
        // Get message IDs
        $messageIds = $messages->pluck('id')->toArray();
        
        // Find the original agent ID from transfer messages
        $originalAgentId = null;
        foreach ($transferMessages as $transferMsg) {
            if ($transferMsg->original_agent_id) {
                $originalAgentId = $transferMsg->original_agent_id;
                break;
            }
        }
        
        // If this is a transferred chat, find the agent who transferred it
        $transferredFrom = null;
        if ($originalAgentId) {
            $originalAgent = User::find($originalAgentId);
            if ($originalAgent) {
                $transferredFrom = [
                    'id' => $originalAgent->id,
                    'name' => $originalAgent->name
                ];
            }
        }
        
        // Format the messages for display
        $formattedMessages = [];
        foreach ($messages as $message) {
            $sender = User::find($message->from_id);
            $receiver = User::find($message->to_id);
            
            // For messages from previous agent, add a note
            $originalAgentInfo = '';
            if ($message->original_agent_id && $message->original_agent_id != $agentId) {
                $originalAgent = User::find($message->original_agent_id);
                if ($originalAgent) {
                    $originalAgentInfo = " (from agent {$originalAgent->name})";
                }
            }
            
            $formattedMessages[] = [
                'id' => $message->id,
                'from_id' => $message->from_id,
                'to_id' => $message->to_id,
                'message' => $message->body,
                'attachment' => $message->attachment,
                'time' => $message->created_at->diffForHumans(),
                'timestamp' => $message->created_at->toDateTimeString(),
                'sender_name' => $sender ? $sender->name . $originalAgentInfo : 'Unknown',
                'receiver_name' => $receiver ? $receiver->name : 'Unknown',
                'is_sender' => $message->from_id == $agentId,
                'type' => $message->type ?? 'user',
                'transferred' => $message->transferred ?? false,
                'metadata' => $message->metadata ? json_decode($message->metadata) : null,
            ];
        }
        
        // Include transfer information in the response
        return response()->json([
            'status' => true,
            'messages' => $formattedMessages,
            'has_been_transferred' => $hasBeenTransferred,
            'transfer_count' => $transferMessages->count(),
            'transferred_from' => $transferredFrom
        ]);
    }

    /**
     * Fetch all available agents for the transfer dropdown
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAgents(Request $request)
    {
        // Get all agents (users with role 'team')
        $agents = User::where('role', 'team')->get(['id', 'name']);
        
        return response()->json([
            'status' => true,
            'agents' => $agents
        ]);
    }
}