<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Events\UserActive;
use App\Jobs\MarkUserInactive;




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
            auth()->user()->active_status = 1;
            auth()->user()->save();
            Auth::user()->detail()->updateOrCreate([], [
                'chat_app_last_active_at' => now(),
                'chat_app_last_visited_url' => $request->fullUrl(),
            ]);
        }
        broadcast(new UserActive(auth()->user()->id, auth()->user()->name));
        MarkUserInactive::dispatch(auth()->user()->id)->delay(now()->addMinutes(10));


        return $next($request);
    }
}
