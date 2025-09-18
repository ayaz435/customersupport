<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatsEmail;
use App\Models\ChMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function getOnlineUsers()
    {
        $onlineUsers = User::where('status', 'online')->get(['name', 'status']);
    return response()->json($onlineUsers);
    }

    public function sendChatSummary(Request $request)
    {   $supportdb = env('CUSTOMERSUPPORT_DB_DATABASE');
        try {
            // Validate the input
            $request->validate([
                'pdf' => 'required',
                'created_at' => 'required',
                'current_date' => 'required',
            ]);
            // Retrieve the file and data
            $pdfFile = $request->file('pdf');
            $createdAt = $request->input('created_at');
           $uid= $request->input('uid');
            $currentDate = $request->input('current_date');
            $message = ChMessage::where('id', $uid)->first();
            if ($message) {
                // Retrieve the from_id and to_id from the message
                $from_id = $message->from_id;
                $to_id = $message->to_id;
                // You can now use these variables as neede
              $fromUser = DB::table("xlserp_customersupport.users")
    ->select('id', 'role', 'name')
    ->where('id', $from_id)
    ->first();

$toUser = DB::table("$supportdb.users")
    ->select('id', 'role', 'name')
    ->where('id', $to_id)
    ->first();

            if (!$fromUser || !$toUser) {
                return response()->json(['error' => 'User not found'], 404);
            }
            // Assign roles for team and user
            $teammemberName = ($fromUser->role === 'team') ? $fromUser->name : $toUser->name;
            $teammemberId = ($fromUser->role === 'team') ? $fromUser->id : $toUser->id;
            $userName = ($toUser->role === 'user') ? $toUser->name : $fromUser->name;
            $userId = ($toUser->role === 'user') ? $toUser->id : $fromUser->id;

            }
          // Save the file temporarily
            $filePath = $pdfFile->storeAs('temp', 'chat_summary.pdf');

            // Prepare email data
            $emailData = [
                'start_date' => $createdAt,
                'current_date' => $currentDate,
                'team' => $teammemberName,
                'user' => $userName,
            ];
            // Send the email
            Mail::send('emails.chat_summary', $emailData, function ($message) use ($filePath) {
                $message->to('zunair.b.ahmad@gmail.com')
                    ->subject('Chat Summary')
                    ->attach(storage_path('app/' . $filePath));
            });

            $emailLink = url('/emails/chat_summary/' . uniqid('summary_'));

            // Store the email link and other details in the ChatsEmail model
            ChatsEmail::create([
                
                'teammember' => $teammemberName,
                'user' => $userName,
                'emaillink' => $emailLink // Store the generated email link
            ]);

            // Clean up the file
            unlink(storage_path('app/' . $filePath));
            return response()->json(['success' => true, 'message' => 'Chat summary sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    // Your other controller methods...
 

   
}
