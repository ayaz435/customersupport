<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\Chat;
use App\Models\Complain;
use App\Models\Tickets;
use App\Models\Notification;
use App\Models\User;
use App\Models\UsersQuestion;
use App\Models\inbox;
use App\Models\Reason;
use App\Models\Followup3;
use App\Models\Followup6;
use App\Models\Followup9;
use App\Models\LateMessages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class AdminChatsController extends Controller
{
    public function usersInsert(){
        $responsedata=[];
        $users_array=[];
        $exist_user_id=[];
        $not_exist=[];
        $existingUseremail=[];
        for ($i=1; $i<=15;$i++ ){
            $responseb = Http::get("https://webexcels.pk/api/active-support-customer?batch_number=$i");
            $responseDatab = $responseb->json();
            
            foreach ($responseDatab['data'] as $user) {
                if(isset($user['email'])){
                        $drm_user_email=$user['email'];
                        $existingUser = User::where('email', $user['email'])->first();
                        if($existingUser)    $existingUseremail[$user['email']]=true; 
                    }
                    else{
                        $drm_user_email=null;
                        $existingUser = true;
                    }
                
                $existingUserID = User::where('drm_user_id', $user['user_id'])->first();
                if($existingUserID){
                    $exist_user_id[$user['id']]=true;
                }else{
                    $not_exist[$user['id']]=true;
                }
                
                $password = Str::random(12);
                if (!$existingUser) {
                    if($user['create_date']=="0000-00-00 00:00:00"){
                        $create_date=null;
                    }
                    else{
                        $create_date=$user['create_date'];
                    }
                    
                    $newUser = User::create([
                        'drm_user_id' => $user['user_id'],
                        'name' => $user['name'],
                        'email' => $drm_user_email,
                        'cname' => $user['cname'],
                        'com_id' => $user['com_id'],
                        'password' => Hash::make($password),
                        'gm_approve_status'=> "Approved",
                        'creation_date'=> $create_date,
                        // 'ac_approve_date'=> $user['ceo_disc_status'],
                        // 'hod_approve_date'=> $user['acc_disc_status'],
                        'role' => 'user',
                    ]);
                    $users_array[$user['user_id']]=$user;
                    if($newUser){
                        DB::table('password_text')->insert([
                            'user_id' => $newUser->id,
                            'password' => $password
                        ]);
                    }
                    
                }
                
            }
            
        }
        
            
             
            

        $existing_users = User::where('role', "user")->count();
        
        dd(['exist_uses_id'=>$exist_user_id, 'not_exist'=>$not_exist,'users_added'=>  $users_array,'existing_users'=>$existing_users, 'existingUseremail'=>$existingUseremail]);
    }

    public function followupform($id, $cname, $a, $phone = null)
    {
        $activeUsers = User::where('role', 'team')
                ->where('id', '!=', Auth::user()->id) // Exclude the current user
                ->where('active_status', 1) // Only include active agents
                ->select('id', 'name', 'avatar') // Only get necessary fields
                ->get();
        // $activeUsers = User::where('designation', 'activeuser')->select('id', 'name')->get();
        return view('admin.followupform',compact('id', 'cname','phone', 'a' , 'activeUsers'));
    }

    public function followupFormSubmit(Request $request)
    {
            // dd($request->all());

        $request->validate([
            'cid' => 'required',
            'a' => 'required',
            'company' => 'required',
            'task' => 'required',
            'team' => 'required',
            'team_id' => 'required|integer|exists:users,id',
            'priority' => 'required',
            'detail' => 'nullable',
            'communication' => 'nullable|array',
        ]);

          $followupModel = null;
    
        if ($request->a == 3) {
            $followupModel = new Followup3();
        } elseif ($request->a == 6) {
            $followupModel = new Followup6();
        }
        elseif ($request->a == 9) {
            $followupModel = new Followup9();
        }
    
        if (!$followupModel) {
            return redirect()->back()->with('error', 'Invalid task selection.');
        }
    
        $followupModel->cid = $request->cid;
        $followupModel->cname = $request->company;
        $followupModel->phone = $request->phone;
        $followupModel->task = $request->task;
        $followupModel->team = $request->team;
        $followupModel->team_id = $request->team_id;
        $followupModel->date = now()->format('M d, Y');
        $followupModel->comunicationtype = $request->filled('communication')
            ? implode(', ', $request->communication)
            : null;
        $followupModel->priority = $request->priority;
        $followupModel->detail = $request->detail;
    
        $followupModel->save();
        
    
        return redirect()->route('admin.followup')->with('success', 'Followup saved successfully!');
    }

public function followup()
{
    $response = Http::get('https://webexcels.pk/api/in-service-three-month');
    $responseData = $response->json();
    $data = isset($responseData['data']) && is_array($responseData['data']) ? $responseData['data'] : [];
    $datacount = count($data);

    $responseb = Http::get('https://webexcels.pk/api/in-service-six-month');
    $responseDatab = $responseb->json();
    $datab = isset($responseDatab['data']) && is_array($responseDatab['data']) ? $responseDatab['data'] : [];
    $datacountb = count($datab);

    
    $responsec = Http::get('https://webexcels.pk/api/in-service-one-year');
    $responseDatac = $responsec->json();
    $datac = isset($responseDatac['data']) && is_array($responseDatac['data']) ? $responseDatac['data'] : [];
    $datacountc = count($datac);
    
    return view('admin.followup' ,compact('datacount','datacountb','datacountc'));
}
public function followup3()
{
    try {
        // Fetch data from the API
        $response = Http::get('https://webexcels.pk/api/in-service-three-month');

        // Decode JSON response
        if ($response->successful()) {
            $responseData = $response->json();

            // Ensure 'data' exists and is an array
            $data = isset($responseData['data']) && is_array($responseData['data']) ? $responseData['data'] : [];
        } else {
            $data = []; // Fallback for unsuccessful response
        }
    } catch (\Exception $e) {
        $data = []; // Fallback for exceptions
        \Log::error("Error fetching data from API: " . $e->getMessage());
    }

    // Pass the data to the view
    return view('admin.followup3', ['data' => $data]);
}
public function followup6()
{
    try {
        // Fetch data from the API
        $response = Http::get('https://webexcels.pk/api/in-service-six-month');

        // Decode JSON response
        if ($response->successful()) {
            $responseData = $response->json();

            // Ensure 'data' exists and is an array
            $data = isset($responseData['data']) && is_array($responseData['data']) ? $responseData['data'] : [];
        } else {
            $data = []; // Fallback for unsuccessful response
        }
    } catch (\Exception $e) {
        $data = []; // Fallback for exceptions
        \Log::error("Error fetching data from API: " . $e->getMessage());
    }

    // Pass the data to the view
    return view('admin.followup6', ['data' => $data]);
}
public function followup9()
{
    try {
        // Fetch data from the API
        $response = Http::get('https://webexcels.pk/api/in-service-one-year');

        // Decode JSON response
        if ($response->successful()) {
            $responseData = $response->json();

            // Ensure 'data' exists and is an array
            $data = isset($responseData['data']) && is_array($responseData['data']) ? $responseData['data'] : [];
        } else {
            $data = []; // Fallback for unsuccessful response
        }
    } catch (\Exception $e) {
        $data = []; // Fallback for exceptions
        \Log::error("Error fetching data from API: " . $e->getMessage());
    }

    // Pass the data to the view
    return view('admin.followup9', ['data' => $data]);
}
public function completedtask()
{
    return view('admin.completedtask');
}

    public function chat(Request $request)
    {
        $chatdb = env('CHAT_DB_DATABASE');
         $supportdb = env('DB_DATABASE');
        $teamMembers = User::where('role', 'team')->pluck('name', 'id');
        $users = User::where('role', 'user')->pluck('name', 'id');
       $ch_messages = DB::connection($chatdb)
    ->table('ch_messages')
    ->join(DB::raw($supportdb . '.users as from_user'), 'ch_messages.from_id', '=', DB::raw('from_user.id'))
    ->join(DB::raw($supportdb . '.users as to_user'), 'ch_messages.to_id', '=', DB::raw('to_user.id'))
    ->select('ch_messages.*', DB::raw('from_user.name as from_name'), DB::raw('to_user.name as to_name'))
    ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'ch_messages' => $ch_messages
            ]);
        } else {
            return view('admin.chats.chats', [
                'ch_messages' => $ch_messages,
                'teamMembers' => $teamMembers,
                'users' => $users,
            ]);
        }
    }


