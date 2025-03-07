<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{

    public function index()
    {
        $agents = Agent::all();
        return view('admin.agents.dashboard', compact('agents'));
    }

    public function create()
    {
        return view('admin.agents.create');
    }


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
            'status' => 1, 
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Agent added successfully.');
    }


    public function editAgent($id)
    {
        $agent = Agent::findOrFail($id);
        return view('admin.edit-agent', compact('agent')); 
    }

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
    public function showSignupForm()
    {
        return view('admin.signup');
    }

    public function adminSignup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6', 
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Admin account created successfully.');
    }



    public function showLoginForm()
    {
        return view('admin.login');
    }

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

        Session::put('admin_id', $admin->id);
        Session::put('admin_name', $admin->name);

        return redirect()->route('admin.dashboard');
    }

    public function showDashboard()
    {
        $agents = Agent::all();
        return view('admin.dashboard', compact('agents'));
    }

    public function adminLogout()
    {
        Session::flush();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }

    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        return view('admin.agents.edit', compact('agent'));
    }

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

    public function toggleStatus($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->status = !$agent->status; 
        $agent->save();

        return redirect()->route('admin.dashboard')->with('success', 'Agent status updated successfully.');
    }

    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Agent deleted successfully.');
    }
}
