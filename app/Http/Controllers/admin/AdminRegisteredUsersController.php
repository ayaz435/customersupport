<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Mail\UpdateEmail;
use App\Mail\DelEmail;
use Illuminate\Support\Facades\Session;
class AdminRegisteredUsersController extends Controller
{
    public function registeredusers(Request $request)
    {
       $registeredusers = User::with('details')
           ->whereIn('role', ['user', 'newuser'])->get();
           
        //   dd($registeredusers->details->password);
        if ($request->wantsJson()) {
            return response()->json([
                'users' => $registeredusers
            ]);
        } else {
            return view('admin.registeredusers.registeredusers', [
                'users' => $registeredusers
            ]);
        }
    }

    public function registeredService(Request $request)
    {
       $registeredService = User::with('details')
           ->whereIn('role', ['service'])->get();
           
        if ($request->wantsJson()) {
            return response()->json([
                'users' => $registeredService
            ]);
        } else {
            return view('admin.registeredusers.register_service_members', [
                'registeredServiceMembers' => $registeredService
            ]);
        }
    }

    public function registeredSalesTeam(Request $request)
    {
       $salesMembers = User::with('details')
           ->whereIn('role', ['sales'])->get();
        if ($request->wantsJson()) {
            return response()->json([
                'users' => $salesMembers
            ]);
        } else {
            return view('admin.registeredusers.sales_members', [
                'sales_members' => $salesMembers
            ]);
        }
    }

    public function registeredDevelopmentTeam(Request $request)
    {
       $developmentMembers = User::with('details')
           ->whereIn('role', ['development'])->get();
        if ($request->wantsJson()) {
            return response()->json([
                'users' => $developmentMembers
            ]);
        } else {
            return view('admin.registeredusers.development_members', [
                'development_members' => $developmentMembers
            ]);
        }
    }
    
    public function registeredteammembers(Request $request)
    {
        $registeredusers = User::with('details')
                ->where('role','team')->get();

        if ($request->wantsJson()) {
            return response()->json([
                'users' => $registeredusers
            ]);
        } else {
            return view('admin.registeredusers.registeredteammembers', [
                'users' => $registeredusers
            ]);
        }
    }


    public function useredit(Request $request, $id)
    {
        $registereduser = User::find($id);
        $type = $request->query('type', 'user'); 

        if (!$registereduser) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'User not found'], 404);
            }

            return abort(404); // For web requests, show a 404 page.
        }

        if ($request->expectsJson()) {
            return response()->json(['user' => $registereduser], 200);
        }

        return view('admin.registeredusers.edit', ['users' => $registereduser, 'type' => $type]);
    }

    public function userupdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->getResponse($request, ['error' => $validator->errors()], 400);
        }

        $registeredusers = User::find($id);

        if (!$registeredusers) {
            return $request->expectsJson()
                ? response()->json(['error' => 'User not found'], 404)
                : abort(404);
        }

        $registeredusers->name = $request->name;
        $registeredusers->email = $request->email;
        $registeredusers->password = $request->password;
        $registeredusers->role = $request->role;
        $registeredusers->save();
    // Mail::to($registeredusers->email)->send(new UpdateEmail($registeredusers));
        // Use conditional logic to return the appropriate response

        $type = $request->input('type', 'user');
        
        if ($request->expectsJson()) {
            return response()->json(['message' => 'User updated successfully'], 200);
        }

        switch ($type) {
            case 'support':
                return redirect()->route('admin.registeredteammembers')->with('success', 'Support team member updated successfully');
            case 'service':
                return redirect()->route('admin.register-service')->with('success', 'Service team member updated successfully');
            case 'user':
            default:
                return redirect()->route('admin.registeredusers')->with('success', 'User updated successfully');
        }
        // return $request->expectsJson()
        //     ? response()->json(['message' => 'Category updated successfully'], 200)
        //     : redirect()->route('admin.registeredusers')->with('success', ' updated successfully');
    }

    public function userdel(Request $request, $id)
    {
        $registereduser = User::find($id);
    
        if (!$registereduser) {
            return $this->getResponse($request, ['error' => 'User not found'], 404);
        }
    
        $deletedUserEmail=$registereduser->email;
        DB::table('password_text')->where('user_id', $user->id)->delete();

    
        $registereduser->delete();
    
    
        // Check if the email is present and send the email
        if ($deletedUserEmail) {
            Mail::to($deletedUserEmail)->send(new DelEmail($registereduser));
        }
    
        // Flash message for successful deletion
        if ($request->expectsJson()) {
            return $this->getResponse($request, ['message' => 'User deleted successfully'], 200);
        }
    
        return redirect()->back()->with('success', 'User deleted successfully');
    }

    private function getResponse(Request $request, $data, $status)
    {
        $registeredusers = User::all();
        if ($request->expectsJson()) {
            return response()->json($data, $status);
        }
    
        return view('admin.registeredusers.registeredusers', ['users' => $registeredusers]);
    }
}