public function inboxstore(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'role' => 'required',
            'message' => 'required',
        ]);

        // Create a new instance of the Inbox model
        $inbox = new inbox();
        $inbox->role = $request->role;
        $inbox->message = $request->message;
        $inbox->save();

        // Redirect back or wherever you want after storing the data
        return redirect()->back()->with('success', 'Message sent successfully!');
    }

 


   public function fetchUserApiData()
{
    // Step 1: Fetch all company IDs from the first API
    $initialResponse = Http::get('https://webexcels.pk/api/in-service-customers');
    
    // Check if the initial request was successful
    if (!$initialResponse->successful()) {
        return response()->json(['error' => 'Failed to fetch company IDs'], 500);
    }
    
    // Parse the JSON response containing company IDs
    $companyData = json_decode($initialResponse->body(), true);
    
    // Check if data exists and is in the expected format
    if (!isset($companyData['data']) || !is_array($companyData['data'])) {
        return response()->json(['error' => 'Invalid company data format'], 500);
    }
    
    $processedUsers = [];
    $errors = [];
    
    
    dd($companyData);
    // Step 2: Process each company ID
    foreach ($companyData['data'] as $company) {
        // Make sure the company has a com_id
        if (!isset($company['com_id'])) {
            $errors[] = 'Missing com_id in company data';
            continue;
        }
        
        $comId = $company['com_id'];

        // Step 3: Make a request to the second API for each company ID
        $userResponse = Http::get("https://webexcels.pk/api/cname/{$comId}");
        
        if (!$userResponse->successful()) {
            $errors[] = "Failed to fetch data for company ID: {$comId}";
            continue;
        }
        
        $userData = json_decode($userResponse->body(), true);
        
        // Check if user data is valid
        if (!isset($userData['status']) || $userData['status'] !== "true" || !isset($userData['data'])) {
            $errors[] = "Invalid user data format for company ID: {$comId}";
            continue;
        }
        
        // Extract the user details
        $userDetails = $userData['data'];
        
        // Store individual fields in variables
        $name = $userDetails['name'] ?? 'Unknown';
        $email = $userDetails['email'] ?? 'unknown@example.com';
        $cname = $userDetails['cname'] ?? 'Unknown';
        
        // Store for response
        $processedUsers[] = [
            'com_id' => $comId,
            'name' => $name,
            'email' => $email,
            'cname' => $cname
        ];
        
        // Check if the user already exists
        $existingUser = User::where('email', $email)->first();
        
        if (!$existingUser) {
            $password = Str::random(12);
            $newUser = User::create([
                'name' => $name,
                'email' => $email,
                'cname' => $cname,
                'password' => bcrypt($password),
                'role' => 'user',
            ]);
            
            // Send welcome email to the new user
            // Mail::to($newUser->email)->send(new WelcomeEmail($newUser));
        }
    }
    
    // Return a JSON response with results
    return response()->json([
        'message' => 'Data processing completed',
        'processed_users' => count($processedUsers),
        'errors' => count($errors) > 0 ? $errors : null,
        'users' => $processedUsers
    ]);
}


    public function fetchTeamApiData()
    {

        $response = Http::get('https://webexcels.pk/api/team');

        if ($response->successful()) {
            $jsonBody = $response->body();
            $data = json_decode($jsonBody, true);

            foreach ($data['data'] as $user) {
                $existingUser = User::where('email', $user['email'])->first();
                $password = Str::random(12);
                if (!$existingUser) {
                    
                    $user=User::create([
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'drm_user_id' => $user['user_id'],
                        'designation' => $user['designation'],
                        'password' => $password, 
                        'role' => 'team',

                    ]);
                    if($user){
                        DB::table('password_text')->insert([
                            'user_id' => $user->id,
                            'password' => $password
                        ]);
                    }
                    
                }
            }

            return response()->json(['message' => 'Data fetched and stored successfully']);
        } else {
            return response()->json(['error' => 'Failed to fetch API data'], 500);
        }
    }

    public function fetchServiceMembers()
    {
        DB::beginTransaction();
        try{
            $response = Http::get('https://webexcels.pk/api/service-team');

            if (!$response->successful()) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to fetch API data'], 500);
            }

            $data = json_decode($response->body(), true);
            
            foreach ($data['data'] as $user) {
                // dd($user['name'],$user['user_id'],$user['email'],$user['role_name'],bcrypt('qwerasdfcvcbn'));
                $existingUser = User::where('email', $user['email'])->first();

                if(!$existingUser) {
                    $password = Str::random(12);
                    
                    try{
                        $newUser = User::create([
                            'name' => $user['name'],
                            'email' => $user['email'],
                            'drm_user_id' => $user['user_id'],
                            'designation' => $user['role_name'],
                            'password' => bcrypt($password), 
                            'role' => 'service',
                        ]);

                        if ($newUser) {
                            DB::table('password_text')->insert([
                                'user_id' => $newUser->id,
                                'password' => $password
                            ]);
                        }
                    } catch (\Exception $e) {
                        DB::rollBack();
                        throw $e;
                    }
                }else{
                    $existingUser->update([
                        'role' => 'service',
                        'designation' => $user['role_name']
                    ]);

                    $existingPassword = DB::table('password_text')
                        ->where('user_id', $existingUser->id)
                        ->value('password');

                    // Mail::to($existingUser->email)->send(new WelcomeEmail($existingUser,$existingPassword));
                }
            }
            DB::commit();
            return redirect()->route('admin.register-service')->with('success', 'Data fetched and stored successfully');
        } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'error' => 'An error occurred while processing the data.',
                    'details' => $e->getMessage(),
                ], 500);
            }
    }

    public function latemessage(Request $request)
    {

        $response = DB::select('SELECT * FROM late_messages');
        $result = User::select('id', 'name', 'email')
            ->where('role', 'team')
            ->has('lateMessages')
            ->withCount('lateMessages')
            ->get();
       
       return view('admin.chats.chatsfetch', compact('response','result'));
    }
    

