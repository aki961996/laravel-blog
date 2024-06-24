<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    public function create_user(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make(trim($request->password));
        $user->save();
        return redirect()->route('login')->with('status', 'User created successfully.');
    }
}
