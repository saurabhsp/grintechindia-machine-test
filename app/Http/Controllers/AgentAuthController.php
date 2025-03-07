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
            dd($agent->status);
        }

        return response()->json($agents);
    }

    public function showLoginForm()
    {
        return view('admin.agents.login');
    }

    
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

    
    if ($agent->status == 0) {
        return back()->with('error', 'Your account is blocked. Contact the admin.');
    }

    
    Session::put('id', $agent->id);
    Session::put('agent_status', $agent->status);
    Session::put('agent_name', $agent->name); 

    
    return redirect()->route('agent.dashboard');
}


    
    public function showDashboard()
    {
        $users = User::all(); 
        return view('admin.agents.dashboard', compact('users'));
    }
    public function agentLogout()
    {
        Session::flush();
        return redirect()->route('agent.login')->with('success', 'Logged out successfully.');
    }

    
}