// Function to check if a user is a team member
private function isTeamMember($userId) {
    // Assuming you have a User model with a role attribute
    $user = User::find($userId);

    // Check if the user has a role that designates them as a team member
    if ($user && $user->role === 'user') {
        return true;
    }

    return false;
}

public function storeReason(Request $request, $id)
{
    $chatdb = env('CHAT_DB_DATABASE');
         $supportdb = env('DB_DATABASE');
    // Validate the incoming data
    $request->validate([
        'reason' => 'required',
    ]);

    // Retrieve the reason input
    $reason = $request->input('reason');

    // Update the database using a raw query
    LateMessages::where('id', $id)
        ->update(['reason' => $reason]);

    // Return response
    return redirect()->back()->with('success', 'Reason updated successfully.');
}


    public function teamLateMessage(Request $request)
    {
        $authName = Auth::user()->name;
        $responseb = LateMessages::where('team_id', Auth::id())
            ->get();
    
        $result = LateMessages::where('team_id', Auth::id())
            ->get()
            ->groupBy('team_id')
            ->map->count()
            ->toArray();
        $user = $request->user();
        $messages = Inbox::where('role', $user->role)->get();
    
        $submittedMessageIds = LateMessages::whereNotNull('reason')  // Only include rows where the 'reason' field is not null
        ->where('reason', '!=', '')  // Ensure 'reason' is not an empty string
        ->pluck('id')
        ->toArray();
    
        $data = Followup3::where('team', $authName)->count();
        $data2 = Followup6::where('team', $authName)->count();
        $data3 = Followup9::where('team', $authName)->count();
        $tickets  = Tickets::where('handle_by',Auth::id())->orWhere('handle_by', null)->where('category','About Services')->count();

        $allcount=$data+$data2+$data3;
    
            return view('team.dashboard', [
                'responseb' => $responseb,
                'result' => $result,
                'submittedMessageIds' => $submittedMessageIds,
                'messages' => $messages,
                'allcount' => $allcount,
                'ticket' => $tickets
            ]);
    }


