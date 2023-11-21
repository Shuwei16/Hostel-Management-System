<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

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

    function forgotPassword(){
        return view('auth/forgotpassword');
    }

    function forgotPasswordPost(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $emailExist = User::where('email', '=', $request->email)->first();
        if($emailExist == null) {
            return redirect(route('forgotpassword'))->with("error", "Email does not exist. Please re-enter the registered email.");
        } else {
            $data = [
                "subject"=>"Password Reset Verification",
                "user_id"=>$emailExist->id
                ];
              // MailNotify class that is extend from Mailable class.
              try
              {
                Mail::to($request->email)->send(new ResetPasswordMail($data));
                return redirect(route('forgotpassword'))->with("success", "Password reset link has been sent to your email. Please check your email.");
              }
              catch(Exception $e)
              {
                return redirect(route('forgotpassword'))->with("error", "Sorry! There is something wrong. Please try again latter");
              }
            
        }
    }

    function resetPassword($id){
        return view('auth/resetpassword', compact('id'));
    }

    function resetPasswordPost(Request $request){
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $userData = User::find($request->id);

        if(!Hash::check($request->password, $userData->password)) {
            $userData->update(['password' => Hash::make($request->password)]);
            return redirect(route('login'))->with("success", "Your password has been updated! You can now login to your account with new password.");
        } else {
            return redirect(route('resetpassword', ['id'=>$request->id]))->with("error", "Cannot use back the same password.");
        }
        
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

    function changePasswordPost(Request $request) {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $userData = User::find(auth()->id());
        if(Hash::check($request->old_password, $userData->password)) {
            if(!Hash::check($request->password, $userData->password)) {
                $userData->update(['password' => Hash::make($request->password)]);
                return redirect(route('resident-profile'))->with("success", "Your password has been successfully updated!");
            } else {
                return redirect(route('resident-changePassword'))->with("error", "Cannot use back the same password.");
            }

        } else {
            return redirect(route('resident-changePassword'))->with("error", "Incorrect old password!");
        }
    }

    function residentForgotPasswordPost(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $emailExist = User::where('email', '=', $request->email)->first();
        if($emailExist == null) {
            return redirect(route('resident-forgotPassword'))->with("error", "Email does not exist. Please re-enter the registered email.");
        } else {
            $data = [
                    "subject"=>"Password Reset Verification",
                    "user_id"=>$emailExist->id
                    ];
            try
            {
              Mail::to($request->email)->send(new ResetPasswordMail($data));
              return redirect(route('resident-forgotPassword'))->with("success", "Password reset link has been sent to your email. Please check your email.");
            }
            catch(Exception $e)
            {
              return redirect(route('resident-forgotPassword'))->with("error", "Sorry! There is something wrong. Please try again latter");
            }
            
        }
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('home'));
    }
}
