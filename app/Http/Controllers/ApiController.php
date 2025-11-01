<?php

namespace App\Http\Controllers;
use App\Models\Storedesign;
use App\Models\Productdesign;

use Illuminate\Http\Request;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ApiController extends Controller
{
    public function designapi(Request $request)
    {
    $storedesigns = Storedesign::all();
     return response()->json([
            'storedesigns' => $storedesigns,
        ]);
    }

 public function productdesignapi(Request $request)
    {
     $productdesigns = Productdesign::all();
        
        return response()->json([
            'productdesigns' => $productdesigns,
        ]);
    }
    
    public function insertNewUser(Request $request)
    {
        $request->validate([
            'drm_user_id' => 'required',
            'name' => 'required|string',
            'email' => 'email|required|unique:users,email',
            'cname' => 'nullable|string',
            'password'=>'nullable|string|min:8',
            'com_id' => 'required|integer',
            'gm_approve_status'=>'required|String',
            'creation_date'=>'nullable',
            'ac_approve_date'=> 'nullable',
            'hod_approve_date'=> 'nullable'
        ]);


        if($request->input('password'))
           $password= $request->input('password');
        else
            $password = Str::random(12);
            
        try {
             $newUser = User::create([
                'drm_user_id' => $request->input('drm_user_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'cname' => $request->input('cname'),
                'com_id' => $request->input('com_id'),
                'password' => Hash::make($password),
                'gm_approve_status'=> $request->input('gm_approve_status'),
                'creation_date'=> $request->input('creation_date'),
                'ac_approve_date'=> $request->input('ac_approve_date'),
                'hod_approve_date'=> $request->input('hod_approve_date'),
                'role' => 'user',
            ]);
            /*$newUser = new User([
                'drm_user_id' => $request->input('drm_user_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'cname' => $request->input('cname'),
                'com_id' => $request->input('com_id'),
                'password' => Hash::make($password),
                'role' => 'user',
            ]);*/
            
            // $newUser->password=$password;

            if($newUser){
                DB::table('password_text')->insert([
                    'user_id' => $newUser->id,
                    'password' => $password
                ]);
            }
            
            Mail::to($newUser->email)->send(new WelcomeEmail($newUser,$password));

            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'user' => $newUser,
                'generated_password' => $password, // Optional, use only if safe
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user.',
                'error' => $e->getMessage(), // Optional: for debugging
            ], 500);
        }

    }
    
    public function updateUserApprovalStatus(Request $request)
    {
        $request->validate([
            'com_id' => 'required|integer',
            'gm_approve_status' => 'nullable|string',
            'creation_date' => 'nullable|date',
            'ac_approve_date' => 'nullable|date',
            'hod_approve_date' => 'nullable|date'
        ]);
    
        try {
            // Find user by com_id
            $user = User::where('com_id', $request->input('com_id'))->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found with the provided com_id.',
                ], 404);
            }
    
            // Prepare update data - only include fields that are present in request
            $updateData = [];
            
            if ($request->has('gm_approve_status')) {
                $updateData['gm_approve_status'] = $request->input('gm_approve_status');
                $user->gm_approve_status= $request->input('gm_approve_status');
            }
            
            if ($request->has('creation_date')) {
                $updateData['creation_date'] = $request->input('creation_date');
                $user->creation_date= $request->input('creation_date');
            }
            
            if ($request->has('ac_approve_date')) {
                $updateData['ac_approve_date'] = $request->input('ac_approve_date');
                $user->ac_approve_date = $request->input('ac_approve_date');
            }
            
            if ($request->has('hod_approve_date')) {
                $updateData['hod_approve_date'] = $request->input('hod_approve_date');
                $user->hod_approve_date = $request->input('hod_approve_date');
            }
    
            // Check if there's anything to update
            if (empty($updateData)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid fields provided for update.',
                ], 400);
            }
            $user->save();
            // Update the user
            // $user->update($updateData);
    
            return response()->json([
                'success' => true,
                'message' => 'User approval status updated successfully.',
                'user' => $user->fresh(), // Get updated user data
                'updated_fields' => array_keys($updateData)
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user approval status.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function insertNewTeam(Request $request)
    {
        $request->validate([
            'drm_user_id' => 'required',
            'name' => 'required|string',
            'email' => 'email|required|unique:users,email',
            'password'=>'nullable|string|min:8',
            'designation' => 'nullable|string',
        ]);

        if($request->input('password'))
           $password= $request->input('password');
        else
            $password = Str::random(12);
            
        try {
            $newUser = User::create([
                'drm_user_id' => $request->input('drm_user_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'designation' => $request->input('designation'),
                'password' => Hash::make($password),
                'role' => 'team',
            ]);
            if($newUser){
                DB::table('password_text')->insert([
                    'user_id' => $newUser->id,
                    'password' => $password
                ]);
            }
            
            Mail::to($newUser->email)->send(new WelcomeEmail($newUser,$password));
            
            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'user' => $newUser,
                'generated_password' => $password, // Optional, use only if safe
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user.',
                'error' => $e->getMessage(), // Optional: for debugging
            ], 500);
        }

    }

    public function addServiceMember(Request $request)
    {
        $request->validate([
            'drm_user_id' => 'required',
            'name' => 'required|string',
            'email' => 'email|required|unique:users,email',
            'password'=>'nullable|string|min:8',
            'designation' => 'nullable|string',
        ]);

        if($request->input('password'))
           $password= $request->input('password');
        else
            $password = Str::random(12);
            
        try {
            $newUser = User::create([
                'drm_user_id' => $request->input('drm_user_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'designation' => $request->input('designation'),
                'password' => Hash::make($password),
                'role' => 'service',
            ]);
            if($newUser){
                DB::table('password_text')->insert([
                    'user_id' => $newUser->id,
                    'password' => $password
                ]);
            }
            
            Mail::to($newUser->email)->send(new WelcomeEmail($newUser,$password));
            
            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'user' => $newUser,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user.',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function addUser(Request $request)
    {
        $request->validate([
            'drm_user_id' => 'required',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $request->input('drm_user_id') . ',drm_user_id',
            'password' => 'nullable|string|min:8',
            'designation' => 'nullable|string',
            'role' => 'required|in:service,sales,development',
        ]);

        $role = $request->input('role');
        $password = $request->input('password') ?? null;

        try {
            $existingUser = User::where('email', $request->input('email'))
                                ->orWhere('drm_user_id', $request->input('drm_user_id'))
                                ->first();

            if ($existingUser) {
                $dataToUpdate = [];

                if ($existingUser->name !== $request->input('name')) {
                    $dataToUpdate['name'] = $request->input('name');
                }

                if ($existingUser->email !== $request->input('email')) {
                    $dataToUpdate['email'] = $request->input('email');
                }

                if ($existingUser->designation !== $request->input('designation')) {
                    $dataToUpdate['designation'] = $request->input('designation');
                }

                if ($existingUser->role !== $role) {
                    $dataToUpdate['role'] = $role;
                }

                if ($password) {
                    $dataToUpdate['password'] = Hash::make($password);
                }

                if (!empty($dataToUpdate)) {
                    $existingUser->update($dataToUpdate);

                    if ($password) {
                        DB::table('password_text')->updateOrInsert(
                            ['user_id' => $existingUser->id],
                            ['password' => $password]
                        );
                    }
                }

                $newUser = $existingUser;
            } else {
                $newUser = User::create([
                    'drm_user_id' => $request->input('drm_user_id'),
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'designation' => $request->input('designation'),
                    'password' => Hash::make($password),
                    'role' => $role,
                ]);

                DB::table('password_text')->insert([
                    'user_id' => $newUser->id,
                    'password' => $password,
                ]);
            }

            Mail::to($newUser->email)->send(new WelcomeEmail($newUser, $password));

            return response()->json([
                'success' => true,
                'message' => $existingUser ? 'User updated successfully.' : 'User created successfully from DRM.',
                'user' => $newUser,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create or update user.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
