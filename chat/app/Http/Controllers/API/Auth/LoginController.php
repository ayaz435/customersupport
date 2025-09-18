<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

use Chatify\Facades\ChatifyMessenger as Chatify;
use App\Models\User;
use Chatify\Http\Controllers\MessagesController as ChatifyMessagesController;
use App\Jobs\MarkUserInactive;
use App\Events\UserActive;
use App\Events\UserInactive;



class LoginController extends ChatifyMessagesController
{
    public function login(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

       $request->authenticate();

        auth()->user()->active_status = 1;
        auth()->user()->save();
        auth()->user()->detail()->updateOrCreate([], [
            'chat_app_last_login_at' => now(),
        ]);
            
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        MarkUserInactive::dispatch(auth()->user()->id)->delay(now()->addMinutes(10));
        broadcast(new UserActive(auth()->user()->id, auth()->user()->name));

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
    
    public function logout(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'message' => 'User is not authenticated'
            ], 401);
        }
        
        auth()->user()->active_status = 0;
        auth()->user()->save();
        auth()->user()->detail()->updateOrCreate([], [
            'chat_app_last_logout_at' => now(),
        ]);
        broadcast(new UserInactive(auth()->user()->id));
        
        // Revoke the current access token
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    // Optional: Logout from all devices
    public function logoutFromAllDevices(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'message' => 'User is not authenticated'
            ], 401);
        }
        auth()->user()->active_status = 0;
        auth()->user()->save();
        auth()->user()->detail()->updateOrCreate([], [
            'chat_app_last_logout_at' => now(),
        ]);
        broadcast(new UserInactive(auth()->user()->id));
               
        
        // Revoke all tokens for the user
        $request->user()->tokens()->delete();
        
        return response()->json([
            'message' => 'Successfully logged out from all devices'
        ]);
    }
}
