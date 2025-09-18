<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Chat;
use App\Models\LateMessages;
use App\Models\Complain;
use App\Models\Tickets;
use App\Models\Notification;
use App\Models\UsersQuestion;
use App\Models\inbox;
use App\Models\Reason;

// Import the Validator class

class AdminHomeController extends Controller
{

    public function userTrackingOld()
    {
        $users = User::whereHas('detail')->with('detail')->get();
        $now = Carbon::now();

        $processUserActivity = function ($users, $prefix) use ($now) {
            return $users->map(function ($user) use ($now, $prefix) {
                $detail = $user->detail;
                
                if (!$detail) {
                    return null;
                }

                $times = [
                    'login'  => $detail->{$prefix . '_last_login_at'} ? Carbon::parse($detail->{$prefix . '_last_login_at'}) : null,
                    'logout' => $detail->{$prefix . '_last_logout_at'} ? Carbon::parse($detail->{$prefix . '_last_logout_at'}) : null,
                    'active' => $detail->{$prefix . '_last_active_at'} ? Carbon::parse($detail->{$prefix . '_last_active_at'}) : null,
                    'left'   => $detail->{$prefix . '_last_left_at'} ? Carbon::parse($detail->{$prefix . '_last_left_at'}) : null,
                ];

                $latestField = collect($times)->filter()->sortDesc()->keys()->first();
                if (!$latestField) {
                    return null; 
                }

                $latestTime = $times[$latestField];
                $diffInMinutes = $latestTime ? $latestTime->diffInMinutes($now) : null;

                if ($latestField === 'active') {
                    $user->activity_status = $diffInMinutes <= 10 ? 'active' : 'inactive';
                    $user->activity_priority = $diffInMinutes <= 10 ? 0 : 1;
                } elseif ($latestField === 'login') {
                    $user->activity_status = $diffInMinutes <= 10 ? 'active' : 'inactive';
                    $user->activity_priority = $diffInMinutes <= 10 ? 0 : 1;
                } elseif ($latestField === 'left') {
                    $user->activity_status = 'inactive';
                    $user->activity_priority = 2;
                } elseif ($latestField === 'logout') {
                    $user->activity_status = 'inactive';
                    $user->activity_priority = 3;
                } else {
                    return null;
                }

                $user->latest_field = $latestField;
                $user->latest_time = $latestTime;

                return $user;
            })->filter()->sortBy([
                ['activity_priority', 'asc'],
                ['latest_time', 'desc'],
            ]);
        };

        [$appUsers, $webUsers, $chatAppUsers, $chatWebUsers] = Concurrency::run([
            fn() => $processUserActivity($users, 'app'),
            fn() => $processUserActivity($users, 'web'),
            fn() => $processUserActivity($users, 'chat_app'),
            fn() => $processUserActivity($users, 'chat_web'),
        ]);

        // dd( compact('appUsers', 'webUsers', 'chatAppUsers', 'chatWebUsers', 'users'));
        return view('admin.user_tracking.user_tracking', compact('appUsers', 'webUsers', 'chatAppUsers', 'chatWebUsers'));
    }

