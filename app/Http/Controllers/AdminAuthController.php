<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agent;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    function showSignupForm()
    {
        return view('admin.signup'); // Returns the signup form
    }

    function adminSignup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6'
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Admin Created. Please login.');
    }

    function showLoginForm()
    {
        return view('admin.login'); // Returns the login form
    }

    function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        // Store admin in session
        Session::put('admin_id', $admin->id);
        Session::put('admin_name', $admin->name);

        return redirect()->route('admin.dashboard')->with('success', 'Login successful.');
    }

    function showDashboard()
    {
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }
        $agents = Agent::all(); // Fetch all agents
        return view('admin.dashboard', compact('agents'));
    }

    function adminLogout()
    {
        Session::flush();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
