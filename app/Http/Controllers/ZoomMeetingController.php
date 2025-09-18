<?php

namespace App\Http\Controllers;

// app/Http/Controllers/ZoomMeetingController.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ZoomMeeting;

class ZoomMeetingController extends Controller
{
    public function create()
    {
        return view('zoom-meetings.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'topic' => 'required',
        'start_time' => 'required|date',
    ]);
 
    // Create a Zoom meeting
    $response = Http::post('https://api.zoom.us/v2/users/me/meetings', [
        'topic' => $request->input('topic'),
        'type' => 2, // Scheduled meeting
        'start_time' => $request->input('start_time'),
    ], [
        'Authorization' => 'Basic ' . base64_encode(config('services.zoom.api_key') . ':' . config('services.zoom.api_secret')),
    ]);
    
    $data = $response->json();
    
    // Save the Zoom meeting details in the database
    ZoomMeeting::create([
        'topic' => $data['topic'] ?? $request->input('topic'), // Use the form value as a fallback
        'start_time' => $data['start_time'] ?? $request->input('start_time'), // Use the form value as a fallback
        'zoom_meeting_id' => $data['id'],
    ]);
    
    return redirect()->route('zoom-meetings.create')->with('success', 'Zoom meeting created successfully');
    

}

}