    public function userTracking()
    {
        $users = User::whereHas('detail')->with('detail')->where('role','user')->get();
        $now = Carbon::now();

        // Process user activity function
        $processUserActivity = function ($users, $prefix) use ($now) {
            return $users->map(function ($user) use ($now, $prefix) {
                $detail = $user->detail;

                if (!$detail) {
                    return null;
                }

                $times = [
                    'login'  => $detail->{$prefix . '_last_login_at'} ? Carbon::parse($detail->{$prefix . '_last_login_at'}) : null,
                    'logout' => $detail->{$prefix . '_last_logout_at'} ? Carbon::parse($detail->{$prefix . '_last_logout_at'}) : null,
                    'active' => $detail->{$prefix . '_last_active_at'} ? Carbon::parse($detail->{$prefix . '_last_active_at'}) : null,
                    'left'   => $detail->{$prefix . '_last_left_at'} ? Carbon::parse($detail->{$prefix . '_last_left_at'}) : null,
                ];

                $latestField = collect($times)->filter()->sortDesc()->keys()->first();
                if (!$latestField) {
                    return null;
                }

                $latestTime = $times[$latestField];
                $diffInMinutes = $latestTime ? $latestTime->diffInMinutes($now) : null;

                // Activity logic
                if ($latestField === 'active') {
                    $user->activity_status = $diffInMinutes <= 10 ? 'active' : 'inactive';
                    $user->activity_priority = $diffInMinutes <= 10 ? 0 : 1;
                } elseif ($latestField === 'login') {
                    $user->activity_status = $diffInMinutes <= 10 ? 'active' : 'inactive';
                    $user->activity_priority = $diffInMinutes <= 10 ? 0 : 1;
                } elseif ($latestField === 'left') {
                    $user->activity_status = 'inactive';
                    $user->activity_priority = 2;
                } elseif ($latestField === 'logout') {
                    $user->activity_status = 'inactive';
                    $user->activity_priority = 3;
                }

                $user->latest_field = $latestField;
                $user->latest_time = $latestTime;
                $user->diff_in_minutes = $diffInMinutes;

                return $user;
            })->filter()->sortBy([
                ['activity_priority', 'asc'],
                ['latest_time', 'desc'],
            ]);
        };

        // Process all user types concurrently
        // $results = Concurrency::run([
        //     'app' => fn() => $processUserActivity($users, 'app'),
        //     'web' => fn() => $processUserActivity($users, 'web'),
        //     'chat_app' => fn() => $processUserActivity($users, 'chat_app'),
        //     'chat_web' => fn() => $processUserActivity($users, 'chat_web'),
        // ]);
        $results = [
            'chat_app' => $processUserActivity($users, 'chat_app'),
            'chat_web' => $processUserActivity($users, 'chat_web'),
            'app'      => $processUserActivity($users, 'app'),
            'web'      => $processUserActivity($users, 'web'),
        ];

        // Assign to individual variables for clarity
        $appUsers = $results['app'];
        $webUsers = $results['web'];
        $chatAppUsers = $results['chat_app'];
        $chatWebUsers = $results['chat_web'];

        // Calculate statistics based on each platform's processed users
        $stats = [];
        foreach ($results as $type => $platformUsers) {
            $stats[$type] = [
                'active' => $platformUsers->where('activity_status', 'active')->count(),
                'inactive' => $platformUsers->where('activity_status', 'inactive')->count(),
                'total' => $platformUsers->count(),
            ];
        }

        return view('admin.user_tracking.user_tracking', compact('results', 'stats'));
    }

