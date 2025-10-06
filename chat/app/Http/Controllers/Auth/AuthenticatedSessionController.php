<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\RedirectResponse;
use App\Jobs\MarkUserInactive;
use App\Events\UserActive;
use App\Events\UserInactive;






class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    // public function create(): View
    // {
    //     return view('auth.login');
    // }
    
    /**
     * Display the login view.
     */
    public function create(Request $request)
    {
        // Check if there's an auth token from customer support
        $authToken = $request->get('auth_token');
        
        if ($authToken) {
            $user = $this->authenticateFromToken($authToken);
            
            if ($user && in_array($user->role, ['team', 'admin','user', 'service'])) {
                // Auto-login the user
                Auth::login($user);
                
                // Update active status
                auth()->user()->active_status = 1;
                auth()->user()->save();
                auth()->user()->detail()->updateOrCreate([], [
                    'chat_web_last_login_at' => now(),
                ]);
                MarkUserInactive::dispatch(auth()->user()->id)->delay(now()->addMinutes(10));
                broadcast(new UserActive(auth()->user()->id, auth()->user()->name));
                // Redirect based on role
                if ($user->role === 'team') {
                    return redirect()->route('chatify');
                }
                return redirect()->route('chatdash');
            }
        }
        
        return view('auth.login');
    }

    /**
     * Authenticate user from customer support token
     */
    private function authenticateFromToken($token)
    {
        try {
            $data = json_decode(base64_decode($token), true);
            
            // Check if token is not older than 5 minutes
            // if (!$data || (now()->timestamp - $data['timestamp']) > 300) {
            //     return null;
            // }
            
            // Find user by email and verify data
            $user = User::where('email', $data['email'])
                ->where('id', $data['user_id'])
                ->where('role', $data['role'])
                ->first();
            
            return $user;
            
        } catch (\Exception $e) {
            return null;
        }
    }

    

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        auth()->user()->active_status = 1;
        auth()->user()->save();

        auth()->user()->detail()->updateOrCreate([], [
            'chat_web_last_login_at' => now(),
        ]);

        MarkUserInactive::dispatch(auth()->user()->id)->delay(now()->addMinutes(10));
        broadcast(new UserActive(auth()->user()->id, auth()->user()->name));

        $request->session()->regenerate();
        if ($request->user()->role === 'team') {

            return redirect()->intended(route('chatify'));
        }
        return redirect()->intended(route('chatdash'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        
        auth()->user()->active_status = 0;
        auth()->user()->save();

        auth()->user()->detail()->updateOrCreate([], [
            'chat_web_last_logout_at' => now(),
        ]);
        broadcast(new UserInactive(auth()->user()->id));
                
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
    
    /**
     * Destroy an authenticated session.
     */
    public function apiDestroy(Request $request)
    {
        
        auth()->user()->active_status = 0;
        auth()->user()->save();

        auth()->user()->detail()->updateOrCreate([], [
            'chat_app_last_logout_at' => now(),
        ]);

        broadcast(new UserInactive(auth()->user()->id));
                
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            "status" => true,
            "message" => "logged out successfully"
        ]);
    }
}
