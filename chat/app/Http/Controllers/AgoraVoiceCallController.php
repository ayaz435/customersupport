<?php

namespace App\Http\Controllers;
use App\Models\UsersQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model


class AgoraVoiceCallController extends Controller
{
    public function Chatdash()
    {
        return view ('chatdash');
    }
    public function Chatdashstore(Request $request)
    {
        // Validate the form data
        $request->validate([
            // Add validation rules for other form fields if needed
            'selected_values' => 'required|array',
            'selected_values.*' => 'string',
        ]);
    
        // Get the authenticated user's ID
        $userId = Auth::id();
    
        // Fetch the authenticated user's information
        $user = User::find($userId);
        $userName = $user->name;
       
        // Get the selected values from the request
        $selectedValues = $request->input('selected_values');
    
        // Save the selected values to the database along with the user's name
        // Example using Eloquent model:
        UsersQuestion::on('xlserp_customersupport')->create([
            'name' => $userName,
            'question' => implode(', ', $selectedValues), // Assuming you want to store them as a comma-separated string
            // Add other fields if needed
        ]);
    
        // Redirect or return a response as needed
        return redirect()->route('chatify');
    }
}
