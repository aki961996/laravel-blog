<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
    public function forget_pass()
    {
        return view('auth.forget_pass');
    }

    public function forget_password_create(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            $user->remember_token = Str::random(40);
            $user->save();
            Mail::to($user->email)->send(new ForgetPasswordMail($user));
            return redirect()->back()->with('status', 'Please check your email and reset your password');
        } else {
            return redirect()->back()->with('error', 'Email not found');
        }
    }

    //reset pass function
    public function reset_password($token)
    {
        $remember_token = $token;
        $user = User::where('remember_token', $remember_token)->first();
        if (!empty($user)) {
            return view('auth.reset_password', ['user' => $user]);
        } else {
            abort(404);
        }
    }

    public function rest_password_post(Request $request, $token)
    {
        // Validate input fields
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'cpassword' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Password and Confirm password is required');
        }
        if ($request->password != $request->cpassword) {
            return redirect()->back()->with('error', 'Password and Confirm password does not match');
        }

        $remember_token = $token;
        $user = User::where('remember_token', '=', $remember_token)->first();
        if (!empty($user)) {
            if (!empty($request->password) == !empty($request->cpassword)) {
                $user->password =  Hash::make($request->password);
                if (empty($user->email_verified_at)) {
                    $user->email_verified_at = now();
                }
                $user->remember_token = Str::random(40);
                $user->save();
                return redirect()->route('login')->with('status', 'Your password has been reset successfully');
            } else {
                return redirect()->back()->with('error', 'Password and Confirm password does not match');
            }
        } else {
            abort(404);
        }
    }

    // public function rest_password_post(Request $request, $token)
    // {
    //     // Validate input fields
    //     $validator = Validator::make($request->all(), [
    //         'password' => 'required',
    //         'cpassword' => 'required|same:password',
    //     ]);

    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator) // Pass validation errors to the view
    //             ->withInput(); // Keep input values filled
    //     }

    //     $user = User::where('remember_token', $token)->first();

    //     // Check if user exists
    //     if (!$user) {
    //         abort(404);
    //     }

    //     // Update user password and other details
    //     $user->password = Hash::make($request->password);
    //     if (empty($user->email_verified_at)) {
    //         $user->email_verified_at = now();
    //     }
    //     $user->remember_token = Str::random(40);
    //     $user->save();


    //     return redirect()->route('login')->with('status', 'Your password has been reset successfully');
    // }


    public function auth_login(Request $request)
    {
        $remember = !empty($request->remember) ? 'true' : 'false';

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            if (!empty(Auth::user()->email_verified_at)) {
                echo 'successfully';
                die;
            } else {
                $user = new User();
                $user_id = Auth::user()->id;
                Auth::logout();
                $user = $user->getSingle($user_id);
                //remember_token token mati 
                $user->remember_token = Str::random(40);
                $user->save();
                Mail::to($user->email)->send(new RegisterMail($user));
                return redirect()->back()->with('status', 'Please first you can verify your email address');
            }
        } else {
            return redirect()->back()->with('error', 'Please enter current Email and Password');
        }
    }


    public function create_user(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|size:7',
        ]);
        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make(trim($request->password));
        $user->remember_token = Str::random(10);
        $user->save();

        Mail::to($user->email)->send(new RegisterMail($user));
        return redirect()->route('login')->with('status', 'Your account created successfully and Verify your email address');
    }

    //when click mail verify button then this api
    public function verify($token)
    {
        $remember_token = $token;
        $user = User::where('remember_token', $remember_token)->first();
        if (!empty($user)) {
            //$user->email_verified_at = date('Y-m-d H:i:s');
            $user->email_verified_at = now();
            $user->remember_token = Str::random(40);
            $user->save();
            return redirect()->route('login')->with('status', 'Your account verified successfully');
        } else {
            abort(404);
        }
    }
}
