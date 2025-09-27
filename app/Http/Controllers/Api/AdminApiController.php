<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\UsersQuestion;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Projectform;
use App\Models\File;
use App\Models\Catagory;
use App\Models\Followup3;
use App\Models\Followup6;
use App\Models\Followup9;
use App\Models\Tickets;
use App\Models\LateMessages;
use App\Models\inbox;
use Illuminate\Support\Facades\Mail;
use App\Mail\DelEmail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Exception;



class AdminApiController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function userquestion(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $questions = UsersQuestion::orderBy('id', 'desc')->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'message' => 'User questions retrieved successfully',
                'data' => [
                    'user_questions' => $questions->items(),
                    'pagination' => [
                        'current_page' => $questions->currentPage(),
                        'total_pages' => $questions->lastPage(),
                        'per_page' => $questions->perPage(),
                        'total_count' => $questions->total(),
                        'has_more_pages' => $questions->hasMorePages()
                    ]
                ]
            ], 200);
            
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve user questions: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user questions',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
    
    public function latemessage()
    {
        try {
            
    
            $response = LateMessages::get();
            if (!$response) {
                return response()->json([
                    'error' => 'No late messages found.'
                ], 404);
            }
    
            $result = User::select('name')
                ->where('role', 'team')
                ->has('lateMessages')
                ->withCount('lateMessages')
                ->get()
                ->mapWithKeys(function ($user) {
                    return [$user->name => $user->late_messages_count];
                })
                ->toArray();
    
            return response()->json([
                'success' => true,
                'response' => $response,
                'result' => $result
            ]);
        } catch (Exception $e) {
            // Log the error
            Log::error('Late message fetch failed: ' . $e->getMessage());
    
            return response()->json([
                'error' => 'An unexpected error occurred.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    public function allUsers()
    {
        try {
            $users = User::where('role', 'user')->get();
    
            if ($users->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No users found with the specified role.',
                    'users' => []
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'users' => $users
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    public function clientDataWithAllUsers(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid input.',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $selectedEmail = $request->input('email');
    
            $users = User::where('role', 'user')->get();
            $projectforms = Projectform::where('eemail', $selectedEmail)->orderBy('created_at', 'desc')->get();
            $files = File::where('email', $selectedEmail)->orderBy('created_at', 'desc')->get();
            $categories = Catagory::where('email', $selectedEmail)->orderBy('created_at', 'desc')->get();
    
            if ($projectforms->isEmpty() && $files->isEmpty() && $categories->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No client data found for the provided email.',
                    'users' => $users,
                    'projectforms' => [],
                    'files' => [],
                    'categories' => []
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'users' => $users,
                'projectforms' => $projectforms,
                'files' => $files,
                'categories' => $categories
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching client data: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    public function clientData(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid input.',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $selectedEmail = $request->input('email');
    
            $user = User::with([
                'projectforms' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'files' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'storedesigns' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                 'categories.subCategories.productDesigns' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ])->where('email', $selectedEmail)
              ->where('role', 'user')
              ->first();
            
            // Filter product designs after fetching (same logic as your first example)
            if ($user && $user->categories) {
                foreach ($user->categories as $category) {
                    foreach ($category->subCategories as $sub) {
                        // Filter product designs where main_category_id matches
                        $sub->setRelation('productDesigns', $sub->productDesigns->filter(function ($design) use ($sub) {
                            return $design->main_category_id == $sub->main_category_id;
                        })->values());
                    }
                }
            }

    
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching client data: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function completeTask()
    {
        try {
            // Initialize default values
            $complete3 = collect([]);
            $complete6 = collect([]);
            $complete9 = collect([]);
            $errors = [];
            
            // Fetch Followup3 data
            try {
                $complete3 = Followup3::get();
                \Log::info('Successfully retrieved ' . $complete3->count() . ' Followup3 records');
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error fetching Followup3: ' . $e->getMessage());
                $errors['followup3'] = 'Unable to fetch 3-day followup data';
            } catch (\Exception $e) {
                \Log::error('Error fetching Followup3: ' . $e->getMessage());
                $errors['followup3'] = 'Error retrieving 3-day followup data';
            }
            
            // Fetch Followup6 data
            try {
                $complete6 = Followup6::get();
                \Log::info('Successfully retrieved ' . $complete6->count() . ' Followup6 records');
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error fetching Followup6: ' . $e->getMessage());
                $errors['followup6'] = 'Unable to fetch 6-day followup data';
            } catch (\Exception $e) {
                \Log::error('Error fetching Followup6: ' . $e->getMessage());
                $errors['followup6'] = 'Error retrieving 6-day followup data';
            }
            
            // Fetch Followup9 data
            try {
                $complete9 = Followup9::get();
                \Log::info('Successfully retrieved ' . $complete9->count() . ' Followup9 records');
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error fetching Followup9: ' . $e->getMessage());
                $errors['followup9'] = 'Unable to fetch 9-day followup data';
            } catch (\Exception $e) {
                \Log::error('Error fetching Followup9: ' . $e->getMessage());
                $errors['followup9'] = 'Error retrieving 9-day followup data';
            }
            
            // Prepare response data
            $responseData = [
                'complete3' => $complete3,
                'complete6' => $complete6,
                'complete9' => $complete9,
            ];
            
            // Add summary statistics
            $summary = [
                'total_records' => $complete3->count() + $complete6->count() + $complete9->count(),
                'followup3_count' => $complete3->count(),
                'followup6_count' => $complete6->count(),
                'followup9_count' => $complete9->count(),
            ];
            
            // Determine response based on errors
            if (empty($errors)) {
                // All data retrieved successfully
                return response()->json([
                    'success' => true,
                    'message' => 'Task completion data retrieved successfully',
                    'data' => $responseData,
                    'summary' => $summary,
                    'timestamp' => now()->toISOString(),
                ], 200);
                
            } else if (count($errors) < 3) {
                // Partial success - some data retrieved
                \Log::warning('Partial data retrieval for completeTask', $errors);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Task completion data partially retrieved',
                    'data' => $responseData,
                    'summary' => $summary,
                    'warnings' => $errors,
                    'timestamp' => now()->toISOString(),
                ], 206); // 206 Partial Content
                
            } else {
                // Complete failure - no data retrieved
                \Log::error('Complete failure retrieving task completion data', $errors);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to retrieve task completion data',
                    'data' => $responseData,
                    'summary' => $summary,
                    'errors' => $errors,
                    'timestamp' => now()->toISOString(),
                ], 500);
            }
            
        } catch (\Exception $e) {
            \Log::error('Complete task method failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Service temporarily unavailable',
                'data' => [
                    'complete3' => [],
                    'complete6' => [],
                    'complete9' => [],
                ],
                'summary' => [
                    'total_records' => 0,
                    'followup3_count' => 0,
                    'followup6_count' => 0,
                    'followup9_count' => 0,
                ],
                'error' => 'Internal server error',
                'timestamp' => now()->toISOString(),
            ], 503);
        }
    }
    
    public function activeTeamMembers()
    {
        try {
            $activeUsers = User::where('role', 'team')
                ->where('active_status', 1)
                ->get();
    
            return response()->json([
                'status' => 'success',
                'data' => [
                    'activeUsers' => $activeUsers
                ]
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function followupAssignTask(Request $request)
    {
        try {
            $validated = $request->validate([
                'cid' => 'required',
                'followup_type' => 'required|in:3,6,9', 
                'company' => 'required',
                'task' => 'required',
                'team' => 'required',
                'team_id' => 'required|integer|exists:users,id',
                'priority' => 'required',
                'detail' => 'nullable',
                'communication' => 'nullable|array',
            ]);
    
            $modelClass = match ((int)$request->followup_type) {
                3 => Followup3::class,
                6 => Followup6::class,
                9 => Followup9::class,
                default => null,
            };
    
            if (!$modelClass) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid task selection.',
                ], 400);
            }
    
            $followupModel = $modelClass::firstOrNew(['cid' => $request->cid]);
    
            if (!$followupModel) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid task selection.',
                ], 400);
            }
    
            // Fill and save model
            $followupModel->cid = $validated['cid'];
            $followupModel->cname = $validated['company'];
            $followupModel->phone = $request->phone;
            $followupModel->task = $validated['task'];
            $followupModel->team = $validated['team'];
            $followupModel->team_id = $validated['team_id'];
            $followupModel->date = now()->format('M d, Y');
            $followupModel->comunicationtype = $request->filled('communication')
                ? implode(', ', $request->communication)
                : null;
            $followupModel->priority = $validated['priority'];
            $followupModel->detail = $validated['detail'] ?? null;
    
            $followupModel->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Followup Task Assinged successfully!',
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $e->errors(),
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function completedUpdateApproveStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'adminstatus' => 'required|string|in:decline,approve',
            'followup_type' => 'required|in:3,6,9',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $id = $request->id;
        $adminstatus = $request->adminstatus;
        $followup_type = $request->followup_type;
    
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
    
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'data' => [
                'id' => $record->id,
                'adminstatus' => $record->adminstatus,
                'teamstatus' => $record->teamstatus,
            ]
        ]);
    }

    public function registeredUsers()
    {
        try {
            $registeredUsers = User::whereIn('role', ['user', 'newuser'])
                ->get();
    
            return response()->json([
                'success' => true,
                'users' => $registeredUsers
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching registered users: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch registered users.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function allTeam()
    {
        try {
            $users = User::where('role', 'team')->get();
    
            if ($users->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No users found with the specified role.',
                    'teams' => []
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'teams' => $users
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getServiceMembers()
    {
        try {
            $serviceMembers = User::where('role', 'service')->get();
    
            if ($serviceMembers->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No service members found.',
                    'service_members' => []
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'service_members' => $serviceMembers
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching service members: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function announcementInbox(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role' => [
                    'required',
                    'string',
                    'in:admin,user,newuser,team' 
                ],
                'message' => [
                    'required',
                    'string',
                    'max:1000', 
                    'min:1'
                ]
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422); 
            }
    
            $inbox = new inbox(); 
            $inbox->role = $request->role;
            $inbox->message = trim($request->message); 
            
            if ($inbox->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Message sent successfully!',
                    'data' => [
                        'id' => $inbox->id,
                        'role' => $inbox->role,
                        'message' => $inbox->message,
                        'created_at' => $inbox->created_at
                    ]
                ], 201); // Created
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save message'
                ], 500); // Internal Server Error
            }
    
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
            
        } catch (QueryException $e) {
            Log::error('Database error in inboxStore: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred'
            ], 500);
            
        } catch (Exception $e) {
            Log::error('Unexpected error in inboxStore: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred'
            ], 500);
        }
    }
    
    public function index(Request $request)
    {
        try {
            $chatdb = env('CHAT_DB_DATABASE');
            
            $userCount = 0;
            $teamCount = 0;
            $latemessages = [];
            $tickets = 0;
            $imagePath = null;
            $promotionData = [];
            
            try {
                $userCount = User::where('role', 'user')->orWhere('role', 'newuser')->count();
                $teamCount = User::where('role', 'team')->count();
            } catch (\Exception $e) {
                \Log::error('Error fetching user counts: ' . $e->getMessage());
            }
            
            try {
                if ($chatdb) {
                    $latemessages = DB::connection($chatdb)->select('SELECT * FROM late_messages');
                }
            } catch (\Exception $e) {
                \Log::error('Error fetching late messages: ' . $e->getMessage());
            }
            
            try {
                $tickets = Tickets::where('category', 'About Team Member')->count();
            } catch (\Exception $e) {
                \Log::error('Error fetching tickets count: ' . $e->getMessage());
            }
            
            try {
                $response = Http::timeout(10) 
                              ->retry(3, 1000) 
                              ->get('https://webexcels.pk/api/promotion');
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (isset($data['data']) && is_array($data['data']) && !empty($data['data'])) {
                        $promotionData = $data['data'];
                        
                        if (isset($data['folderPath']) && isset($data['data'][0]['img'])) {
                            $imagePath = $data['folderPath'] . $data['data'][0]['img'];
                        }
                    } else {
                        \Log::warning('API response structure is invalid or empty');
                    }
                } else {
                    \Log::error('API request failed with status: ' . $response->status());
                    
                    switch ($response->status()) {
                        case 404:
                            \Log::error('API endpoint not found');
                            break;
                        case 500:
                            \Log::error('API server error');
                            break;
                        case 429:
                            \Log::error('API rate limit exceeded');
                            break;
                        default:
                            \Log::error('API request failed: ' . $response->body());
                    }
                }
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                \Log::error('API connection failed: ' . $e->getMessage());
            } catch (\Illuminate\Http\Client\RequestException $e) {
                \Log::error('API request exception: ' . $e->getMessage());
            } catch (\Exception $e) {
                \Log::error('Unexpected error during API call: ' . $e->getMessage());
            }
            
            return response()->json([
                'userCount' => $userCount,
                'teamCount' => $teamCount,
                'ticketCount' => $tickets,
                'latemessages' => $latemessages,
                'imagePath' => $imagePath,
                'data' => $promotionData,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Dashboard index method failed: ' . $e->getMessage());
            
            return response()->json([
                'userCount' => 0,
                'teamCount' => 0,
                'ticketCount' => 0,
                'latemessages' => [],
                'imagePath' => null,
                'data' => [],
            ]);
        }
    }
    
    public function tickets()
    {
        try {
            $tickets = collect([]);
            
            try {
                $tickets = Tickets::with('user')->get();
                
                return response()->json([
                    'success' => true,
                    'data' => $tickets,
                    'count' => $tickets->count(),
                    'message' => 'Tickets retrieved successfully'
                ], 200);
                
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error fetching tickets: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'count' => 0,
                    'message' => 'Database error occurred',
                    'error' => 'Unable to fetch tickets from database'
                ], 500);
                
            } catch (\Exception $e) {
                \Log::error('Error fetching tickets: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'count' => 0,
                    'message' => 'An error occurred while fetching tickets'
                ], 500);
            }
            
        } catch (\Exception $e) {
            \Log::error('Tickets API method failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'data' => [],
                'count' => 0,
                'message' => 'Service temporarily unavailable'
            ], 503);
        }
    }
    
    public function updateStatus(Request $request, $id)
    {
        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'status' => 'required|string|in:Open,Closed,Pending,Resolved,In Progress', 
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Find the ticket
            $ticket = Tickets::with('user')->find($id);
    
            if (!$ticket) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket not found'
                ], 404);
            }
    
            // Update ticket
            $ticket->status = $request->input('status');
            $ticket->handle_by = Auth::user()->id;
            $ticket->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Ticket status updated successfully',
                'data' => [
                    'ticket_id' => $ticket->id,
                    'status' => $ticket->status,
                    'handled_by' => $ticket->handle_by,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the ticket status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function updateUser(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'drm_user_id' => 'sometimes|string|max:255|unique:users,drm_user_id,' . $id,
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|max:255|unique:users,email,' . $id,
                'cname' => 'sometimes|string|max:255',
                'com_id' => 'sometimes|string|max:255',
                'password' => 'sometimes|string|min:8|confirmed',
                'role' => 'sometimes|in:user,admin,team,newuser',
            ]);
    
            if ($validator->fails()) {
                \Log::warning('User update validation failed for ID: ' . $id, $validator->errors()->toArray());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Find the user
            try {
                $user = User::findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                \Log::error('User not found for update. ID: ' . $id);
                
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
    
            // Prepare update data
            $updateData = [];
            
            // Only update fields that are present in the request
            if ($request->has('drm_user_id')) {
                $updateData['drm_user_id'] = $request->input('drm_user_id');
            }
            
            if ($request->has('name')) {
                $updateData['name'] = $request->input('name');
            }
            
            if ($request->has('email')) {
                $updateData['email'] = $request->input('email');
            }
            
            if ($request->has('cname')) {
                $updateData['cname'] = $request->input('cname');
            }
            
            if ($request->has('com_id')) {
                $updateData['com_id'] = $request->input('com_id');
            }
            
            if ($request->has('role')) {
                $updateData['role'] = $request->input('role');
            }
            
            // Handle password update separately
            if ($request->has('password') && !empty($request->input('password'))) {
                $updateData['password'] = Hash::make($request->input('password'));
            }
    
            // Update timestamps
            $updateData['updated_at'] = now();
    
            try {
                // Perform the update
                $updated = $user->update($updateData);
                
                if ($updated) {
                    // Refresh the user model to get updated data
                    $user->refresh();
                    
                    \Log::info('User updated successfully. ID: ' . $id . ', Updated fields: ' . implode(', ', array_keys($updateData)));
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'User updated successfully',
                        'data' => [
                            'id' => $user->id,
                            'drm_user_id' => $user->drm_user_id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'cname' => $user->cname,
                            'com_id' => $user->com_id,
                            'role' => $user->role,
                            'updated_at' => $user->updated_at,
                        ]
                    ], 200);
                } else {
                    \Log::warning('User update returned false. ID: ' . $id);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'No changes were made to the user'
                    ], 200);
                }
                
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error during user update. ID: ' . $id . ', Error: ' . $e->getMessage());
                
                // Handle specific database errors
                if ($e->getCode() === '23000') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Duplicate entry detected. Email or DRM User ID already exists.'
                    ], 409);
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Database error occurred during update'
                ], 500);
                
            } catch (\Exception $e) {
                \Log::error('Unexpected error during user update. ID: ' . $id . ', Error: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'An unexpected error occurred during update'
                ], 500);
            }
            
        } catch (\Exception $e) {
            \Log::error('User update method failed completely. ID: ' . $id . ', Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Service temporarily unavailable'
            ], 503);
        }
    }

    public function deleteUserApi(Request $request, $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }
    
        $email = $user->email;
    
        // Optional: If you also want to delete from user_details
        DB::table('password_text')->where('user_id', $user->id)->delete();
    
        // Delete user
        $user->delete();
    
        // Send deletion email
        Mail::to($email)->send(new DelEmail($user));
    
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',
        ]);
    }
    
}
