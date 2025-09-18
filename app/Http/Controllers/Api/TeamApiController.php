<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Models\Followup3;
use App\Models\Followup6;
use App\Models\Followup9;
use App\Models\Tickets;
use App\Models\LateMessages;
use Illuminate\Routing\Controller;



class TeamApiController extends Controller
{
    public function teamDashboard(Request $request)
    {
        try {
            $teamId = Auth::id();
    
            if (!$teamId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access. No authenticated user found.'
                ], 401);
            }
    
            // Fetch late messages from another database connection
            $lateMessages = LateMessages::where('team_id', $teamId)
                ->get();
    
            // Fetch followups and tickets
            $followup3 = Followup3::where('team_id', $teamId)->get();
            $followup6 = Followup6::where('team_id', $teamId)->get();
            $followup9 = Followup9::where('team_id', $teamId)->get();
            $tickets   = Tickets::with('user')->where('handle_by',$teamId)->orWhere('handle_by', null)->where('category', 'About Services')->get();
    
            return response()->json([
                'status' => 'success',
                'data' => [
                    'late_messages' => $lateMessages,
                    'followup_3'    => $followup3,
                    'followup_6'    => $followup6,
                    'followup_9'    => $followup9,
                    'tickets'       => $tickets,
                ]
            ], 200);
    
        } catch (\Exception $e) {
            Log::error('teamLateMessage Error: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function updateFollowupStatus(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'id' => 'required|integer',
                'followup_type' => 'required|in:3,6,9',
            ]);
    
            $id = $validated['id'];
            $followupType = $validated['followup_type'];
    
            // Determine model
            $model = match ($followupType) {
                3 => Followup3::class,
                6 => Followup6::class,
                9 => Followup9::class,
            };
    
            // Find and update the record
            $record = $model::find($id);
    
            if (!$record) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Record not found.'
                ], 404);
            }
    
            $record->teamstatus = 'Complete';
            // $record->adminstatus = ''; // Uncomment and set if needed
            $record->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Communication type updated successfully.',
                'data' => $record
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            \Log::error('updateCommunicationType Error: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function updateReason(Request $request, $id)
    {
        try {
            $request->validate([
                'reason' => 'required|string|max:1000',
            ]);
    
            $reason = $request->input('reason');
    
            $record = DB::table('late_messages')->where('id', $id)->first();
    
            if (!$record) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Record not found.'
                ], 404);
            }
    
            DB::table('late_messages')
                ->where('id', $id)
                ->update(['reason' => $reason]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Reason updated successfully.'
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            Log::error('updateReason Error: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
