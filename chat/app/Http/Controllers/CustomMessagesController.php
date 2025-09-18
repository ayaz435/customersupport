<?php


namespace App\Http\Controllers;

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
use Chatify\Http\Controllers\MessagesController as ChatifyMessagesController;

use App\Jobs\CheckIfUserRepliedJob;
use App\Events\IncomingCallEvent;
use App\Events\ClientCallTimeout;
use App\Events\UserTyping;

//use App\Jobs\ProcessChatMessage;



class CustomMessagesController extends ChatifyMessagesController
{
    protected $perPage = 30;

    public function getMessages($userId, Request $request)
    {
        $messages = Chatify::fetchMessagesQuery($userId, auth()->id())
            ->orderBy('created_at', 'desc') 
            ->paginate($request->get('per_page', 100));
        
        return response()->json([
            'status' => 'success',
            'data' => $messages
        ]);
    }

    /**
     * Authenticate the connection for pusher
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function pusherAuth(Request $request)
    {
        return Chatify::pusherAuth(
            $request->user(),
            Auth::user(),
            $request['channel_name'],
            $request['socket_id']
        );
    }
    
    /**
     * Authenticate the connection for pusher
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function CallDialing(Request $request)
    {
        $validated=$request->validate([
            'name' => 'required|string',
            'channel' => 'required|string',
            'type' => 'required|string',
            'from_id'=>'required|string',
            'to_id'=>'required|string',
            'from_name'=>'required|string',
            'call_type'=>'required|string',
            'timestamp' => 'nullable',
            'channel_id'=>'required|string',
        ]);
        // dd($validated['to_id']);
         // Broadcast the incoming call event to the recipient
        broadcast(new IncomingCallEvent($validated['to_id'], $validated));

        return response()->json([
            'status' => 'success',
            'message' => 'Call initiated successfully',
            'channel_id' => $validated['channel_id'],
            'call_data' => $validated
        ]);
        
        
    }
    
    /**
     * Authenticate the connection for pusher
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function callTimeout(Request $request)
    {
        $validated=$request->validate([
            'name' => 'required|string',
            'channel' => 'required|string',
            'type' => 'required|string',
            'from_id'=>'required|string',
            'to_id'=>'required|string',
            'from_name'=>'required|string',
            'message'=>'required|string',
            'timestamp' => 'nullable',
            'channel_id'=>'required|string',
        ]);
        // dd($validated['to_id']);
         // Broadcast the incoming call event to the recipient
        broadcast(new ClientCallTimeout($validated['to_id'], $validated));

        return response()->json([
            'status' => 'success',
            'message' => 'User missed the call',
            'channel_id' => $validated['channel_id'],
            'call_data' => $validated
        ]);
        
        
    }
    
    /**
     * Authenticate the connection for pusher
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function userTyping(Request $request)
    {
        $validated=$request->validate([
            'from_id'=>'required|string',
            'to_id'=>'required|string',
            'typing'=>'required|boolean',
        ]);
        // dd($validated['to_id']);
         // Broadcast the incoming call event to the recipient
        broadcast(new UserTyping($validated['to_id'], $validated));

        return response()->json([
            'status' => 'success',
            'message' => 'Typing status updated',
            'call_data' => $validated
        ]);
        
        
    }
    
    /**
     * fetch [user/group] messages from database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function agents(Request $request)
    {
        $agents = User::where('role', 'team')
            ->where('id', '!=', Auth::user()->id) // Exclude the current user
            ->where('active_status', 1) // Only include active agents
            ->select('id', 'name', 'avatar') // Only get necessary fields
            ->get();
            
            
        return response()->json([
            'status' => true,
            'agents' => $agents
        ]);
    }

    public function getAvailableAgents(Request $request)
    {
        
        // dd("present");
        // You might want to adjust the query based on your user roles system
        // This example assumes you have a 'role' column or a related role model
        
    }


    /**
     * Returning the view of the app with the required data.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index( $id = null)
    {
        // $messenger_color = Auth::user()->messenger_color;
        return view('Chatify::pages.app', [
            'id' => $id ?? 0,
            'messengerColor' => /*$messenger_color ? $messenger_color :*/ Chatify::getFallbackColor(),
            'dark_mode' => /*Auth::user()->dark_mode < 1 ?*/ 'light'/* : 'dark'*/,
        ]);
    }

    /**
     * Fetch data (user, favorite.. etc).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function idFetchData(Request $request)
    {


        $favorite = Chatify::inFavorite($request['id']);
        $fetch = OtherProjectUser::where('id', $request['id'])->first();
        if($fetch){
            $userAvatar = Chatify::getUserWithAvatar($fetch)->avatar;
        }$activeStatus = $fetch->active;

        return Response::json([
            'favorite' => $favorite,
            'fetch' => $fetch ?? null,
            'user_avatar' => $userAvatar ?? null,
            'active' => $activeStatus,
        ]);
    }

    /**
     * This method to make a links for the attachments
     * to be downloadable.
     *
     * @param string $fileName
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|void
     */
    public function download($fileName)
    {
        $filePath = config('chatify.attachments.folder') . '/' . $fileName;
        if (Chatify::storage()->exists($filePath)) {
            return Chatify::storage()->download($filePath);
        }
        return abort(404, "Sorry, File does not exist in our server or may have been deleted!");
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
            
            if($fromUser->role === 'team'){
                
                $lastTeamMessage = DB::table('ch_messages')
                    ->where('from_id', Auth::user()->id) 
                    ->where('to_id', $request['id']) 
                    ->whereNotIn('body', ['We sincerely apologize for the delay. Our team is currently assisting other customers, but you’re important to us and we’ll respond as soon as possible. Thank you for waiting.', 'We truly appreciate your patience. Our support team is still working to get to your query. If you’d prefer, you can leave your message and contact details — we’ll get back to you as soon as we can.', 'We’re still connecting you with one of our support team members. Thank you for your patience, and we’ll be with you shortly!']) 
                    ->where('message_type', '!=', 'call')
                    ->orderBy('created_at', 'desc') 
                    ->first();
                    
                if($lastTeamMessage) {
                    $UserMessageAfterLastReply = DB::table('ch_messages')
                        ->where('from_id', $request['id']) 
                        ->where('to_id', auth()->id())  
                        ->where('message_type', '!=', 'call')
                        ->where('created_at', '>', $lastTeamMessage->created_at)
                        ->where('created_at', '<', Carbon::now())  
                        ->orderBy('created_at', 'asc')    
                        ->first(); 
                }else{
                    $UserMessageAfterLastReply = DB::table('ch_messages')
                        ->where('from_id', $request['id']) 
                        ->where('to_id', auth()->id())
                        ->where('message_type', '!=', 'call')
                        ->orderBy('created_at', 'asc')    
                        ->first(); 
                }
                
                if($UserMessageAfterLastReply){
                    $messageTime = Carbon::parse($UserMessageAfterLastReply->created_at);
                    $currentTime = Carbon::now();
                
                    $differenceInSeconds = $messageTime->diffInSeconds($currentTime);
                    if($differenceInSeconds> 180){
                        $hours = floor($differenceInSeconds / 3600);
                        $minutes = floor(($differenceInSeconds % 3600) / 60);
                        $seconds = $differenceInSeconds % 60;
                        
                        $formatted = sprintf('%02dh %02dm %02ds', $hours, $minutes, $seconds);
                        
                        $lateMessageData = [
                            'message' => $UserMessageAfterLastReply->body,
                            'lateminutes' => $formatted,
                            'teammember' => $teammemberName,
                            'team_id' => $teammemberId,
                            'user' => $userName,
                            'user_id'=>$userId ,
                            'user_message_id'=>$UserMessageAfterLastReply->id
                        ];
    
                        $lateMessage = LateMessages::create($lateMessageData);
                    }
                    
                }
                    
                  
            }
                    
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
            $message->message_type=$request['message_type'];
            $message->save();

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
    
    
    /**
     * Format time difference into days, hours, minutes, and seconds.
     *
     * @param int $seconds
     * @return string
     */
    private function formatTimeDifference($seconds)
    {
        $days = floor($seconds / 86400);
        $seconds %= 86400;

        $hours = floor($seconds / 3600);
        $seconds %= 3600;

        $minutes = floor($seconds / 60);
        $seconds %= 60;

        $formattedTime = [];
        if ($days > 0) {
            $formattedTime[] = $days . ' day' . ($days > 1 ? 's' : '');
        }
        if ($hours > 0) {
            $formattedTime[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
        }
        if ($minutes > 0) {
            $formattedTime[] = $minutes . ' minute' . ($minutes > 1 ? 's' : '');
        }
        if ($seconds > 0 || empty($formattedTime)) {
            $formattedTime[] = $seconds . ' second' . ($seconds > 1 ? 's' : '');
        }

        return implode(', ', $formattedTime);
    }


    /**
     * fetch [user/group] messages from database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetch(Request $request)
    {
        $chatId = $request['id'];

        // Assuming you want to fetch all messages without pagination
        $messages = Chatify::fetchMessagesQuery($chatId)->latest()->get();

        $totalMessages = $messages->count();

        $response = [
            'total' => $totalMessages,
            'messages' => '',
        ];

        // if there are no messages yet.
        if ($totalMessages < 1) {
            $response['messages'] = '<p class="message-hint center-el"><span>Say \'hi\' and start messaging</span></p>';
            return Response::json($response);
        }

        $allMessages = null;
        foreach ($messages->reverse() as $message) {
            $allMessages .= Chatify::messageCard(
                Chatify::parseMessage($message)
            );
        }

        $response['messages'] = $allMessages;

        return Response::json($response);
    }
    /**
     * Make messages as seen
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function seen(Request $request)
    {
        $updatedCount= Message::where('to_id', auth()->id())
                                ->where('from_id', $request['id'])
                                ->where('seen', 0)
                                ->update(['seen' => 1]);
        
        // make as seen
        $seen = Chatify::makeSeen($request['id']);
        // send the response
        return Response::json([
            'status' => $seen, 
            'seen_marked_count' => $updatedCount ,      
            ], 200);
    }
    

    public function getContacts(Request $request)
    {
        // get all users that received/sent message from/to [Auth user]
        $users = Message::join('users', function ($join) {
            $join->on('ch_messages.from_id', '=', 'users.id')
                ->orOn('ch_messages.to_id', '=', 'users.id');
        })
        ->where(function ($q) {
            $q->where('ch_messages.from_id', Auth::user()->id)
            ->orWhere('ch_messages.to_id', Auth::user()->id);
        })
        ->where('users.id', '!=', Auth::user()->id)
        ->select([
            'users.id',
            'users.name',
            'users.email',
            'users.avatar',
            // Add other specific columns you need
            DB::raw('MAX(ch_messages.created_at) as max_created_at')
        ])
        ->orderBy('max_created_at', 'desc')
        ->groupBy('users.id', 'users.name', 'users.email', 'users.avatar') // List all non-aggregate columns
        ->paginate($request->per_page ?? $this->perPage);
        
        $usersList = $users->items();
        if (count($usersList) > 0) {
            $contacts = '';
            foreach ($usersList as $user) {
                $contacts .= Chatify::getContactItem($user);
            }
        } else {
            $contacts = '<p class="message-hint center-el"><span>Your contact list is empty</span></p>';
        }
        
        return Response::json([
            'contacts' => $contacts,
            'total' => $users->total() ?? 0,
            'last_page' => $users->lastPage() ?? 1,
        ], 200);
    }
    
    public function apiGetContacts(Request $request)
    // public function getContactsitems(Request $request)
    {
        // retuen;
        // get all users that received/sent message from/to [Auth user]
        $users = Message::join('users', function ($join) {
            $join->on('ch_messages.from_id', '=', 'users.id')
                ->orOn('ch_messages.to_id', '=', 'users.id');
        })
        ->where(function ($q) {
            $q->where('ch_messages.from_id', Auth::user()->id)
            ->orWhere('ch_messages.to_id', Auth::user()->id);
        })
        ->where('users.id', '!=', Auth::user()->id)
        ->select([
            'users.id',
            'users.name',
            'users.email',
            'users.email_verified_at',
            'users.role',
            'users.remember_token',
            'users.created_at',
            'users.updated_at',
            'users.active_status',
            'users.avatar',
            'users.dark_mode',
            'users.messenger_color',
            'users.notifications',
            'users.designation',
            'users.cname',
            'users.com_id',
            'users.last_seen',
            
            DB::raw('MAX(ch_messages.created_at) as max_created_at')
        ])
        ->orderBy('max_created_at', 'desc')
        ->groupBy(
            'users.id',
            'users.name',
            'users.email',
            'users.email_verified_at',
            'users.role',
            'users.remember_token',
            'users.created_at',
            'users.updated_at',
            'users.active_status',
            'users.avatar',
            'users.dark_mode',
            'users.messenger_color',
            'users.notifications',
            'users.designation',
            'users.cname',
            'users.com_id',
            'users.last_seen'
        )
        ->paginate($request->per_page ?? $this->perPage);
        
        $usersList = $users->items();
                // dd($usersList);

        // if (count($usersList) > 0) {
            $contacts = [];

            foreach ($usersList as $user) {
                $contacts[] = [
                    'id' => 1,
                    'user_id' => $user->id,
                    'contact_item' => Chatify::getContactItem($user),
                    'role' => Auth::user()->email
                ];
            }
        // } else {
        //     $contacts = '<p class="message-hint center-el"><span>Your contact list is empty</span></p>';
        // }
        
        return Response::json([
            'contacts' => $contacts,
            'total' => $users->total() ?? 0,
            'last_page' => $users->lastPage() ?? 1,
        ], 200);
    }


    /**
     * Update user's list item data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateContactItem(Request $request)
    {
        // Get authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        // Get the user data for the specified user_id
        $targetUser = OtherProjectUser::find($request->user_id);
        if (!$targetUser) {
            return response()->json([
                'message' => 'User not found!',
            ], 404);
        }

        // Assuming Chatify::getContactItem expects a Message model, adapt this if needed
        $contactItem = Chatify::getContactItem($targetUser);

        // Debugging: Check the value of $contactItem
        if (is_null($contactItem)) {
            return response()->json([
                'message' => 'Contact item is null!',
            ], 500);
        }

        // Save or update the contact item in the database
        DB::table('contacts')->updateOrInsert(
            ['user_id' => $request->user_id], // assuming 'user_id' is the unique identifier
            [
                'contact_item' => $contactItem,
                'role' => $user->email, // Assuming 'role' is where you want to store the email
            ]
        );

        // Send the response
        return response()->json([
            'contactItem' => $contactItem,
        ], 200);
    }

    /**
     * Put a user in the favorites list
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function favorite(Request $request)
    {
        $userId = $request['user_id'];
        // check action [star/unstar]
        $favoriteStatus = Chatify::inFavorite($userId) ? 0 : 1;
        Chatify::makeInFavorite($userId, $favoriteStatus);

        // send the response
        return Response::json([
            'status' => @$favoriteStatus,
        ], 200);
    }

    /**
     * Get favorites list
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function getFavorites(Request $request)
    {
        $favoritesList = '';
        $loggedInUser = Auth::user();

        if ($loggedInUser->role === 'team') {
            $users = OtherProjectUser::where('role', 'user')
                ->where('active_status', '1')
                ->get();
        } else {
            $users = OtherProjectUser::select(
                        'users.*',
                        DB::raw("(
                            SELECT COUNT(*)
                            FROM active_chats
                            WHERE active_chats.team_id = users.id
                            AND active_chats.chat_active_status = 1
                        ) as active_chats_count")
                    )
                    ->where('role', 'team')
                    ->where('active_status', 1)
                    ->orderBy('active_chats_count', 'asc')
                    ->get();

        }

        if($users){
            foreach ($users as $user) {
                if ($loggedInUser && $user->id !== $loggedInUser->id) {
                    $favoritesList .= view('Chatify::layouts.favorite', ['user' => $user])->render();
                }
            }
            if ($loggedInUser->role !== 'team') {
                return response()->json([
                'count' => $users->count(),
                'favorites' => $users->count() > 0 ? $favoritesList : null,
                'name' => $users[0]['name'],
                'chat_count' => $users[0]['active_chats_count']
                ], 200);
            }else{
                return response()->json([
                'count' => $users->count(),
                'favorites' => $users->count() > 0 ? $favoritesList : null,
                'name' => "No",
                'chat_count' => 0
                ], 200);
            }

        }


        return response()->json(['message' => 'No active chats found'], 404);
    }

    public function getchatTransferTo(Request $request)
    {
        $favoritesList = '';

        // Get the team member with the least number of active chats
        $teamMemberCounts = ActiveChats::select('teammember', DB::raw('COUNT(*) as chat_count'))
            ->groupBy('teammember')
            ->orderBy('chat_count', 'asc')
            ->first();

        if ($teamMemberCounts) {
            $nameWithLeastChats = $teamMemberCounts->teammember;
            $leastChatCount = $teamMemberCounts->chat_count;

            // Get the currently authenticated user
            $loggedInUser = Auth::user();

            // Determine the role and fetch only active users
            if ($loggedInUser->role === 'team') {
                // Fetch active team members with least chats
                $filteredUsers = OtherProjectUser::where('role', 'team')
       //                    ->where('designation', 'activeuser')
                    ->where('active_status', '1')
                    ->get();

                // Now filter based on name
                $users = $filteredUsers->where('name', $nameWithLeastChats);
            }

            foreach ($users as $user) {
                if ($loggedInUser && $user->id !== $loggedInUser->id) {
                    $favoritesList .= view('Chatify::layouts.favorite', ['user' => $user])->render();
                }
            }

            return response()->json([
                'count' => $users->count(),
                'favorites' => $users->count() > 0 ? $favoritesList : null,
                'name' => $nameWithLeastChats,
                'chat_count' => $leastChatCount
            ], 200);
        }

        return response()->json(['message' => 'No active chats found'], 404);
    }


    /**
     * Search in messenger
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function search(Request $request)
    {
        $getRecords = null;
        $input = trim(filter_var($request['input']));

        // Fetch all users with role 'team' from the "other_project" database
        if (Auth::user()->role === 'team') {
            // Fetch all users with the 'user' role
            $records = OtherProjectUser::where('id', '!=', Auth::user()->id)
                ->where('role', 'user');
        } else {
            // Fetch all users with the 'team' role
            $records = OtherProjectUser::where('id', '!=', Auth::user()->id)
                ->where('role', 'team');
        }


        // If a search term is provided, add the search condition
        if ($input !== '') {
            $records->where('cname', 'LIKE', "%{$input}%");
        }

        // Paginate the results
        $records = $records->paginate($request->per_page ?? $this->perPage);

        foreach ($records->items() as $record) {
            // Get the user information with avatar from the "other_project" database
            $user = Chatify::getUserWithAvatar($record);

            $getRecords .= view('Chatify::layouts.listItem', [
                'get' => 'search_item',
                'user' => $user,
            ])->render();
        }

        // If there are no users with the specified role
        if ($records->total() < 1) {
            $getRecords = '<p class="message-hint center-el"><span>Invalid Name</span></p>';
        }

        // send the response
        return response()->json([
            'records' => $getRecords,
            'total' => $records->total(),
            'last_page' => $records->lastPage(),
        ], 200);
    }


    /**
     * Get shared photos
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function sharedPhotos(Request $request)
    {
        $shared = Chatify::getSharedPhotos($request['user_id']);
        $sharedPhotos = null;

        // shared with its template
        for ($i = 0; $i < count($shared); $i++) {
            $sharedPhotos .= view('Chatify::layouts.listItem', [
                'get' => 'sharedPhoto',
                'image' => Chatify::getAttachmentUrl($shared[$i]),
            ])->render();
        }
        // send the response
        return Response::json([
            'shared' => count($shared) > 0 ? $sharedPhotos : '<p class="message-hint"><span>Nothing shared yet</span></p>',
        ], 200);
    }

    /**
     * Delete conversation
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteConversation(Request $request)
    {
        // delete
        $delete = Chatify::deleteConversation($request['id']);

        // send the response
        return Response::json([
            'deleted' => $delete ? 1 : 0,
        ], 200);
    }

    /**
     * Delete message
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteMessage(Request $request)
    {
        // delete
        $delete = Chatify::deleteMessage($request['id']);

        // send the response
        return Response::json([
            'deleted' => $delete ? 1 : 0,
        ], 200);
    }

    public function updateSettings(Request $request)
    {
        $msg = null;
        $error = $success = 0;

        // dark mode
        if ($request['dark_mode']) {
            $request['dark_mode'] == "dark"
                ? OtherProjectUser::where('id', Auth::user()->id)->update(['dark_mode' => 1])  // Make Dark
                : OtherProjectUser::where('id', Auth::user()->id)->update(['dark_mode' => 0]); // Make Light
        }

        // If messenger color selected
        if ($request['messengerColor']) {
            $messenger_color = trim(filter_var($request['messengerColor']));
            OtherProjectUser::where('id', Auth::user()->id)
                ->update(['messenger_color' => $messenger_color]);
        }
        // if there is a [file]
        if ($request->hasFile('avatar')) {
            // allowed extensions
            $allowed_images = Chatify::getAllowedImages();

            $file = $request->file('avatar');
            // check file size
            if ($file->getSize() < Chatify::getMaxUploadSize()) {
                if (in_array(strtolower($file->extension()), $allowed_images)) {
                    // delete the older one
                    if (Auth::user()->avatar != config('chatify.user_avatar.default')) {
                        $avatar = Auth::user()->avatar;
                        if (Chatify::storage()->exists($avatar)) {
                            Chatify::storage()->delete($avatar);
                        }
                    }
                    // upload
                    $avatar = Str::uuid() . "." . $file->extension();
                    $update = OtherProjectUser::where('id', Auth::user()->id)->update(['avatar' => $avatar]);
                    $file->storeAs(config('chatify.user_avatar.folder'), $avatar, config('chatify.storage_disk_name'));
                    $success = $update ? 1 : 0;
                } else {
                    $msg = "File extension not allowed!";
                    $error = 1;
                }
            } else {
                $msg = "File size you are trying to upload is too large!";
                $error = 1;
            }
        }

        // send the response
        return Response::json([
            'status' => $success ? 1 : 0,
            'error' => $error ? 1 : 0,
            'message' => $error ? $msg : 0,
        ], 200);
    }

    /**
     * Set user's active status
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function setActiveStatus(Request $request)
    {
        $activeStatus = $request['status'] > 0 ? 1 : 0;
        auth()->user()->active_status = $activeStatus ;
        auth()->user()->save(); 

        return Response::json([
            'status' => true,
        ], 200);
    }


    public function userActiveStatus($id)
    {
        $user = User::with('detail')->find($id);

        if (!$user || !$user->detail) {
            return response()->json([
                'success' => false,
                'message' => 'User or user detail not found',
            ], 404);
        }

        $now = Carbon::now();
        $detail = $user->detail;
        $times = [
            'login'  => $detail->chat_app_last_login_at ? Carbon::parse($detail->chat_app_last_login_at) : null,
            'logout' => $detail->chat_app_last_logout_at ? Carbon::parse($detail->chat_app_last_logout_at) : null,
            'active' => $detail->chat_app_last_active_at ? Carbon::parse($detail->chat_app_last_active_at) : null,
            'left'   => $detail->chat_app_last_left_at ? Carbon::parse($detail->chat_app_last_left_at) : null,
        ];
        $latestEntry = collect($times)
            ->filter()
            ->sortDesc()
            ->first();

        if (!$latestEntry) {
            return response()->json([
                'success' => false,
                'message' => 'No activity data available',
            ], 404);
        }

        $latestField = collect($times)
            ->filter()
            ->sortDesc()
            ->keys()
            ->first();
        $diffInMinutes = $latestEntry->diffInMinutes($now);
        [$activityStatus, $activityPriority] = $this->getActivityStatusAndPriority($latestField, $diffInMinutes);

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'activity_status' => $activityStatus,
            'activity_priority' => $activityPriority,
            'latest_field' => $latestField,
            'latest_time' => $latestEntry,
            'diff_in_minutes' => $diffInMinutes,
        ]);
    }

    private function getActivityStatusAndPriority($latestField, $diffInMinutes)
    {
        switch ($latestField) {
            case 'active':
            case 'login':
                return $diffInMinutes <= 10 
                    ? ['active', 0] 
                    : ['inactive', 1];
            
            case 'left':
                return ['inactive', 2];
            
            case 'logout':
                return ['inactive', 3];
            
            default:
                return ['inactive', 4];
        }
    }
    
    
}
