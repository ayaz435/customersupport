<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requestmeeting;


class RequestmeetingController extends Controller
{
    public function request(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'team' => 'required',
            'app' => 'required',
            'reason' => 'required'
        ]);

        // Create a new request meeting
        $requestmeeting = new Requestmeeting;
        $requestmeeting->name = $request->name;
        $requestmeeting->email = $request->email;
        $requestmeeting->team = $request->team;
        $requestmeeting->app = $request->app;
        $requestmeeting->reason = $request->reason;
        $requestmeeting->save();

        // Retrieve users with the 'team' role


        // Redirect back with success message and users
        return redirect()->back()->with('success', 'Request Sent Successfully');
    }


}