public function userquestion()
{
   $question = UsersQuestion::orderBy('id', 'desc')->get();

    return view('admin.userquestions', ['user_questions' => $question]);
}
    private function getUserRole($userId)
    {
        $chatdb = env('CHAT_DB_DATABASE');
         $supportdb = env('DB_DATABASE');
       $user = DB::connection($chatdb)
    ->table($supportdb . '.users') // Correctly interpolate $supportdb
    ->where('id', $userId)
    ->select('role')
    ->first();


        return $user ? $user->role : null;
    }

    public function getChatData(Request $request)
    {
        $chatdb = env('CHAT_DB_DATABASE');
         $supportdb = env('DB_DATABASE');
        $teamMembers = User::where('role', 'team')->pluck('name', 'id');
        $users = User::where('role', 'user')->pluck('name', 'id');

        $teamMemberNames = (array)$request->input('team_member');
        $userNames = (array)$request->input('user');

       $query = DB::connection($chatdb)
    ->table('ch_messages')
    ->join("{$supportdb}.users as from_user", 'ch_messages.from_id', '=', 'from_user.id')
    ->join("{$supportdb}.users as to_user", 'ch_messages.to_id', '=', 'to_user.id')
    ->select(
        'ch_messages.*',
        'from_user.name as from_name',
        'to_user.name as to_name'
    );

        if (!empty($teamMemberNames)) {
            $query->whereIn('from_user.name', $teamMemberNames)
                ->orWhereIn('to_user.name', $teamMemberNames);
        }

        if (!empty($userNames)) {
            $query->whereIn('from_user.name', $userNames)
                ->orWhereIn('to_user.name', $userNames);
        }

        $ch_messages = $query->get();

        return view('admin.dashboard', [
            'ch_messages' => $ch_messages,
            'teamMembers' => $teamMembers,
            'users' => $users,
        ]);
    }

    public function Chatdel(Request $request, $id)
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return $this->getResponse($request, ['error' => 'User not found'], 404);
        }

        // Store the user's email in the session
        Session::put('deleted_user_email', $chat->email);

        $chat->delete();

        // Retrieve the stored email from the session
        $deletedUserEmail = Session::pull('deleted_user_email');

        // Check if the email is present and send the email


        // Flash message for successful deletion
        if ($request->expectsJson()) {
            return $this->getResponse($request, ['message' => 'User deleted successfully'], 200);
        }

        return redirect()->back()->with('success', 'User deleted successfully');
    }

    private function getResponse(Request $request, $data, $status)
    {
        $chat = Chat::all();
        if ($request->expectsJson()) {
            return response()->json($data, $status);
        }

        return view('admin.chats.chats', ['ch_messages' => $chat]);
    }
    public function complainfetch()
    {
     
        $count1 = Tickets::whereIn('status', ['Closed', 'Resolved'])->where('category','About Team Member')->count();
        $count2 = Tickets::whereNotIn('status', ['Closed', 'Resolved'])->where('category','About Team Member')->count();
        $count3 = $complains = Tickets::where('category','About Team Member')->count();
        // $count4 = $complains = Tickets::where('category','About Services')->count();
        $count5 = Tickets::whereIn('status', ['Closed', 'Resolved'])->where('category','About Services')->count();
        $count6 = Tickets::whereNotIn('status', ['Closed', 'Resolved'])->where('category','About Services')->count();
        $count7  = Tickets::where('category','About Services')->count();
    
        return view('admin.tickets', compact('count1', 'count2', 'count3','count5', 'count6', 'count7'));
        
        
       /* $complains=Tickets::get();

        // Pass all data to the view, including complaints with customer names
        return view('admin.complain', [
            'complains' => $complains,
        ]);*/
    }
    public function completedtickets(){
        $tickets = Tickets::with('team')->whereIn('status', ['Closed', 'Resolved'])->where('category','About Team Member')->get();
        return view('admin.ticket-table', [
            'tickets' => $tickets,
        ]);
    }
    public function pendingtickets(){
        $tickets = Tickets::with('team')->whereNotIn('status', ['Closed', 'Resolved'])->where('category','About Team Member')->get();
        return view('admin.ticket-table', [
            'tickets' => $tickets,
        ]);
    }
    public function receivedticktets(){
        $tickets=Tickets::with('team')->where('category','About Team Member')->get();
        return view('admin.ticket-table', [
            'tickets' => $tickets,
        ]);
    }
    public function complainfetchdel($id)
    {
        $chat = Complain::find($id);
        $chat->delete();
        return redirect()->back()->with('success', 'Complain deleted successfully');
    }
    public function updateStatus(Request $request, $id)
    {
        $data = $request->json()->all();
        $ticket = Tickets::with('user')->where('id', $data['id'])->first();
        $ticket->status = $data['status'];
        $ticket->handle_by = Auth::user()->id;
        $ticket->save();
    
        return response()->json(['success' => true]);
    }
    public function tickets()
    {
        $count1 = Tickets::whereIn('status', ['Closed', 'Resolved'])->where('category','About Services')->count();
        $count2 = Tickets::whereNotIn('status', ['Closed', 'Resolved'])->where('category','About Services')->count();
        $count3  = Tickets::where('category','About Services')->count();
    
        return view('admin.ticket', compact('count1', 'count2', 'count3'));
    }
    public function serviceCompletedTickets(){
        $tickets = Tickets::with('handler')->with('team') 
            ->whereIn('status', ['Closed', 'Resolved'])
            ->where('category', 'About Services')
            ->get();
        return view('admin.ticket-table', [
            'tickets' => $tickets,
        ]);
    }
    public function servicePendingTickets(){
        $tickets = Tickets::with('team')->whereNotIn('status', ['Closed', 'Resolved'])->where('category','About Services')->get();
        return view('admin.ticket-table', [
            'tickets' => $tickets,
        ]);
    }
    public function serviceReceivedTickets(){
        $tickets=Tickets::with('team')->where('category','About Services')->get();
        return view('admin.ticket-table', [
            'tickets' => $tickets,
        ]);
    }

