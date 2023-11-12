<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function login() {
        return view('auth/login');
    }

    function signup() {
        return view('auth/signup');
    }

    function loginPost(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)) {
            $user_role=Auth::user()->role;

            switch($user_role) {
                case 0:
                    return redirect()->intended(route('non-resident-new'));
                    break;
                case 1:
                    $residentInfo = Student::where('user_id', '=', auth()->id())
                                           ->first();
                    if($residentInfo->address != null || $residentInfo->emergency_contact_name != null || $residentInfo->emergency_contact != null){
                        return redirect()->intended(route('resident-announcement'));
                    } else {
                        return redirect()->intended(route('resident-editProfile'))->with("success", "Welcome, new resident! please complete your information here.");
                    }
                        
                    break;
                case 2:
                    return redirect()->intended(route('admin-dashboard'));
                    break;
                default:
                    Auth::logout();
                    return redirect(route('login'))->with("error", "Oops something went wrong!");
            }
        }
        return redirect(route('login'))->with("error", "Login details are not valid.");
    }

    function signupPost(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        if(!$user){
            return redirect(route('signup'))->with("error", "Sign up failed, please try again.");
        }
        return redirect(route('login'))->with("success", "You have signed up successfully, now you can login to your account.");
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('home'));
    }
}
