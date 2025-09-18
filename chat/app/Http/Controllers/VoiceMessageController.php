<?php

namespace App\Http\Controllers;

use App\Events\VoiceMessageSent;
use App\Models\VoiceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoiceMessageController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $voiceMessage = new VoiceMessage();
        $voiceMessage->user_id = $user->id;
        $voiceMessage->message = $request->input('message'); // Assuming 'message' is the audio data
        $voiceMessage->save();

        broadcast(new VoiceMessageSent($voiceMessage))->toOthers();

        return response()->json($voiceMessage);
    }
}