// completed task


    public function completedUpdateApproveStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'adminstatus' => 'required|string|in:decline,approve',
            'a' => 'required|in:3,6,9',
        ]);
        
        $id = $request->id;
        $adminstatus = $request->adminstatus;
        $a = $request->a;
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $id = $request->id;
        $adminstatus = $request->adminstatus;
        $followup_type = $request->a;
    
        $model = match ((int) $followup_type) {
            3 => Followup3::class,
            6 => Followup6::class,
            9 => Followup9::class,
            default => null,
        };
    
        if (!$model) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid follow-up type.'
            ], 400);
        }
    
        $record = $model::find($id);
    
        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found.'
            ], 404);
        }
        
        if($request->adminstatus=='approve'){
            $record->adminstatus = $adminstatus;
            $record->teamstatus = 'Complete';
            $record->save();
        }else{
            $record->adminstatus = $adminstatus;
            $record->teamstatus = '';
            $record->save();
        }
       

        return redirect()->back()->with('success', 'Communication type updated successfully.');
    }


public function completefollowup()
{
    $authName = Auth::user()->name;

    // Fetch data
    $data = Followup3::get();
    $data2 = Followup6::get();
    $data3 = Followup9::get();

    // Store counts
    $count1 = $data->count();
    $count2 = $data2->count();
    $count3 = $data3->count();

    // Pass data and counts to the view
    return view('admin.completefollowup', compact('count1', 'count2', 'count3'));
}

public function completefollowup3()
{
    $data = Followup3::get();
    return view('admin.completefollowup3', ['data' => $data, 'month'=>3]);
}
public function completefollowup6()
{
    $data = Followup6::get();
    return view('admin.completefollowup3', ['data' => $data, 'month'=>6]);
}
public function completefollowup9()
{
    $data = Followup9::get();
    return view('admin.completefollowup3', ['data' => $data, 'month'=>9]);
}



}
