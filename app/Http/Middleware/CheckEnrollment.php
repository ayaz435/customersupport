<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Enroll;

class CheckEnrollment
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // Get the user's enrollment status
            $enroll = Enroll::where('id', auth()->user()->id)
                            ->where('status', 'Enrolled')
                            ->first();

            // If enrolled, allow access to the route
            if ($enroll) {
                return $next($request);
            }
        }

        // If not authenticated or not enrolled, redirect to check-voucher route
        return redirect()->route('check-voucher')->with('error', 'Please check your enrollment status.');
    }
}
