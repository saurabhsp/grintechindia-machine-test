<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{

    // Show all agents
    public function index()
    {
        $agents = Agent::all();
        return view('admin.agents.dashboard', compact('agents'));
    }

    // Show the form for creating a new agent
    public function create()
    {
        return view('admin.agents.create');
    }


    // Store a new agent
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:agents,phone',
            'email' => 'required|email|unique:agents,email',
            'pan_card' => 'required|string|max:20|unique:agents,pan_card',
            'password' => 'required|min:6',
        ]);

        Agent::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'pan_card' => $request->pan_card,
            'password' => Hash::make($request->password),
            'status' => 1, // Default active status
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Agent added successfully.');
    }


    // Show the Edit Agent Form
    public function editAgent($id)
    {
        $agent = Agent::findOrFail($id); // Find agent by ID
        return view('admin.edit-agent', compact('agent')); // Pass agent data to view
    }

    // Update Agent Details
    public function updateAgent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $id,
            'phone' => 'required|digits:10',
            'pan_card' => 'required|string|max:10',
        ]);

        $agent = Agent::findOrFail($id);
        $agent->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'pan_card' => $request->pan_card,
        ]);

        return redirect()->route('admin.agents')->with('success', 'Agent details updated successfully!');
    }
    // Show signup form
    public function showSignupForm()
    {
        return view('admin.signup');
    }

    // Handle admin signup
    public function adminSignup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6', // Remove 'confirmed'
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Admin account created successfully.');
    }



    // Show login form
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Handle admin login
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Invalid credentials.');
        }

        // Store admin session
        Session::put('admin_id', $admin->id);
        Session::put('admin_name', $admin->name);

        return redirect()->route('admin.dashboard');
    }

    // Show dashboard with agent data
    public function showDashboard()
    {
        $agents = Agent::all();
        return view('admin.dashboard', compact('agents'));
    }

    // Handle admin logout
    public function adminLogout()
    {
        Session::flush();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }


    // Show edit form
    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        return view('admin.agents.edit', compact('agent'));
    }

    // Update agent details
    public function update(Request $request, $id)
    {
        $agent = Agent::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:agents,phone,' . $id,
            'email' => 'required|email|unique:agents,email,' . $id,
            'pan_card' => 'required|string|max:20|unique:agents,pan_card,' . $id,
        ]);

        $agent->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'pan_card' => $request->pan_card,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Agent details updated successfully.');
    }

    // Toggle agent status (Block/Unblock)
    public function toggleStatus($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->status = !$agent->status; // Toggle status
        $agent->save();

        return redirect()->route('admin.dashboard')->with('success', 'Agent status updated successfully.');
    }

    // Delete an agent
    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Agent deleted successfully.');
    }
}
