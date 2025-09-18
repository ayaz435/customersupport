<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckDashboardAccess
{
    public function handle($request, Closure $next, $role)
    {
        $userRole = Auth::check() ? Auth::user()->role : session('user_role');

        if ($userRole !== $role) {
            // Redirect to the appropriate dashboard
            switch ($userRole) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'team':
                    return redirect()->route('team.dashboard');
                case 'user':
                    return redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
}
