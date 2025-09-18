<?php

namespace App\Http\Controllers\API;

use Chatify\Http\Controllers\MessagesController as ChatifyMessagesController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Carbon\Carbon;
use App\Models\ChMessage as Message;
use App\Models\ChFavorite as Favorite;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Str;
use App\Models\OtherProjectUser;
use App\Models\ActiveChats;
use App\Models\LateMessages;

use App\Jobs\CheckIfUserRepliedJob;

class CustomMessagesApiController extends ChatifyMessagesController
{
     public function getContacts(Request $request)
    {
     $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        // Fetch contacts from the database that match the authenticated user's email in the 'role' field
        $contacts = DB::table('contacts')
            ->where('role', $user->email)
            ->get();

        // Send the response
        return response()->json([
            'contacts' => $contacts,
        ], 200);
    }
    
     /**
     * Send a message to database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function send(Request $request)
    {


        $error = (object)[
            'status' => 0,
            'message' => null
        ];
        $attachment = null;
        $attachment_title = null;
        $timeDifference = null;
        $formattedTime = null;
        $remainingTime = null;
        $lastMessageTime = null;

        if ($request->hasFile('file')) {
            // Handling attachments
            $allowed_images = Chatify::getAllowedImages();
            $allowed_files  = Chatify::getAllowedFiles();
            // dd(['allowed_images'=>$allowed_images, 'allowed_files'=>$allowed_files]);
            $allowed        = array_merge($allowed_images, $allowed_files);

            $file = $request->file('file');
            // dd(Chatify::getMaxUploadSize());
            if ($file->getSize() < Chatify::getMaxUploadSize()) {
                if (in_array(strtolower($file->extension()), $allowed)) {
                    $attachment_title = $file->getClientOriginalName();
                    $attachment = Str::uuid() . "." . $file->extension();
                    $file->storeAs(config('chatify.attachments.folder'), $attachment, config('chatify.storage_disk_name'));
                } else {
                    $error->status = 1;
                    $error->message = "File extension not allowed!";
                }
            } else {
                $error->status = 1;
                $error->message = "File size you are trying to upload is too large!";
            }
        }
        $fromUser = DB::table('xlserp_customersupport.users')
            ->select('id', 'role', 'name')
            ->where('id', Auth::user()->id)
            ->first();

        $toUser = DB::table('xlserp_customersupport.users')
            ->select('id', 'role', 'name')
            ->where('id', $request['id'])
            ->first();

        if (!$fromUser || !$toUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Assign roles for team and user
        $teammemberName = ($fromUser->role === 'team') ? $fromUser->name : $toUser->name;
        $teammemberId = ($fromUser->role === 'team') ? $fromUser->id : $toUser->id;
        $userName = ($toUser->role === 'user') ? $toUser->name : $fromUser->name;
        $userId = ($toUser->role === 'user') ? $toUser->id : $fromUser->id;

        if (!$error->status) {

            


            // Sending message
            $message = Chatify::newMessage([
                'from_id' => Auth::user()->id,
                'to_id' => $request['id'],
                'body' => htmlentities(trim($request['message']), ENT_QUOTES, 'UTF-8'),
                'team'=>$teammemberName,
                'user'=>$userName,
                'attachment' => ($attachment) ? json_encode((object)[
                    'new_name' => $attachment,
                    'old_name' => htmlentities(trim($attachment_title), ENT_QUOTES, 'UTF-8'),

                ]) : null,
            ]);

//            ProcessChatMessage::dispatch($message)->onQueue('chat');

            if($fromUser->role === 'user'){
                CheckIfUserRepliedJob::dispatch(Auth::user()->id, $request['id'], $message->id,
                    'We’re still connecting you with one of our support team members. Thank you for your patience, and we’ll be with you shortly!',1,2)->delay(now()->addMinutes(2));
            }else{
                
                $ifChatExists = ActiveChats::where('user_id', $userId)->where('team_id', $teammemberId)->first();

                if(!$ifChatExists){
                    ActiveChats::create([
                        'teammember' => $teammemberName,
                        'team_id' => $teammemberId,
                        'user' => $userName,
                        'user_id' => $userId,
                        'chat_active_status'=>1,
                    ]);
                }else{
                    $ifChatExists->chat_active_status = 1;
                        $ifChatExists->save();
                }
                CheckIfUserRepliedJob::dispatch(Auth::user()->id, $request['id'], $message->id,
                    'User active status off ',4,10)->delay(now()->addMinutes(10));
            }


            $messageData = Chatify::parseMessage($message);
            if (Auth::user()->id != $request['id']) {
                Chatify::push("private-chatify." . $request['id'], 'messaging', [
                    'from_id' => Auth::user()->id,
                    'to_id' => $request['id'],
                    'message' => Chatify::messageCard($messageData, true)
                ]);
            }
        }

        // Fetch the user details from the database


        // Retrieve the last and second last messages
        $lastMessage = DB::table('ch_messages')
            ->where(function ($query) use ($teammemberId, $userId) {
                $query->where('from_id', $teammemberId)
                    ->where('to_id', $userId)
                    ->orWhere('from_id', $userId)
                    ->where('to_id', $teammemberId);
            })
            ->orderBy('created_at', 'desc')
            ->first();

        $lastuserMessage = DB::table('ch_messages')
            ->where('from_id', $userId) // Ensure the message is from the user
            ->where('to_id', $teammemberId) // Ensure the message is to the team member
            ->orderBy('created_at', 'desc') // Order by creation time to get the latest message
            ->first(); // Fetch the first (latest) message


        $secondLastMessage = DB::table('ch_messages')
            ->where(function ($query) use ($teammemberId, $userId) {
                $query->where('from_id', $teammemberId)
                    ->where('to_id', $userId)
                    ->orWhere('from_id', $userId)
                    ->where('to_id', $teammemberId);
            })
            ->orderBy('created_at', 'desc')
            ->skip(1) // Skip the first (most recent) message
            ->take(1)
            ->first();

        // Check if the last and second last messages exist
        if ($lastMessage && $secondLastMessage) {
            // Ensure the sequence is team (last) -> user (second last)
            $lastFromUser = DB::table('xlserp_customersupport.users')->find($lastMessage->from_id);
            $secondLastFromUser = DB::table('xlserp_customersupport.users')->find($secondLastMessage->from_id);

            // If last message is from team and second last from user
            if ($lastFromUser->role === 'team' && $secondLastFromUser->role === 'user') {
                // Calculate the time difference only for this valid sequence
                $lastMessageTime = strtotime($lastMessage->created_at);
                $secondLastMessageTime = strtotime($secondLastMessage->created_at);
                $timeDifference = $lastMessageTime - $secondLastMessageTime;

                // Subtract 30 seconds if needed
                if ($timeDifference > 180) {
                    $remainingTime = $timeDifference - 180;
                }

                // Format the time difference
                $formattedTime = $this->formatTimeDifference($timeDifference);

                // Reset the condition after the calculation (to prevent recalculation)
                // This can be done by setting a flag, or by storing the result in a session or cache
                if (!empty($lastuserMessage->body) && !empty($remainingTime) && !empty($teammemberName) && !empty($userName)) {

                    // Prepare data for insertion into LateMessages model
                    $lateMessageData = [
                        'message' => $lastuserMessage->body,
                        'lateminutes' => $remainingTime,
                        'teammember' => $teammemberName,
                        'team_id' => $teammemberId,
                        'user' => $userName
                    ];

                    // Insert data into LateMessages model
                    $lateMessage = LateMessages::create($lateMessageData);

                    // Return the response with the updated structure

                }
            }
        }

        // Check if all required fields have values


        return response()->json([
            'status' => '200',
            'error' => $error,
            'message' => isset($messageData) ? Chatify::messageCard($messageData) : null,
            'lateminutes' => $timeDifference,
            'teammember' => $teammemberName,
            'user' => $userName,
            'remaining_time' => $remainingTime,
            'formatted_time' => $formattedTime,
            'last_message_time' => $lastMessageTime ? date('Y-m-d H:i:s', $lastMessageTime) : null,
        ]);
    }
    
}

