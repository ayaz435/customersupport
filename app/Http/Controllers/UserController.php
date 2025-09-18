<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catagory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    // authentication
    public function userauthenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                $user = Auth::guard('user')->user();
                if ($user->role == 1) {
                    return redirect()->route('courses');
                } else {
                    $user = Auth::guard('user')->logout();
                    return redirect()->route('login')->with('error', 'You are not authorized to access admin panel');
                }
            } else {
                return redirect()->route('login')->with('error', 'Either Email/Password is incorrect');
            }
        } else {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('index');
    }
    //authentication ends
    
    public function login()
    {
        return view('login');
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
            'password' => 'required'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return redirect('login')->with('success', 'Registered Successfully');
    }
}
