<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = User::where('is_admin', 1)->first();
        return view('backend.dashboard', ['user' => $user]);
    }
}
