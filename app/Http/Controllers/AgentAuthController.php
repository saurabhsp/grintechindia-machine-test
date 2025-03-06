<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AgentAuthController extends Controller
{

    public function showdata()
    {
        $agents = Agent::all();

        foreach ($agents as $agent) {
            dd($agent->status); // This will dump the status of the first agent
        }

        return response()->json($agents);
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('admin.agents.login');
    }

    // Handle agent login
    public function agentLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $agent = Agent::where('email', $request->email)->first();

        if (!$agent) {
            return back()->with('error', 'No agent found with this email.');
        }

        if (!Hash::check($request->password, $agent->password)) {
            return back()->with('error', 'Incorrect password.');
        }

        // Store session
        Session::put('id', $agent->id); 
        Session::put('agent_status', $agent->status);
        Session::put('agent_name', $agent->name); // ✅ Store the agent's name

        // return "Success";
        return redirect()->route('agent.dashboard');
    }


    // Show the agent dashboard
    public function showDashboard()
    {
        $users = User::all(); // Fetch all users
        return view('admin.agents.dashboard', compact('users'));
    }
    public function agentLogout()
    {
        Session::flush();
        return redirect()->route('agent.login')->with('success', 'Logged out successfully.');
    }

    
}
