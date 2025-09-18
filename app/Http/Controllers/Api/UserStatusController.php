<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\UserOnline;
use App\Events\UserOffline;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserStatusController extends Controller
{
    public function setOnline()
    {
        $user = auth()->user();
        
        // Update user's last seen
        $user->update(['last_seen' => now()]);
        
        // Cache online status for 5 minutes
        Cache::put("user_online_{$user->id}", true, 300);
        
        $onlineUserIds = Cache::get('online_user_ids', []);
        if (!in_array($user->id, $onlineUserIds)) {
            $onlineUserIds[] = $user->id;
            Cache::put('online_user_ids', $onlineUserIds, 300);
        }
        
        // Broadcast online status
        broadcast(new UserOnline($user))->toOthers();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Status updated to online'
        ]);
    }
    
    public function setOffline()
    {
        $user = auth()->user();
        
        // Update user's last seen
        $user->update(['last_seen' => now()]);
        
        // Remove from online cache
        Cache::forget("user_online_{$user->id}");
        
        $onlineUserIds = Cache::get('online_user_ids', []);
        $onlineUserIds = array_filter($onlineUserIds, fn($id) => $id != $user->id);
        Cache::put('online_user_ids', $onlineUserIds, 300);
        
        // Broadcast offline status
        broadcast(new UserOffline($user))->toOthers();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Status updated to offline'
        ]);
    }
    
    // public function getOnlineUsers()
    // {
    //     $onlineUserIds = [];
        
    //     // Get all cached online users
    //     $cacheKeys = Cache::getRedis()->keys('*user_online_*');
    //     foreach ($cacheKeys as $key) {
    //         $userId = str_replace('user_online_', '', $key);
    //         if (Cache::get($key)) {
    //             $onlineUserIds[] = $userId;
    //         }
    //     }
        
    //     $onlineUsers = User::whereIn('id', $onlineUserIds)
    //                       ->select('id', 'name', 'avatar', 'last_seen')
    //                       ->get();
        
    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $onlineUsers
    //     ]);
    // }
    public function getOnlineUsers()
    {
        $onlineUserIds = Cache::get('online_user_ids', []);
        
        $onlineUsers = User::whereIn('id', $onlineUserIds)
            ->select('id', 'name', 'avatar', 'last_seen')
            ->get();
    
        return response()->json([
            'status' => 'success',
            'data' => $onlineUsers
        ]);
    }
    
    public function getUserStatus($userId)
    {
        $isOnline = Cache::has("user_online_{$userId}");
        $user = User::find($userId);
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'user_id' => $userId,
                'is_online' => $isOnline,
                'last_seen' => $user ? $user->last_seen : null
            ]
        ]);
    }
}