    public function userActivityAjax(Request $request)
    {
        if ($request->ajax()) {
            $users = User::whereHas('detail')->with('detail')->get();
            $now = Carbon::now();

            // Same processing logic
            $processUserActivity = function ($users, $prefix) use ($now) {
                return $users->map(function ($user) use ($now, $prefix) {
                    $detail = $user->detail;

                    if (!$detail) {
                        return null;
                    }

                    $times = [
                        'login'  => $detail->{$prefix . '_last_login_at'} ? Carbon::parse($detail->{$prefix . '_last_login_at'}) : null,
                        'logout' => $detail->{$prefix . '_last_logout_at'} ? Carbon::parse($detail->{$prefix . '_last_logout_at'}) : null,
                        'active' => $detail->{$prefix . '_last_active_at'} ? Carbon::parse($detail->{$prefix . '_last_active_at'}) : null,
                        'left'   => $detail->{$prefix . '_last_left_at'} ? Carbon::parse($detail->{$prefix . '_last_left_at'}) : null,
                    ];

                    $latestField = collect($times)->filter()->sortDesc()->keys()->first();
                    if (!$latestField) {
                        return null;
                    }

                    $latestTime = $times[$latestField];
                    $diffInMinutes = $latestTime ? $latestTime->diffInMinutes($now) : null;

                    // Activity logic
                    if ($latestField === 'active') {
                        $user->activity_status = $diffInMinutes <= 10 ? 'active' : 'inactive';
                        $user->activity_priority = $diffInMinutes <= 10 ? 0 : 1;
                    } elseif ($latestField === 'login') {
                        $user->activity_status = $diffInMinutes <= 10 ? 'active' : 'inactive';
                        $user->activity_priority = $diffInMinutes <= 10 ? 0 : 1;
                    } elseif ($latestField === 'left') {
                        $user->activity_status = 'inactive';
                        $user->activity_priority = 2;
                    } elseif ($latestField === 'logout') {
                        $user->activity_status = 'inactive';
                        $user->activity_priority = 3;
                    }

                    $user->latest_field = $latestField;
                    $user->latest_time = $latestTime;
                    $user->diff_in_minutes = $diffInMinutes;

                    return $user;
                })->filter()->sortBy([
                    ['activity_priority', 'asc'],
                    ['latest_time', 'desc'],
                ]);
            };

            // Process all user types concurrently
            $results = Concurrency::run([
                'app' => fn() => $processUserActivity($users, 'app'),
                'web' => fn() => $processUserActivity($users, 'web'),
                'chat_app' => fn() => $processUserActivity($users, 'chat_app'),
                'chat_web' => fn() => $processUserActivity($users, 'chat_web'),
            ]);

            // Calculate statistics based on each platform's processed users
            $stats = [];
            foreach ($results as $type => $platformUsers) {
                $stats[$type] = [
                    'active' => $platformUsers->where('activity_status', 'active')->count(),
                    'inactive' => $platformUsers->where('activity_status', 'inactive')->count(),
                    'total' => $platformUsers->count(),
                ];
            }

            return response()->json([
                'results' => $results,
                'stats' => $stats,
                'timestamp' => now()->format('M d, Y - H:i:s')
            ]);
        }
    }

    public function index(Request $request)
    {
        $userCount = User::where('role', 'user')->count();
        $teamCount = User::where('role', 'team')->count();
        $newuserCount = User::where('role', 'newuser')->count();
        $tickets  = Tickets::count();
        
        $reasons = DB::table('reasons')->get();
        
        $usersWithLateReplies = User::select('id', 'name', 'email')
            ->where('role', 'team')
            ->has('lateMessages')
            ->withCount('lateMessages')
            ->get();
        $responses = [
            'usersWithLateReplies' => $usersWithLateReplies,
            'totalLateMessagesCount' => LateMessages::count(), 
            'reasons' => $reasons, 
        ];
        $response = Http::get('https://webexcels.pk/api/promotion');
        $data = $response->json();
        
        if (isset($data['result']) && $data['result'] === 'found' && isset($data['data'][0]['img'])) {
            $imagePath = $data['folderPath'] . $data['data'][0]['img'];

            return view('admin.dashboard', [
                'userCount' => $userCount,
                'teamCount' => $teamCount,
                'newuserCount' => $newuserCount,
                'responses'=>$responses,
                'imagePath' => $imagePath, 
                'data' => $data['data'],
                'ticket'=>$tickets
            ]);
        } else {
            // Handle if no image found
            return view('admin.dashboard', [
                'userCount' => $userCount,
                'teamCount' => $teamCount,
                'newuserCount' => $newuserCount,
                'responses'=>$responses,
                'ticket'=>$tickets
            ]);
        }
        
    }
    
    private function isTeamMember($userId) {
        // Assuming you have a User model with a role attribute
        $user = User::find($userId);
    
        // Check if the user has a role that designates them as a team member
        if ($user && $user->role === 'user') {
            return true;
        }
    
        return false;
    }

    public function logout()
    {
        auth()->user()->detail()->updateOrCreate([], [
            'web_last_logout_at' => now(),
        ]);

        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
