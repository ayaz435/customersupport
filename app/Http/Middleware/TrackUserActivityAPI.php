<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class TrackUserActivityAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Auth::user()->detail()->updateOrCreate([], [
                'app_last_active_at' => now(),
                'app_last_visited_url' => $request->fullUrl(),
            ]);
        }

        return $next($request);
    }
}
