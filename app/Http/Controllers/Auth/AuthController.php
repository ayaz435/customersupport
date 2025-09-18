<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
class AuthController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }
   // user
   public function login()
   {
       return view('login');
   }
   
    public function apilogin(Request $request)
    {
        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find user by email
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Check password (both hashed and plaintext for backward compatibility)
            $passwordValid = Hash::check($request->password, $user->password) || 
                           $request->password === $user->password;

            if (!$passwordValid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Create token (if using Laravel Sanctum)
            $token = $user->createToken('auth_token')->plainTextToken;
            
            $user->fcm_token=$request->fcm_token;
            $user->app_version=$request->app_version;
            $user->build_number=$request->build_number;
            $user->platform=$request->platform;
            $user->app_url=$request->app_url;
            $user->save();

            $user->detail()->updateOrCreate([], [
                'app_last_login_at' => now(),
            ]);



            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function apiLogout(Request $request)
    {
        try {
            // Get the authenticated user
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $user->detail()->updateOrCreate([], [
                'app_last_logout_at' => now(),
            ]);
            
            // Revoke the current token
            $request->user()->currentAccessToken()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Logout successful'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    // Alternative: Logout from all devices
    public function apiLogoutAll(Request $request)
    {
        try {
            // Get the authenticated user
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $user->detail()->updateOrCreate([], [
                'app_last_logout_at' => now(),
            ]);
            
            // Revoke all tokens for the user
            $user->tokens()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Logout from all devices successful'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }

   public function register()
   {
       return view('register');
   }

   public function registerindex(Request $request)
   {
       $user = User::get();

       if ($request->wantsJson()) {
           return response()->json(['users' => $user]);
       } else {
           return view('admin.register.index', ['users' => $user]);
       }
   }
   public function registerdel(Request $request, $id)
   {
       $user = User::findOrFail($id);
       $user->delete();

       if ($request->wantsJson()) {
           return response()->json(['message' => 'Deleted successfully']);
       } else {
           return back()->with('success', 'Deleted Successfully');
       }
   }
   public function registerstore(Request $request)
   {
       $request->validate([
           'name' => 'required',
           'email' => 'required',
           'password' => 'required',
           'role' => 'required'
       ]);
       $user = new User;
       $user->name = $request->name;
       $user->email = $request->email;
       $user->role = $request->role;
       $user->password = $request->password;
       $user->save();
       Mail::to($user->email)->send(new WelcomeEmail($user));
       return redirect('admin/registeredusers')->with('success', 'Registered Successfully');
   }



   public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // dd($request);

        if ($validator->passes()) {
            $admin = User::where('email', $request->email)->first();

            

            if ($admin) {
                // Attempt authentication with hashed password
                if (Hash::check($request->password, $admin->password)) {
                    Auth::guard('admin')->login($admin, $request->get('remember'));
                    session(['user_role' => $admin->role]);
                    
                    $admin->detail()->updateOrCreate([], [
                        'web_last_login_at' => now(),
                    ]);

                    return $this->redirectBasedOnRole($admin->role);
                }

                // Attempt authentication with plaintext password
                elseif ($request->password === $admin->password) {
                    Auth::guard('admin')->login($admin, $request->get('remember'));
                    session(['user_role' => $admin->role]);

                    $admin->detail()->updateOrCreate([], [
                        'web_last_login_at' => now(),
                    ]);

                    return $this->redirectBasedOnRole($admin->role);
                }
            }

            return redirect()->route('login')->with('error', 'Either Email/Password is incorrect');
        } else {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'team':
                return redirect()->route('team.dashboard');
            case 'user':
                return redirect()->route('homeuser.projectform');
            default:
                Auth::guard('admin')->logout();
                return redirect()->route('login')->with('error', 'You are not authorized');
        }
    }

}
