<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Chatify\Facades\ChatifyMessenger as Chatify;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatifyContactsApiController extends Controller
{
    /**
     * Get all contacts with online status for the authenticated user
     */
    public function getContacts(Request $request)
    {
        try {
            $authUserId = Auth::id();
            
            if (!$authUserId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Get contacts (users who have exchanged messages with auth user)
            $contacts = $this->getUserContacts($authUserId);
            
            // Add online status and additional info
            $contactsWithStatus = [];
            
            foreach ($contacts as $contact) {
                $isOnline = Chatify::isOnline($contact->id);
                $lastMessage = $this->getLastMessage($authUserId, $contact->id);
                $unreadCount = $this->getUnreadCount($authUserId, $contact->id);
                
                $contactsWithStatus[] = [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'avatar' => $this->getUserAvatar($contact),
                    'is_online' => $isOnline,
                    'last_seen' => $this->getLastSeen($contact->id),
                    'status' => $isOnline ? 'online' : 'offline',
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'last_activity' => $lastMessage['created_at'] ?? null
                ];
            }

            // Sort by online status and last activity
            usort($contactsWithStatus, function($a, $b) {
                // Online users first
                if ($a['is_online'] != $b['is_online']) {
                    return $b['is_online'] <=> $a['is_online'];
                }
                // Then by last activity
                return ($b['last_activity'] ?? '') <=> ($a['last_activity'] ?? '');
            });

            return response()->json([
                'success' => true,
                'contacts' => $contactsWithStatus,
                'total' => count($contactsWithStatus),
                'online_count' => count(array_filter($contactsWithStatus, fn($c) => $c['is_online']))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch contacts',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get contacts with pagination and search
     */
    public function getContactsWithPagination(Request $request)
    {
        try {
            $authUserId = Auth::id();
            $search = $request->get('search', '');
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 20);
            $onlineOnly = $request->get('online_only', false);

            $query = $this->getContactsQuery($authUserId, $search);
            
            $contacts = $query->paginate($perPage, ['*'], 'page', $page);
            
            $contactsWithStatus = [];
            
            foreach ($contacts->items() as $contact) {
                $isOnline = Chatify::isOnline($contact->id);
                
                // Skip offline users if only online requested
                if ($onlineOnly && !$isOnline) {
                    continue;
                }
                
                $lastMessage = $this->getLastMessage($authUserId, $contact->id);
                $unreadCount = $this->getUnreadCount($authUserId, $contact->id);
                
                $contactsWithStatus[] = [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'avatar' => $this->getUserAvatar($contact),
                    'is_online' => $isOnline,
                    'last_seen' => $this->getLastSeen($contact->id),
                    'status' => $isOnline ? 'online' : 'offline',
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'last_activity' => $lastMessage['created_at'] ?? null
                ];
            }

            return response()->json([
                'success' => true,
                'contacts' => $contactsWithStatus,
                'pagination' => [
                    'current_page' => $contacts->currentPage(),
                    'last_page' => $contacts->lastPage(),
                    'per_page' => $contacts->perPage(),
                    'total' => $contacts->total(),
                ],
                'online_count' => count(array_filter($contactsWithStatus, fn($c) => $c['is_online']))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch contacts',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get only online contacts
     */
    public function getOnlineContacts(Request $request)
    {
        try {
            $authUserId = Auth::id();
            $contacts = $this->getUserContacts($authUserId);
            
            $onlineContacts = [];
            
            foreach ($contacts as $contact) {
                $isOnline = Chatify::isOnline($contact->id);
                
                if ($isOnline) {
                    $lastMessage = $this->getLastMessage($authUserId, $contact->id);
                    
                    $onlineContacts[] = [
                        'id' => $contact->id,
                        'name' => $contact->name,
                        'email' => $contact->email,
                        'avatar' => $this->getUserAvatar($contact),
                        'is_online' => true,
                        'status' => 'online',
                        'last_message' => $lastMessage,
                        'unread_count' => $this->getUnreadCount($authUserId, $contact->id)
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'online_contacts' => $onlineContacts,
                'count' => count($onlineContacts)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch online contacts'
            ], 500);
        }
    }

    /**
     * Search contacts with online status
     */
    public function searchContacts(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2'
        ]);

        try {
            $authUserId = Auth::id();
            $searchQuery = $request->get('query');
            
            $contacts = User::where('id', '!=', $authUserId)
                ->where(function($q) use ($searchQuery) {
                    $q->where('name', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('email', 'LIKE', "%{$searchQuery}%");
                })
                ->limit(50)
                ->get();
            
            $searchResults = [];
            
            foreach ($contacts as $contact) {
                $isOnline = Chatify::isOnline($contact->id);
                $hasConversation = $this->hasConversation($authUserId, $contact->id);
                
                $searchResults[] = [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'avatar' => $this->getUserAvatar($contact),
                    'is_online' => $isOnline,
                    'status' => $isOnline ? 'online' : 'offline',
                    'has_conversation' => $hasConversation,
                    'last_seen' => $this->getLastSeen($contact->id)
                ];
            }

            return response()->json([
                'success' => true,
                'results' => $searchResults,
                'query' => $searchQuery,
                'count' => count($searchResults)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to search contacts'
            ], 500);
        }
    }

    /**
     * Get user contacts (users with message history) - Alternative approach
     */
    private function getUserContacts($userId)
    {
        // Get all unique contact IDs from messages
        $contactIds = DB::table('ch_messages')
            ->where('from_id', $userId)
            ->pluck('to_id')
            ->merge(
                DB::table('ch_messages')
                    ->where('to_id', $userId)
                    ->pluck('from_id')
            )
            ->unique()
            ->filter(function($id) use ($userId) {
                return $id != $userId; // Exclude self
            })
            ->values();

        // Get users by these contact IDs
        return User::whereIn('id', $contactIds)->get();
    }

    /**
     * Get contacts query for pagination - Alternative approach
     */
    private function getContactsQuery($userId, $search = '')
    {
        // Get all unique contact IDs
        $contactIds = DB::table('ch_messages')
            ->where('from_id', $userId)
            ->pluck('to_id')
            ->merge(
                DB::table('ch_messages')
                    ->where('to_id', $userId)
                    ->pluck('from_id')
            )
            ->unique()
            ->filter(function($id) use ($userId) {
                return $id != $userId;
            })
            ->values();

        $query = User::whereIn('id', $contactIds);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        return $query;
    }

    /**
     * Get last message between two users
     */
    private function getLastMessage($userId, $contactId)
    {
        $message = DB::table('ch_messages')
            ->where(function($q) use ($userId, $contactId) {
                $q->where(['from_id' => $userId, 'to_id' => $contactId])
                  ->orWhere(['from_id' => $contactId, 'to_id' => $userId]);
            })
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$message) {
            return null;
        }

        return [
            'id' => $message->id,
            'body' => $message->body,
            'attachment' => $message->attachment,
            'from_id' => $message->from_id,
            'created_at' => $message->created_at,
            'is_sender' => $message->from_id == $userId
        ];
    }

    /**
     * Get unread message count
     */
    private function getUnreadCount($userId, $contactId)
    {
        return DB::table('ch_messages')
            ->where('from_id', $contactId)
            ->where('to_id', $userId)
            ->where('seen', 0)
            ->count();
    }

    /**
     * Check if conversation exists between users
     */
    private function hasConversation($userId, $contactId)
    {
        return DB::table('ch_messages')
            ->where(function($q) use ($userId, $contactId) {
                $q->where(['from_id' => $userId, 'to_id' => $contactId])
                  ->orWhere(['from_id' => $contactId, 'to_id' => $userId]);
            })
            ->exists();
    }

    /**
     * Get user avatar
     */
    private function getUserAvatar($user)
    {
        return Chatify::getUserWithAvatar($user)->avatar ?? asset('assets/chatify/images/default-avatar.png');
    }

    /**
     * Get user last seen time
     */
    private function getLastSeen($userId)
    {
        $lastSeen = DB::table('users')
            ->where('id', $userId)
            ->value('last_seen');

        return $lastSeen ? Carbon::parse($lastSeen)->toISOString() : null;
    }
}